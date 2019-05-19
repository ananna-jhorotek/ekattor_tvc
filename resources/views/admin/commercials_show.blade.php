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
              <div class="card-header">{{ $commercial->name }}
                <div class="card-header-actions">
                  
                  <div class="row align-items-center">
                  @if($commercial->status === 0)
                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <a role="button" class="btn btn-sm btn-pill btn-block btn-success" href="/commercials/{{$commercial->id}}/edit">Approve</a>
                  </div>
                  @elseif($commercial->status === 1)
                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <form id="cal-form" action="/commercial_cal_events/{{$commercial->id}}/index" method="POST">

                      @method('PATCH')
                      @csrf
                      <button type="submit" class="btn btn-sm btn-pill btn-block btn-success" href="#">
                      Sync to Calendar
                      </button>
                    
                    </form>
                  </div>

                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <a role="button" class="btn btn-sm btn-pill btn-block btn-info" href="/commercials/{{$commercial->id}}/edit">Edit</a>
                   {{-- <button class="btn btn-info mb-1" type="button" data-toggle="modal" data-target="#infoModal">Edit</button> --}}
                  </div>
                  @endif
                  {{-- <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <form id="cal-form" action="/commercial_cal_events/{{$commercial->id}}/index" method="POST">

                      @method('PATCH')
                      @csrf
                      <button type="submit" class="btn btn-sm btn-pill btn-block btn-success" href="#">
                      Sync to Calendar
                      </button>
                    
                    </form>
                  </div> --}}
                 {{--  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <a role="button" class="btn btn-sm btn-pill btn-block btn-info" href="/commercials/{{$commercial->id}}/edit">Edit</a>
                  </div> --}}
                  <div class="col-6 col-sm-4 col-md-2 col-xl mb-3 mb-xl-0">
                    <form id="dlt-form" action="/commercials/{{$commercial->id}}" method="POST">

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
                    <dt class="col-sm-3">Client</dt>
                    <dd class="col-sm-3">{{ $commercial->client }}</dd>
                    <dt class="col-sm-3">Brand</dt>
                    <dd class="col-sm-3">{{ $commercial->brand }}</dd>

                    <dt class="col-sm-3">Program</dt>
                    <dd class="col-sm-3">{{ $commercial->program->name }}</dd>
                    <dt class="col-sm-3">Duration</dt>
                    <dd class="col-sm-3">{{ $commercial->duration.' sec'}}</dd>

                    <dt class="col-sm-3">Break Slot</dt>
                    <dd class="col-sm-3">{{ $commercial->break->name }}</dd>
                    <dt class="col-sm-3">Slot Duration</dt>
                    <dd class="col-sm-3">{{ $break->duration.' sec' }}</dd>

                    <dt class="col-sm-3">Occupied Slot</dt>
                    <dd class="col-sm-3">{{ $break->occupied.' sec' }}</dd>
                    <dt class="col-sm-3">Remaining Duration</dt>
                    <dd class="col-sm-3">{{ ($break->duration-$break->occupied).' sec'}}</dd>

                    <dt class="col-sm-3">Starts at</dt>
                    <dd class="col-sm-3">{{ $commercial->start_time }}</dd>
                    <dt class="col-sm-3">Ends at</dt>
                    <dd class="col-sm-3">{{ $commercial->end_time }}</dd>

                    <dt class="col-sm-3">Validity</dt>
                    <dd class="col-sm-3">{{ $commercial->start_date.' to '}} {{ $commercial->end_date }}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-3">
                      @if($commercial->status == 1)
                      Approved
                      @elseif($commercial->status == 0)
                      Pending
                      @endif
                    </dd>
                    <dt class="col-sm-3">Net Rate</dt>
                    <dd class="col-sm-3">{{ $commercial->net_rate.' BDT' }}</dd>
                    

                    <dt class="col-sm-3">Remarks</dt>
                    <dd class="col-sm-3">{{ $commercial->remarks }}</dd>

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