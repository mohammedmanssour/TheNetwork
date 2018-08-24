<?php

namespace Modules\Posts\Traits;

use Modules\Posts\Entities\Post;
use Illuminate\Database\Eloquent\Model;

trait CanLike{

    /*----------------------------------------------------
    * Relationships
    --------------------------------------------------- */
    public function likes()
    {
        return $this->morphedByMany(Post::class, 'model', 'likes');
    }

    /*----------------------------------------------------
    * methods
    --------------------------------------------------- */
    /**
     * like the required model
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return $this
     */
    public function like(Model $model)
    {
        $this->likes()->attach($model);
        return $this;
    }

    /**
     * unlike the required post
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return $this
     */
    public function unlike(Model $model)
    {
        $this->likes()->detach($model);
        return $this;
    }

    /**
     * check if the current $model was liked by the current user
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return boolean
     */
    public function hasLiked(Model $model)
    {
        return $this->likes()->where('model_id', $model->id)->where('model_type', get_class($model))->count();
    }

}