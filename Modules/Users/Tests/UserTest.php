<?php

namespace Modules\Users\Tests;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    /** @test */
    public function can_confirm_user_account()
    {
        $this->user->confirmed();

        $this->assertNotNull($this->user->confirmed_at);
        $this->assertNotNull(User::whereNotNull('confirmed_at')->first());
    }

    /** @test */
    public function can_suspend_user_account()
    {
        $this->user->suspend();

        $this->assertNotNull($this->user->suspended_at);
        $this->assertNotNull(User::whereNotNull('suspended_at')->first());
    }

    /** @test */
    public function can_activate_user_account()
    {
        $this->user->activate();

        $this->assertNull($this->user->suspended_at);
        $this->assertNotNull(User::whereNull('suspended_at')->first());
    }
}
