<?php

namespace Modules\Users\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * only get basic info for user
     *
     * @var boolean
     */
    protected $basic = false;

    /**
     * include email in transformer
     *
     * @var boolean
     */
    protected $includeEmail = false;

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

        $info['cover'] = optional($model->firstMedia('cover'))->id;
        $info['description'] = $model->description;

        if(!$this->includeEmail){
            return $info;
        }

        $info['email'] = $model->email;

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

    /**
     * notify transformer to include email in info
     *
     * @return \Modules\Users\Transformers\UserTransformer
     */
    public function withEmail()
    {
        $this->includeEmail = true;
        return $this;
    }
}
