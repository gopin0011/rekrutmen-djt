<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        //
        Validator::extend('excel_time_format', function ($attribute, $value, $parameters, $validator) {
            // $attribute: nama atribut
            // $value: nilai dari atribut
            // $parameters: parameter lainnya yang diberikan pada aturan validasi (jika ada)
            // $validator: instance Validator

            if (!is_string($value)) {
                return false;
            }

            $jam = explode(":", $value);
            $value = sprintf("%02d", $jam[0]).":".$jam[1];

            $timeRegex = '/^([01]\d|2[0-3]):([0-5]\d)$/'; // Format HH:mm

            return preg_match($timeRegex, $value);
        });
    }
}
