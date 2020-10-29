@extends('layouts.master')
@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Joborder Maintenance &nbsp; <a class="btn blue" href="{!! url('joborder/create') !!}">Add New</a>
				</h3>
				<ul class="page-breadcrumb breadcrumb">
					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/joborder">Joborder</a>						
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
							<th>Teamleader</th>
							<th>Joborder</th>
					
						
						</tr>
					</thead>
					<tbody>						
						@forelse($joborders as $i => $e)
						<tr>
							<td>{!! $i+1 !!}</td>
							<td>{!! $e->teamleader !!}</td>
							<td>{!! $e->joborder !!}</td>
							
						</tr>
						@empty
						<tr>
							<td colspan="4">No Joborder</td>
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
