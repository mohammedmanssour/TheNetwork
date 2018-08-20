<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Testing\TestResponse;

class TestResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        TestResponse::macro('assertRequestIsSuccessful', function(){
            $this->assertStatus(200)
                ->assertJson(['meta' => generate_meta('success')]);

            return $this;
        });
    }
}
