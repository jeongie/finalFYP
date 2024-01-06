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
        
        {{-- FOR EXTRACTED DATA --}}
        @if(isset($apidata))
        <div style="overflow-x:auto;">
            <table class="w3-table w3-bordered w3-striped" style="font-size: 14px;">
                <thead>
                    <tr>
                        <th>PID</th>
                        {{-- <th>rest bp</th> --}}
                        @if(in_array('cabg', $selectedData))
                            <th>Date of CABG</th>
                        @endif
                        @if(in_array('hb1ac', $selectedData))
                            <th>HbA1c 
                        @endif
                        @if(in_array('Rest HR', $selectedData))
                            <th>Resting Heart Rate
                        @endif
                        @if(in_array('hypertension', $selectedData))
                            <th>Hypertension
                        @endif
                        @if(in_array('cholestrol', $selectedData))
                            <th>Cholestrol
                        @endif
                        @if(in_array('smoking', $selectedData))
                            <th>Smoking
                        @endif
                        @if(in_array('alcohol', $selectedData))
                            <th>Alcohol
                        @endif
                        @if(in_array('bmi', $selectedData))
                            <th>BMI</th>
                        @endif
                        @if(in_array('Rest BP', $selectedData))
                            <th>Resting BP
                        @endif
                        @if(in_array('Peak BP', $selectedData))
                            <th>Peak BP 
                        @endif
                        @if(in_array('METS', $selectedData))
                            <th>Metabolic Equivalents
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @foreach($apidata as $item)
                        <tr>
                            <td>{{ $item['PID'] }}</td>
                            {{-- <td>{{ $item['Rest BP'] }}</td> --}}

                            @if(in_array('cabg', $selectedData))
                                <td>{{ $item['cabg'] }}</td>
                            @endif
                            @if(in_array('hb1ac', $selectedData))
                                <td>{{ $item['hb1ac'] }}</td>
                            @endif
                            @if(in_array('Rest HR', $selectedData))
                                <td>{{ $item['Rest HR'] }}</td>
                            @endif
                            @if(in_array('hypertension', $selectedData))
                                <td>{{ $item['hypertension'] }}</td>
                            @endif
                            @if(in_array('cholestrol', $selectedData))
                                <td>{{ $item['cholestrol'] }}</td>
                            @endif
                            @if(in_array('smoking', $selectedData))
                                <td>{{ $item['smoking'] }}</td>
                            @endif
                            @if(in_array('alcohol', $selectedData))
                                <td>{{ $item['alcohol'] }}</td>
                            @endif
                            @if(in_array('bmi', $selectedData))
                                <td>{{ $item['bmi'] }}</td>
                            @endif
                            @if(in_array('Rest BP', $selectedData))
                                <td>{{ $item['Rest BP'] }}</td>
                            @endif
                            @if(in_array('Peak BP', $selectedData))
                                <td>{{ $item['Peak BP'] }}</td>
                            @endif
                            @if(in_array('METS', $selectedData))
                                <td>{{ $item['METS'] }}</td>
                            @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{-- <form id="dataForm" action="{{ route('store.database') }}" method="post"> --}}
            {{-- <a href="{{ route('export.excel') }}" class="btn btn-primary float-right mb-3">Export Excel</a>  --}}
            {{-- <a href="{{ route('store.database', ['sessionId' => session()->getId()]) }}" class="btn btn-primary btn-right mb-3">Data extracted is correct!</a> --}}
            <form id="dataForm2" action="{{ route('store.database') }}" method="post">
            @csrf
            <input type="hidden" name="selectedData" value="{{ json_encode($selectedData) }}">

            {{--  @foreach ($selectedData as $storeData)
                <input type="hidden" name="selected_data[]" value="{{htmlentities(json_encode($apidata))}}">  --}}
            <button type="submit" class="btn btn-primary float-right mb-3">Store in Database</button>
            {{-- <button type="form" class="btn btn-primary float-right mb-3" onclick="submitForm()">Store in Database</button> --}}
            </form>
        </div>

        <script>
            function submitForm() {
              // Submit the form using JavaScript
              document.getElementById('dataForm2').submit();
          }
        </script>


        @else
        <p>No data received from the API.</p>
        @endif
        
    </div>

    



@endsection