<?php

namespace Modules\Users\Tests;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FollowingApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->actingAs($this->user);
    }
    /** @test */
    public function can_get_all_followers()
    {
        factory(User::class,30)->create()->each->follow($this->user);

        $this->json('get', "api/users/{$this->user->id}/followers")
            ->assertRequestIsSuccessful()
            ->assertJsonCount(20, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'cover', 'profile_picture', 'description']
                ]
            ]);
    }

    /** @test */
    public function can_get_all_following()
    {
        factory(User::class, 30)->create()->each(function($user){
            $this->user->follow($user);
        });

        $this->json('get', "api/users/{$this->user->id}/following")
            ->assertRequestIsSuccessful()
            ->assertJsonCount(20, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'cover', 'profile_picture', 'description']
                ]
            ]);
    }

    /** @test */
    public function can_follow_user()
    {
        $user = factory(User::class)->create();

        $this->json('post', "api/users/{$user->id}/followers")
            ->assertRequestIsSuccessful();

        $this->assertEquals(1, $user->followers()->count());
        $this->assertEquals(1, $this->user->following()->count());
    }

    /** @test */
    public function user_can_not_follow_user_if_he_is_following_him_now()
    {
        $user = factory(User::class)->create();
        $this->user->follow($user);

        $this->json('post', "api/users/{$user->id}/followers")
            ->assertStatus(409)
            ->assertJson([
                'meta' => generate_meta('failure', ['You are following user currently'])
            ]);

        $this->assertEquals(1, $user->followers()->count());
        $this->assertEquals(1, $this->user->following()->count());
    }

    /** @test */
    public function user_can_un_follow_user()
    {
        $user = factory(User::class)->create();
        $this->user->follow($user);

        $this->json('delete', "api/users/{$user->id}/followers")
            ->assertRequestIsSuccessful();

        $this->assertEquals(0, $user->followers()->count());
        $this->assertEquals(0, $this->user->following()->count());
    }

    /** @test */
    public function user_can_not_unfollow_user_if_he_is_not_following_him_now()
    {
        $user = factory(User::class)->create();

        $this->json('delete', "api/users/{$user->id}/followers")
            ->assertStatus(409)
            ->assertJson([
                'meta' => generate_meta('failure', ['You are not following user currently'])
            ]);

        $this->assertEquals(0, $user->followers()->count());
        $this->assertEquals(0, $this->user->following()->count());
    }
}
