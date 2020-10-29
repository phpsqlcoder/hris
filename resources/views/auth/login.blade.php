<!DOCTYPE html>

<html lang="en">

<head>
<meta charset="utf-8"/>
<title>Contractors Information System</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/> -->
<link href="{{ asset('metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="{{ asset('metronic/assets/global/plugins/select2/select2.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/admin/pages/css/login-soft.css')}}" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="{{ asset('metronic/assets/global/css/components.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
<link id="style_color" href="{{ asset('metronic/assets/admin/layout/css/themes/default.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="#">
    {{-- <img src="{{ asset('images/logo.png')}}" alt=""/> --}}
    </a>
</div>

<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
        <h3 class="form-title">Login to your account</h3>
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username" class="control-label visible-ie8 visible-ie9">Username</label>
            <div>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix" id="username" type="text" autocomplete="off" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus/>
                </div>              
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">            
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix"  id="password" type="password" name="password" placeholder="Password" required/>
            </div>
              @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>      
        <div class="form-actions">
            <label class="checkbox">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</label>
            <button type="submit" class="btn blue pull-right">
            Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>     
       
        
        <div class="create-account">
            <p>
                {{ date('Y') }}  &copy; {{-- Philsaga Mining Corp. --}}
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->


</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright" style="color:gray;">
     <small>Developed by: Jundrie</small>
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ asset('metronic/assets/global/plugins/respond.min.js')}}"></script>
<script src="{{ asset('metronic/assets/global/plugins/excanvas.min.js')}}"></script> 
<![endif]-->
<script src="{{ asset('metronic/assets/global/plugins/jquery-1.11.0.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js')}} before bootstrap.min.js')}} to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ asset('metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js')}}"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('metronic/assets/global/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/pages/scripts/login-soft.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
        jQuery(document).ready(function() {     
            Metronic.init(); // init metronic core components
            Layout.init(); // init current layout
            QuickSidebar.init() // init quick sidebar
            Login.init();

            // init background slide images
            $.backstretch([
                "{{ asset('metronic/assets/admin/pages/media/bg/1.jpg')}}",
                "{{ asset('metronic/assets/admin/pages/media/bg/2.jpg')}}",
                "{{ asset('metronic/assets/admin/pages/media/bg/3.jpg')}}",
                "{{ asset('metronic/assets/admin/pages/media/bg/4.jpg')}}"
                ], {
                  fade: 1000,
                  duration: 8000
                }
            );
        });
    </script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>