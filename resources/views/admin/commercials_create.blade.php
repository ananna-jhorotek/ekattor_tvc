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
              <form class="col-md-12" method="POST" action="/commercials">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="name">Caption/TVC Name</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{old('name')}}">                   
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="client">Client</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="client" id="client" value="{{old('client')}}">                   
                    @if ($errors->has('client'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('client') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="brand">Brand</label>
                    <input type="text" class="form-control {{ $errors->has('brand') ? 'is-invalid' : '' }}" name="brand" id="brand" value="{{old('brand')}}">                   
                    @if ($errors->has('brand'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('brand') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="program_id">Program</label>
                    <select name="program_id" id="program_id" class="form-control">
                      @foreach($programs as $program)
                        <option value="{{$program->id}}">{{$program->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="break_id">Break</label>
                    <select name="break_id" id="break_id" class="form-control">
                      @foreach($breaks as $break)
                        <option value="{{$break->id}}">{{$break->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="duration">Duration (in sec)</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" name="duration" id="duration" value="{{old('duration')}}">

                    @if ($errors->has('duration'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('duration') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-3">
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
                  <div class="form-group col-md-3">
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
                  <div class="form-group col-md-3">
                    <label for="net_rate">Net Rate</label>
                    <input type="number" min="0" class="form-control {{ $errors->has('net_rate') ? 'is-invalid' : '' }}" name="net_rate" id="net_rate" value="{{old('net_rate')}}">

                    @if ($errors->has('net_rate'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('net_rate') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="remarks">Remarks</label>
                    <input type="text" class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" name="remarks" id="remarks" value="{{old('remarks')}}">

                    @if ($errors->has('remarks'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('net_rate') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group col-md-12 text-center">
                    <div class="col-md-2 offset-md-5">
                        <button type="submit" class="btn btn-primary">
                            SUBMIT
                        </button>
                    </div>
                  </div>
                </div>
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
              defaultDate: moment().add(1,'months')
          });
      });
  </script>
  <script>
    $(document).ready(function () {
      $('#start_datepicker').on('input', function() {

        $sd = $('#start_date').val();
        
        $('#end_datepicker').datetimepicker('date', moment($sd, 'YYYY-MM-DD').add(1, 'months') );
      });
    });
  </script>
@endsection