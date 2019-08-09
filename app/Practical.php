<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Practical extends Model
{
    public $timestamps = true;
    
    /**
     * Получить пользователя, который добавил лабораторную
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('App\User', "user_id", "id");
    }

    /**
     * Получить все комментарии к определенной лабораторной
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getComments()
    {
        return $this->hasMany('App\Comment', 'practical_id');
    }
}
