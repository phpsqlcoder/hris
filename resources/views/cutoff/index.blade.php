@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Cutoff Maintenance &nbsp; <a class="btn blue" href="{!! url('cutoff/create') !!}">Add New</a>
				</h3>
				<ul class="page-breadcrumb breadcrumb">
					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/cutoff">cutoff</a>						
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
						@forelse($cutoffs as $i => $e)
						<tr>
							<td>{!! $i+1 !!}</td>
							<td>{!! $e->code !!}</td>
							<td>{!! $e->payroll !!}</td>
							<td>{!! $e->start !!}</td>
							<td>{!! $e->end !!}</td>
							<td>
								<a class="btn btn-xs purple" href="\cutoff\{{ $e->id }}\edit" title="Edit Cutoff"><i class="fa fa-pencil"> </i>&nbsp;Edit</a>
								<a class="btn btn-xs green" href="\cutoff\{{ $e->id }}\setpayrate" title="Set Payroll Rate"><i class="fa fa-money"></i>&nbsp;Set Payroll Rate</a>
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
<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
    Metronic.init();
	Layout.init();
	QuickSidebar.init();
});
</script>
@endsection
