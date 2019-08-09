<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /**
     * Все студенты программы
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUsers()
    {
        return $this->hasMany("App\Group", "program_id", "id");
    }
}
