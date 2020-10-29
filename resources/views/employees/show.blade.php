@extends('layouts.master')
<link href="{{ asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('metronic/assets/admin/pages/css/profile.css') }}" rel="stylesheet" type="text/css"
@section('content')

		<div class="modal fade in" id="basic" tabindex="-1" role="basic" aria-hidden="false">
			<div class="modal-dialog">
				<div class="modal-content">
				<form action="/employees/{{$employee->id}}/resign" method="post">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Resign {{$employee->fullName}}</h4>
					</div>
					<div class="modal-body">
						<div class="note note-danger">
							<h4 class="block">Note:</h4>
							<p>
								 This is for voluntary resignation only. If this employee has been forced to resign because of violation, kindly proceed to Violation tab.
							</p>
						</div>
						<p>Effectivity Date:</p>
						<input type="date" name="resigned_date" class="form-control" value="{{date('Y-m-d')}}">
						<p>Reason:</p>
						 <textarea name="resign_reason" id="" cols="30" class="form-control" rows="10" required="required" placeholder="Enter reason for resignation here.."></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn blue" value="Submit">
					</div>
				</div>
				</form>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Employee Profile &nbsp;
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


		<div class="row profile">
				<div class="col-md-12">
					<!--BEGIN TABS-->
					<div class="tabbable tabbable-custom tabbable-full-width">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tab_1_1" data-toggle="tab"><i class="fa fa-user"></i>
								Profile </a>
							</li>
							<li>
								<a href="#tab_1_2" data-toggle="tab"><i class="fa fa-files-o"></i>
								Work History </a>
							</li>
							<li>
								<a href="#tab_1_3" data-toggle="tab"><i class="fa fa-hospital-o"></i>
								Leave </a>
							</li>
							<li>
								<a href="#tab_1_4" data-toggle="tab"><i class="fa fa-calendar"></i>
								DTR </a>
							</li>
							<li>
								<a href="#tab_1_6" data-toggle="tab"><i class="fa fa-ruble"></i>
								Payroll </a>
							</li>
							<li>
								<a href="#tab_1_20" data-toggle="tab"><i class="fa fa-credit-card"></i>
								Loans </a>
							</li>
							<li>
								<a href="#tab_1_7" data-toggle="tab"><i class="fa fa-warning"></i>
								Violations <span class="badge badge-danger">{{ count($violations) }}</span></a>
							</li>
							<li>
								<a href="#tab_1_8" data-toggle="tab"><i class="fa fa-child"> </i>
								Dependents <span class="badge badge-success">{{count($dependents)}}</span></a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_1">
								<div class="row">
									<div class="col-md-3">
										<ul class="list-unstyled profile-nav">
											
											@if($employee->image)
												<img src="{{ asset('images/'.$employee->image) }}" class="img-responsive" alt="" width="200" />	
											@else
												<img src="{{ asset('metronic/assets/admin/pages/media/profile/avatar.png') }}" class="img-responsive" alt="" width="200" />
											@endif	
											</li>
											<li>&nbsp;</li>
											<li>
												<small>Employment Status:</small> {{ $employee->status }}										
											</li>
											<li>
												<small>Date Hired:</small> {{ $employee->hiredDate }}								
											</li>
											{{-- <li>
												<small>Contractor:</small> {{ $employee->contractor }}										
											</li>
											<li>
												<small>Teamleader:</small> {{ $employee->teamleader }}										
											</li> --}}
											
											
										</ul>
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-8 profile-info">
												<h1>{{$employee->fullName}}</h1>
												<a href="/employees/{{$employee->id}}/edit" class="btn green btn-xs"><i class="fa fa-pencil"></i> Update</a>
												<a data-toggle="modal" href="#basic" class="btn red btn-xs"><i class="fa fa-times"></i> Tag as Resign</a>
												<p><small><strong>Address: </strong> <cite title="{{$employee->address}}">{{$employee->address}} <i class="glyphicon glyphicon-map-marker"></i></cite></small></p>
												<p><small><strong>Contact#: </strong> <cite title="{{$employee->contactNo}}">{{$employee->contactNo}}</cite></small>
												</p><p><small><strong>Birth Date: </strong> <cite title="{{$employee->birthDate}}">{{$employee->birthDate}}</cite></small>
												</p><p><small><strong>Birth Place: </strong> <cite title="{{$employee->birthPlace}}">{{$employee->birthPlace}}</cite></small>
												</p><p><small><strong>Gender: </strong> <cite title="{{$employee->gender}}">{{$employee->gender}}</cite></small>
												</p><p><small><strong>Civil Status: </strong> <cite title="{{$employee->civilStatus}}">{{$employee->civilStatus}}</cite></small>
												</p><p><small><strong>Blood Type: </strong> <cite title="{{$employee->bloodType}}">{{$employee->bloodType}}</cite></small>
												</p><p><small><strong>Religion: </strong> <cite title="{{$employee->religion}}">{{$employee->religion}}</cite></small>
												</p><p><h4>Emergency Contact Person:</h4>
												</p><p><small><strong>Name: </strong> <cite title="{{$employee->emergencyContactPerson}}">{{$employee->emergencyContactPerson}}</cite></small>
												</p><p><small><strong>Contact#: </strong> <cite title="{{$employee->emergencyContactNo}}">{{$employee->emergencyContactNo}}</cite></small>
                        						</p>												
											</div>
											<!--end col-md-8-->
											<div class="col-md-4">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<div class="caption">
															 Government ID
														</div>														
													</div>
													<div class="portlet-body">
														<ul class="list-unstyled">
															<li>
																<span class="sale-info">
																SSS <i class="fa fa-img-up"></i>
																</span>
																<span class="sale-num">
																{{$employee->sss}} </span>
															</li>
															<li>
																<span class="sale-info">
																HDMF <i class="fa fa-img-down"></i>
																</span>
																<span class="sale-num">
																{{$employee->hdmf}} </span>
															</li>
															<li>
																<span class="sale-info">
																Philhealth </span>
																<span class="sale-num">
																{{$employee->philhealth}} </span>
															</li>
															<li>
																<span class="sale-info">
																TIN </span>
																<span class="sale-num">
																{{$employee->tin}} </span>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<!--end col-md-4-->
										</div>
										<!--end row-->
										
									</div>
								</div>
							</div>
							<!--tab_1_2-->
							<div class="tab-pane" id="tab_1_2">
								<div class="row">									
									<div class="col-md-12">										
										<table width="50%">
											<tr>
												<td>Start Date</td>
												<td><input type="date" class="form-control sm" name="startwh" id="startwh"></td>
												
												<td><a href="#" class="btn green sm" onclick="processWorkHistory({{ $employee->id }},$('#startwh').val(),$('#endwh').val());">Generate</a></td>
											</tr>
											<tr>
												<td><br><br></td>
											</tr>
										</table>
										<div id="workHistoryDiv"></div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab_1_3">
								<div class="row profile-account">
									<div class="col-md-12">
										<div class="portlet box blue tabbable">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-gift"></i>Leave Details
												</div>
											</div>
											<div class="portlet-body">
												<div class=" portlet-tabs">
													<ul class="nav nav-tabs">
														<li>
															<a href="#leave_tab3" data-toggle="tab">
															<span class="fa fa-plus"></span>  File Leave
															 </a>
														</li>
														<li>
															<a href="#leave_tab2" data-toggle="tab">
															<span class="fa fa-sort-amount-asc"></span> Ledger </a>
														</li>
														<li class="active">
															<a href="#leave_tab1" data-toggle="tab">
															<span class="fa fa-tasks"></span> Summary </a>
														</li>
													</ul>
													<div class="tab-content">
														<div class="tab-pane active" id="leave_tab1">
															<div class="row">
																<div class="col-md-6 note note-danger">	<h3>Balance Summary</h3>			
																	<table class="table" style="font-size:12px;">
																		<thead>
																			<tr>
																				<th>Code</th>
																				<th>Name</th>
																				<th>Balance</th>
																			</tr>
																		</thead>
																		<tbody>
																			@forelse($employeeleaves as $employeeleave)
																				<tr>
																					<td>{{ $employeeleave->leavecode }}</td>
																					<td>{{ $employeeleave->leavename }}</td>
																					<td>{{ $employeeleave->balance }}</td>
																				</tr>
																			@empty
																			<tr>
																				<td colspan="3" align="center"> No Record found!</td>																					
																			</tr>
																			@endforelse																				
																		</tbody>
																	</table>
																	
																</div>
																<div class="col-md-6">
																	<div class="portlet box blue-steel ">
																		<div class="portlet-title">
																			<div class="caption">
																				<i class="fa fa-plus"></i> Add Leave Balance
																			</div>																	
																		</div>
																		<div class="portlet-body form">
																			<form class="form-horizontal" role="form" method="post" action="/leaveledgers">
																				{{ csrf_field() }}
																				<div class="form-body">
																					<div class="form-group">
																						<label class="col-md-3 control-label">Qty:</label>
																						<div class="col-md-9">
																							<input type="number" class="form-control input-sm" name="qty" required>
																						</div>
																					</div>																			
																					<div class="form-group">
																						<label class="col-md-3 control-label">Leave Type</label>
																						<div class="col-md-9">
																							<select class="form-control input-sm" name="leave_id">
																								<option value="" selected="selected"> - Select Leave Type -</option>
																								@forelse ($leaves as $leave)				
																									<option value="{{$leave->id}}">{{$leave->name}}</option>
																								@empty

																								@endforelse
																							</select>
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="col-md-3 control-label">Effectivity Date:</label>
																						<div class="col-md-9">
																							<input type="date" class="form-control input-sm" name="effectivityDate" required value="{{ date('Y-m-d') }}">
																						</div>
																					</div>
																					<div class="form-group">
																						<label class="col-md-3 control-label">Remarks:</label>
																						<div class="col-md-9">
																							<textarea required name="remarks" id="" cols="30" rows="4"></textarea>
																							<input type="hidden" name="employee_id" value="{{ $employee->id }}">
																						</div>
																					</div>
																				</div>
																				<div class="form-actions pull-right">
																						<input type="reset" class="btn default btn-sm" value="Reset">
																						<input type="submit" class="btn green btn-sm" value="Submit">
																				</div>																		
																			</form>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="tab-pane" id="leave_tab2">
															
															<select name="leavetype" id="leavetype" class="form-control">											
																<option value="0"> - Select Leave Type -</option>
																@forelse ($leaves as $leave)				
																	<option value="{{$leave->id}}">{{$leave->name}}</option>
																@empty

																@endforelse
															</select>
															<br><br><br>
															<input type="hidden" name="employee_id" id="employee_id" value="{{ $employee->id }}">
															<table class="table" style="font-size:12px;">
																<thead>
																<tr>
																	<th>Type</th>
																	<th>EffectivityDate</th>
																	<th>In/Out</th>
																	<th>Running Balance</th>
																	<th>Remarks</th>
																</tr>
																</thead>
																<tbody id="leaveledgerbody" style="text-align: center;">
																
																</tbody>
															</table>
														</div>
														<div class="tab-pane" id="leave_tab3">
															<table width="100%">
																<form id="fileleaveform" method="post">
																<tr>
																	<td>Leave:<select required name="fileleavetype" id="fileleavetype" class="form-control">											
																			<option value=""> - Select Leave Type -</option>
																			@forelse ($leaves as $leave)				
																				<option value="{{$leave->id}}">{{$leave->name}}</option>
																			@empty

																			@endforelse
																		</select>
																	</td>
																	<td>Start: <input required class="form-control" type="date" min="{{$BlockDate}}" name="leave_start" id="leave_start"></td>
																	<td>End: <input required class="form-control" type="date" min="{{$BlockDate}}" name="leave_end" id="leave_end"></td>
																	<td><br><input type="submit" class="btn green" value="Go"></td>
																</tr>
																</form>
																<tr>
																	<td colspan="4">
																		 <form action="/leaves/{{$employee->id}}/submitfileleave" method="post" id="getdateleaveform">
																			<div id="fileleavefilterdates"></div>
																		 </form>
																	</td>
																</tr>
															</table>
															
															
														</div>															
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_4">
								<div class="row">									
									<div class="col-md-12">										
										<table width="60%">
											<tr>
												<td>Start Date</td>
												<td><input type="date" class="form-control sm" name="startedtr" id="startedtr"></td>
												<td><input type="date" class="form-control sm" name="endedtr" id="endedtr"></td>
												<td><a href="#" class="btn green sm" onclick="getDTRperEmployee({{ $employee->id }},$('#startwh').val(),$('#endwh').val());">Generate</a></td>
											</tr>
											<tr>
												<td><br><br></td>
											</tr>
										</table>
										<div id="DTRperEmployee"></div>
									</div>
								</div>
							</div>
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_6">
								<div class="row">
									<div class="col-md-12">
										<h1>Payroll</h1>
										<table class="table" style="font-size:12px;">
											<thead>
	    			<tr>						<th>Cutoff</th>
									    		<th>Present</th>
									    		<th>Absent</th>
									    		<th>Leave</th>
									    		<th>Suspended</th>
									    		<th>Amount</th>
									    		<th>Rate</th>
									    		<th>Cola</th>
									    		<th>SSS</th>
									    		<th>SSS Loan</th>									    		
									    		<th>HDMF</th>
									    		<th>HDMF Loan</th>
									    		<th>Phic</th>
									    		<th>Total</th>
									    		
									    	</tr>
								    	</thead>
								    	<tbody>
								    	@forelse($payrolls as $payroll)
								    		<tr align="right">
								    			<td>{{ $payroll->cutoff->Cname }}</td>		
								    			<td>{{ $payroll->present }}</td>
								    			<td>{{ $payroll->absent }}</td>
								    			<td>{{ $payroll->leave }}</td>
								    			<td>{{ $payroll->suspended }}</td>
								    			<td>{{ $payroll->amount }}</td>
								    			<td>{{ $payroll->rate }}</td>
								    			<td>{{ $payroll->cola }}</td>
								    			<td>{{ $payroll->sss_amount }}</td>
								    			<td>{{ $payroll->sss_loan_amount }}</td>								    			
								    			<td>{{ $payroll->hdmf_amount }}</td>
												<td>{{ $payroll->hdmf_loan_amount }}</td>
												<td>{{ $payroll->philhealth_amount }}</td>
								    			<td>{{ number_format(($payroll->amount + $payroll->cola),2) }}</td>
								    		</tr>
								    	@empty
								    	<tr>
								    		<td colspan="10" align="center"> No Record</td>
								    	</tr>
								    	@endforelse									    	
								    	</tbody>
										</table>
									</div>									
								</div>
							</div>
							<div class="tab-pane" id="tab_1_20">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet-body">
											<div class="col-md-6">
												<div class="portlet box blue-steel ">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-plus"></i> Existing Loans
														</div>																	
													</div>
													<div class="portlet-body form">
														<table class="table" style="font-size:12px;">
															<thead>
																<tr>
																	<th>Stop</th>
																	<th>Type</th>
																	<th>Amount</th>
																	<th># of Deduction</th>														
																	<th>Deduction per Payroll</th>																	
																</tr>
															</thead>
															<tbody>
																@forelse($loans as $loan)
																	<tr>
																	@if($loan->isClosed==0)
																		<td id="loanbtn"><a href="#" onclick="loanstop({{ $loan->id }})"><i class="fa fa-times-circle"></i></a></td>
																	@else
																		<td>Stopped</td>
																	@endif
																		
																		<td><a href="/loan/details/{{$loan->id}}">{{$loan->loanType}}</a></td>
																		<td style="text-align: right;">{{$loan->amount}}</td>
																		<td style="text-align: right;">{{$loan->deductionNumber}}</td>
																		<td style="text-align: right;">{{number_format(($loan->amount/$loan->deductionNumber),2) }}</td>
																	</tr>
																@empty
																	<tr>
																		<td colspan="5"> No Existing Loan</td>
																	</tr>	
																@endforelse
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="portlet box blue-steel ">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-plus"></i> Add Loan Entry
														</div>																	
													</div>
													<div class="portlet-body form">
														<form class="form-horizontal" role="form" method="post" action="/loans">
															{{ csrf_field() }}
															<div class="form-body">
																<div class="form-group">
																	<label class="col-md-3 control-label">Loan Type</label>
																	<div class="col-md-9">
																		<select class="form-control input-sm" name="loanType" id="loanType">										
																			<option value="SSS">SSS</option>		
																			<option value="HDMF">HDMF</option>
																		</select>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-3 control-label">Amount:</label>
																	<div class="col-md-9">
																		<input type="number" class="form-control input-sm" id="amount" step="0.01" value="0.01" name="amount" required>
																	</div>
																</div>	
																<div class="form-group">
																	<label class="col-md-3 control-label">No of Deduction:</label>
																	<div class="col-md-9">
																		<input type="number" class="form-control input-sm" id="deductionNumber" name="deductionNumber" required>
																	</div>
																</div>																			
																
																<div class="form-group">
																	<label class="col-md-3 control-label">Deduction Start:</label>
																	<div class="col-md-9">
																		<input type="date" class="form-control input-sm" min="{{$BlockDate}}" name="startDate" id="startDate" required>
																	</div>
																</div>
																<input type="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
															</div>
															<div class="form-actions pull-right">
																	<input type="reset" class="btn default btn-sm" value="Reset">
																	<input type="submit" class="btn green btn-sm" value="Submit">
															</div>																		
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>								
								</div>
							</div>
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_7">
								<div class="row">
									<div class="col-md-12">
										<a href="/violations/{{$employee->id}}/create" class="btn red">Add Violation <i class="fa fa-arrow-circle-o-right"></i></a><br><br>
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
												<tr style="font-size: 12px;">
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
							<!--end tab-pane-->
							<div class="tab-pane" id="tab_1_8">
								<div class="row">
									<div class="col-md-12">
										<div class="tabbable tabbable-custom tabbable-custom-profile">
											
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body">
														<table class="table table-condensed table-hover">
														<thead>
														<tr>
															<th>
																<i class="fa fa-briefcase"></i> Name
															</th>
															<th class="hidden-xs">
																<i class="fa fa-question"></i> Relation
															</th>
															<th>
																<i class="fa fa-bookmark"></i> Birthday
															</th>
															<th>
																<i class="fa fa-bookmark"></i> Age
															</th>
														</tr>
														</thead>
														<tbody>
														@forelse($dependents as $dependent)
															<tr style="font-size: 12px;">
																<td>{{$dependent->fullName}}</td>
																<td>{{$dependent->relationship}}</td>
																<td>{{$dependent->birthDate}}</td>
																<td>{{$dependent->age}}</td>
															</tr>
														@empty
															<tr><td colspan="4" align="center">No Dependent</td></tr>
														@endforelse
														
														</tbody>
														</table>
													</div>
												</div>											
											</div>
										</div>
									</div>								
								</div>
							</div>
							<!--end tab-pane-->
						</div>
					</div>
					<!--END TABS-->
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

$( "#leavetype" ).change(function() {
  var ltype = $(this).val();
  var employee_id = $('#employee_id').val();
  $( "#leaveledgerbody" ).html( "<div id='loader-img' class='col-md-2 col-md-offset-5' style='margin-top:100px;'><img src='{{ asset('metronic/ajax-loader-big.gif') }}'></div>" );

    	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})

    	$.ajax({
		  method: "POST",
		  url: "/leaveledgers/"+employee_id+"/getledger",
		  data: { ltype: ltype }
		})
		.done(function( html ) {
		  $( "#leaveledgerbody" ).html( html );
		});
});

$('#fileleaveform').submit(function(e){
	e.preventDefault();
	var employee_id = $('#employee_id').val();
	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})
	$.ajax({
	  method: "POST",
	  url: "/leaves/"+employee_id+"/getdates",
	  data: { start: $('#leave_start').val(), end: $('#leave_end').val(),leavetype: $("#fileleavetype option:selected").text(), leaveid:$('#fileleavetype').val() }
	})
	.done(function( html ) {
	  $( "#fileleavefilterdates" ).html( html );
	});
});

function checkIfSobraSaBalance(balance){
	var total_selected = $('input:checkbox.leavedateselected:checked').length;

	if(parseInt(total_selected) > parseInt(balance)){
		alert('Warning! Insufficient Leave balance. You can only select up to '+balance+'.' );
	}
}

$('#getdateleaveform').submit(function(e){
	
	var total_selected = $('input:checkbox.leavedateselected:checked').length;
	var balance = $('#leavebal').val();
	if(parseInt(total_selected) > parseInt(balance)){
		alert('Insufficient Leave balance. You can only select up to '+balance+'.' );
		e.preventDefault();
	}
	else{
		$("#getdateleaveform").submit();
	}
});

function processWorkHistory(a,b){
	 $( "#workHistoryDiv" ).html( "<div id='loader-img' class='col-md-2 col-md-offset-5' style='margin-top:100px;'><img src='{{ asset('metronic/ajax-loader-big.gif') }}'></div>" );
	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})
	$.ajax({
	  method: "POST",
	  url: "/dtr/getWorkHistoryPerEmployee",
	  data: { employee_id: a, start: b}
	})
	.done(function( html ) {
	  $( "#workHistoryDiv" ).html( html );
	});
}

function loanstop(a){
	 $( "#loanbtn" ).html( "<div id='loader-img' class='col-md-2 col-md-offset-5' style='margin-top:100px;'><img src='{{ asset('metronic/ajax-loader-big.gif') }}'></div>" );
	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})
	$.ajax({
	  method: "GET",
	  url: "/loans/stop/"+a
	})
	.done(function( html ) {
	  $( "#loanbtn" ).html( html );
	});
}

function getDTRperEmployee(a,b,c){
	 $( "#DTRperEmployee" ).html( "<div id='loader-img' class='col-md-2 col-md-offset-5' style='margin-top:100px;'><img src='{{ asset('metronic/ajax-loader-big.gif') }}'></div>" );
	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})
	$.ajax({
	  method: "POST",
	  url: "/dtr/getDTRperEmployee",
	  data: { employee_id: a, start: b, end: c}
	})
	.done(function( html ) {
	  $( "#DTRperEmployee" ).html( html );
	});
}


</script>
@endsection
