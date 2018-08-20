<?php

namespace Modules\Users\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create([
            'email' => 'manssour.mohammed@gmail.com',
            'password' => bcrypt('secret')
        ]);
    }
    /** @test */
    public function user_can_login()
    {
        $this->user->confirmed();

        $this->json('post', 'api/login',[
            'email' => 'manssour.mohammed@gmail.com',
            'password' => 'secret'
        ])
        ->assertRequestIsSuccessful()
        ->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'description'],
            'meta' => ['token', 'code', 'message'],
        ]);
    }

    /** @test */
    public function user_cannot_login_because_of_bad_credentials()
    {
        $this->user->confirmed();

        $this->json('post', 'api/login', [
            'email' => 'manssour.mohammed@gmail.com',
            'password' => 'secret1'
        ])
        ->assertStatus(401)
        ->assertJson(['meta' => generate_meta('failure', ['Not Authorized'])]);
    }

    /** @test */
    public function user_cannot_login_because_account_is_not_confirmed()
    {
        $this->json('post', 'api/login', [
            'email' => 'manssour.mohammed@gmail.com',
            'password' => 'secret'
        ])
        ->assertStatus(412)
        ->assertJson(['meta' => generate_meta('failure', ['Your account is not confirmed'])]);
    }
}
