<?php

namespace App\Providers;

use App\Services\Payment\Contracts\PaymentProviderInterface;
use App\Services\Payment\Providers\FakePaymentProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(

        PaymentProviderInterface::class,

        FakePaymentProvider::class
);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
