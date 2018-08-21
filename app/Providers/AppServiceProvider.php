<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(TestResponseServiceProvider::class);
        if(class_exists(\Spatie\Fractal\Fractal::class)){
            $this->app->register(FractalServiceProvider::class);
        }
    }
}
