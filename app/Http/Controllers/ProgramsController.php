<?php

namespace App\Http\Controllers;

use App\Imports\ProgramsImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use App\Program;
use App\Day;
use App\Time;
use App\Program_day;
use App\Cal_event;

class ProgramsController extends Controller
{
    //
    public function index()
    {
    	$programs = Program::paginate(10);
    	$days = Day::all();
        $times = Time::all();

    	return view('admin.programs_list', compact('programs','days','times'));
    }

    public function filter()
    {
        $time = request()->time_id;
        $days = Day::all();
        $times = Time::all();

        // $programs = Program::where('time_id', $time)
        // ->where('name',request()->name)
        // ->get();

        $query = Program::query();
        $query->when($time,
        function($q){
            return $q->where('time_id','=', request()->time_id);
        });
        $query->when(request()->type,
        function($q){
            return $q->where('type','=', request()->type);
        });
        $query->when(request()->name,
        function($q){
            return $q->where('name','=', request()->name);
        });
        $programs = $query->paginate(10);
        // dd($programs->get());

        return view('admin.programs_list', compact('programs','days','times'));

    }

    public function show(Program $program)
    {
        $days = Day::all();
        $times = Time::all();

        foreach($program->day as $day)
        {
            $selected_days[] = $day->pivot->day_id;
        }
        // $selected_days = explode(',', $program->days);
        return view('admin.programs_show', compact('program','selected_days','days','times'));
    }

    public function create()
    {
    	$days = Day::all();
    	$times = Time::all();

    	return view('admin.programs_add', compact('days','times'));
    }

    public function store()
    {
    	request()->validate(
		[
			'name' => ['required','min:3'],
			'type' => ['required'],
			'start_time' => ['required'],
			'end_time' => ['required'],
			'start_date' => ['required'],
			'end_date' => ['required'],
			'days' => ['required'],
			'br_dur_before' => ['required','numeric'],
			'br_dur_mid1' => ['required','numeric'],
			'br_dur_mid2' => ['required','numeric'],
			'br_dur_mid3' => ['required','numeric']
		]);

    	$program = new Program();
    	$program->name = request('name');
    	$program->type = request('type');
    	$program->start_time = request('start_time');
    	$program->end_time = request('end_time');
    	$program->time_id = request('time_id');
    	$program->start_date = request('start_date');
    	$program->end_date = request('end_date');
    	$days=request('days');
    	
        // $times = Time::all();

        // $program_time = Carbon::create($program->start_time);
        // $midnight = Carbon::createMidnightDate();

        // if($program_time->gte($midnight))
        // {
        //     $program_time = Carbon::tomorrow('Asia/Dhaka')->setTimeFrom($program_time);
        //     dump($program_time);
        // }
        // foreach ($times as $time) {
        //     $slot_start = Carbon::create($time->start_time);
        //     $slot_end = Carbon::create($time->end_time);

        //     if($slot_start->gt($slot_end)){
        //         $slot_end = Carbon::tomorrow('Asia/Dhaka')->setTimeFrom($slot_end);
        //         // dump($slot_start);
        //         // dump($slot_end);
        //     }
        //     if($program_time->between($slot_start,$slot_end))
        //     {
        //         dump($time->name);
        //         dump($slot_start);
        //         dump($program_time);
        //         dump($slot_end);
        //     }
        // }

    	$program->save();

        $program->break_type()->attach(1, ['duration' => request('br_dur_before')]);
        $program->break_type()->attach(2, ['duration' => request('br_dur_mid1')]);
        $program->break_type()->attach(3, ['duration' => request('br_dur_mid2')]);
        $program->break_type()->attach(4, ['duration' => request('br_dur_mid3')]);

        foreach ($days as $day_id) {
            $program->day()->attach($day_id);
        }

    	return redirect('/programs');
    }

    public function edit(Program $program)
    {
    	// $program = Program::findOrFail($id);
    	$days = Day::all();
    	$times = Time::all();

    	foreach($program->day as $day)
    	{
    		$selected_days[] = $day->pivot->day_id;
    	}
    	// $selected_days = explode(',', $program->days);
    	return view('admin.programs_edit', compact('program','selected_days','days','times'));
    }

    public function update(Program $program)
    {
    	// $program = Program::findOrFail($id);

    	$program->name = request('name');
    	$program->type = request('type');
    	$program->start_time = request('start_time');
    	$program->end_time = request('end_time');
    	$program->time_id = request('time');
    	$program->start_date = request('start_date');
    	$program->end_date = request('end_date');
    	$days = request('days');
    	// $program->days = implode(',', request('days'));

    	$program->save();

    	$program->day()->sync($days);

        $program->break_type()->sync([1 => ['duration' => request('br_dur_before')], 2 => ['duration' => request('br_dur_mid1')], 3 => ['duration' => request('br_dur_mid2')], 4 => ['duration' => request('br_dur_mid3')]]);

    	return redirect('/programs/'.$program->id);
    }

    public function destroy(Program $program)
    {    	
    	// $program = Program::findOrFail($id);
    	 
    	foreach($program->day as $day)
    	{
            $cal_events = Cal_event::where('program_id', $program->id)
            ->where('day_id', $day->id)
            ->get(); 

            foreach ($cal_events as $cal_event) {
                if($cal_event->event_id)
                {
                    $event = Event::find($cal_event->event_id);

                    $event->delete();
                }

                $cal_event->delete();

            }

    		$program->day()->detach($day->pivot->day_id);

            $program->break_type()->detach([1, 2, 3, 4]);
    	}

        foreach ($program->commercial as $commercial) {
            // $break_type =  $program->break_type()->wherePivot('break_type_id', $commercial->break_id)->first();

            // $occupied = $break_type->occupied;

            // $break_type->occupied = $occupied - $commercial->duration;

            // $break_type->save();

            $commercial->delete();
        }

    	$program->delete();

    	return redirect('/programs');
    }

    public function getDays($day_name){
        return new \DatePeriod(
            Carbon::parse("First ".$day_name." of May 2019"),
            CarbonInterval::weeks(),
            Carbon::parse("First ".$day_name." of July 2019")
        );
    }

    public function bulk_upload()
    {
        return view('admin.programs_bulk');
    }

    public function import() 
    {
        Excel::import(new ProgramsImport, 'programs.xlsx');
        
        // return redirect('/')->with('success', 'All good!');
    }

}
