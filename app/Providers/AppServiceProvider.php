<?php

namespace App\Providers;

use Money\Money;
use Money\Currencies\ISOCurrencies;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Money\Formatter\IntlMoneyFormatter;

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
        Blade::stringable(function (Money $money) {
            $currencies = new ISOCurrencies();
            $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
            $moneyFormatter = new IntlMoneyFormatter($numberFormatter, $currencies);

            return $moneyFormatter->format($money);
        });
    }
}
