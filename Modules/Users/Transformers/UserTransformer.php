<?php

namespace Modules\Users\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'profile_picture' => optional($model->firstMedia('profile_picture'))->id,
            'cover' => optional($model->firstMedia('cover'))->id,
            'description' => $model->description
        ];
    }
}
