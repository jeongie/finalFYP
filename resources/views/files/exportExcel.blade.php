<!DOCTYPE html>
@extends('layouts.app-master')

<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />

@section('content')
    <a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Export Extracted Data</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha512-MoRNloxbStBcD8z3M/2BmnT+rg4IsMxPkXaGh2zD6LGNNFE80W3onsAhRcMAMrSoyWL9xD7Ert0men7vR8LUZg==" crossorigin="anonymous" />
        
    </head>
    <body>
        <div class="container">
            <div class="row mt-5">
                <div class="col-6 offset-3">
                    <div class="card">
                        @include('layouts.partials.messages')
                        <div class="card-header">
                            <strong>Export Extracted Data</strong>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('export.excel', ['export_new_files' => true]) }}" class="btn btn-primary mb-3">Export New Files</a>
                            <a href="{{ route('export.excel') }}" class="btn btn-primary mb-3">Export All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

{{--ref: https://www.nicesnippets.com/blog/streaming-export-csv-in-laravel#google_vignette --}}