<?php

namespace Modules\Users\Traits;

use Illuminate\Database\Eloquent\Model;

trait CanFollow {

    public function following()
    {
        return $this->morphedByMany(get_class($this), 'model', 'followings');
    }

    /*----------------------------------------------------
    * methods
    --------------------------------------------------- */
    /**
     * follow model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return $this
     */
    public function follow(Model $model)
    {
        $this->following()->attach($model->id);
        return $this;
    }

    /**
     * unfollow $model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return $this
     */
    public function unfollow(Model $model)
    {
        $this->following()->detach($model->id);
        return $this;
    }

    /**
     * check if current user is following $model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return boolean
     */
    public function isFollowing(Model $model)
    {
        return $this->following()
                ->where('model_id', $model->id)
                ->where('model_type', get_class($model))
                ->exists();
    }

    /*----------------------------------------------------
    * Attributes
    --------------------------------------------------- */
    public function getFollowingCountAttribute()
    {
        if(isset($this->getAttributes()['following_count']))
        {
            return $this->getAttributes()['following_count'];
        }

        return $this->following()->count();
    }
}