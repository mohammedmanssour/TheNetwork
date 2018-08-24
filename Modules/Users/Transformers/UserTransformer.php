<?php

namespace Modules\Users\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $basic = false;
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($model)
    {
        $info = [
            'id' => $model->id,
            'name' => $model->name,
            'profile_picture' => optional($model->firstMedia('profile_picture'))->id,
        ];

        if($this->basic){
            return $info;
        }

        $info['email'] = $model->email;
        $info['cover'] = optional($model->firstMedia('cover'))->id;
        $info['description'] = $model->description;

        return $info;
    }

    /**
     * notify transformer to only include basic data
     *
     * @return \Modules\Users\Transformers\UserTransformer
     */
    public function onlyBasic()
    {
        $this->basic = true;
        return $this;
    }
}
