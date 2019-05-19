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
            <form class="col-md-12" method="POST" action="/commercials/import" enctype="multipart/form-data">
              @csrf
              <div class="form-row">
                <div class="form-group col-md-12">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="import_file" id="import_file" >
                    <label class="custom-file-label" for="import_file">Choose file...</label>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12 text-center">
                  <a href="/commercials/downloadSample">Download Sample File</a>
                  <br>
                  <div class="col-md-2 offset-md-5">
                      <button type="submit" class="btn btn-success">
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

  <script type="text/javascript">
    $('.custom-file-input').on('change', function() { 
      let fileName = $(this).val().split('\\').pop(); 
      $(this).next('.custom-file-label').addClass("selected").html(fileName); 
    });
  </script>
@endsection