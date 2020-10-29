@extends('layouts.master')
@section('content')


		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Employee 201 Form &nbsp;
				</h3>
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/employees">Employees</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						{{ $employee->fullname }}
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<form role="form" method="post" action="/employees/{{ $employee->id }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}
		<div class="row">
			<div class="col-md-6">				
				<div class="portlet box red-intense">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-asterisk"></i> Required Fields
							</div>							
						</div>
						<div class="portlet-body form">							
								<div class="form-body">
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Employee ID</label>
										<div class="col-md-9">
											<div class="input-group input-medium">
												<input type="text" name="empid" value="{{ $employee->empid }}" class="form-control" placeholder="" readonly="readonly">
												<span class="input-group-addon">
												<i class="fa fa-user"></i>
												</span>
											</div>
										</div>
									</div>

									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">First Name</label>
										<div class="col-md-9">
											<input type="text" name="fName" value="{{ $employee->fName }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Middle Name</label>
										<div class="col-md-9">
											<input type="text" name="mName" value="{{ $employee->mName }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Last Name</label>
										<div class="col-md-9">
											<input type="text" name="lName" value="{{ $employee->lName }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Ext</label>
										<div class="col-md-9">
											<input type="text" name="extName" value="{{ $employee->extName }}" class="form-control input-inline input-medium" placeholder="e.g. Jr, Sr, III">											
										</div>
									</div>
									<input type="hidden" name="contractor" value=" ">
									<input type="hidden" name="teamleader" value=" ">
									
									<input type="hidden" name="location" value=" ">
									
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Biometric ID</label>
										<div class="col-md-9">
											<input type="number" name="biometricId" value="{{ $employee->biometricId }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Gender</label>
										<div class="radio-listcol-md-9">
											<label class="radio-inline">
											<input type="radio" name="gender" value="Male" @if($employee->gender=="Male") checked @endif > Male </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="Female" @if($employee->gender=="Female") checked @endif> Female </label>											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Birth Date</label>
										<div class="col-md-9">
											<input type="date" name="birthDate" value="{{ $employee->birthDate }}" class="form-control input-inline input-medium">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">SSS</label>
										<div class="col-md-9">
											<input type="text" name="sss" value="{{ $employee->sss }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">SSS Contribution</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="sss_contribution" value="{{ $employee->sss_contribution }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">HDMF</label>
										<div class="col-md-9">
											<input type="text" name="hdmf" value="{{ $employee->hdmf }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">HDMF Contribution</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="hdmf_contribution" value="{{ $employee->hdmf_contribution }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Philhealth</label>
										<div class="col-md-9">
											<input type="text" name="philhealth" value="{{ $employee->philhealth }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Philhealth Contribution</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="philhealth_contribution" value="{{ $employee->philhealth_contribution }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">TIN</label>
										<div class="col-md-9">
											<input type="text" name="tin" value="{{ $employee->tin }}" class="form-control input-inline input-medium" placeholder="000-000-000">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Date Hired:</label>
										<div class="col-md-9">
											<input type="date" name="hiredDate" value="{{ $employee->hiredDate }}" class="form-control input-inline input-medium">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Address</label>
										<div class="col-md-9">
											<input type="text" name="address" value="{{ $employee->address }}" class="form-control input-inline input-large" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contact no.</label>
										<div class="col-md-9">
											<input type="text"  name="contactNo" value="{{ $employee->contactNo }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Blood Type</label>
										<div class="col-md-9">
											<input type="text" name="bloodType" value="{{ $employee->bloodType }}" class="form-control input-inline input-small" placeholder="">													
										</div>
									</div>	
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Civil Status</label>
										<div class="col-md-9">
											<select type="text" name="civilStatus" class="form-control input-inline input-medium">
												<option value=''> - Select Status -
												<option value='SINGLE'>SINGLE
												<option value='MARRIED'>MARRIED
												<option value='DIVORCED'>DIVORCED
												<option value='WIDOWED'>WIDOWED
												<option value='COHABITING'>COHABITING
												<option value='CIVIL UNION'>CIVIL UNION
												<option value='DOMESTIC PARTNERSHIP'>DOMESTIC PARTNERSHIP
												<option value='UNMARRIED PARTNERS'>UNMARRIED PARTNERS
												<option value='{{ $employee->civilStatus }}' selected="selected">{{ $employee->civilStatus }}
											</select>											
										</div>
									</div>									
									<h3>In Case of Emergency:</h3>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contact Person</label>
										<div class="col-md-9">
											<input type="text" name="emergencyContactPerson" value="{{ $employee->emergencyContactPerson }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contact no</label>
										<div class="col-md-9">
											<input type="text" name="emergencyContactNo" value="{{ $employee->emergencyContactNo }}" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>									
								</div>
								<div class="form-actions">
									<button type="submit" class="btn blue">Submit</button>
									
								</div>
							
						</div>
					</div>
			</div>
			@php
			$x=-1
			@endphp
			<div class="col-md-6">				
				<div class="portlet box purple-plum">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-child"></i> Dependents
							</div>							
						</div>
						<div class="portlet-body form">
							
								<div class="form-body">

								@if($dependent->count())
									<h4>Update Existing</h4>
									<hr>									
									@foreach($dependent as $x => $e)
										<input type="hidden" name="existing_dependent_id[{{$x + 1}}]" value="{{$e->id}}">
										<div class="form-group margin-bottom-10">
											<label class="col-md-3 control-label">Name</label>
											<div class="col-md-9">
												<input type="text" name="existing_dependent_name[{{$x + 1}}]" value="{{ $e->fullName }}" class="form-control input-inline input-medium" placeholder="">											
											</div>
										</div>						
										<div class="form-group margin-bottom-10">
											<label class="col-md-3 control-label">Relationship</label>
											<div class="col-md-9">
												<select type="text" name="existing_dependent_relationship[{{$x + 1}}]" class="form-control input-inline input-medium">
													<option value=''> - Relationship -
													<option value='FATHER'>Father
													<option value='MOTHER'>Mother
													<option value='BROTHER'>Brother
													<option value='SISTER'>Sister
													<option value='SPOUSE'>Spouse
													<option value='CHILD'>Child
													<option value='COUSIN'>Cousin
													<option value='NEPHEW'>Nephew
													<option value='MOTHER IN LAW'>Mother in Law
													<option value='FATHER IN LAW'>Father in Law
													<option value='UNCLE'>Uncle
													<option value='AUNT'>Aunt
													<option value='OTHER'>Other
													<option value='{{ $e->relationship }}' selected="selected">{{ $e->relationship }}
												</select>											
											</div>
										</div>	
										<div class="form-group margin-bottom-20 clearfix">
											<label class="col-md-3 control-label">Birthday:</label>
											<div class="col-md-9">
												<input type="date" name="existing_dependent_bday[{{$x + 1}}]" value="{{ $e->birthDate }}" class="form-control input-inline input-medium">											
											</div>
										</div>
										<hr>
										
									@endforeach
								@endif
								<input type="hidden" name="total_existing" value="{{ $x + 1 }}">
									<h4>Add New</h4>
									<hr>
								@for($i=1;$i<=10;$i++)
									<h5 style="font-weight:bold;">Dependent #{{$i}}</h5>
									<div class="form-group margin-bottom-10">
										<label class="col-md-3 control-label">Name</label>
										<div class="col-md-9">
											<input type="text" name="dependent_name[{{$i}}]" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>						
									<div class="form-group margin-bottom-10">
										<label class="col-md-3 control-label">Relationship</label>
										<div class="col-md-9">
											<select type="text" name="dependent_relationship[{{$i}}]" class="form-control input-inline input-medium">
												<option value=''> - Relationship -
												<option value='FATHER'>Father
												<option value='MOTHER'>Mother
												<option value='BROTHER'>Brother
												<option value='SISTER'>Sister
												<option value='SPOUSE'>Spouse
												<option value='CHILD'>Child
												<option value='COUSIN'>Cousin
												<option value='NEPHEW'>Nephew
												<option value='MOTHER IN LAW'>Mother in Law
												<option value='FATHER IN LAW'>Father in Law
												<option value='UNCLE'>Uncle
												<option value='AUNT'>Aunt
												<option value='OTHER'>Other
											</select>											
										</div>
									</div>	
									<div class="form-group margin-bottom-20 clearfix">
										<label class="col-md-3 control-label">Birthday:</label>
										<div class="col-md-9">
											<input type="date" name="dependent_bday[{{$i}}]" class="form-control input-inline input-medium">											
										</div>
									</div>
									<hr>
									@endfor	
																		
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
