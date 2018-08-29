<?php

namespace Modules\Comments\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Users\Transformers\UserTransformer;

class CommentTransformer extends TransformerAbstract
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
            'content' => $model->content
        ];
    }

    /**
     * include user transformer
     *
     * @param \Modules\Comments\Entities\Comment $model
     * @return void
     */
    public function includeUser($model)
    {
        return $this->item($model->user, (new UserTransformer)->onlyBasic());
    }

}
