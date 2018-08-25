<?php

namespace Modules\Users\Traits;

use App\User;

trait CanBeFollowed{

    public function followers()
    {
        return $this->morphToMany(User::class, 'model', 'followings');
    }

    /*----------------------------------------------------
     * Attributes
    --------------------------------------------------- */
    public function getFollowersCountAttribute()
    {
        if (isset($this->getAttributes()['followers_count'])) {
            return $this->getAttributes()['followers_count'];
        }

        return $this->followers()->count();
    }

}