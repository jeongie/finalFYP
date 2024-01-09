@extends('layouts.app-master')

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

@section('content')
<a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
    <div class="bg-light p-5 rounded">
        <h1>Files</h1>
        @include('layouts.partials.messages')
        <a href="{{ route('files.create') }}" class="btn btn-primary float-right mb-3">Add file(s)</a>

        <table class="w3-table w3-bordered w3-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Size</th>
              <th scope="col">Type</th>
              <th scope="col">Action</th>
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
                  <td width="5%">
                    <form action="{{ route('file.delete', ['id' => $file->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class=".btn btn-danger btn-sm ">Delete</button>
                    </form>
                  </td> 
              </tr>
            @endforeach
            
          </tbody>
        </table>
        <br><br>
        
        @if(count($files) > 0)
          <a href="/files/filelist" class="btn btn-primary btn-right mb-3">Proceed</a>
        @else
          <button class="btn btn-secondary btn-right mb-3" disabled>Proceed (Upload a file first)</button>
        @endif
        {{-- <a href="/files/filelist" class="btn btn-primary btn-right mb-3">Proceed</a>
        <a href="{{ route('files.create') }}" class="btn btn-primary float-right mb-3">Add file/text</a> --}}

    </div>
@endsection