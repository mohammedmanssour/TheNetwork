<?php

namespace Modules\Posts\Traits;

use App\User;

trait CanBeLiked {

    /*----------------------------------------------------
    * Relationships
    --------------------------------------------------- */
    public function likedBy()
    {
        return $this->morphToMany(User::class, 'model', 'likes');
    }

    /*----------------------------------------------------
    * Attributes
    --------------------------------------------------- */
    public function getLikedByCountAttribute()
    {
        if(isset($this->getAttributes()['likedBy_count'])){
            return $this->getAttributes()['likedBy_count'];
        }

        return $this->likedBy()->count();
    }

}