<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Http\Interfaces\ProductRepositoryInterface',
            'App\Repository\ProductRepository');

        $this->app->bind(
            'App\Http\Interfaces\UserRepositoryInterface',
            'App\Repository\UserProductRepository');

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
