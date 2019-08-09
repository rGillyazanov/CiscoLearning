<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theory extends Model
{
    protected $table = 'theories';

    public $timestamps = true;

    public function getComments()
    {
        return $this->hasMany('App\Comment', 'theory_id', 'id');
    }
}
