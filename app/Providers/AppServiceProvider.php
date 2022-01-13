<?php

namespace App\Providers;

use App\Services\Contracts\PaymentGatewayProvider;
use App\Services\PaymentGateway\StripePaymentGateway;
use App\Support\InfoTextHelper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PaymentGatewayProvider::class, StripePaymentGateway::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('infoText', function ($name) {
            return "<?php echo app(App\Support\InfoTextHelper::class)->get($name); ?>";
        });
    }
}
