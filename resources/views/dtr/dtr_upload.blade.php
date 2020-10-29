@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Upload Manual DTR &nbsp;
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
							<i class="fa fa-cogs"></i>Download DTR Template
						</div>
					</div>
					<div class="portlet-body">
						<form action="/dtr/dtr_download_template" enctype="multipart/form-data" method="post" accept-charset="utf-8">
							{{ csrf_field() }}
							<table width="100%">
								<tr>
									<td>
										Teamleader
									</td>
									<td>
										Location
									</td>
								</tr>
								<tr>
									<td>
										<select name="teamleader" class="form-control">
											<option value=""> - Select Teamleader - </option>
											{!! $teamleaders !!}
										</select><br>
									</td>
									<td>
										<select name="location" class="form-control">
											<option value=""> - Select Location - </option>
											{!! $locations !!}
										</select>
										<br>
									</td>
								</tr>
								<tr>
									<td>
										Start Date
									</td>
									<td>
										End Date
									</td>
								</tr>
								<tr>
									<td>
										<input type="date" name="startdate" class="form-control" min="{!! $BlockDate !!}">
									</td>
									<td>
										<input type="date" name="enddate" class="form-control" min="{!! $BlockDate !!}">
									</td>
								</tr>
							</table>
							<br>
							<input type="submit" class="btn yellow-casablanca btn-sm" value="Download">
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6">	
				<div class="portlet box purple">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Upload DTR
						</div>
					</div>
					<div class="portlet-body">
						<form action="/dtr/dtr_post" enctype="multipart/form-data" method="post" accept-charset="utf-8">
							{{ csrf_field() }}
							<input type="file" name="xls" required><br>
							<input type="submit" class="btn  yellow-casablanca btn-sm" value="Upload">
						</form>
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
