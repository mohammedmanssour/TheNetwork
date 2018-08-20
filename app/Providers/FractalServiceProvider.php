<?php

namespace App\Providers;

use Spatie\Fractal\Fractal;
use Illuminate\Support\ServiceProvider;

class FractalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Fractal::macro('withContentMeta', function(){
            $this->addMeta(
                generate_meta($this->data)
            );
            return $this;
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
