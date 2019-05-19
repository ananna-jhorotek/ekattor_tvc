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
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <i class="fa fa-align-justify"></i> Commercial </div>
                  <div class="card-body">
                    <form class="col-md-12" method="POST" action="/commercials/{{ $commercial->id }}">
                      @method('PATCH')
                      @csrf
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="name">Caption/TVC Name</label>
                          <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name" value="{{ $commercial->name }}">                   
                          @if ($errors->has('name'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                        </div>
                        <div class="form-group col-md-3">
                          <label for="client">Client</label>
                          <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="client" id="client" value="{{ $commercial->client }}">                   
                          @if ($errors->has('client'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('client') }}</strong>
                              </span>
                          @endif
                        </div>
                        <div class="form-group col-md-3">
                          <label for="brand">Brand</label>
                          <input type="text" class="form-control {{ $errors->has('brand') ? 'is-invalid' : '' }}" name="brand" id="brand" value="{{ $commercial->brand }}">                   
                          @if ($errors->has('brand'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('brand') }}</strong>
                              </span>
                          @endif
                        </div>
                        <div class="form-group col-md-3">
                          <label for="duration">Duration (in sec)</label>
                          <input type="number" min="0" class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" name="duration" id="duration" value="{{ $commercial->duration }}">

                          @if ($errors->has('duration'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('duration') }}</strong>
                              </span>
                          @endif
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="program_id">Program</label>
                          <select name="program_id" id="program_id" class="form-control">
                            @foreach($programs as $program)
                              <option value="{{$program->id}}" <?php if ($program->id===$commercial->program_id) { echo "selected"; } ?> >{{$program->name}}
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="break_id">Break</label>
                          <select name="break_id" id="break_id" class="form-control">
                            @foreach($breaks as $break)
                              <option value="{{$break->id}}" <?php if ($break->id===$commercial->break_id) { echo "selected"; } ?> >{{$break->name}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="slot_duration">Slot Duration (in sec)</label>
                          <input type="number" min="0" class="form-control {{ $errors->has('slot_duration') ? 'is-invalid' : '' }}" name="slot_duration" id="slot_duration" value="{{ $br->duration }}" disabled>

                          @if ($errors->has('slot_duration'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('slot_duration') }}</strong>
                              </span>
                          @endif
                        </div>
                        <div class="form-group col-md-3">
                          <label for="remaining_duration">Remaining Duration (in sec)</label>
                          <input type="number" min="0" class="form-control {{ $errors->has('remaining_duration') ? 'is-invalid' : '' }}" name="remaining_duration" id="remaining_duration" value="{{ $br->duration-$br->occupied }}" disabled>

                          @if ($errors->has('remaining_duration'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('remaining_duration') }}</strong>
                              </span>
                          @endif
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="start_date">Start Date</label>
                          {{-- <input type="text" class="form-control" name="start_date" id="start_date"> --}}
                          <div class="input-group date" id="start_datepicker" data-target-input="nearest">
                            <input type="text" name="start_date" value="{{ $commercial->start_date }}" class="form-control {{ $errors->has('start_date ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#start_datepicker"/>
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
                            <input type="text" name="end_date" value="{{ $commercial->end_date }}" class="form-control {{ $errors->has('end_date ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#end_datepicker"/>
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
                          <input type="number" min="0" class="form-control" name="net_rate" id="net_rate" value="{{ $commercial->net_rate }}">
                        </div>
                        <div class="form-group col-md-3">
                          <label for="remarks">Remarks</label>
                          <input type="text" class="form-control" name="remarks" id="remarks" value="{{ $commercial->remarks }}">
                        </div>
                      </div>                     
                      
                    <hr>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="start_time">Start Time</label>
                          <div class="input-group date" id="start_timepicker" data-target-input="nearest">
                            <input type="text" id="start_time" name="start_time" value="{{ $commercial->start_time }}" class="form-control {{ $errors->has('start_time ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#start_timepicker"/>
                            <div class="input-group-append" data-target="#start_timepicker" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                            </div>
                            @if ($errors->has('start_time'))
                                <span class="invalid-feedback"  style="display: block" role="alert">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
                            @endif
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="end_time">End Time</label>
                          <div class="input-group date" id="end_timepicker" data-target-input="nearest">
                            <input type="text" name="end_time"  value="{{ $commercial->end_time }}" class="form-control {{ $errors->has('end_time ') ? 'is-invalid' : '' }} datetimepicker-input" data-target="#end_timepicker"/>
                            <div class="input-group-append" data-target="#end_timepicker" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                            </div>
                          </div>
                          @if ($errors->has('end_time'))
                              <span class="invalid-feedback" style="display: block" role="alert">
                                  <strong>{{ $errors->first('end_time') }}</strong>
                              </span>
                          @endif
                        </div>
                        <div class="form-group col-md-2 offset-md-1 ">
                          <label for="status"></label>
                          <br>
                          <div class="form-check" style="padding-top: .8rem;">
                            <input class="form-check-input" type="hidden" name="status" value="0">
                            <input class="form-check-input" type="checkbox" id="status" name="status" value="1" <?php if ($commercial->status===1) { echo "checked"; } ?> >
                            <label class="form-check-label" for="status">
                              Approved
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12 text-center">
                          <div class="col-md-2 offset-md-5">
                              <button type="submit" id="save_edit" class="btn btn-primary">
                                  SUBMIT
                              </button>
                          </div>
                        </div>
                      </div>
                    </form>

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
           $('#start_datepicker, #end_datepicker').datetimepicker({
              format: 'YYYY-MM-DD',
              defaultDate: moment()
          });

           var break_type = $("#break_id").val();
           var sub = 0;
           if(Number(break_type)==1){
              sub = {{$br->duration}};
              console.log(sub);
           }

           $('#start_timepicker').datetimepicker({
              format: 'HH:mm:ss',
              defaultDate: moment('{{$commercial->program->start_time}}', 'HH:mm:ss').subtract(sub, 'seconds'),
              minDate: moment('{{$commercial->program->start_time}}', 'HH:mm:ss').subtract(sub, 'seconds'),
              maxDate: moment('{{$commercial->program->end_time}}', 'HH:mm:ss'),
              useCurrent:false
          });
          $('#end_timepicker').datetimepicker({
              format: 'HH:mm:ss',
              defaultDate: moment($('#start_time').val(), 'HH:mm:ss').add({{$commercial->duration}}, 'seconds'),
              maxDate: moment('{{$commercial->program->end_time}}', 'HH:mm:ss'),
              useCurrent:false
          });
      });
  </script>
  <script>
    $(document).ready(function () {
      var duration = $("#duration").val();
      var remaining_dur = $("#remaining_duration").val();

      if(Number(duration) > Number(remaining_dur))
      {
        $('#duration, #remaining_duration').addClass('is-invalid');
        $('#status').attr("disabled", true);

      }
      else{
        $('#duration, #remaining_duration').removeClass('is-invalid');
        $('#status').attr("disabled", false);
      }

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      function ajaxCall(){     

        var sub = 0;
        var program_id = $("#program_id").val();
        var break_id = $("#break_id").val();
        var duration = $("#duration").val();  

        $.ajax({
          type:'POST',
          url:'/getBreaks',
          data:{program_id:program_id, break_id:break_id},
          success:function(data){
            // alert(data.success);
            $('#slot_duration').val(data.duration);
            $remaining_dur = data.duration - data.occupied;
            $('#remaining_duration').val($remaining_dur);

            if(Number(break_id)==1){
              sub = data.duration;
            }

            $('#start_timepicker, #end_timepicker').datetimepicker('minDate', false);
            $('#start_timepicker, #end_timepicker').datetimepicker('maxDate', false);

            $('#start_timepicker, #end_timepicker').datetimepicker('maxDate', moment(data.prog_et, 'HH:mm:ss').format('HH:mm:ss') );
            $('#start_timepicker, #end_timepicker').datetimepicker('minDate', moment(data.prog_st, 'HH:mm:ss').subtract(sub, 'seconds').format('HH:mm:ss') );
            // console.log($('#start_timepicker').datetimepicker('options').minDate);
            // console.log($('#start_timepicker').datetimepicker('options').maxDate);
            $('#start_timepicker').datetimepicker('date', moment(data.prog_st, 'HH:mm:ss').subtract(sub, 'seconds'), );
            $('#end_timepicker').datetimepicker('date', moment($('#start_time').val(), 'HH:mm:ss').add(duration, 'seconds') );

            if($("#duration").val()>$remaining_dur)
            {
              $('#duration, #remaining_duration').addClass('is-invalid');
              $('#status').attr("disabled", true);

              <?php if($commercial->status==1){ ?>
                $('#status').attr("checked", false);                
              <?php } ?>

            }
            else{
              $('#duration, #remaining_duration').removeClass('is-invalid');
              $('#status').attr("disabled", false);

              <?php if($commercial->status==1){ ?>
                $('#status').attr("checked", true);                
              <?php } ?>
            }
          }
        });
      }

      $("#program_id, #break_id").change(function(e){          
        e.preventDefault();
        // $('#start_timepicker').datetimepicker({
        //       format: 'HH:mm:ss',
        //       defaultDate: moment('{{$commercial->program->start_time}}', 'HH:mm:ss'),
        //       maxDate: moment('{{$commercial->program->end_time}}', 'HH:mm:ss'),
        //       useCurrent:false
        //   });
        // $('#start_timepicker').datetimepicker('date', moment('07:00:00', 'HH:mm:ss') );
        ajaxCall();
      });
      $("#duration").keyup(function(e){          
        e.preventDefault(); 
        ajaxCall();
      });

      $('#start_timepicker').on('input', function() {
        var duration = $("#duration").val();

        $st = $('#start_time').val();
        
        $('#end_timepicker').datetimepicker('date', moment($st, 'HH:mm:ss').add(duration, 'seconds') );
      });
    });
  </script>
@endsection