<?php

namespace Modules\Comments\Policies;

use App\User;
use Modules\Comments\Entities\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Comment $comment, Model $model)
    {
        return $user->id == $comment->user_id ||
            $model->id == $comment->model_id && $comment->model_type == get_class($model) && $model->user_id == $user->id;
    }
}
