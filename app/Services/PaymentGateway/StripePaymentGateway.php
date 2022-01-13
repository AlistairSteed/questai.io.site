<?php

namespace App\Services\PaymentGateway;

use App\Models\Basket;
use App\Models\Basketline;
use App\Models\Product;
use App\Models\Coupon;
use Stripe\StripeClient;
use App\Services\Contracts\PaymentGatewayProvider;
use Illuminate\Http\Request;
use Stripe\Webhook as StripeWebhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class StripePaymentGateway implements PaymentGatewayProvider
{
    /** @var \Stripe\StripeClient */
    public $client;

    public function __construct()
    {
        $this->client = new StripeClient(config('services.stripe.secret'));
    }

    public function checkoutUrl(Basket $basket,  Coupon $coupon = null): string
    {
      $payload = [
        'line_items' => $basket->basketLines->map(function(Basketline $basketLine) {
            return [
                'price' => $basketLine->product->stripe_price_id,
                'quantity' => 1,
            ];
        })->toArray(),
        'metadata' => [
            'basket' => base64_encode($basket->baid),
            'coupon' => isset($coupon->coid)? base64_encode($coupon->coid) : null
        ],
        'payment_method_types' => [
          'card',
        ],
        'mode' => 'payment',
        'success_url' => url('/payment/success'),
        'cancel_url' => url('/payment/cancelled'),
        ];
        if($coupon){
          $payload['discounts'] = [[
            'coupon' => $coupon->stripe_coupon_id
            ]]; 
        }
        $checkout_session = $this->client->checkout->sessions->create($payload);

        return $checkout_session->url;
    }

    public function generateWebhooks()
    {
        $this->client->webhookEndpoints->create([
            'url' => route('stripe.webhook'),
            'enabled_events' => [
                'checkout.session.completed',
            ],
        ]);
    }
    
    public function handleWebhook(Request $request): void
    {
        $event = $this->resolveEvent($request);
        switch ($event->type) {
          case 'checkout.session.async_payment_failed':
            $checkout = $event->data->object;
          case 'checkout.session.async_payment_succeeded':
            $checkout = $event->data->object;
          case 'checkout.session.completed':
            $this->processCompletedCheckout($event->data->object);
          case 'checkout.session.expired':
            $checkout = $event->data->object;
          // ... handle other event types
          default:
            echo 'Received unknown event type ' . $event->type;
        }
        
        if($event->type == 'checkout.session.completed'){
            $msg = 'completed';
        }elseif($event->type == 'checkout.session.expired'){
            $msg = 'expired';
        }elseif($event->type == 'checkout.session.async_payment_failed'){
            $msg = 'async payment failed';
        }elseif($event->type == 'checkout.session.async_payment_succeeded'){
            $msg = 'async payment succeeded';
        }
        
        // Responece add in Payment table
        $payments = [
            'basket_id' => base64_decode($event->data->object->metadata->basket),
            'payment_response' => $event->data->object,
            'payment_status' => $msg,
            'payment_type' => 'stripe',
        ];
        Payment::create($payments);
    }
    
    protected function resolveEvent(Request $request)
    {
        // $payload = json_encode($request->all());
        // $sig_header = $request->header('HTTP_STRIPE_SIGNATURE');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        
        try {
          $event = StripeWebhook::constructEvent(
            $payload, $sig_header, config('services.stripe.strip_webhook')
          );
          return $event;
        } catch(\UnexpectedValueException $e) {
          // Invalid payload
          print_r($e->getMessage());
          http_response_code(400);
          exit();
        } catch(SignatureVerificationException $e) {
          // Invalid signature
          print_r($e->getMessage());
          http_response_code(400);
          exit();
        }
        
    }
    
    protected function processCompletedCheckout($data)
    {
        $response = Http::withToken(config('services.stripe.secret'))->get('https://api.stripe.com/v1/payment_intents/'.$data->payment_intent);
        $jsonData = $response->json();
        
        $basket_id = base64_decode($data->metadata->basket);
        // Update Basket table
        $baskets = Basket::findOrFail($basket_id);
        $baskets->baid = $basket_id; 
        $baskets->bacomplete = 1; 
        $baskets->badatecomplete = Carbon::now()->format('Y-m-d H:i:s');
        $baskets->total_amount = number_format($data->amount_subtotal/100, 2, '.', ''); 
        $baskets->grand_total_amount = number_format($data->amount_total/100, 2, '.', ''); 
        $baskets->invoice_url = $jsonData['charges']['data'][0]['receipt_url'];  
        $baskets->coupon_id = base64_decode($data->metadata->coupon);
        $baskets->save(); 
        
        // Update BasketLine table
        $basketlineData = Basketline::where('blbasketid',$basket_id)->update(['blprocessed' => 1]);
    }
}