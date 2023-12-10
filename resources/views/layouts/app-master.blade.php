<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>Automatic Extraction System</title>

    <!-- Bootstrap core CSS -->
    <link href="/build/assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      .btn-right {
        float: right;
      }


      .custom-btn {
        background-color: DodgerBlue;
        border: none;
        color: white;
        padding: 12px 16px;
        font-size: 16px;
        cursor: pointer;
      }

      /* Darker background on mouse-over */
      .custom-btn:hover {
        background-color: RoyalBlue;
      } */

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="resources\css\app.css" rel="stylesheet">
</head>
<body>

    <main class="container">
        @yield('content')
    </main>

      
  </body>
</html>