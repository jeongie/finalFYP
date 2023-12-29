@extends('layouts.app-master')

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

@section('content')
<a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
<a href="/files" class="custom-btn"><i class="fa fa-arrow-left"></i></a>
    <div class="bg-light p-5 rounded">
        <h1>Files</h1>

        @include('layouts.partials.messages')

        <table class="w3-table w3-bordered w3-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Size</th>
              <th scope="col">Type</th>
            </tr>
          </thead>
          <tbody>

            @php
            $counter = 1;
            @endphp

            @foreach($files as $file)
            {{-- <p><a href="{{ route('upload.show', ['id' => $file->id]) }}">{{ $file->name }}</a></p> --}}
              <tr>
                <td width="3%">{{ $counter++ }}</td>
                <td>{{ $file->name }}</td>
                <td width="10%">{{ $file->size }}</td>
                <td width="10%">{{ $file->type }}</td>
                <td width="5%">
              </tr>
            @endforeach
            
          </tbody>
        </table>
    </div>
  
     <div class="iframe-container">
      <iframe src="{{ asset('public/files/' . $file->name) }}" width="100%" height="600" frameborder="0"></iframe>
     </div>
    {{-- <div class="iframe-container">
        <iframe src= Storgae::url(public/file/pre_stress_35891647.docx) width="100%" height="600" frameborder="0"></iframe>
    </div> --}}
    {{-- <iframe src="{{ route('file.show', ['id' => $file->id]) }}" name="iframe_a" height="400px" width="400px" title="Iframe Example"></iframe> --}}

    <p><a href="https://www.w3schools.com" target="iframe_a">Preview of documents</a></p>
    </div>

    {{-- <style>
        .iframe-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 56.25%; /* 16:9 aspect ratio (height: 9/16 = 0.5625) */
        }

        .iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style> --}}

    <div class="bg-light p-5 rounded">
      <form id="dataForm" action="{{ route('api.getapi') }}" method="post">
          @csrf 
          <h5>Select data to be extracted</h5>
          <input type="checkbox" name="data[]" value="date"> Date <br/>
          <input type="checkbox" name="data[]" value="bmi"> BMI <br/>
          <input type="checkbox" name="data[]" value="bp"> Blood Pressure <br/>
  
          {{-- <button type="submit" id= "extract" class="btn btn-primary float-right mb-3">Extract</button> --}}
          <button type="button" onclick="submitForm()">Extract</button>
          {{-- <a href="{{ route('api.getapi') }}" class="btn btn-primary btn-right mb-3">Extract</a> --}}
      </form>
    </div>

    <script>
      function submitForm() {
        // Submit the form using JavaScript
        document.getElementById('dataForm').submit();
    }
  </script>

       
   
@endsection