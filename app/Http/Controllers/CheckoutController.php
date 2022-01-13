<?php

namespace App\Http\Controllers;

use Log;
use Validator;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Services\Contracts\PaymentGatewayProvider;

class CheckoutController extends Controller
{
    /** @var PaymentGatewayProviderr */
    protected $paymentGatewayProvider;

    public function __construct(PaymentGatewayProvider $paymentGatewayProvider)
    {
        $this->paymentGatewayProvider = $paymentGatewayProvider;
    }

    public function checkout(Request $request)
    {   
        $user = $request->user();
        $user->load('activeBasket.basketLines');
        $coupon = Coupon::where('cocode',$request->coupon)->first();

        $url = $this->paymentGatewayProvider->checkoutUrl($request->user()->activeBasket, $coupon);

        return redirect()->to($url);
        
    }

    public function afterPayment()
    {
        echo 'Payment Has been Received';
    }
    
    public function webhook(Request $request)
    {
        
       $webhookResponce = $this->paymentGatewayProvider->handleWebhook($request);
        echo 'webooks';
        Log::debug('strip webhook. ', $request->all());
    }

    public function paymentSuccess(){
        return redirect()->back()->with('success','Your order has been successfully completed.');
    }

    public function paymentCancel(){
        return redirect()->back()->with('error','You have to cancel your payment.');
    }
}
