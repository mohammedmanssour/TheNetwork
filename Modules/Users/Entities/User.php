<?php

namespace Modules\Users\Entities;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'description', 'type', 'confirmed_at', 'suspended_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'confirmed_at', 'suspended_at'
    ];

    /*----------------------------------------------------
    * Methods
    --------------------------------------------------- */
    /**
     * set user account as confirmed
     *
     * @return \Modules\Users\Entities\User $this
     */
    public function confirmed()
    {
        $this->confirmed_at = Carbon::now()->toDateTimeString();
        $this->save();
        return $this;
    }

    /**
     * suspend user account
     *
     * @return \Modules\Users\Entities\User $this
     */
    public function suspend()
    {
        $this->suspended_at = Carbon::now()->toDateTimeString();
        $this->save();
        return $this;
    }

    /**
     * activate user account
     *
     * @return \Modules\Users\Entities\User $this
     */
    public function activate()
    {
        $this->suspended_at = null;
        $this->save();
        return $this;
    }

    /*----------------------------------------------------
    * Scopes
    --------------------------------------------------- */
    public function scopeWhereActive($query)
    {
        return $query->whereNotNull('confirmed_at')
                    ->whereNull('suspended_at');
    }
}
