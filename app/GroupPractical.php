<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPractical extends Model
{
    public $table = 'group_practical';

    public $fillable = ['group_id', 'practical_id', 'access'];

    public $timestamps = false;

    /**
     * Возвращаем модель лабораторной работы
     */
    public function getPractical()
    {
        return $this->belongsTo('App\Practical', 'practical_id', 'id');
    }

    public function getPracticals()
    {
        return $this->hasMany('App\Practical', 'practical_id', 'id');
    }

    /**
     * Возвращаем модель группы, которой предоставлен доступ
     * к лабораторной работе
     */
    public function getGroup()
    {
        return $this->belongsTo('App\Group', 'group_id', 'id');
    }
}
