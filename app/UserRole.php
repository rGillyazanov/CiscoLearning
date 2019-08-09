<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;

class UserRole extends Model
{
    public $table = "user_roles";

    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany('App\Roles', 'roles', 'role_id', 'id');
    }
}
