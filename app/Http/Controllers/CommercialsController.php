<?php

namespace App\Http\Controllers;

use Response;

use App\Exports\CommercialsExport;
use App\Imports\CommercialsImport;

use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Commercial;
use App\Program;
use App\Break_type;
use App\Break_type_program;

class CommercialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        if($status === "1")
        {
            $commercials = Commercial::where('status', 1)->simplePaginate(10);
            return view('admin.commercials_list', compact('commercials'));
        }
        else
        {
            $commercials = Commercial::where('status','<>', 1)->simplePaginate(10);
            return view('admin.commercials_list', compact('commercials'));
        }
        // $commercials = Commercial::all();

        // return view('admin.commercials_pending_list', compact('commercials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = Program::all();
        $breaks = Break_type::all();
        return view('admin.commercials_create', compact('programs','breaks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $attributes = request()->validate(
        [
            'name' => ['required','min:3'],
            'client' => ['required'],
            'brand' => ['required'],
            'program_id' => ['required'],
            'break_id' => ['required'],
            'duration' => ['required','numeric'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'net_rate' => [''],
            'remarks' => ['']
        ]);

        Commercial::create($attributes);

        return redirect('/commercials');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Commercial $commercial)
    {
        // $programs = Program::all();
        // $breaks = Break_type::all();

        $break = $commercial->program->break_type[(($commercial->break_id)-1)]->pivot;
         // $remaining_dur = $commercial->program->break_type[(($commercial->break_id)-1)]->pivot->remaining_dur;
         
        return view('admin.commercials_show', compact('commercial','break')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Commercial $commercial)
    {
        $programs = Program::all();
        $breaks = Break_type::all();

        $br = $commercial->program->break_type[(($commercial->break_id)-1)]->pivot;
        $remaining_dur = $br->duration - $br->occupied;

        return view('admin.commercials_edit', compact('commercial', 'programs','breaks','br'));    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Commercial $commercial)
    {
        request()->validate(
        [
            'name' => ['required','min:3'],
            'client' => ['required'],
            'brand' => ['required'],
            'program_id' => ['required'],
            'break_id' => ['required'],
            'duration' => ['required','numeric'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'start_time' => [Rule::requiredIf(request('status')==1)],
            'end_time' => [Rule::requiredIf(request('status')==1)]
        ]);

        // $commercial->update($attributes);

        $commercial->name = request('name');
        $commercial->client = request('client');
        $commercial->brand = request('brand');
        $prev_program = $commercial->program_id;
        $commercial->program_id = request('program_id');
        $prev_break = $commercial->break_id;
        $commercial->break_id = request('break_id');
        $prev_dur = $commercial->duration;
        $commercial->duration = request('duration');
        $commercial->start_date = request('start_date');
        $commercial->end_date = request('end_date');
        $commercial->net_rate = request('net_rate');
        $commercial->remarks = request('remarks');

        $commercial->start_time = request('start_time');
        $commercial->end_time = request('end_time');
        $prev_status = $commercial->status;
        $curr_status = request('status');
        $commercial->status = request('status');

        $commercial->save();

        if($prev_status==0 && $curr_status==1)
        {
            $break_type = Break_type_program::where('program_id', $commercial->program_id)
            ->where('break_type_id', $commercial->break_id)
            ->first();

             $occupied = $break_type->occupied;

             $break_type->occupied = $occupied + $commercial->duration;

             $break_type->save();
        }
        elseif($prev_status==1 && $curr_status==0)
        {
            $break_type = Break_type_program::where('program_id', $prev_program)
            ->where('break_type_id', $prev_break)
            ->first();

             $occupied = $break_type->occupied;

             $break_type->occupied = $occupied - $prev_dur;

             $break_type->save();
        }
        elseif($prev_status==1 && $curr_status==1)
        {
            if($prev_program != $commercial->program_id || $prev_break != $commercial->break_id)
            {
                // if($prev_dur != $commercial->duration)
                {
                    //Update Prev occupied time
                    $prev_break_type = Break_type_program::where('program_id', $prev_program)
                    ->where('break_type_id', $prev_break)
                    ->first();

                     $occupied = $prev_break_type->occupied;

                     $prev_break_type->occupied = $occupied - $prev_dur;

                     $prev_break_type->save();

                     //Update New occupied time
                     $break_type = Break_type_program::where('program_id', $commercial->program_id)
                    ->where('break_type_id', $commercial->break_id)
                    ->first();

                     $occupied = $break_type->occupied;

                     $break_type->occupied = $occupied + $commercial->duration;

                     $break_type->save();
                }
            }
            else
            {
                if($prev_dur != $commercial->duration)
                {
                    //Update Occupied time
                     $break_type = Break_type_program::where('program_id', $commercial->program_id)
                    ->where('break_type_id', $commercial->break_id)
                    ->first();

                     $prev_occupied = $break_type->occupied;

                     $curr_occupied = $prev_occupied - $prev_dur;
                     $break_type->occupied = $curr_occupied + $commercial->duration;

                     $break_type->save();
                }
            }
        }

        return redirect('/commercials/'.$commercial->id);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commercial $commercial)
    {
        $break_type = Break_type_program::where('program_id', $commercial->program_id)
        ->where('break_type_id', $commercial->break_id)
        ->first();

        $occupied = $break_type->occupied;

        $break_type->occupied = $occupied - $commercial->duration;

        $break_type->save();

        $commercial->delete();

        return redirect('/commercials');
    }

    public function getBreaks(Request $request)
    {
        $break_type = Break_type_program::where('program_id', $request->program_id)
                    ->where('break_type_id', $request->break_id)
                    ->first();
        $prog = Program::find($request->program_id);

        return response()->json([
            'duration' => $break_type->duration,
            'occupied' => $break_type->occupied,
            'prog_st' => $prog->start_time,
            'prog_et' => $prog->end_time
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportCreate()
    {
        $programs = Program::all();
        $breaks = Break_type::all();
        return view('admin.commercials_export', compact('programs','breaks'));
    }

    public function export()
    {
        request()->validate(
        [
            'start_date' => [Rule::requiredIf(request('end_date'))],
            'end_date' => [Rule::requiredIf(request('start_date'))],
        ]);
        // $exportArr=[];
        $exportArr[]=["Ekattor Television"];
        $exportArr[]=["Daily Commercial Schedule"];
        $exportArr[]=[date("d F Y - l").' [From 06:00:00 to 05:59:59]'];
        $exportArr[]=[""];

        $arr=[];

        $ht=0;
        $nt=0;
        $nrbt=0;

        $query = Program::query();
        $query->when(request()->program_id,
        function($q){
            return $q->where('id','=', request()->program_id);
        });
        $query->whereDate('start_date', '<=', date("Y-m-d"))
            ->whereDate('end_date', '>=', date("Y-m-d"));

        $today_programs = $query->orderBy('time_id')->orderBy('start_time')->get();

        foreach ($today_programs as $today_program) {

            $bquery = $today_program->break_type();
            $bquery->when(request()->break_id,
                function($q){
                    return $q->where('break_type_program.break_type_id',request()->break_id);
                });
            $break_types = $bquery->get();
            
            foreach ($break_types as $break_type) {
                
                $cquery = $today_program->commercial()->where('break_id',$break_type->id)->where('status', 0);

                $cquery->when(request()->name,
                function($q){
                    return $q->where('name','=', request()->name);
                });
                $cquery->when(request()->client,
                function($q){
                    return $q->where('client','=', request()->client);
                });
                $cquery->when(request()->brand,
                function($q){
                    return $q->where('brand','=', request()->brand);
                });
                $cquery->when(request()->start_date && request()->end_date,
                function($q){
                    return $q->where('end_date','>=', request()->start_date)
                    ->where('start_date','<=', request()->end_date);
                });
                $commercials = $cquery->orderBy('start_time')->get();

                if(!$commercials->isEmpty())
                {
                    if($today_program->time_id == 1 && $ht==0) 
                    { 
                        $exportArr[]=["Happening Time"];
                        $ht=1;
                    }
                    elseif($today_program->time_id == 2 && $nt==0) 
                    { 
                        $exportArr[]=["Night Time"];
                        $nt=1;
                    }
                    elseif($today_program->time_id == 3 && $nrbt==0) 
                    { 
                        $exportArr[]=["NRB Time"];
                        $nrbt=1;
                    }

                    $str = $break_type->name.' Break of '.$today_program->type.' "'.$today_program->name.'" at '.$today_program->start_time.' - '.$break_type->pivot->duration.'s ';
                    $br=[$str];

                    $exportArr[]=$br;
                    $exportArr[]=["Product Name","Duration","End date","Remarks"];
                    $total=0;

                    foreach ($commercials as $commercial) {
                        $total = $total+$commercial->duration;
                        $arr=[$commercial->name, $commercial->duration, $commercial->end_date, $commercial->remarks];
                        $exportArr[]=$arr;
                    }
                    $remarks = ($total/600)*10;
                    $exportArr[]=["Total",$total,"",$remarks];
                    $exportArr[]=["","","",""];                        
                }
            }         
        }
        $export = new CommercialsExport([$exportArr]);

        return Excel::download($export, 'Commercials.xlsx');
    }

    public function import_create() 
    {
        return view('admin.commercials_import');
    }

    public function import_store(Request $request) 
    {
        // dd(request()->file('import_file'));
        Excel::import(new CommercialsImport, request()->file('import_file'));
        
        return redirect('/commercials')->with('success', 'All good!');
    }

    public function downloadSample()
    {
        $file= public_path(). "/Commercials.csv";

        $headers = array('Content-Type: application/csv', );

        return Response::download($file, 'Sample.csv', $headers);
    }
}
