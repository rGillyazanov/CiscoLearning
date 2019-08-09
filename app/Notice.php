<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';

    public $timestamps = true;

    protected $fillable = ['text', 'user_id', 'status', 'created_at', 'updated_at'];

    /**
     * Получает пользователя данного уведомления
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Отправляет уведомление от администратора указанному пользователю
     * @param $text
     * @param $user_id
     */
    public function sendNotice(string $text, int $user_id)
    {
        $this->text = $text;
        $this->user_id = $user_id;
        $this->status = 0;

        $this->save();
    }
}
