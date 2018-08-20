<?php

namespace Modules\Users\Tests;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->state('confirmed')->create([
            'name' => 'Mohammed Manssour',
            'email' => 'manssour.mohammed@gmail.com',
            'description' => 'senior Software Engineer'
        ]);

        $this->actingAs($this->user);
    }

    /** @test */
    public function can_get_user_info()
    {
        $this->withoutExceptionHandling();
        $this->json('get', 'api/me')
            ->assertRequestIsSuccessful()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'description']
            ])
            ->assertJsonFragment([
                    'name' => 'Mohammed Manssour',
                    'email' => 'manssour.mohammed@gmail.com',
                    'description' => 'senior Software Engineer'
            ]);
    }

}
