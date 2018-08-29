<?php

namespace Modules\Users\Tests;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Modules\Users\Events\NewUserRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegistrationTest extends TestCase
{

    use DatabaseMigrations;


    /** @test */
    public function user_can_create_account()
    {
        $this->withoutExceptionHandling();
        Event::fake();

        $this->json('post','api/register',[
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])
        ->assertRequestIsSuccessful();

        $this->assertDatabaseHas('users',[
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
        ]);

        Event::assertDispatched(NewUserRegistered::class, function($e){
            return $e->user->email == 'manssour.mohammed@gmail.com';
        });
    }

    /** @test */
    public function can_not_register_because_of_messing_data()
    {
        Event::fake();

        $this->json('post', 'api/register', [])
            ->assertStatus(422)
            ->assertJsonFragment([
                    'message' => [
                    'Name is required',
                    'Email is required',
                    'Password and Password Confirmation are required',
                    ]
            ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
        ]);

        Event::assertNotDispatched(NewUserRegistered::class);
    }

    /** @test */
    public function can_not_register_because_email_is_not_valid()
    {
        Event::fake();

        $this->json('post', 'api/register', [
                'name' => 'Mohammed Manssour',
                'email' => 'manssour.mohammed@gmail',
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ])
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => [
                    'Please set valid email address'
                ]
            ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
        ]);

        Event::assertNotDispatched(NewUserRegistered::class);
    }

    /** @test */
    public function can_not_register_because_passowrd_conformation_not_valid()
    {
        Event::fake();

        $this->json('post', 'api/register', [
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
            'password' => 'secret',
            'password_confirmation' => 'secret1',
        ])
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => [
                    'Password and Password Confirmation must match'
                ]
            ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
        ]);

        Event::assertNotDispatched(NewUserRegistered::class);
    }

}
