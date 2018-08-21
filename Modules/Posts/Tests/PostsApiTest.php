<?php

namespace Modules\Posts\Tests;

use App\User;
use Tests\TestCase;
use Modules\Posts\Entities\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostsApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->actingAs($this->user);
    }
    /** @test */
    public function can_get_latest_posts()
    {
        $this->withoutExceptionHandling();
        $posts = factory(Post::class,30)->create();

        $this->sendPostsRequest('api/posts', 20);
        $this->sendPostsRequest('api/posts?page=2', 10);
    }

    private function sendPostsRequest($uri, $expectedCount)
    {
        $this->json('get', $uri)
            ->assertRequestIsSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'content', 'user', 'images']
                ]
            ])
            ->assertJsonCount($expectedCount, 'data');
    }
}
