@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Upload Employee File &nbsp;
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
		
			<div class="col-md-12">	
				<div class="portlet box purple">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Upload Excel File
						</div>
					</div>
					<div class="portlet-body">
						<form action="/batchupdate_upload/employees" enctype="multipart/form-data" method="post" accept-charset="utf-8">
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
