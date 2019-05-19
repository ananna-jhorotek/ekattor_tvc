<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cal_event extends Model
{

    public $timestamps = false;
    
	protected $fillable = [
	    'program_id',
	    'event_id',
	  ];

    public function program()
    {
    	return $this->belongsTo(Program::class);
    }

    public function day()
    {
    	return $this->belongsTo(Day::class);
    }
}
