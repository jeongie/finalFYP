@extends('layouts.app-master')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


@section('content')
    <a href="/dashboard" class="custom-btn"><i class="fa fa-home"></i></a>
    <a href="/files" class="custom-btn"><i class="fa fa-arrow-left"></i></a>

<!DOCTYPE html>
<html>
<head>
    <title>Database Error</title>
</head>
<body>
    <h1>An error occurred while connecting to database page database_error.blade</h1>
    <p>{{ $error }}</p>
</body>
</html>