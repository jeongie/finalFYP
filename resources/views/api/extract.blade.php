@extends('layouts.app-master')

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

@section('content')
<a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
<a href="/files/filelist" class="custom-btn"><i class="fa fa-arrow-left"></i></a>
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
                        <th>Gender</th>
                        <th>Age</th>
                        @if(in_array('hb1ac', $selectedData))
                            <th>HbA1c(%)</th>
                        @endif
                        @if(in_array('hypertension', $selectedData))
                            <th>Hypertension</th>
                        @endif
                        @if(in_array('cholestrol', $selectedData))
                            <th>Cholestrol</th>
                        @endif
                        @if(in_array('smoking', $selectedData))
                            <th>Smoking</th>
                        @endif
                        @if(in_array('alcohol', $selectedData))
                            <th>Alcohol</th>
                        @endif
                        @if(in_array('diet', $selectedData))
                            <th>Diet</th>
                        @endif
                        @if(in_array('bmi', $selectedData))
                            <th>BMI</th>
                        @endif
                        @if(in_array('ef', $selectedData))
                            <th>Ejection Fraction(%)</th>
                        @endif

                        @if(in_array('Rest HR', $selectedData))
                            <th>Resting Heart Rate</th>
                        @endif
                        @if(in_array('Peak HR', $selectedData))
                            <th>Peak Heart Rate</th>
                        @endif
                        @if(in_array('HR reserve', $selectedData))
                            <th>Heart Rate Reserve</th>
                        @endif
                        @if(in_array('HR recovery', $selectedData))
                            <th>Heart Rate Recovery</th>
                        @endif
                        @if(in_array('Rest BP', $selectedData))
                            <th>Resting BP</th>
                        @endif
                        @if(in_array('Peak BP', $selectedData))
                            <th>Peak BP </th>
                        @endif
                        @if(in_array('METS', $selectedData))
                            <th>Metabolic Equivalents</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    @foreach($apidata as $item)
                        <tr>
                            <td>{{ $item['PID'] }}</td>
                            <td>{{ $item['gender'] }}</td>
                            <td>{{ $item['age'] }}</td>
                            @if(in_array('hb1ac', $selectedData))
                                <td>{{ $item['hb1ac'] }}</td>
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
                            @if(in_array('diet', $selectedData))
                                <td>{{ $item['diet'] }}</td>
                            @endif
                            @if(in_array('bmi', $selectedData))
                                <td>{{ $item['bmi'] }}</td>
                            @endif
                            @if(in_array('ef', $selectedData))
                                <td>{{ $item['ef'] }}</td>
                            @endif

                            @if(in_array('Rest HR', $selectedData))
                                <td>{{ $item['Rest HR'] }}</td>
                            @endif
                            @if(in_array('Peak HR', $selectedData))
                                <td>{{ $item['Peak HR'] }}</td>
                            @endif
                            @if(in_array('HR reserve', $selectedData))
                                <td>{{ $item['HR reserve'] }}</td>
                            @endif
                            @if(in_array('HR recovery', $selectedData))
                                <td>{{ $item['HR recovery'] }}</td>
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
            <form id="dataForm2" action="{{ route('store.database') }}" method="post">
            @csrf
            <input type="hidden" name="selectedData" value="{{ json_encode($selectedData) }}">

            <button type="submit" class="btn btn-primary float-right mb-3">Store in Database</button>
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