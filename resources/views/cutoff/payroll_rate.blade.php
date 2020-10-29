@extends('layouts.master')
@section('pagecss')

@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Payroll Rate &nbsp; 
				</h3>				
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Cutoff</a>
						<i class="fa fa-angle-right"></i>						
					</li>
					<li>						
						{{$cutoff->payroll}}										
					</li>

				</ul>
				
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">						
			<div id="records" class="col-md-12">
				<table class="table table-condensed table-hover">						
					<thead>
						<tr>							
							<th>Teamleader</th>
							<th>Location</th>
							<th>Rate</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
				@forelse($data as $contractor)																
							<tr>								
								<td><input type="hidden" name="teamleader" value="{{$contractor->teamleader}}">{{$contractor->teamleader}}</td>
								<td><input type="hidden" name="teamleader" value="{{$contractor->location}}">{{$contractor->location}}</td>
								<td><input type="number" class="form-control text-right input-sm" step="0.01" min="0.00" name="teamleader" value="{{$contractor->rate}}" name="rate{{$contractor->id}}" id="rate{{$contractor->id}}" onchange="saverate({{$contractor->id}})"></td>
								<td id="stat{{$contractor->id}}">
									@if($contractor->rate>0) 
										<span class="label label-primary">Saved</span>
									@else 
										
									@endif
								</td>
							</tr>						
				@empty
					<tr><td><span class="alert alert-danger">Cant Connect to OMWS!</span></td></tr>
				@endforelse
					</tbody>
				</table>
			</div>			
		</div>



@endsection

@section('pagejs')
<script src="{{ asset('metronic/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/plugins/bootstrap-datepaginator/bootstrap-datepaginator.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>


<script>
jQuery(document).ready(function() {       
    Metronic.init();
	Layout.init();
	QuickSidebar.init();
	
});
</script>


<script type="text/javascript">	
    function saverate(x){

		$( "#stat"+x ).html("<img src='{{ asset('metronic/ajax-loader.gif') }}'/>");
		$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})
		$.ajax({
		  method: "POST",
		  url: "/postpayrate/"+x+"/save_payrate",
		  data: { nrate: $('#rate'+x).val() }
		})
		.done(function( html ) {
			//alert(html);
		  	$( "#stat"+x ).html( html );
		});
    	//alert(contractorname + '-' + contractorcode + '-' + location);
    }
</script>
@endsection
