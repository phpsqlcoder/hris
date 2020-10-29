@extends('layouts.master')
@section('content')

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
						<a href="/employees">Employees</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/employees/add">Add New</a>
					</li>
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<form role="form" method="post" action="/employees" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="row">
			<div class="col-md-6">				
				<div class="portlet box green">
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
												<input type="text" name="empid" class="form-control" placeholder="" readonly="readonly">
												<span class="input-group-addon">
												<i class="fa fa-user"></i>
												</span>
											</div>
										</div>
									</div>
									
											
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">First Name</label>
										<div class="col-md-9">
											<input type="text" name="fName" class="form-control input-inline input-medium" placeholder="" required>											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Middle Name</label>
										<div class="col-md-9">
											<input type="text" name="mName" class="form-control input-inline input-medium" placeholder="" required>											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Last Name</label>
										<div class="col-md-9">
											<input type="text" name="lName" class="form-control input-inline input-medium" required placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Ext</label>
										<div class="col-md-9">
											<input type="text" name="extName" class="form-control input-inline input-medium" placeholder="e.g. Jr, Sr, III">											
										</div>
									</div>
									<input type="hidden" name="contractor" readonly="readonly" class="form-control" value="{{ Auth::user()->role }}" required>
									{{-- <div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contractor</label>
										<div class="col-md-9">
											<div class="input-group input-medium">
												<input type="text" name="contractor" readonly="readonly" class="form-control" value="{{ Auth::user()->role }}" required>
												<span class="input-group-addon">
												<i class="fa fa-group "></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Teamleader<br>
										& Location</label>
										<div class="col-md-9">
											<select type="text" name="teamleader" class="form-control input-inline input-medium" required>
												<option value=''> - Select Teamleader -
												@forelse($contractors as $contractor)
													<option value="{{ $contractor->contractor }}|{{ $contractor->location }}">{{ $contractor->contractor }} - {{ $contractor->location }}</option>											
												@empty

												@endforelse
												
											</select>											
										</div>
									</div> --}}
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Rate</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="rate" class="form-control input-inline input-medium" placeholder="" value="0.00">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Biometric ID</label>
										<div class="col-md-9">
											<input type="number" name="biometricId" class="form-control input-inline input-medium" placeholder="" value="0">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Gender</label>
										<div class="radio-listcol-md-9">
											<label class="radio-inline">
											<input type="radio" name="gender" value="Male" checked> Male </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="Female"> Female </label>											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Birth Date</label>
										<div class="col-md-9">
											<input type="date" name="birthDate" class="form-control input-inline input-medium">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">SSS</label>
										<div class="col-md-9">
											<input type="text" name="sss" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">SSS Contribution</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="sss_contribution" class="form-control input-inline input-medium" placeholder="" value="0.00">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">HDMF</label>
										<div class="col-md-9">
											<input type="text" name="hdmf" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">HDMF Contribution</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="hdmf_contribution" class="form-control input-inline input-medium" value="0.00" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Philhealth</label>
										<div class="col-md-9">
											<input type="text" name="philhealth" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Philhealth Contribution</label>
										<div class="col-md-9">
											<input type="number" step="0.01" name="philhealth_contribution" class="form-control input-inline input-medium" placeholder="" value="0.00">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">TIN</label>
										<div class="col-md-9">
											<input type="text" name="tin" class="form-control input-inline input-medium" placeholder="000-000-000">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Date Hired:</label>
										<div class="col-md-9">
											<input type="date" name="hiredDate" class="form-control input-inline input-medium" required>											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Address</label>
										<div class="col-md-9">
											<input type="text" name="address" class="form-control input-inline input-large" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contact no.</label>
										<div class="col-md-9">
											<input type="text"  name="contactNo" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Blood Type</label>
										<div class="col-md-9">
											<input type="text" name="bloodType" class="form-control input-inline input-small" placeholder="">													
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
											</select>											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Picture</label>
										<div class="col-md-9">
											<input type="file" name="picture" class="form-control input-inline input-small">													
										</div>
									</div>										
									<h3>In Case of Emergency:</h3>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contact Person</label>
										<div class="col-md-9">
											<input type="text" name="emergencyContactPerson" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>
									<div class="form-group margin-bottom-10 clearfix">
										<label class="col-md-3 control-label">Contact no</label>
										<div class="col-md-9">
											<input type="text" name="emergencyContactNo" class="form-control input-inline input-medium" placeholder="">											
										</div>
									</div>								
								</div>
								<div class="form-actions">
									<button type="submit" class="btn blue">Submit</button>
									
								</div>
							
						</div>
					</div>
			</div>
			<div class="col-md-6">				
				<div class="portlet box yellow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-child"></i> Dependents
							</div>							
						</div>
						<div class="portlet-body form">								
								<div class="form-body">
								@for($i=1;$i<=10;$i++)
									<h5 style="font-weight:bold;">Dependent #{{$i}}</h5>
									<div class="form-group margin-bottom-10">
										<label class="col-md-3 control-label">Full Name:</label>
										<div class="col-md-9">
											<input type="text" name="dependent_name[{{$i}}]" class="form-control input-inline input-sm" placeholder="">											
										</div>
									</div>						
									<div class="form-group margin-bottom-10">
										<label class="col-md-3 control-label">Relationship:</label>
										<div class="col-md-9">
											<select type="text" name="dependent_relationship[{{$i}}]" class="form-control input-inline input-sm">
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
											<input type="date" name="dependent_bday[{{$i}}]" class="form-control input-inline input-sm">											
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
