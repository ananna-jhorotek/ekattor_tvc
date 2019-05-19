<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use App\Program;
use App\Day;
use App\Time;
use App\Cal_event;

class Cal_eventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Program $program)
    {
        foreach($program->day as $day)
        {
            $selected_days[] = $day->id;
        }

        $sel_days_coll = collect($selected_days);

        echo '<pre>';
        echo($sel_days_coll) ;
        echo '</pre>';

        $cal_events_coll = collect($program->cal_events);

        $cal_events_days = $cal_events_coll->map(function ($item, $key) {
            return $item['day_id'];
        })->unique();

        echo '<pre>';
        echo($cal_events_days);
        echo '</pre>';

        $new_days = $sel_days_coll->diff($cal_events_days);
        $old_days = $cal_events_days->diff($sel_days_coll);

        if($new_days)
        {
            $this->store($new_days, $program);
        }

        if($old_days)
        {
            $this->destroy($old_days,$program->id);
        }

        //Check for name update of events

        $first_event = Event::find($program->cal_events()->first()->event_id);

        if($program->name != $first_event->name)
        {
            $this->update_name($program);
        }

        //Check for time update of events
        $startTime = (new Carbon($program->start_time))->format('H:i:s');
        $ev_startTime = ($first_event->startDateTime)->format('H:i:s');
        $endTime = (new Carbon($program->end_time))->format('H:i:s');
        $ev_endTime = ($first_event->endDateTime)->format('H:i:s');

        if($startTime != $ev_startTime || $endTime != $ev_endTime)
        {
            $this->update_time($program,$startTime,$endTime);
        }

        return redirect('/programs/');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {       
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($new_days, $program)
    {

        // $startDateTime = date('Y-m-d H:i:s', strtotime("$program->start_date $program->start_time"));
        $startTime = (new Carbon($program->start_time))->format('H:i:s');

        // $endDateTime = date('Y-m-d H:i:s', strtotime("$program->end_date $program->end_time"));
        $endTime = (new Carbon($program->end_time))->format('H:i:s');

        foreach ($new_days as $new_day) {

            $day_name = Day::findOrFail($new_day)->name;

            $total_days = $this->getDays($day_name);

            foreach ($total_days as $total_day) {     
                echo $day_name.'<br>';


                $event = new Event;

                $event->name = $program->name;

                echo $event->name . '<br>';
                $sdt = $total_day->setTimeFrom($startTime);
                $event->startDateTime = $sdt;
                echo $event->startDateTime . '<br>';

                $edt = $total_day->setTimeFrom($endTime);
                $event->endDateTime = $edt;
                echo $event->endDateTime . '<br>';

                $calendarEvent = $event->save();

                $cal_event = new Cal_event();
                $cal_event->day_id = $new_day;
                $cal_event->program_id = $program->id;
                $cal_event->event_id = $calendarEvent->id;

                // $cal_event->program()->associate($cal_event);

                $cal_event->save();           
            }            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_name($program)
    {
        foreach ($program->cal_events as $cal_event) {
                if($cal_event->event_id)
                {
                    $event = Event::find($cal_event->event_id);

                    $event->name = $program->name ;
                    echo $event->name.'<br>';
                    $event->save();
                }

            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_time($program, $startTime, $endTime)
    {
        foreach ($program->cal_events as $cal_event) {
            if($cal_event->event_id)
            {
                $event = Event::find($cal_event->event_id);

                $sdt = $event->startDateTime->setTimeFrom($startTime);
                $event->startDateTime =  $sdt;
                echo $event->startDateTime.'<br>';

                $edt = $event->endDateTime->setTimeFrom($endTime);
                $event->endDateTime = $edt;
                echo $event->endDateTime.'<br>';

                $event->save();
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($old_days, $program_id)
    {
        foreach ($old_days as $old_day) {
            echo $old_day.'<br>';

            $cal_events = Cal_event::where('program_id', $program_id)
            ->where('day_id', $old_day)
            ->get(); 

            foreach ($cal_events as $cal_event) {
                if($cal_event->event_id)
                {
                    $event = Event::find($cal_event->event_id);

                    $event->delete();
                }

                $cal_event->delete();

            }
        }
    }

    public function getDays($day_name){
        return new \DatePeriod(
            Carbon::parse("First ".$day_name." of May 2019"),
            CarbonInterval::weeks(),
            Carbon::parse("First ".$day_name." of June 2019")
        );
    }

    public function destroyAll()
    {        
        $events = Event::get()->all();

        foreach ($events as $event) {
            echo '<pre>';
            echo($event->startDateTime);
            echo '</pre>';
            $event->delete();
        }
    }
}
