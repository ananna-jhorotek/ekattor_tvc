@extends('layouts.app')
@section('content')
  <div class="app-body">
      @include('common.sidebar')

      <main class="main">
        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
<table class="table table-striped">
  <thead>
    <tr>
      {{-- <th scope="col">ID</th> --}}
      <th scope="col">Caption/TVC Name</th>
      <th scope="col">Client</th>
      <th scope="col">Brand</th>
      <th scope="col">Program</th>
      <th scope="col">Break</th>
      <th scope="col">Duration</th>
      {{-- <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
      <th scope="col">Start Date</th>
      <th scope="col">End Date</th> --}}
      <th scope="col">Status</th>
      {{-- <th scope="col">Net Rate</th> --}}
      {{-- <th scope="col">Action</th> --}}
    </tr>
  </thead>
  <tbody>
    @foreach ($commercials as $commercial)
    <tr>
      {{-- <th scope="row">{{$commercial->id}}</th> --}}
      <td><a role="button" class="btn btn-link" href="/commercials/{{$commercial->id}}">{{$commercial->name}}</a></td>
      <td>{{$commercial->client}}</td>
      <td>{{$commercial->brand}}</td>
      <td>{{$commercial->program->name}}</td>
      <td>{{$commercial->break->name}}</td>
      <td>{{$commercial->duration}}</td>
      {{-- <td>{{$commercial->start_time}}</td>
      <td>{{$commercial->end_time}}</td>
      <td>{{$commercial->start_date}}</td>
      <td>{{$commercial->end_date}}</td> --}}
      {{-- <td>
        @foreach ($program->day as $day) 
            {{$day->name.','}}
        @endforeach
      </td> --}}
      {{-- <td>{{$program->days}}</td> --}}
      <td>
        @if($commercial->status == 1)
        Approved
        @elseif($commercial->status == 0)
        Pending
        @else
        Rejected
        @endif
      </td>
      {{-- <td>{{$commercial->net_rate}}</td> --}}
      {{-- <td><a role="button" class="btn btn-link" href="/commercials/{{$commercial->id}}/edit"><i class="icon-pencil"></i></a></td>
      <td><form id="dlt-form" action="/commercials/{{$commercial->id}}" method="POST">

        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-link"><i class="icon-trash"></i></button>
      
      </form>
      </td> --}}
    </tr>
    @endforeach
  </tbody>
</table>
<nav>
  <ul class="pagination justify-content-end">
  {{ $commercials->links() }}
  </ul>
</nav>
</div>
</div>
</div>
</main>
      
    </div>

@endsection