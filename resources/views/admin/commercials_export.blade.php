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
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">Filter
                    <div class="card-header-actions">
                      {{-- <a class="card-header-action btn-setting" href="#">
                        <i class="icon-settings"></i>
                      </a> --}}
                      <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true">
                        <i class="icon-arrow-up"></i>
                      </a>
                      {{-- <a class="card-header-action btn-close" href="#">
                        <i class="icon-close"></i>
                      </a> --}}
                    </div>
                  </div>
                  <div class="collapse show" id="collapseExample">
                    <div class="card-body">
                      <form class="col-md-12" method="POST" action="/commercials/export" enctype="multipart/form-data">
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="name">TVC Name/Caption</label>
                          <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group col-md-4">
                          <label for="name">Client</label>
                          <input type="text" class="form-control" name="client" id="client">
                        </div>                        
                        <div class="form-group col-md-4">
                          <label for="name">Brand</label>
                          <input type="text" class="form-control" name="brand" id="brand">
                        </div>
                        <div class="form-group col-md-3">
                          <label for="program_id">Program</label>
                          <select name="program_id" id="program_id" class="form-control">
                            <option value="">Select</option>
                            @foreach($programs as $program)
                              <option value="{{$program->id}}">{{$program->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="break_id">Break</label>
                          <select name="break_id" id="break_id" class="form-control">
                            <option value="">Select</option>
                            @foreach($breaks as $break)
                              <option value="{{$break->id}}">{{$break->name}}</option>
                            @endforeach
                          </select>
                        </div>
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
                              <span class="invalid-feedback" style="display: block;" role="alert">
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
                              <span class="invalid-feedback" style="display: block;" role="alert">
                                  <strong>{{ $errors->first('end_date') }}</strong>
                              </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12 text-center">
                          <div class="col-md-2 offset-md-5">
                              <button type="submit" class="btn btn-primary">
                                  EXPORT
                              </button>
                          </div>
                        </div>
                      </div>
                    </form>
                    </div>

                  </div>
                </div>
              </div>
              <!-- /.col-->
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