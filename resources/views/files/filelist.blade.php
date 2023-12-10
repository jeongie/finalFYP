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
            @foreach($files as $file)
              <tr>
                <td width="3%">{{ $file->id }}</td>
                <td>{{ $file->name }}</td>
                <td width="10%">{{ $file->size }}</td>
                <td width="10%">{{ $file->type }}</td>
                <td width="5%">
              </tr>
            @endforeach
            
          </tbody>
        </table>
        {{-- <a href="/files/extractedfile" class="btn btn-primary btn-right mb-3">Proceed</a> --}}
        {{-- <a href="{{ route('files.create') }}" class="btn btn-primary float-right mb-3">Add file/text</a> --}}
    </div>

    <div class="bg-light p-5 rounded">
      <form id="dataForm">
        <form action="{{ route('api.getapi') }}" method="post">
          @csrf 
          <h5>Select data to be extracted</h5>
          <input type="checkbox" name="data[]" value="date"> Date <br/>
          <input type="checkbox" name="data[]" value="BMI"> BMI <br/>
          <input type="checkbox" name="data[]" value="bp"> Blood Pressure <br/>
  
          {{-- <button type="submit" class="btn btn-primary float-right mb-3">Extract</button> --}}
          <a href="{{ route('api.getapi') }}" class="btn btn-primary btn-right mb-3">Extract</a>
      </form>
    </div>

    {{-- <script>
      function extractData() {
          console.log('extractData function called');
          // Get selected checkboxes
          const checkboxes = document.querySelectorAll('input[name="data[]"]:checked');
          const selectedData = Array.from(checkboxes).map(checkbox => checkbox.value);
  
          // Prepare data for submission
          const formData = new FormData();
          formData.append('_token', document.querySelector('input[name="_token"]').value);
          formData.append('selectedData', JSON.stringify(selectedData));
  
          // Send a POST request to the Laravel route
          fetch('{{ route('files.extract') }}', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              // Handle the response data (e.g., update the UI)
              console.log(data);
          })
          .catch(error => {
              console.error('Error:', error);
          });

          return redirect()->route('files.index')->withSuccess(__('File added successfully.'));
      }
  </script>
   --}}

       
   
@endsection