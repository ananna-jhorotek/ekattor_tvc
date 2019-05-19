<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Break_type extends Model
{
    public $timestamps = false;

    protected $table = "break_types";

    public function commercials()
    {
    	return $this->hasMany(Commercial::class);
    }

    public function Program()
    {
    	return $this->belongsToMany(Program::class)->withPivot('duration','occupied');
    }
}
