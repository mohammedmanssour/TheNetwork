<?php

namespace Modules\Posts\Tests;

use App\User;
use Tests\TestCase;
use Plank\Mediable\Media;
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

    /** @test */
    public function user_can_create_new_posts()
    {
        $this->withoutExceptionHandling();
        $this->sendPostRequest('post', 'api/posts');
    }

    /** @test */
    public function user_can_create_new_posts_despite_that_images_was_not_set()
    {
        $this->withoutExceptionHandling();
        $this->sendPostRequest('post', 'api/posts', false);
    }

    /** @test */
    public function user_can_not_create_new_post_because_of_content_is_not_present()
    {
        $this->sendInvalidContentPostRequest('post', 'api/posts');
    }

    /** @test */
    public function user_can_not_create_new_post_because_of_images_are_invalid()
    {
        $this->sendInvalidImagesPostRequest('post', 'api/posts');
    }

    /** @test */
    public function user_can_update_post()
    {
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->sendPostRequest('put', "api/posts/{$post->id}");
    }

    /** @test */
    public function user_can_update_post_despite_that_images_was_not_set()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->sendPostRequest('put', "api/posts/{$post->id}", false);
    }

    /** @test */
    public function user_can_not_update_post_because_content_is_not_present()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id
        ]);
        $this->sendInvalidContentPostRequest('put', "api/posts/{$post->id}");
    }

    /** @test */
    public function user_can_not_post_because_images_are_not_valid()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id
        ]);
        $this->sendInvalidImagesPostRequest('put', "api/posts/{$post->id}");
    }

    /** @test */
    public function user_can_not_update_post_because_he_does_not_own_it()
    {

        $post = factory(Post::class)->create();
        $this->json('put', "api/posts/{$post->id}",[
            'content' => 'This is post content'
        ])->assertStatus(403)
        ->assertJson(['meta' => generate_meta('failure',['FORBIDDEN'])]);
    }

    /** @test */
    public function user_can_delete_post()
    {
        $post = factory(Post::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->json('delete', "api/posts/{$post->id}")
            ->assertRequestIsSuccessful();

        $post = Post::withTrashed()->find($post->id);
        $this->assertNotNull($post->deleted_at);
    }

    /** @test */
    public function user_can_not_delete_because_he_does_not_own_it()
    {
        $post = factory(Post::class)->create();

        $this->json('delete', "api/posts/{$post->id}")
            ->assertStatus(403)
            ->assertJson(['meta' => generate_meta('failure',['FORBIDDEN'])]);

        $post = Post::withTrashed()->find($post->id);
        $this->assertNull($post->deleted_at);
    }


    private function sendPostsRequest($uri, $expectedCount)
    {
        $res = $this->json('get', $uri)
            ->assertRequestIsSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'content', 'user', 'images']
                ]
            ])
            ->assertJsonCount($expectedCount, 'data');
    }

    public function sendPostRequest($method, $uri, $includeImages = true)
    {
        $media = factory(Media::class, 5)->create();

        $data = [
            'content' => 'This is post content'
        ];
        if($includeImages){
            $data['images'] = $media->pluck('id')->all();
        }

        $this->json($method, $uri,$data)
            ->assertRequestIsSuccessful()
            ->assertJsonStructure([
                'data' => ['id', 'content', 'user', 'images']
            ])
            ->assertJsonFragment([
                'content' => 'This is post content',
                'images' => $includeImages ? $media->pluck('id')->all() : []
            ]);

        $this->assertDatabaseHas('posts', [
            'content' => 'This is post content',
            'user_id' => $this->user->id
        ]);
    }

    public function sendInvalidContentPostRequest($method, $uri)
    {
        $media = factory(Media::class, 5)->create();
        $this->json($method, $uri, [
            'images' => $media->pluck('id')->all()
        ])->assertStatus(422)
            ->assertJsonFragment([
                'message' => [
                    'Content is required'
                ]
            ]);
    }
    private function sendInvalidImagesPostRequest($method, $uri)
    {
        $media = factory(Media::class, 5)->create();
        $this->json($method, $uri, [
            'content' => 'This is post content',
            'images' => [10001, 100002, 1000005]
        ])->assertStatus(422)
            ->assertJsonFragment([
                'message' => [
                    'Image must be valid',
                    'Image must be valid',
                    'Image must be valid',
                ]
            ]);

        $this->assertDatabaseMissing('posts', [
            'content' => 'This is post content'
        ]);
    }
}
