@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				DTR &nbsp; <a href="/dtr/create" class="btn green"> Input Logs</a>
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
				<table class="table">
					<thead>
						<tr>
							<th>Seq</th>
							<th>Code</th>
							<th>Payroll</th>
							<th>Cutoff</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>						
						@forelse($dtr as $i => $e)
						<tr>
							<td>{!! $i+1 !!}</td>
							<td>{!! $e->code !!}</td>
							<td>{!! $e->payroll !!}</td>
							<td>{!! date('M d',strtotime($e->start)) !!} - {!! date('M d, Y',strtotime($e->end)) !!}</td>
						
							<td>
							@if($e->isDtrClosed)
								
								<a class="btn btn-xs green" href="\cutoff\{{ $e->id }}\setpayrate" title="Set Payroll Rate"><i class="fa fa-money"></i>&nbsp;Set Payroll Rate</a>								
								<a class="btn btn-xs purple" href="/payroll/load_adjustment/{{ $e->id }}" title="Adjustment"><i class="fa fa-pencil-square-o"></i>&nbsp;Process Payroll</a>
								<a class="btn btn-xs red postbutton" href="#" dataid="{{ $e->id }}" title="Post Cutoff"><i class="fa fa-mail-forward"></i>&nbsp;Post Payroll</a>
								<a class="btn btn-xs red-thunderbird" href="/payroll/delete_record_option/{{ $e->id }}" title="Erase Records"><i class="fa fa-times-circle"></i>&nbsp;Erase Records</a>
							@else
								<a class="btn btn-xs green" href="\cutoff\{{ $e->id }}\setpayrate" title="Set Payroll Rate"><i class="fa fa-money"></i>&nbsp;Set Payroll Rate</a>								
								<a class="btn btn-xs purple" href="/payroll/load_adjustment/{{ $e->id }}" title="Adjustment"><i class="fa fa-pencil-square-o"></i>&nbsp;Process Payroll</a>
								<a class="btn btn-xs red postbutton" href="#" dataid="{{ $e->id }}" title="Post Cutoff"><i class="fa fa-mail-forward"></i>&nbsp;Post Payroll</a>
								<a class="btn btn-xs red-thunderbird" href="/payroll/delete_record_option/{{ $e->id }}" title="Erase Records"><i class="fa fa-times-circle"></i>&nbsp;Erase Records</a>
								
							@endif
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="4">No Leave</td>
						</tr>
						@endforelse					
					</tbody>
				</table>
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
