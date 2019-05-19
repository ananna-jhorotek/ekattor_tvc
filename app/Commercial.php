<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commercial extends Model
{
    protected $table = "commercials";

	protected $fillable = [
    	'name',
	    'client',
	    'brand',
	    'program_id',
	    'break_id',
        'start_time',
        'end_time',
	    'duration',
	    'start_date',
	    'end_date',
        'status',
	    'net_rate',
	    'remarks',
  	];

    public function program()
    {
    	return $this->belongsTo(Program::class);
    }

    public function break()
    {
    	return $this->belongsTo(Break_type::class);
    }

    public function commercial_cal_events()
    {
        return $this->hasMany(Commercial_cal_event::class);
    }
}
