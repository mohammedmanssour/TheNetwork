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

}