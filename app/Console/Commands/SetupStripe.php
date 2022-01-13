<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\PaymentGateway\StripePaymentGateway;

class SetupStripe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up neccessary data for stripe to work';

    /** @var StripePaymentGateway */
    protected $stripePaymentGateway;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->stripePaymentGateway = app(StripePaymentGateway::class);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Product::all()->each(function(Product $product) {
            $product->generateStripeProduct();
        });
        
        Coupon::all()->each(function(Coupon $coupon) {
            $coupon->generateStripeCoupon();
        });

        $this->stripePaymentGateway->generateWebhooks();


        return 0;
    }
}
