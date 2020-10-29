@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				DTR &nbsp;
				</h3>
				<ul class="page-breadcrumb breadcrumb">
					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/dtr">DTR</a>						
					</li>
					
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		
		<div class="row">
			<div class="col-md-6">	
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Download Biometric Data
						</div>
					</div>
					<div class="portlet-body">
						
						<p>Start: <input type="date" name="start" id="start" value="{{ date('Y-m-d') }}">
						&nbsp;&nbsp;&nbsp;End: <input type="date" name="end" id="end" value="{{ date('Y-m-d') }}">
						</p>
						<a onclick="window.open('http://172.16.40.48/cis/tad/bm/download.php?ip=192.168.1.1&start='+$('#start').val()+'&end='+$('#end').val(),'','width=600,height=600');" href="#" class="btn purple">Download Raw Logs</a><br><br>
					{{-- 	@foreach($bm as $name => $ip)
							<a onclick="window.open('http://172.16.40.48/cis/tad/bm/download.php?ip={{ $ip }}&start='+$('#start').val()+'&end='+$('#end').val(),'','width=600,height=600');" href="#" class="btn purple">Download {{ $name }}</a><br><br>
						@endforeach --}}
					</div>
				</div>
			</div>
			<div class="col-md-6">	
				<div class="portlet box purple">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Download Report
						</div>
					</div>
					<div class="portlet-body">
						<div>
							<div class="alert alert-info">
								Make sure to download first the biometric logs before generating the report 
							</div>
							<form action="/dtr/download_bm_generate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								{{ csrf_field() }}
								<p>Start: <input type="date" name="start" id="start" value="{{ date('Y-m-d') }}">
								&nbsp;&nbsp;&nbsp;End: <input type="date" name="end" id="end" value="{{ date('Y-m-d') }}">
								<input type="submit" value="Generate" class="btn green">
								</p>	
							</form>		
						</div>		
						<div>
							<div class="alert alert-info">
								Download Raw Logs per Employee
							</div>
							<form action="/dtr/download_bm_generate_raw" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								{{ csrf_field() }}
								<p>Start: <input type="date" name="start" id="start" value="{{ date('Y-m-d') }}">
								&nbsp;&nbsp;&nbsp;End: <input type="date" name="end" id="end" value="{{ date('Y-m-d') }}">
								<input type="submit" value="Generate" class="btn green">
								</p>	
							</form>		
						</div>			
					</div>
				</div>
			</div>
			
		</div>
		
@endsection

@section('pagejs')
<script src="{{ asset('metronic/assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {  

	jQuery('.postbutton').click(function(){
		 var x = jQuery(this).attr('dataid');
	    bootbox.confirm("This will lock this DTR cutoff. Do you want to continue?", function(result) {
	      if(result){
	      	window.location.href = "/cutoff/"+x+"/postCutoff";
	      }
	    }); 
	});    

    Metronic.init();
	Layout.init();
	QuickSidebar.init();



});
</script>
@endsection
