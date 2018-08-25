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
}
