<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answer';

    public $timestamps = false;

    /**
     * Получаем студента, ответившего на вопрос
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Получаем ответ на вопрос
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getAnswer()
    {
        return $this->belongsTo('App\Answer', 'answer_id');
    }

    /**
     * Тест где был оставлен ответ на вопрос
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getTask()
    {
        return $this->belongsTo('App\Task', 'task_id');
    }

    /**
     * Вопрос в котором был оставлен ответ
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getQuestion()
    {
        return $this->belongsTo('App\Question', 'question_id');
    }
}
