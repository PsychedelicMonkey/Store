<?php

namespace App\Providers;

use App\Models\Shop\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Eloquent settings.
        Model::shouldBeStrict(! $this->app->isProduction());

        // Cashier settings.
        Cashier::useCustomerModel(Customer::class);
    }
}
