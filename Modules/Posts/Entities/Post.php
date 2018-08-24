<?php

namespace Modules\Posts\Entities;

use Plank\Mediable\Mediable;
use Modules\Posts\Traits\CanBeLiked;
use Illuminate\Database\Eloquent\Model;
use Modules\Comments\Traits\HasComments;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes,
        Mediable,
        HasComments,
        CanBeLiked;

    protected $fillable = [
        'content'
    ];

    protected $dates = [
        'deleted_at'
    ];

    /*----------------------------------------------------
    * Relationships
    --------------------------------------------------- */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function comments()
    {
        return $this->morphMany(
            \Modules\Comments\Entities\Comment::class,
            'commentable',
            'model_type',
            'model_id'
        );
    }
}
