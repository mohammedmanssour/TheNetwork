<?php

namespace Modules\Posts\Entities;

use App\User;
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
        return $this->belongsTo(User::class);
    }

    /*----------------------------------------------------
    * scopes
    --------------------------------------------------- */
    public function scopeFromFeed($query)
    {
        return $query->whereIn(
            'user_id',
            \DB::table('followings')
                ->select('model_id')
                ->where('user_id', auth()->user()->id)
                ->where('model_type', User::class)
        );
    }

    public function scopeTrendy($query)
    {
        return $query->orderBy('comments_count', 'desc')
                ->orderBy('liked_by_count', 'desc');
    }
}
