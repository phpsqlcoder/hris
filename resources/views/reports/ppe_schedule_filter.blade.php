@extends('layouts.master')
@section('pagecss')
<link href="{{ asset('/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css"/>

@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				APE Schedule &nbsp; 
				</h3>				
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Month</a>
						<i class="fa fa-angle-right"></i>						
					</li>
					<li>						
						<select name="month" id="month" class="form-control" required>
								<option value=""> - Select Month -</option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
									
						</select>												
					</li>				
					<li>
						<a href="#" class="btn blue" style="position:relative;top:-4px;color:white;" onclick="window.open('/reports/ppe_schedule/'+$('#month').val(),'','width=1200,height=900');">
						Go <i class="fa fa-arrow-circle-o-right"></i></a>
					</li>					
				</ul>
				
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
