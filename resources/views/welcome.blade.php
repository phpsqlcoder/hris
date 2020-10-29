@extends('layouts.master')
@section('pagecss')
<link href="{{ asset('/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css"/>

@section('content')

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                 Human Resource Information System &nbsp; 
                </h3>               
                
                
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">           
                <div id="datepage" class="col-md-12"></div>
                <div id="records" class="col-md-12" style="margin-top:100px;""></div>           
        </div>



@endsection

@section('pagejs')
<script src="{{ asset('metronic/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>


<script>
jQuery(document).ready(function() {       
    Metronic.init();
    Layout.init();
    QuickSidebar.init();
    
});
</script>

@endsection
