<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = true;

    /**
     * Получаем всех студентов группы (без повторений)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUsers()
    {
        return $this->hasMany("App\User", "group_id", "id")->where('role_id', 2)->orderBy('name', 'asc');
    }

    /**
     * Получаем всех студентов группы (С повторениями)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getUsersAll()
    {
        return $this->belongsToMany("App\User");
    }

    /**
     * Возвращаем модель образовательной программы у группы
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getProgram()
    {
        return $this->belongsTo('App\Program', 'program_id', "id");
    }
}
