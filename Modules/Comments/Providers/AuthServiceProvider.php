<?php

namespace Modules\Comments\Providers;

use Modules\Comments\Entities\Comment;
use Modules\Comments\Policies\CommentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public $policies = [
        Comment::class => CommentPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
