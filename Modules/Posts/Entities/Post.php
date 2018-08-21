<?php

namespace Modules\Posts\Entities;

use Plank\Mediable\Mediable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, Mediable;

    protected $fillable = [
        'content'
    ];

    protected $dates = [
        'deleted_at'
    ];
}
