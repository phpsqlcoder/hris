<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HRIS</title>

    <link href="{{ asset('/metronic/assets/google.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>

    @yield('pagecss')

    <link href="{{ asset('/metronic/assets/global/css/components.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/global/css/plugins.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
    <link id="style_color" href="{{ asset('/metronic/assets/admin/layout/css/themes/default.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/metronic/assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content ">
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner" style="width:100%;position: relative;top: -10px;">       
                <a href="/" style="text-decoration: none;"><h3 style="color:#0000;">{{ config('app.name') }}</h3></a>
                
        </div>
         
    </div>

    <div class="clearfix"></div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
                    <li class="sidebar-search-wrapper">
                        <form class="sidebar-search" action="extra_search.html" method="POST">
                            <a href="javascript:;" class="remove">
                            <i class="icon-close"></i>
                            </a>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Employee...">
                                <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
                                </span>
                                <ul class="nav navbar-nav pull-right hide">
                                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                                    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar" style="position:relative;left:30px;">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <i class="icon-bell"></i>
                                        <span class="badge badge-default">
                                        7 </span>
                                        </a>
                                        <ul class="dropdown-menu" style="width:170px;">
                                            <li>
                                                <p>
                                                     You have 14 new notifications
                                                </p>
                                            </li>
                                            <li>
                                                <ul class="dropdown-menu-list scroller" style="height: 250px;">
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                        </span>
                                                        New user registered. <span class="time">
                                                        Just now </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                        </span>
                                                        Server #12 overloaded. <span class="time">
                                                        15 mins </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                        </span>
                                                        Server #2 not responding. <span class="time">
                                                        22 mins </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                        </span>
                                                        Application error. <span class="time">
                                                        40 mins </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                        </span>
                                                        Database overloaded 68%. <span class="time">
                                                        2 hrs </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                        </span>
                                                        2 user IP blocked. <span class="time">
                                                        5 hrs </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                        </span>
                                                        Storage Server #4 not responding. <span class="time">
                                                        45 mins </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                        </span>
                                                        System Error. <span class="time">
                                                        55 mins </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                        <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                        </span>
                                                        Database overloaded 68%. <span class="time">
                                                        2 hrs </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="external">
                                                <a href="#">
                                                See all notifications <i class="m-icon-swapright"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                            </div>
                        </form>
                    </li>
                    <li class="start ">
                        <a href="/">
                        <i class="icon-home"></i>
                        <span class="title">Home</span>                       
                        </a>                        
                    </li>
                    <li class="start ">
                        <a href="/employees">
                        <i class="icon-users"></i>
                        <span class="title">Employees</span>                       
                        </a>                        
                    </li>
                     <li style="display:none;">
                        <a href="javascript:;">
                        <i class="icon-calculator"></i>
                        <span class="title">Update Employees</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="/batchupdate/employees">
                                Download</a>
                            </li>
                            <li>
                                <a href="/batchupdate_upload_page/employees">
                                Upload</a>
                            </li> 
                             <li>
                                <a href="/batchupdate/dependents">
                                Dependents Form</a>
                            </li>                           
                        </ul>
                    </li>
                    
                    <li class="start ">
                        <a href="/cutoff">
                        <i class="icon-calendar"></i>
                        <span class="title">Cutoff</span>                       
                        </a>                        
                    </li>
                    <li class="start " style="display:none;">
                        <a href="/locations">
                        <i class="icon-directions"></i>
                        <span class="title">Teamleader & Location</span>                       
                        </a>                        
                    </li>
                    <li class="start ">
                        <a href="/dtr">
                        <i class="fa fa-file-code-o"></i>
                        <span class="title">DTR List</span>                       
                        </a>                        
                    </li>
                    <li>
                        <a href="javascript:;">
                        <i class="icon-calculator"></i>
                        <span class="title">Add DTR</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">                          
                            <li>
                                <a href="/dtr/create">
                                Add Manual DTR</a>
                            </li>
                            <li style="display:none;">
                                <a href="/dtr/uploadexcel">
                                Upload Biometric Data</a>
                            </li>
                            <li>
                                <a href="/dtr/download_bm">
                                Download Biometric Data</a>
                            </li>
                            <li>
                                <a href="/dtr/uploaddtr">
                                Upload Manual DTR</a>
                            </li>
                        </ul>
                    </li>
                    <li style="display:none;">
                        <a href="/payroll">
                        <i class="icon-envelope-letter"></i>
                        <span class="title">Payroll</span>
                       
                        </a>
                        
                    </li>                   
                    <li>
                        <a href="javascript:;">
                        <i class="icon-support"></i>
                        <span class="title">Maintenance</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">                          
                            <li>
                                <a href="/leaves">
                                <i class="icon-basket"></i>
                                Leave</a>
                            </li>
                            <li>
                                <a href="/shift">
                                <i class="icon-basket"></i>
                                Shift</a>
                            </li>
                            <li>
                                <a href="/position">
                                <i class="icon-basket"></i>
                                Position</a>
                            </li>
                            <li style="display:none;">
                                <a href="/joborder">
                                <i class="icon-basket"></i>
                                Joborder</a>
                            </li>                                                    
                        </ul>
                    </li>
                     <li>
                        <a href="javascript:;">
                        <i class="icon-bar-chart"></i>
                        <span class="title">Reports</span>
                        <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="/reports/tss_filter">
                                <i class="icon-calculator"></i>
                                Time Sheet Summary</a>
                            </li>
                            <li>
                                <a href="/reports/tss_range_filter">
                                <i class="icon-calculator"></i>
                                Time Sheet Summary (Range)</a>
                            </li>
                            <li>
                                <a href="/reports/payroll_filter">
                                <i class="icon-credit-card"></i>
                                Payroll Summary</a>
                            </li>
                            <li>
                                <a href="/reports/deductions_filter">
                                <i class="icon-calculator"></i>
                                Payroll Deductions</a>
                            </li>
                            <li style="display:none;">
                                <a href="/reports/statutories_filter">
                                <i class="icon-credit-card"></i>
                                Advance Statutories</a>
                            </li>   
                            <li>
                                <a href="/reports/payslip_filter">
                                <i class="icon-envelope-letter"></i>
                                Payslip</a>
                            </li>
                            <li>
                                <a href="/reports/masterlist_filter">
                                <i class="fa fa-file-text-o"></i>
                                Masterlist</a>
                            </li>
                            <li style="display:none;">
                                <a href="/reports/ppe_schedule_filter">
                                <i class="fa fa-calendar"></i>
                                APE Schedule</a>
                            </li>
                             <li>
                                <a href="/reports/resigned_filter">
                                <i class="fa fa-calendar"></i>
                                Resigned/Dismissed Employees </a>
                            </li>
                                                         
                        </ul>
                    </li>                   
                    <li class="start ">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-pin"></i>
                        <span class="title">Logout</span>                       
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>                        
                    </li>
                     <li class="sidebar-toggler-wrapper">
                        <div class="sidebar-toggler">
                        </div>
                    </li>
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </div>
    <div class="page-content-wrapper">
        <div class="page-content">  
            @yield('content')
        </div>
    </div>
    </div>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/jquery.cokie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>

    @yield('pagejs')
</body>
</html>

