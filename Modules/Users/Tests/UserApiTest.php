<?php

namespace Modules\Users\Tests;

use App\User;
use Tests\TestCase;
use Plank\Mediable\Media;
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

    /** @test */
    public function user_can_update_profile()
    {
        $this->withoutExceptionHandling();

        $profilePicture = factory(Media::class)->create(['disk'=> 'local']);
        $cover = factory(Media::class)->create(['disk'=> 'local']);
        $this->json('put','api/me',[
            'name' => 'Nawras Manssour',
            'email' => 'nawras.mohammed@gmail.com',
            'description' => 'Software Engineer',
            'profile_picture' => $profilePicture->id,
            'cover' => $cover->id,
        ])->assertRequestIsSuccessful()
        ->assertJsonStructure([
            'data' => ['id', 'name', 'email', 'description', 'profile_picture', 'cover']
        ])
        ->assertJsonFragment([
            'name' => 'Nawras Manssour',
            'email' => 'nawras.mohammed@gmail.com',
            'description' => 'Software Engineer',
            'profile_picture' => $profilePicture->id,
            'cover' => $cover->id,
        ]);

        //password hasn't changed
        $this->assertEquals('$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', $this->user->password);
    }

}
