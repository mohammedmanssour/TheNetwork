<?php

namespace Modules\Posts\Tests;

use App\User;
use Tests\TestCase;
use Modules\Posts\Entities\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LikeableTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function user_liked_many_posts()
    {
        factory(Post::class, 10)->create()->each(function($post){
            \DB::table('likes')->insert([
                'user_id' => $this->user->id,
                'model_id' => $post->id,
                'model_type' => get_class($post),
            ]);
        });

        $this->assertEquals(10, $this->user->likes()->count());
    }

    /** @test */
    public function user_can_like_a_post()
    {
        $post = factory(Post::class)->create();

        $this->user->like($post);

        $this->assertEquals(1, $this->user->likes()->count());
    }

    /** @test */
    public function can_unlike_required_post()
    {
        $post = factory(Post::class)->create();
        \DB::table('likes')->insert([
            'user_id' => $this->user->id,
            'model_id' => $post->id,
            'model_type' => get_class($post)
        ]);

        $this->user->unlike($post);
        $this->assertEquals(0, $this->user->likes()->count());
    }

    /** @test */
    public function check_if_user_has_likes_posts_or_not()
    {
        $post = factory(Post::class)->create();
        \DB::table('likes')->insert([
            'user_id' => $this->user->id,
            'model_id' => $post->id,
            'model_type' => get_class($post)
        ]);
        $this->assertNotEquals(0, $this->user->hasLiked($post));

        $post = factory(Post::class)->create();
        $this->assertEquals(0, $this->user->hasLiked($post));
    }
}
