<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Получаем группу студента
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getGroup()
    {
        return $this->belongsTo("App\Group", "group_id");
    }

    /**
     * Получаем все группы пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getGroups()
    {
        return $this->belongsToMany("App\Group", 'group_user');
    }
    
    /**
     * Получаем роль пользователя
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getRole()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    /**
     * Получает все уведомления пользователя
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getNotices()
    {
        return $this->hasMany('App\Notice');
    }
}
