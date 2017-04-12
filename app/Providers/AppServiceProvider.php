<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationData;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Validator::extend('array_min', function ($attribute, $value, $parameters, $validator) {
        // nazwa atrybutu
        $attributeName = explode('.', $attribute)[0];

        // pobranie wszytkich elementów tablicy
        $data = $validator->getData()[$attributeName];
        if(!is_array($data)){
          return false;
        }

        return count($data) >= $parameters[0];
      });

      Validator::replacer('array_min', function ($message, $attribute, $rule, $parameters) {
        return str_replace(':min', $parameters[0], $message);
    });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
