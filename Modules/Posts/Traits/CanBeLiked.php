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
        if(isset($this->getAttributes()['liked_by_count'])){
            return $this->getAttributes()['liked_by_count'];
        }

        return $this->likedBy()->count();
    }

    public function getCurrentUserLikeStatusAttribute(){
        if (isset($this->getAttributes()['current_user_like_status'])) {
            return $this->getAttributes()['current_user_like_status'];
        }

        return $this->likedBy()->where('users.id', optional(auth()->user())->id)->exists();
    }

    /*----------------------------------------------------
    * scopes
    --------------------------------------------------- */
    public function scopeWithCurrentUserLikeStatus($query)
    {
        return $query
                ->selectSub(
                    \DB::table('likes')
                        ->whereRaw("model_id = {$this->getTable()}.id")
                        ->where('model_type', get_class($this))
                        ->where('user_id', optional(auth()->user())->id)
                        ->selectRaw('count(id)')
                    ,'current_user_like_status'
                );

    }

}