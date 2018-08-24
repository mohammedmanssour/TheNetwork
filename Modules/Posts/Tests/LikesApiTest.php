<?php

namespace Modules\Posts\Tests;

use App\User;
use Tests\TestCase;
use Modules\Posts\Entities\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LikesApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create();

        $this->actingAs($this->user);
    }

    /** @test */
    public function can_get_list_of_people_who_likes_the_post()
    {
        $this->withoutExceptionHandling();
        factory(User::class,30)->create()->each->like($this->post);
        //random users who don't like the post and won't be
        factory(User::class, 10)->create();

        $this->json('get',"api/posts/{$this->post->id}/likes")
            ->assertRequestIsSuccessful()
            ->assertJsonCount(20,'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'profile_picture']
                ]
            ]);

        $this->json('get', "api/posts/{$this->post->id}/likes?page=2")
            ->assertJsonCount(10, 'data');

    }

    /** @test */
    public function user_can_like_post()
    {
        $this->json('post', "api/posts/{$this->post->id}/likes")
            ->assertRequestIsSuccessful();

        $this->assertEquals(1, $this->user->likes()->count());
        $this->assertEquals(1, $this->post->likedBy()->count());
    }

    /** @test */
    public function user_can_not_like_post_again()
    {
        $this->user->like($this->post);

        $this->json('post', "api/posts/{$this->post->id}/likes")
            ->assertStatus(409)
            ->assertJson([
                'meta' => generate_meta('failure', ['You have liked this post before'])
            ]);

        $this->assertEquals(1, $this->user->likes()->count());
        $this->assertEquals(1, $this->post->likedBy()->count());

    }

    /** @test */
    public function user_can_unlike_post()
    {
        $this->user->like($this->post);

        $this->json('delete', "api/posts/{$this->post->id}/likes")
            ->assertRequestIsSuccessful();

        $this->assertEquals(0, $this->user->likes()->count());
        $this->assertEquals(0, $this->post->likedBy()->count());
    }

    /** @test */
    public function user_can_not_unlike_post_because_he_did_not_liked_post_before()
    {
        $this->json('delete', "api/posts/{$this->post->id}/likes")
            ->assertStatus(409)
            ->assertJson([
                'meta' => generate_meta('failure', ['You have not liked this post before'])
            ]);

        $this->assertEquals(0, $this->user->likes()->count());
        $this->assertEquals(0, $this->post->likedBy()->count());
    }
}
