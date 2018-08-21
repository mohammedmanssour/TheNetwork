<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Modules\Users\Entities\User as BaseUser;

class User extends BaseUser
{
    use Notifiable;
}
