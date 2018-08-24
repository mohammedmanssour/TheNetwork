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
}
