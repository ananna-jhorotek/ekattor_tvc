@extends('layouts.app')
@section('content')
  <div class="app-body">
    @include('common.sidebar')

    <main class="main">
      <ol class="breadcrumb">
      </ol>

      <div class="container-fluid">
        <div class="animated fadeIn">
          <div class="row">
            <div class="card border-success">
              <div class="card-header">{{ $program->name }}
                <div class="card-header-actions">
                  
                  <div class="row align-items-center">
                  
                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <form id="cal-form" action="/cal_events/{{$program->id}}/index" method="POST">

                      @method('PATCH')
                      @csrf
                      <button type="submit" class="btn btn-sm btn-pill btn-block btn-success" href="#">
                      Sync to Calendar
                      </button>
                    
                    </form>
                  </div>
                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <a role="button" class="btn btn-sm btn-pill btn-block btn-info" href="/programs/{{$program->id}}/edit">Edit</a>
                  </div>
                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <form id="dlt-form" action="/programs/{{$program->id}}" method="POST">

                      @method('DELETE')
                      @csrf
                      <button type="submit" class="btn btn-sm btn-pill btn-block btn-danger" href="#">
                      Delete
                      </button>
                    
                    </form>
                  </div>
                  
                </div>
                  {{-- <button class="btn btn-sm btn-pill btn-block btn-success">
                    Sync
                  </button> --}}
                </div>
              </div>
              <div class="card-body">
                <div class="bd-example">
                  <dl class="row">
                    <dt class="col-sm-3">Starts at</dt>
                    <dd class="col-sm-3">{{ $program->start_time }}</dd>
                    <dt class="col-sm-3">Ends at</dt>
                    <dd class="col-sm-3">{{ $program->end_time }}</dd>

                    <dt class="col-sm-3">Day Part</dt>
                    <dd class="col-sm-3">{{ $program->time->name}}</dd>
                    <dt class="col-sm-3">Validity</dt>
                    <dd class="col-sm-3">{{ $program->start_date.' to '}} {{ $program->end_date }}</dd>

                    <dt class="col-sm-3">Days</dt>
                    <dd class="col-sm-9">
                      @foreach ($program->day as $day) 
                          {{$day->name.','}}
                      @endforeach
                    </dd>

                    <dt class="col-sm-3">Before Break</dt>
                    <dd class="col-sm-3">{{ $program->break_type[0]->pivot->duration.' sec' }}</dd>
                    <dt class="col-sm-3">Mid 1 Break</dt>
                    <dd class="col-sm-3">{{ $program->break_type[1]->pivot->duration.' sec' }}</dd>
                    

                    <dt class="col-sm-3">Mid 2 Break</dt>
                    <dd class="col-sm-3">{{ $program->break_type[2]->pivot->duration.' sec' }}</dd>
                    <dt class="col-sm-3">Mid 3 Break</dt>
                    <dd class="col-sm-3">{{ $program->break_type[3]->pivot->duration.' sec' }}</dd>

                    {{-- <dt class="col-sm-3">Nesting</dt>
                    <dd class="col-sm-9">
                      <dl class="row">
                        <dt class="col-sm-4">Nested definition list</dt>
                        <dd class="col-sm-8">Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc.</dd>
                      </dl>
                    </dd> --}}
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
      
  </div>

  {{-- Script for date-time picker --}}
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
  <script type="text/javascript">
      $(function () {
           $('#start_datepicker, #end_datepicker').datetimepicker({
              format: 'YYYY-MM-DD'
          });
           $('#start_timepicker, #end_timepicker').datetimepicker({
              format: 'HH:mm:ss'
          });
      });
  </script>
@endsection