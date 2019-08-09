<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Имя таблицы с которой связана модель
     * @var string
     */
    protected $table = 'comments';

    public $timestamps = true;

    protected $fillable = ['id', 'text', 'parent', 'practical_id', 'user_id', 'practical_user_id', 'theory_id', 'created_at', 'updated_at'];

    /**
     * Получить пользователя, который оставил комментарий
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Получить лабораторную работу, в которой оставлен комментарий
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getLab()
    {
        return $this->belongsTo('App\Practical', 'practical_id', 'id');
    }

    public function getLabResult()
    {
        return $this->belongsTo('App\PracticalUser', 'practical_user_id', 'id');
    }

    public function getTheory()
    {
        return $this->belongsTo('App\Theory', 'theory_id', 'id');
    }
}
