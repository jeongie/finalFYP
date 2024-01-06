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
      @foreach ($files as $file)
      {{-- <iframe src="{{Storage::disk('public')->url($file->path)}}" width="800" height="600"></iframe> --}}
      {{-- {{Storage::disk('public')->url($file->path)}} --}}
      <iframe src="{{ asset('files/pre_stress_35891647e.docx') }}" width="100%" height="600" frameborder="0"></iframe>
      @endforeach
    
      {{-- <iframe src="{{ asset('file/pre_stress_35891647e.docx') }}" width="100%" height="600" frameborder="0"></iframe> --}}
      {{-- <iframe src="https://docs.google.com/gview?url=C:/Users/hui_c/Downloads/report/pre_stress_35891647.docx&embedded=true"></iframe> --}}
    {{-- <div class="iframe-container">
        <iframe src= Storgae::url(public/file/pre_stress_35891647.docx) width="100%" height="600" frameborder="0"></iframe>
    </div> --}}
    {{-- <iframe src="https://docs.google.com/gview?url=C:/Users/hui_c/Downloads/report/pre_stress_35891647.docx&embedded=true"></iframe>
    <iframe src="{{ asset('public/files/F0326941-1756-4366-91C4-ABFBB0E77C42.pdf') }}" style="width:100%; height:600px;" frameborder="0"></iframe> --}}

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
          <input type="checkbox" name="data[]" value="cabg"> CABG <br/>
          <input type="checkbox" name="data[]" value="hb1ac"> Hb1ac <br/>
          <input type="checkbox" name="data[]" value="Rest HR"> Resting Heart Rate <br/>
          <input type="checkbox" name="data[]" value="hypertension"> Hypertension <br/>
          <input type="checkbox" name="data[]" value="cholestrol"> Cholestrol <br/>
          <input type="checkbox" name="data[]" value="smoking"> Smoking <br/>
          <input type="checkbox" name="data[]" value="alcohol"> Alcohol <br/>
          <input type="checkbox" name="data[]" value="bmi"> BMI <br/>
          <input type="checkbox" name="data[]" value="Rest BP"> Resting Blood Pressure <br/>
          <input type="checkbox" name="data[]" value="Peak BP"> Peak Blood Pressure <br/>
          <input type="checkbox" name="data[]" value="METS"> Metabolic Equivalents <br/>
  
          <button type="button" class="btn btn-primary float-right mb-3" onclick="submitForm()">Extract</button>
      </form>
    </div>

    <script>
      function submitForm() {
        // Submit the form using JavaScript
        document.getElementById('dataForm').submit();
    }
  </script>

       
   
@endsection