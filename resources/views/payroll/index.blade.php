@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Payroll &nbsp; 
				</h3>
				<ul class="page-breadcrumb breadcrumb">
					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/payroll">Payroll</a>						
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
							<th>Cutoff Start</th>
							<th>Cutoff End</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>						
						@forelse($payroll as $i => $e)
						<tr>
							<td>{!! $i+1 !!}</td>
							<td>{!! $e->code !!}</td>
							<td>{!! $e->payroll !!}</td>
							<td>{!! $e->start !!}</td>
							<td>{!! $e->end !!}</td>
							<td>
							@if($e->isDtrClosed)
								<a class="btn btn-icon-only btn-circle green" target="_blank" href="/reports/tss/{{ $e->id }}" title="View TSS"><i class="fa fa-file-text"></i></a>
								<a class="btn btn-icon-only btn-circle purple"  href="/payroll/process/{{ $e->id }}" title="Process Payroll"><i class="fa fa-file-excel-o"></i></a>
							@else

								
							@endif
							@if($e->isPayrollClosed)
								<a class="btn btn-icon-only btn-circle blue" target="_blank" href="/reports/payroll/{{ $e->id }}" title="View Payroll"><i class="fa fa-file-text"></i></a>
								
							@else
							
								
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
