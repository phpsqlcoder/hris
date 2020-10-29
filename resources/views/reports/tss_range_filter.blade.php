@extends('layouts.master')
@section('pagecss')
<link href="{{ asset('/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css"/>

@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Time Sheet Summary Range &nbsp; 
				</h3>				
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Cutoff</a>
						<i class="fa fa-angle-right"></i>						
					</li>
					<li>						
						<select name="start" id="start" class="form-control" style="width: 200px;">
								<option value=""> - Start -</option>
							@forelse($cutoffs as $i => $e)
								<option value="{{$e->id}}"> {{$e->code}} - {{$e->payroll}} ({{ date('F d',strtotime($e->start))}} to {{ date('F d',strtotime($e->end))}})</option>
							@empty

							@endforelse
						</select>												
					</li>
					<li>						
						<select name="end" id="end" class="form-control" style="width: 200px;">
								<option value=""> - End -</option>
							@forelse($cutoffs as $i => $e)
								<option value="{{$e->id}}"> {{$e->code}} - {{$e->payroll}} ({{ date('F d',strtotime($e->start))}} to {{ date('F d',strtotime($e->end))}})</option>
							@empty

							@endforelse
						</select>													
					</li>
					<li>
						<a href="#" class="btn blue" style="position:relative;top:-4px;color:white;" onclick="window.open('/reports/tss_range/'+$('#start').val()+'|'+$('#end').val(),'','width=1200,height=900');">
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
