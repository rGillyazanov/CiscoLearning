<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;

    public function getTrueAnswer()
    {
        return $this->belongsTo('App\Answer', 'true_answer', 'id');
    }

    public function getAnswers()
    {
        return $this->belongsToMany('App\Answer', 'question_answer', 'question_id', 'answer_id', 'id', 'id');
    }
}
