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
            'images' => $model->getMedia('images')->pluck('id')->all()
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
        return $this->item($model->user, new UserTransformer);
    }
}