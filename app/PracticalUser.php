<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PracticalUser extends Model
{
    public $table = 'practical_user';

    public $fillable = ['practical_id', 'user_id', 'score_id', 'created_at', 'updated_at', 'file'];

    /**
     * Получить практическую с оценкой
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getPractical()
    {
        return $this->belongsTo('App\Practical', 'practical_id', 'id');
    }

    /**
     * Получить студента выполнившего лабораторную
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Получить оценку студента за лабораторную работу
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getScore()
    {
        return $this->belongsTo('App\Score', 'score_id', 'id');
    }

    /**
     * Получить комментарии к указанной выполненной работе
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getComments()
    {
        return $this->hasMany('App\Comment', 'practical_user_id', 'id');
    }
}
