<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public $timestamps = false;

    public function Program()
    {
    	return $this->belongsToMany(Program::class);
    }
    public function cal_events()
    {
        return $this->hasMany(Cal_event::class);
    }
}
