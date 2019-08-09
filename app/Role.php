<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Получить всех пользователей с ролью
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_roles', 'role_id', 'user_id', 'id', 'id');
    }
}
