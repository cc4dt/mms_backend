<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Inertia\Response;

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
        Schema::defaultStringLength(191);

        Response::macro('table', function ($subject, callable $withTableBuilder) {
            $tableBuilder = new \App\Datatable\DatatableBuilder($subject, request());

            if ($withTableBuilder) {
                $withTableBuilder($tableBuilder);
            }

            return $tableBuilder->applyTo($this);
        });
        
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
