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
      <br>
      <p><a target="iframe_a">Preview of documents</a></p>
      @foreach ($files as $file)
      <iframe src="{{ asset($file->path) }}" width="80%" height="500" frameborder="0"></iframe>

      @endforeach
    
    <p><a target="iframe_a"></a></p>
    </div>


  <style>
      input {
        
        width: 20px;
        height:20px;
      }
    </style>

  
    <div class="bg-light p-5 rounded">
      <form id="dataForm" action="{{ route('api.getapi') }}" method="post">
        @csrf
        <h3>Select data to be extracted</h3>
    
        <div class="checkbox-group" style="font-size: 16px;">
         <h5>Risk factors</h5>
        <input type="checkbox" name="data[]" value="hb1ac" checked> Hb1ac <br/>
        <input type="checkbox" name="data[]" value="hypertension" checked> Hypertension <br/>
        <input type="checkbox" name="data[]" value="cholestrol" checked> Cholestrol <br/>
        <input type="checkbox" name="data[]" value="smoking" checked> Smoking <br/>
        <input type="checkbox" name="data[]" value="alcohol" checked> Alcohol <br/>
        <input type="checkbox" name="data[]" value="diet" checked> Diet <br/>
        <input type="checkbox" name="data[]" value="bmi" checked> BMI <br/>
        <input type="checkbox" name="data[]" value="ef" checked> Ejection Fraction <br/>
        <br>
        <h5>Test</h5>
        <input type="checkbox" name="data[]" value="METS" checked> Metabolic Equivalents <br/>
        <br>
        <h5>Heart Rate</h5>
        {{-- <div class="sub-checkbox-group"> --}}
          <input type="checkbox" name="data[]" value="Rest HR" checked> Resting Heart Rate <br/>
          <input type="checkbox" name="data[]" value="Peak HR" checked> Peak Heart Rate <br/>
          <input type="checkbox" name="data[]" value="HR reserve" checked> Heart Rate Reserve<br/>
          <input type="checkbox" name="data[]" value="HR recovery" checked> Heart Rate Recovery<br/>
        {{-- </div> --}}
        {{-- <input type="checkbox" name="data[]" value="BP" checked> Blood Pressure <br/> --}}
        <br><h5>Blood Pressure</h5>
        {{-- <div class="sub-checkbox-group"> --}}
          <input type="checkbox" name="data[]" value="Rest BP" checked> Resting Blood Pressure <br/>
          <input type="checkbox" name="data[]" value="Peak BP" checked> Peak Blood Pressure <br/>
        {{-- </div> --}}
        </div>

        <button type="button" class="btn btn-primary float-right mb-3" onclick="submitForm()">Extract</button>
      </form>
    </div>
    

    <script>
      function submitForm() {
    
      document.getElementById('dataForm').submit();
          
      }
    
    </script>

       
   
@endsection