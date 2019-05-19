@extends('layouts.app')
@section('content')
  <div class="app-body">
    @include('common.sidebar')

    <main class="main">
      <div class="container-fluid">
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
                    <form class="col-md-12" method="POST" action="/programs/filter" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="type">Types</label>
                        <select name="type" id="type" class="form-control">
                          <option value="" selected>Select</option>
                          <option value="Program">Program</option>
                          <option value="News">News</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="time_id">Day Part</label>
                        <select name="time_id" id="time_id" class="form-control">
                          <option value="">Select</option>
                          @foreach($times as $time)
                            <option value="{{$time->id}}">{{$time->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  <button type="submit" class="btn btn-primary">Filter</button>
                  </form>
                  </div>

                </div>
              </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-12">
              <div class="card">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      {{-- <th scope="col">ID</th> --}}
                      <th scope="col">Name</th>
                      <th scope="col">Type</th>
                      <th scope="col">Start Time</th>
                      <th scope="col">End Time</th>
                      <th scope="col">Day Part</th>
                      {{-- <th scope="col">Start Date</th>
                      <th scope="col">End Date</th> --}}
                      {{-- <th scope="col">Days</th> --}}
                      {{-- <th scope="col">Before Break</th>
                      <th scope="col">Mid1 Break</th>
                      <th scope="col">Mid2 Break</th>
                      <th scope="col">Mid3 Break</th> --}}
                      {{-- <th scope="col">Edit</th>
                      <th scope="col">Delete</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($programs as $program)
                    <tr>
                      {{-- <th scope="row">{{$program->id}}</th> --}}
                      <td><a role="button" class="btn btn-link" href="/programs/{{$program->id}}">{{$program->name}}</a></td>
                      <td>{{$program->type}}</td>
                      <td>{{$program->start_time}}</td>
                      <td>{{$program->end_time}}</td>
                      <td>{{$program->time->name}}</td>
                      {{-- <td>{{$program->start_date}}</td>
                      <td>{{$program->end_date}}</td> --}}
                      {{-- <td>
                        @foreach ($program->day as $day) 
                            {{$day->name.','}}
                        @endforeach
                      </td>
                      <td>{{$program->br_dur_before}}</td>
                      <td>{{$program->br_dur_mid1}}</td>
                      <td>{{$program->br_dur_mid2}}</td>
                      <td>{{$program->br_dur_mid3}}</td> --}}
                      {{-- <td><a role="button" class="btn btn-link" href="/programs/{{$program->id}}/edit"><i class="icon-pencil"></i></a></td>
                      <td><form id="dlt-form" action="/programs/{{$program->id}}" method="POST">

                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-link"><i class="icon-trash"></i></button>
                      
                      </form>
                      </td> --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          <nav>
            <ul class="pagination justify-content-end">
            {{ $programs->links() }}
            </ul>
          </nav>
          </div>
        </div>
      </div>
    </main>
      
  </div>

@endsection