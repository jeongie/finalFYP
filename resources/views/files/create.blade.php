@extends('layouts.app-master')

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

@section('content')
    <a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
    <a href="/files" class="custom-btn"><i class="fa fa-arrow-left"></i></a>
    <div class="bg-light p-5 rounded">
        <h1>Add file</h1>
        {{-- @include('layouts.partials.messages') --}}

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('files.store') }}" method="post" enctype="multipart/form-data">
            
            @csrf
            <div class="form-group mt-4">
              <input type="file" name="file[]" class="form-control" multiple accept=".doc,.docx,.pdf"/>
            </div>

            <button class= "w-100 btn btn-lg btn-primary mt-4" type="submit">Save</button>
            
        </form>
        
    </div>
@endsection