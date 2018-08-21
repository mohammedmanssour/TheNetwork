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
        $res =$this->json('get', 'api/me')
                ->assertRequestIsSuccessful()
                ->assertJsonStructure([
                    'data' => ['id', 'name', 'email', 'description', 'profile_picture', 'cover']
                ])
                ->assertJsonFragment([
                        'name' => 'Mohammed Manssour',
                        'email' => 'manssour.mohammed@gmail.com',
                        'description' => 'senior Software Engineer'
                ]);
        $data = json_decode($res->getContent())->data;

        $this->assertNotNull($data->id);
        $this->assertNotNull($data->profile_picture);
        $this->assertNotNull($data->cover);
    }

    /** @test */
    public function can_get_user_info_if_has_no_media()
    {
        $this->user->media()->delete();
        $this->withoutExceptionHandling();
        $res = $this->json('get', 'api/me')
            ->assertRequestIsSuccessful()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'description', 'profile_picture', 'cover']
            ])
            ->assertJsonFragment([
                'name' => 'Mohammed Manssour',
                'email' => 'manssour.mohammed@gmail.com',
                'description' => 'senior Software Engineer'
            ]);
        $data = json_decode($res->getContent())->data;

        $this->assertNotNull($data->id);
        $this->assertNull($data->profile_picture);
        $this->assertNull($data->cover);
    }

}
