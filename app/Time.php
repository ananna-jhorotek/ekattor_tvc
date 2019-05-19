<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    public $timestamps = false;

    public function programs()
    {
    	return $this->hasMany(Program::class);
    }
}
