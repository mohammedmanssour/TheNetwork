<?php

namespace Modules\Posts\Tests;

use App\User;
use Tests\TestCase;
use Modules\Posts\Entities\Post;
use Modules\Comments\Entities\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentsApiTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create([
            'user_id' => $this->user->id
        ]);

        $this->actingAs($this->user);
    }
    /** @test */
    public function can_get_all_comments()
    {
        $this->withoutExceptionHandling();

        $comments = factory(Comment::class,30)->create([
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post)
        ]);

        $this->json('get', "api/posts/{$this->post->id}/comments")
            ->assertRequestIsSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'content', 'user']
                ]
            ])
            ->assertJsonCount(20, 'data');

        $this->json('get', "api/posts/{$this->post->id}/comments?page=2")
                ->assertJsonCount(10, 'data');

    }

    /** @test */
    public function can_create_new_comment()
    {
        $this->sendCommentRequest('post', "api/posts/{$this->post->id}/comments");
    }

    /** @test */
    public function can_not_create_comment_because_content_is_not_present()
    {
        $this->sendInvalidCommentRequest('post', "api/posts/{$this->post->id}/comments");
    }

    /** @test */
    public function can_update_comment()
    {
        $this->withoutExceptionHandling();
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post)
        ]);

        $this->sendCommentRequest('put', "api/posts/{$this->post->id}/comments/{$comment->id}");
    }

    /** @test */
    public function can_not_update_comment_because_content_is_not_present()
    {
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post)
        ]);

        $this->sendInvalidCommentRequest('put', "api/posts/{$this->post->id}/comments/{$comment->id}");
    }

    /** @test */
    public function can_not_update_comment_because_does_not_own_it()
    {
        $comment = factory(Comment::class)->create([
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post)
        ]);

        $this->json('put', "api/posts/{$this->post->id}/comments/{$comment->id}",[
                'content' => 'This is comment content'
            ])
            ->assertStatus(403)
            ->assertJson(['meta' => generate_meta('failure',['FORBIDDEN'])]);

        $this->assertDatabaseMissing('comments',[
            'content' => 'This is comment content'
        ]);
    }

    /** @test */
    public function user_can_delete_comment()
    {
        $this->withoutExceptionHandling();
        $comment = factory(Comment::class)->create([
            'user_id' => $this->user->id,
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post),
            'content' => 'This is post comment'
        ]);

        $this->json('delete', "api/posts/{$this->post->id}/comments/{$comment->id}")
            ->assertRequestIsSuccessful();

        $this->assertDatabaseMissing('comments', [
            'content' => 'This is post comment'
        ]);
    }

    /** @test */
    public function can_delete_comment_because_he_own_post()
    {
        $this->withoutExceptionHandling();
        $comment = factory(Comment::class)->create([
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post),
            'content' => 'This is post comment'
        ]);

        $this->json('delete', "api/posts/{$this->post->id}/comments/{$comment->id}")
            ->assertRequestIsSuccessful();

        $this->assertDatabaseMissing('comments', [
            'content' => 'This is post comment'
        ]);
    }

    /** @test */
    public function can_not_delete_post_because_he_does_not_own_it()
    {
        $post = factory(Post::class)->create();

        $comment = factory(Comment::class)->create([
            'model_id' => $post->id,
            'model_type' => get_class($post),
            'content' => 'This is post comment'
        ]);

        $this->json('delete', "api/posts/{$post->id}/comments/{$comment->id}")
            ->assertStatus(403)
            ->assertJson(['meta' => generate_meta('failure',['FORBIDDEN'])]);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is post comment'
        ]);
    }

    /** @test */
    public function can_get_comments_count()
    {
        $comment = factory(Comment::class,33)->create([
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post),
            'content' => 'This is post comment'
        ]);

        $post = Post::withCount('comments')->find($this->post->id);
        $this->assertEquals(33, $post->comments_count);
    }

    /** @test */
    public function can_get_comments_count_from_attribute()
    {
        $comment = factory(Comment::class, 33)->create([
            'model_id' => $this->post->id,
            'model_type' => get_class($this->post),
            'content' => 'This is post comment'
        ]);
        $post = Post::find($this->post->id);
        $this->assertEquals(33, $post->comments_count);
    }

    private function sendCommentRequest($method, $uri)
    {
        $res = $this->json($method, $uri, [
            'content' => 'This is comment content'
        ])
            ->assertRequestIsSuccessful()
            ->assertJsonFragment([
                'content' => 'This is comment content'
            ])
            ->assertJsonStructure([
                'data' => ['id', 'content', 'user']
            ]);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is comment content',
            'model_id' => $this->post->id,
            'user_id' => $this->user->id
        ]);
    }

    private function sendInvalidCommentRequest($method, $uri)
    {
        $this->json($method, $uri)
            ->assertStatus(422)
            ->assertJsonFragment([
                'message' => ['Content is required']
            ]);
    }
}
