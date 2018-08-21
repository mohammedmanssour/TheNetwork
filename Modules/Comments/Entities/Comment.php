<?php

namespace Modules\Comments\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'content'
    ];

    /*----------------------------------------------------
    * Relationships
    --------------------------------------------------- */
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
