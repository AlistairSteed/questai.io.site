<?php

namespace App\Services\Contracts;

use App\Models\Basket;
use App\Models\Coupon;
use Illuminate\Http\Request;

interface PaymentGatewayProvider
{
    public function checkoutUrl(Basket $basket, Coupon $coupon = null): string;
    
    public function handleWebhook(Request $request): void;
}