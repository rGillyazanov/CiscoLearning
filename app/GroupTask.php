<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupTask extends Model
{
    protected $table = 'group_task';

    public $fillable = ['group_id', 'task_id', 'access'];

    public $timestamps = false;

    public function getGroup()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }

    public function getTask()
    {
        return $this->belongsTo('App\Task', 'task_id');
    }
}
