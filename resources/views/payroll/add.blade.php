@extends('layouts.master')
@section('pagecss')
<link href="{{ asset('/metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}" rel="stylesheet" type="text/css"/>

@section('content')

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Daily Time Records &nbsp; 
				</h3>				
				<ul class="page-breadcrumb breadcrumb">					
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Cutoff</a>
						<i class="fa fa-angle-right"></i>						
					</li>
					<li>						
						<select name="cutoff" id="cutoff" class="form-control">
								<option value=""> - Select -</option>
							@forelse($cutoffs as $i => $e)
								<option value="{{$e->start}}|{{$e->end}}|{{$e->id}}"> {{$e->code}} - {{$e->payroll}} ({{ date('F d',strtotime($e->start))}} to {{ date('F d',strtotime($e->end))}})</option>
							@empty

							@endforelse
						</select>												
					</li>
					<li>
						<a href="#" class="btn blue" style="position:relative;top:-4px;color:white;" onclick="submitcutoff($('#cutoff').val());">
						Go <i class="fa fa-arrow-circle-o-right"></i></a>
					</li>					
				</ul>
				
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">			
				<div id="datepage" class="col-md-12"></div>
				<div id="records" class="col-md-12" style="margin-top:100px;""></div>			
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

	function submitcutoff(datesel) {
		var res = datesel.split("|");
        var options = {
			startDate: res[0],
        	endDate: res[1],
        	selectedDate: res[0],
        	showOffDays: false,
            onSelectedDateChanged: function(event, date) {
              //alert("Selected date: " + moment(date).format("Do, MMM YYYY"));
              //alert(moment(date).format("YYYY-MM-DD"));
              //alert(moment(res[0]).format("YYYY-MM-DD"));
              
              if((moment(date).format("YYYY-MM-DD"))<(moment(res[0]).format("YYYY-MM-DD")) || (moment(date).format("YYYY-MM-DD"))>(moment(res[1]).format("YYYY-MM-DD"))){
              	//alert('('+moment(date).format("YYYY-MM-DD")+') This date is not included on this cutoff!');
              	$( "#records" ).html( "<div id='loader-img' class='col-md-6 col-md-offset-3 note note-danger'><h2>This date is not included on this cutoff!</h2></div>" );              	
              }
              else{
              	showemployees(moment(date).format("YYYY-MM-DD"),res[2]);
          	  }
          	  
            }
		}
        $('#datepage').datepaginator(options);
        showemployees(res[0],res[2]);        
    }


    function showemployees(dyt,cutoff){
    	
    	$( "#records" ).html( "<div id='loader-img' class='col-md-2 col-md-offset-5' style='margin-top:100px;'><img src='{{ asset('metronic/ajax-loader-big.gif') }}'></div>" );

    	$.ajaxSetup({
    		headers:{
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		}
    	})

    	$.ajax({
		  method: "POST",
		  url: "/dtr/getform",
		  data: { dyt: dyt,cutoff: cutoff }
		})
		.done(function( html ) {
		  $( "#records" ).html( html );
		});
    }


    function savedtr(x){
    	var ntype = $('#type'+x).val();
    	var nshift = $('#shift'+x).val();
    	var ncontractor = $('#contractor'+x).val();
    	var cont = ncontractor.split("|");
    	var contractorname = cont[0];
    	var contractorcode = cont[1];
    	var location = cont[2];
    	if(ntype != "" && nshift != "" && ncontractor != ""){

    		$( "#stat"+x ).html("<img src='{{ asset('metronic/ajax-loader.gif') }}'/>");
    		$.ajax({
			  method: "POST",
			  url: "/dtr/"+x+"/saverecord",
			  data: { 
			  	stype: ntype,
			  	sshift: nshift,
			  	scontractor: ncontractor,
			  	scontractorname: contractorname,
			  	scontractorcode: contractorcode,
			  	slocation: location
			  }
			})
			.done(function( html ) {
			  $( "#dyttd"+x ).css({"color":"blue","font-weight":"bold"});	
			  $( "#stat"+x ).html( html );
			});
    	}
    	//alert(contractorname + '-' + contractorcode + '-' + location);
    }
</script>
@endsection
