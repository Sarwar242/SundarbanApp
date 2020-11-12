<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\support\Helpers;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('phone', function($attribute, $value, $parameters, $validator) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i', $value) && strlen($value) >= 10;
        });

        Validator::replacer('phone', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, ':attribute is invalid phone number');
        });


        // Builder::macro('whereLike', function ($attributes, string $searchTerm) {
        //     $this->where(function (Builder $query) use ($attributes, $searchTerm) {
        //         foreach (array_wrap($attributes) as $attribute) {
        //             $query->when(
        //                 str_contains($attribute, '.'),
        //                 function (Builder $query) use ($attribute, $searchTerm) {
        //                     [$relationName, $relationAttribute] = explode('.', $attribute);

        //                     $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
        //                         $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
        //                     });
        //                 },
        //                 function (Builder $query) use ($attribute, $searchTerm) {
        //                     $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
        //                 }
        //             );
        //         }
        //     });

        //     return $this;
        // });
    }
}
