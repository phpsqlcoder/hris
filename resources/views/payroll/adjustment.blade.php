@extends('layouts.master')
@section('pagecss')
<link href="{{ asset('/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css"/>

@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Adjustments &nbsp; 
				</h3>				
				<ul class="page-breadcrumb breadcrumb">					
					<li style="display:none;">
						<i class="fa fa-user"></i>
						<a href="#">Team leader</a>
						<i class="fa fa-angle-right"></i>						
					</li>
					<li style="display:none;">						
						<select name="contractor" id="contractor" class="form-control">
							<option value="ALL"> - ALL -</option>
							@forelse($contractors as $contractor)
								<option value="{!! $contractor->teamleader !!}"> {!! $contractor->teamleader !!} </option>
							@empty

							@endforelse
							
						</select>												
					</li>
					<li style="display:none;">
						<i class="fa fa-paw"></i>
						<a href="#">Location</a>
						<i class="fa fa-angle-right"></i>						
					</li>
					<li style="display:none;">						
						<select name="location" id="location" class="form-control">
							<option value="ALL"> - ALL -</option>
							@forelse($locations as $location)
								<option value="{{str_replace("/", "qqqqq", $location->location)}}"> {!! $location->location !!} </option>
							@empty

							@endforelse
						</select>
																	
					</li>
					<li>
						<input type="hidden" name="cutoff" id="cutoff" value="{{$cutoff}}">	
						<a href="#" class="btn blue" style="position:relative;top:-4px;color:white;" onclick="submitfilter('ALL','ALL',$('#cutoff').val());">
						Go <i class="fa fa-arrow-circle-o-right"></i></a>
					</li>					
				</ul>
				
			</div>
		</div>
		<div class="row">
			<div id="records" class="col-md-12"></div>			
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

	function submitfilter(a,b,c) {
		
		$( "#records" ).html( "<div id='loader-img' class='col-md-2 col-md-offset-5' style='margin-top:100px;'><img src='{{ asset('metronic/ajax-loader-big.gif') }}'></div>" );

    	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})

    	$.ajax({
		  method: "POST",
		  url: "/payroll/adjustment/"+c,
		  data: { location: a,contractor: b }
		})
		.done(function( html ) {
		  $( "#records" ).html( html );
		}); 
    }

    function saveadjustment(a,b,c,d){	
    		$( "#rec"+a ).html("<img src='{{ asset('metronic/ajax-loader.gif') }}'/>");
    		$.ajax({
			  method: "POST",
			  url: "/payroll/saveadjustment/"+c,
			  data: { 
			  	pay_id: a, val: b, empid: d
			  }
			})
			.done(function( html ) {	
			  $( "#rec"+a ).html( html );
			});
    	
    	
    	//alert(contractorname + '-' + contractorcode + '-' + location);
    }
</script>
@endsection
