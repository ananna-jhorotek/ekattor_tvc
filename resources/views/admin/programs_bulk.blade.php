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
            <form class="col-md-12" method="POST" action="/programs/bulk">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-12">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="program_file" id="program_file" >
                    <label class="custom-file-label" for="program_file">Choose file...</label>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12 text-center">
                  <div class="col-md-2 offset-md-5">
                      <button type="submit" class="btn btn-success">
                          UPLOAD
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
@endsection