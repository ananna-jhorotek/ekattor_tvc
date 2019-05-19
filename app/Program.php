<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
	protected $fillable = [
	    'name',
	    'type',
	    'start_time',
	    'end_time',
	    'time_id',
	    'start_date',
	    'end_date',
	    'days',
	    'br_dur_before',
	    'br_dur_mid1',
	    'br_dur_mid2',
	    'br_dur_mid3',
	  ];
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    // protected $attributes = [
    //     'delayed' => false,
    // ];

 //    $programs = App\Program::all();

	// foreach ($programs as $program) {
	//     echo $program->name;
	// }
    public function time()
    {
    	return $this->belongsTo(Time::class);
    }

    public function day()
    {
    	return $this->belongsToMany(Day::class);
    }

    public function break_type()
    {
        return $this->belongsToMany(Break_type::class)->withPivot('duration','occupied');
    }

    public function commercial()
    {
    	return $this->hasMany(Commercial::class);
    }

    public function cal_events()
    {
        return $this->hasMany(Cal_event::class);
    }

    public function commercial_cal_events()
    {
        return $this->hasMany(Commercial_cal_event::class);
    }
}
