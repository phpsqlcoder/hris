<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('/metronic/assets/google.css')}}')}}" rel="stylesheet" type="text/css"/>
 
      <link href="{{ asset('/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
      <!-- Global styles END --> 
       
      <!-- Page level plugin styles START -->
      <link href="{{ asset('/metronic/assets/global/plugins/fancybox/source/jquery.fancybox.css')}}" rel="stylesheet">
      <!-- Page level plugin styles END -->

      <!-- Theme styles START -->
      <link href="{{ asset('/metronic/assets/global/css/components.css')}}" rel="stylesheet">
      <link href="{{ asset('/metronic/assets/frontend/layout/css/style.css')}}" rel="stylesheet">
      <link href="{{ asset('/metronic/assets/frontend/layout/css/style-responsive.css')}}" rel="stylesheet">
      <link href="{{ asset('/metronic/assets/frontend/layout/css/themes/red.css')}}" rel="stylesheet" id="style-color">
      <link href="{{ asset('/metronic/assets/frontend/layout/css/custom.css')}}" rel="stylesheet">
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="page-full-width">
    <div class="pre-header">
      <div class="container">        
          <medium>Human Resource Information System </medium><br>  
      </div>
      <br><br>
    </div>
    <br><br>
    <div class="main">
        <div class="page-container">  
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Success!</strong> {{ Session::get('success') }}
                </div>
            @endif
            @if (Session::has('failed'))
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <strong>Error!</strong> {{ Session::get('failed') }}
                </div>
            @endif  
            @yield('content')
        </div>
    </div>
    
   
    <script src="{{ asset('/metronic/assets/global/plugins/jquery-1.11.0.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>      
    <script src="{{ asset('/metronic/assets/frontend/layout/scripts/back-to-top.js')}}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="{{ asset('/metronic/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js')}}" type="text/javascript"></script><!-- pop up -->

    <script src="{{ asset('/metronic/assets/frontend/layout/scripts/layout.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
           
        });
    </script>
</body>
</html>

