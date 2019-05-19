@extends('layouts.app')
@section('content')
  <div class="app-body">
      @include('common.sidebar')

      <main class="main">
        <ol class="breadcrumb">
        </ol>

        <div class="container">
          <div class="animated fadeIn">
            <div class="row">
              <form class="col-md-12" method="POST" action="/programs">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{old('name')}}">                   
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-6">
                    <label for="type">Types</label>
                    <select name="type" id="type" class="form-control">
                      <option value="Program" selected>Program</option>
                      <option value="News">News</option>
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="start_time">Start Time</label>
                    {{-- <input type="text" class="form-control" name="start_time" id="start_time"> --}}
                    <div class="input-group date" id="start_timepicker" data-target-input="nearest">
                      <input type="text" name="start_time" class="form-control {{ $errors->has('start_time ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#start_timepicker"/>
                      <div class="input-group-append" data-target="#start_timepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                      </div>
                    </div>
                    @if ($errors->has('start_time'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('start_time') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="end_time">End Time</label>
                    {{-- <input type="text" class="form-control" name="end_time" id="end_time"> --}}
                    <div class="input-group date" id="end_timepicker" data-target-input="nearest">
                      <input type="text" name="end_time" class="form-control {{ $errors->has('end_time ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#end_timepicker"/>
                      <div class="input-group-append" data-target="#end_timepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                      </div>
                    </div>
                    @if ($errors->has('end_time'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('end_time') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="time_id">Day Part</label>
                    <select name="time_id" id="time_id" class="form-control">
                      @foreach($times as $time)
                        <option value="{{$time->id}}">{{$time->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="start_date">Start Date</label>
                    {{-- <input type="text" class="form-control" name="start_date" id="start_date"> --}}
                    <div class="input-group date" id="start_datepicker" data-target-input="nearest">
                      <input type="text" id="start_date" name="start_date" class="form-control {{ $errors->has('start_date ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#start_datepicker"/>
                      <div class="input-group-append" data-target="#start_datepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                    @if ($errors->has('start_date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('start_date') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="end_date">End Date</label>
                    {{-- <input type="text" class="form-control" name="end_date" id="end_date"> --}}
                    <div class="input-group date" id="end_datepicker" data-target-input="nearest">
                      <input type="text" name="end_date" class="form-control {{ $errors->has('end_date ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#end_datepicker"/>
                      <div class="input-group-append" data-target="#end_datepicker" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                    @if ($errors->has('end_date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('end_date') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="days">Days</label>
                    <select name="days[]" id="days" multiple class="form-control {{ $errors->has('days') ? 'is-invalid' : '' }}">
                      @foreach ($days as $day) 
                        <option value="{{$day->id}}">{{$day->name}}</option>
                      @endforeach
                      {{-- <option value="1" selected>Saturday</option>
                      <option value="2">Sunday</option>
                      <option value="3">Monday</option>
                      <option value="4">Tuesday</option>
                      <option value="5">Wednesday</option>
                      <option value="6">Thursday</option>
                      <option value="7">Friday</option>
                      <option value="8">Everyday</option> --}}
                    </select>                   
                    @if ($errors->has('days'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('days') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="br_dur_before">Before Break (in sec)</label>
                    <input type="text" class="form-control {{ $errors->has('br_dur_before') ? 'is-invalid' : '' }}" name="br_dur_before" id="br_dur_before" value="{{old('br_dur_before')}}">

                    @if ($errors->has('br_dur_before'))
                        <span class="invalid-feedback" role="alert">
                            <strong>The before break field is required.</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="br_dur_mid1">Mid1 Break (in sec)</label>
                    <input type="number" class="form-control {{ $errors->has('br_dur_mid1') ? 'is-invalid' : '' }}" name="br_dur_mid1" id="br_dur_mid1" value="{{old('br_dur_mid1')}}">
                    @if ($errors->has('br_dur_mid1'))
                        <span class="invalid-feedback" role="alert">
                            <strong>The mid 1 break field is required.</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="br_dur_mid2">Mid2 Break (in sec)</label>
                    <input type="number" class="form-control {{ $errors->has('br_dur_mid2') ? 'is-invalid' : '' }}" name="br_dur_mid2" id="br_dur_mid2" value="{{old('br_dur_mid2')}}">
                    @if ($errors->has('br_dur_mid2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>The mid 2 break field is required.</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="br_dur_mid3">Mid3 Break (in sec)</label>
                    <input type="number" class="form-control {{ $errors->has('br_dur_mid3') ? 'is-invalid' : '' }}" name="br_dur_mid3" id="br_dur_mid3" value="{{old('br_dur_mid3')}}">
                    @if ($errors->has('br_dur_mid3'))
                        <span class="invalid-feedback" role="alert">
                            <strong>The mid 3 break field is required.</strong>
                        </span>
                    @endif
                  </div>
                </div>
                
                {{-- <div class="form-group">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                      Check me out
                    </label>
                  </div>
                </div> --}}
                <button type="submit" class="btn btn-primary">SUBMIT</button>
              </form>
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
           $('#start_datepicker').datetimepicker({
              format: 'YYYY-MM-DD',
              defaultDate: moment()
          });
          $('#end_datepicker').datetimepicker({
              format: 'YYYY-MM-DD',
              defaultDate: moment().add(1,'years')
          });
           $('#start_timepicker, #end_timepicker').datetimepicker({
              format: 'HH:mm:[00]',
              defaultDate: moment()
          });
      });


  </script>
  <script>
    $(document).ready(function () {
      $('#start_datepicker').on('input', function() {

        $sd = $('#start_date').val();
        console.log($sd);
        
        $('#end_datepicker').datetimepicker('date', moment($sd, 'YYYY-MM-DD').add(1, 'years') );
      });
    });
  </script>
@endsection