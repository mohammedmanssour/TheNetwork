<?php

namespace Modules\Comments\Entities;

use App\User;
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
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
