<?php

namespace App\Models;

use App\Services\PaymentGateway\StripePaymentGateway;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupon';
    protected $primaryKey = 'coid';
    public $timestamps = false;

    protected $fillable = [
        'coid',
        'coclientid',
        'coall',
        'cocode',
        'codesc',
        'covalue',
        'copercent',
        'coexpire',
        'stripe_coupon_id',
    ];

    public function generateStripeCoupon()
    {
        if ($this->stripe_coupon_id) {
            return;
        }
        
        $client = app(StripePaymentGateway::class)->client;

        if($this->covalue == 0 && $this->copercent !== 0){            
            $stripeCoupon = $client->coupons->create([
                'name' => $this->cocode,
                'percent_off' => $this->copercent,
                'duration' => 'once',
            ]);
        }else if($this->covalue !== 0 && $this->copercent == 0){      
            $stripeCoupon = $client->coupons->create([
                'name' => $this->cocode,
                'amount_off' => ((float)$this->covalue) * 100,
                'currency' => 'usd',
            ]);            
        }

        $this->update([
            'stripe_coupon_id' => $stripeCoupon->id,
        ]);
    }
}
