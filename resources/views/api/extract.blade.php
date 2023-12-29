@extends('layouts.app-master')

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

@section('content')
<a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
<a href="/files" class="custom-btn"><i class="fa fa-arrow-left"></i></a>
    <div class="bg-light p-5 rounded" >
        <h1>Extracted Medical Data</h1>
        @include('layouts.partials.messages')
        
        {{-- @if(isset($apidata))     FIRST FIRST DISPLAY USER
        <table class="w3-table w3-bordered w3-striped"> 
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">BMI</th>
                <th scope="col">Blood Pressure</th>
              </tr>
            </thead>
                @foreach ($apidata['users'] as $user)
                    <tr>
                        <td>{{ $user['id'] }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                    </tr>
                @endforeach
        </table> --}}

        {{-- FOR EXTRACTED DATA --}}
        @if(isset($apidata))
        <div style="overflow-x:auto;">
            <table class="w3-table w3-bordered w3-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th>PID</th>
                        <th>Date of CABG</th>
                        <th>HbA1c</th>
                        <th>Resting Heart Rate</th>
                        <th>Hypertension</th>
                        <th>Cholestrol</th>
                        <th>Smoking</th>
                        <th>Alcohol</th>
                        <th>BMI</th>
                        <th>Resting Blood Pressure</th>
                        <th>Peak Blood Pressure</th>
                        <th>Metabolic Equivalents</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($apidata as $item)
                        <tr>
                            <td>{{ $item['PID'] }}</td>
                            <td>{{ $item['cabg'] }}</td>
                            <td>{{ $item['hb1ac'] }}</td>
                            <td>{{ $item['Rest HR'] }}</td>
                            <td>{{ $item['hypertension'] }}</td>
                            <td>{{ $item['cholestrol'] }}</td>
                            <td>{{ $item['smoking'] }}</td>
                            <td>{{ $item['alcohol'] }}</td> 
                            <td>{{ $item['bmi'] }}</td>
                            <td>{{ $item['Rest BP'] }}</td>
                            <td>{{ $item['Peak BP'] }}</td>
                            <td>{{ $item['METS'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- @if(isset($apidata) && is_string($apidata))
            <p>{{ $apidata }}</p> --}}

        <div class="card-body">
            {{-- <a href="{{ route('export.excel') }}" class="btn btn-primary float-right mb-3">Export Excel</a> --}}
            <a href="{{ route('store.database') }}" class="btn btn-primary btn-right mb-3">Data extracted is correct!</a>
        </div>

        @else
        <p>No data received from the API.</p>
        @endif
        
    </div>

    



@endsection