@extends('layouts.master')
@section('content')
<!-- BEGIN CONTENT -->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Employee 201 Form &nbsp;
				</h3>
				@if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/cutoffs">cutoffs</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/cutoff/{{ $cutoff->id }}/edit">{{ $cutoff->name }}</a>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<form role="form" method="post" action="/cutoff/{{ $cutoff->id }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="row">
			<div class="col-md-6 col-md-offset-3">				
				<div class="portlet box red-intense">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-asterisk"></i> Required Fields
							</div>							
						</div>
						<div class="portlet-body form">							
							<div class="form-body">
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Code</label>
									<div class="col-md-9">
										<div class="input-group input-medium">
											<input type="text" name="code" class="form-control" placeholder="" required value="{{ $cutoff->code }}">
											<span class="input-group-addon">
											<i class="fa fa-list-ol"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Payroll</label>
									<div class="col-md-9">
										<input type="date" name="payroll_date" class="form-control input-inline input-medium" placeholder="" required value="{{ $cutoff->payroll }}">											
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Cutoff Start</label>
									<div class="col-md-9">
										<input type="date" name="start_date" class="form-control input-inline input-medium" placeholder="" required value="{{ $cutoff->start }}">											
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Cutoff End</label>
									<div class="col-md-9">
										<input type="date" name="end_date" class="form-control input-inline input-medium" placeholder="" required value="{{ $cutoff->end }}">											
									</div>
								</div>														
							</div>
							<div class="form-actions">
								<button type="submit" class="btn blue">Submit</button>									
							</div>							
						</div>
					</div>
			</div>
			
		</div>
		</form>



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
