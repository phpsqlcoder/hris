@extends('layouts.master')
@section('content')
<!-- BEGIN CONTENT -->
	
		<!-- BEGIN PAGE HEADER-->
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
						<a href="/employees/{{$employee->id}}">{{$employee->fullName}}</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/violations/{{$employee->id}}/create">Add Violation</a>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
			<div class="row">
			<div class="col-md-12">				
				<div class="portlet box red">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-asterisk"></i> Violation Records
						</div>							
					</div>
					<div class="portlet-body form">							
						<div class="form-body">
							<table class="table table-condensed ">
								<thead>
									<tr>
										<th>Incident Date</th>
										<th>Type</th>
										<th>Suspension Start</th>
										<th>Suspension End</th>
										<th>Details</th>
										<th>Update</th>
									</tr>
								</thead>
								<tbody>
									@forelse($violations as $violation)
									<tr>
										<td>{{ $violation->incidentDateStart }}</td>
										<td>{{ $violation->incidentType }}</td>
										<td>{{ $violation->suspendDateStart }}</td>
										<td>{{ $violation->suspendDateEnd }}</td>
										<td>{{ $violation->details }}</td>
										<td><a href="/violations/{{ $violation->id }}/edit" class="btn btn-xs btn-circle purple"><i class="fa fa-edit"></i></a></td>
									</tr>
									@empty
									<tr>
										<td colspan="6"> - No Records -</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>							
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">				
				@if(empty($violation_e->id))
				<div class="portlet box default">
					<div class="portlet-title">
						<div class="caption" style="color:red;">
							<i class="fa fa-plus"></i> New Violation for {{$employee->fullName}}
						</div>							
					</div>
					<form role="form" method="post" action="/violations">
						{{ csrf_field() }}
						<div class="portlet-body form">							
							<div class="form-body">
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Employee ID</label>
									<div class="col-md-9">
										<div class="input-group input-medium">
											<input type="text" name="empid" class="form-control" placeholder="" readonly="readonly" value="{{$employee->empid}}">
											<span class="input-group-addon">
												<i class="fa fa-user"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Type</label>
									<div class="col-md-9">
										<select type="text" name="incidentType" class="form-control input-inline input-medium" required>
											<option value=''> - Select -
											<option value='Verbal'>Verbal
											<option value='Written'>Written
											<option value='Suspension'>Suspension
											<option value='Dismissal'>Dismissal
											<option value='Blacklist'>Blacklist												
										</select>											
									</div>
								</div>		
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Incident Date</label>
									<div class="col-md-9">
										<input type="date" name="incidentDateStart" class="form-control input-inline input-medium" value="{{date('Y-m-d')}}" required>	
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Details</label>
									<div class="col-md-9">
										<textarea rows="5" cols="30" name="details" class="form-control" required></textarea>																					
									</div>
								</div>

								<h4>If Suspended:</h4>

								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Suspension Start</label>
									<div class="col-md-9">
										<input type="date" name="suspendDateStart" min="{{ $BlockDate }}" class="form-control input-inline input-medium">	
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Suspension End</label>
									<div class="col-md-9">
										<input type="date" name="suspendDateEnd" min="{{ $BlockDate }}" class="form-control input-inline input-medium">	
									</div>
								</div>											
								<input type="hidden" name="employee_id" value="{{$employee->id}}">
								<input type="hidden" name="last_cutoff" value="{{ $BlockDate }}">
							</div>
							<div class="form-actions">
								<button type="submit" class="btn blue pull-right">Submit</button>
							</div>
						</div>
					</form>
				</div>

				@else
				<div class="portlet box default">
					<div class="portlet-title">
						<div class="caption" style="color:red;">
							<i class="fa fa-pencil"></i> Update Violation for {{$employee->fullName}}
						</div>							
					</div>
					<form role="form" method="post" action="/violations/{{ $violation_e->id }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="portlet-body form">							
							<div class="form-body">
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Employee ID</label>
									<div class="col-md-9">
										<div class="input-group input-medium">
											<input type="text" name="empid" class="form-control" placeholder="" readonly="readonly" value="{{$employee->empid}}">
											<span class="input-group-addon">
												<i class="fa fa-user"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Type</label>
									<div class="col-md-9">
										<select type="text" name="incidentType" class="form-control input-inline input-medium" required>
											<option value=''> - Select -
											<option value='Verbal'>Verbal
											<option value='Written'>Written
											<option value='Suspension'>Suspension
											<option value='Blacklist'>Blacklist	
											<option value='{{ $violation_e->incidentType }}' selected>{{ $violation_e->incidentType }}										
										</select>											
									</div>
								</div>		
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Incident Date</label>
									<div class="col-md-9">
										<input type="date" name="incidentDateStart" class="form-control input-inline input-medium" @if (!empty($violation_e->incidentDateStart)) value="{{ $violation_e->incidentDateStart->format('Y-m-d') }}" @endif required>	
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Details</label>
									<div class="col-md-9">
										<textarea rows="5" cols="30" name="details" class="form-control" required>{{ $violation_e->details }}</textarea>																					
									</div>
								</div>

								<h4>If Suspended:</h4>

								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Suspension Start</label>
									<div class="col-md-9">
										<input type="date" name="suspendDateStart" class="form-control input-inline input-medium" @if (!empty($violation_e->suspendDateStart)) value="{{ $violation_e->suspendDateStart->format('Y-m-d')  }}" @endif>	
									</div>
								</div>
								<div class="form-group margin-bottom-10 clearfix">
									<label class="col-md-3 control-label">Suspension End</label>
									<div class="col-md-9">
										<input type="date" name="suspendDateEnd" class="form-control input-inline input-medium"  @if (!empty($violation_e->suspendDateEnd)) value="{{ $violation_e->suspendDateEnd->format('Y-m-d')  }}" @endif>	
									</div>
								</div>											
								<input type="hidden" name="employee_id" value="{{$employee->id}}">
								<input type="hidden" name="last_cutoff" value="{{ $BlockDate }}">
							</div>
							<div class="form-actions">
								<button type="submit" class="btn blue pull-right">Update</button>
							</div>
						</div>
					</form>
				</div>
				@endif
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
