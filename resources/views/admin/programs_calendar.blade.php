@extends('layouts.app')
@section('content')

  <div class="app-body">
    @include('common.sidebar')

    <main class="main">
      <div class="container-fluid">
        <div class="animated fadeIn">
          <div class="row">
            <iframe src="https://calendar.google.com/calendar/embed?src=nrongqst49v6cjcksvi96fml30%40group.calendar.google.com&ctz=Asia%2FDhaka" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
          </div>
        </div>
      </div>
    </main>
    
  </div>

@endsection