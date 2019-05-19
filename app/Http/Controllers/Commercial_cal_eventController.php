<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Carbon\CarbonInterval;

use App\Commercial;
use App\Program;
use App\Break_type;

// use App\Day;
// use App\Time;
use App\Commercial_cal_event;

class Commercial_cal_eventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Commercial $commercial)
    {
        //update
        if($commercial->commercial_cal_events->first())
        {
            //Check for corresponding Program update
            if($commercial->program_id != $commercial->commercial_cal_events()->first()->program_id)
            {
                $this->destroy($commercial);
                $this->store($commercial);
            }
            else
            {
                $first_event = Event::find($commercial->commercial_cal_events()->first()->event_id);

                //Check for Name Update of events
                if($commercial->name != $first_event->name)
                {
                    $this->update_name($commercial);
                }

                //Check for time update of events
                $startTime = (new Carbon($commercial->start_time))->format('H:i:s');
                $ev_startTime = ($first_event->startDateTime)->format('H:i:s');
                $endTime = (new Carbon($commercial->end_time))->format('H:i:s');
                $ev_endTime = ($first_event->endDateTime)->format('H:i:s');

                if($startTime != $ev_startTime || $endTime != $ev_endTime)
                {
                    $this->update_time($commercial, $startTime,$endTime);
                }
            }
        }
        //insert
        else
        {
            $this->store($commercial);
        }

        return redirect('/commercials/?status=1'); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($commercial)
    {
        foreach ($commercial->program->cal_events as $program_cal_event) {
                $program_event = Event::find($program_cal_event->event_id);

                $startTime = (new Carbon($commercial->start_time))->format('H:i:s');
                $endTime = (new Carbon($commercial->end_time))->format('H:i:s');

                $event = new Event;

                $event->name = $commercial->name;
                echo $event->name . '<br>';

                $sdt = ($program_event->startDateTime)->setTimeFrom($startTime);
                $event->startDateTime = $sdt;
                echo $event->startDateTime . '<br>';

                $edt = ($program_event->endDateTime)->setTimeFrom($endTime);
                $event->endDateTime = $edt;
                echo $event->endDateTime . '<br>';

                $calendarEvent = $event->save();

                $commercial_cal_event = new Commercial_cal_event();
                $commercial_cal_event->commercial_id = $commercial->id;
                $commercial_cal_event->program_id = $commercial->program_id;
                $commercial_cal_event->event_id = $calendarEvent->id;

                // $cal_event->program()->associate($cal_event);

                $commercial_cal_event->save();
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
    public function update_name($commercial)
    {
        foreach ($commercial->commercial_cal_events as $cal_event) {
            if($cal_event->event_id)
            {
                $event = Event::find($cal_event->event_id);

                $event->name = $commercial->name ;
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
    public function update_time($commercial, $startTime, $endTime)
    {
        foreach ($commercial->commercial_cal_events as $cal_event) {
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
    public function destroy($commercial)
    {
        foreach ($commercial->commercial_cal_events as $cal_event) {
            if($cal_event->event_id)
            {
                $event = Event::find($cal_event->event_id);

                $event->delete();
            }

            $cal_event->delete();
        }
    }
}
