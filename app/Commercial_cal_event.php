<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commercial_cal_event extends Model
{
    public $timestamps = false;
    
	protected $fillable = [
	    'commercial_id',
	    'event_id',
	  ];

    public function commercial()
    {
    	return $this->belongsTo(Commercial::class);
    }

    public function program()
    {
    	return $this->belongsTo(Program::class);
    }
}
