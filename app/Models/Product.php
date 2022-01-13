<?php

namespace App\Models;

use App\Services\PaymentGateway\StripePaymentGateway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $primaryKey = 'prid';
    public $timestamps = false;

    protected $fillable = [
        'prid',
        'prgroup',
        'prtype',
        'prcategory',
        'prcode',
        'prdesc',
        'prprice',
        'prinformation',
        'prsupplierid',
        'prsupplieritem',
        'prcomment',
        'practive',
        'stripe_product_id',
        'stripe_price_id',
    ];

    //Constant Value
    const PRGROUPONE = '1';
    const PRGROUPTWO = '2';

    public function basketlines()
    {
        return $this->hasOne(Basketline::class, 'blproductid');
    }

    public function generateStripeProduct()
    {
        if ($this->stripe_product_id && $this->stripe_price_id) {
            return;
        }
        
        $client = app(StripePaymentGateway::class)->client;

        $stripeProduct = $client->products->create([
            'name' => $this->prdesc,
        ]);

        $stripePrice = $client->prices->create([
            'unit_amount' => ((float)$this->prprice) * 100,
            'currency' => config('app.currency'),
            'product' => $stripeProduct->id,
          ]);

        $this->update([
            'stripe_product_id' => $stripeProduct->id,
            'stripe_price_id' => $stripePrice->id
        ]);
    }
}
