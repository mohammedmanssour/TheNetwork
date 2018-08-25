<?php

namespace Modules\Users\Tests;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FollowingSystemTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /** @test */
    public function can_get_user_followers()
    {
        factory(User::class, 22)->create()->each(function($user){
            \DB::table('followings')->insert([
                'user_id' => $this->user->id,
                'model_id' => $user->id,
                'model_type' => get_class($user)
            ]);
        });

        $this->assertEquals(22, $this->user->following()->count());
    }

    /** @test */
    public function can_get_user_followings()
    {
        factory(User::class, 22)->create()->each(function ($user) {
            \DB::table('followings')->insert([
                'user_id' => $user->id,
                'model_id' => $this->user->id,
                'model_type' => get_class($this->user)
            ]);
        });

        $this->assertEquals(22, $this->user->followers()->count());
    }

    /** @test */
    public function can_follow_user()
    {
        $user = factory(User::class)->create();

        $this->user->follow($user);

        $this->assertEquals(1, $this->user->following()->count());
        $this->assertEquals(1, $user->followers()->count());
    }

    /** @test */
    public function can_un_follow_user()
    {
        $user = factory(User::class)->create();
        $user->followers()->attach($this->user->id);

        $this->user->unfollow($user);

        $this->assertEquals(0, $this->user->following()->count());
        $this->assertEquals(0, $user->followers()->count());
    }

    /** @test */
    public function following_count_attribute_is_working_good()
    {
        factory(User::class, 22)->create()->each(function($user){
            $this->user->follow($user);
        });

        $this->assertEquals(22, $this->user->following_count);
    }

    /** @test */
    public function followers_count_attribute_is_working_good()
    {
        factory(User::class, 22)->create()->each(function ($user) {
            $user->follow($this->user);
        });

        $this->assertEquals(22, $this->user->followers_count);
    }

    /** @test */
    public function can_check_if_user_is_following_other_user()
    {
        $user = factory(User::class)->create();

        $this->user->follow($user);

        $this->assertTrue($this->user->isFollowing($user));
    }
}
