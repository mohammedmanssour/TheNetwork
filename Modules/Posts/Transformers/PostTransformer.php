<?php

namespace Modules\Posts\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Users\Transformers\UserTransformer;

class PostTransformer extends TransformerAbstract
{
    /**
     * Include resources without needing it to be requested.
     *
     * @var array
     */
    protected $defaultIncludes = ['user'];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($model)
    {
        return [
            'id' => $model->id,
            'content' => $model->content,
            'images' => $model->getMedia('images')->pluck('id')->all(),
            'comments_count' => $model->comments_count,
            'likes_count' => $model->liked_by_count,
            'liked_by_user' => $model->current_user_like_status ? true : false,
            'created_at' => $model->created_at->format('Y-m-d H:i')
        ];
    }

    /**
     * include user info in posts
     *
     * @param \Modules\Posts\Entities\Post $model
     * @return void
     */
    public function includeUser($model)
    {
        return $this->item($model->user, (new UserTransformer)->onlyBasic());
    }
}
