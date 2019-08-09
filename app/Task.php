<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = true;

    public function getQuestions()
    {
        return $this->belongsToMany('App\Question', 'task_question');
    }
}
