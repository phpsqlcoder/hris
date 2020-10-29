@extends('layouts.master')

@section('pagecss')
<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/select2/select2.css') }}"/>

<link rel="stylesheet" type="text/css" href="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>

@endsection

@section('content')


<!-- BEGIN CONTENT -->

		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="page-title">
				Teamleaders &nbsp; 
				</h3>
				<ul class="page-breadcrumb breadcrumb">
					<li class="btn-group">
						<button type="button" class="btn green">
							Export to Excel
							<i class="fa fa-file-excel-o"></i>
						</button>					
					</li>
					<li>
						<i class="fa fa-home"></i>
						<a href="/">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="/locations">Teamleader</a>						
					</li>
					
				</ul>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box yellow">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-user"></i>Employees
						</div>

					</div>
					<div class="portlet-body">				
						<table class="table table-striped table-bordered table-hover" id="sample_2">
							<thead>
								<tr>
									<th class="table-checkbox">
											<input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes"/>
										</th>

									<th>Seq</th>
									<th>Teamleader</th>
									<th>Location</th>
								</tr>
							</thead>
							<tbody>						
								{!! $data !!}
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


@endsection

@section('pagejs')
<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/select2/select2.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>

<script src="{{ asset('metronic/assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
	var TableManaged = function () {
    	var initTable2 = function () {
        var table = $('#sample_2');
        table.dataTable({
            "lengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 500,
            "language": {
                "lengthMenu": " _MENU_ records",
                "paging": {
                    "previous": "Prev",
                    "next": "Next"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#sample_2_wrapper');

        table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).attr("checked", true);
                } else {
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable2();
        }
    };

}();
jQuery(document).ready(function() {       
    Metronic.init();
	Layout.init();
	QuickSidebar.init();
	TableManaged.init();

});
</script>
@endsection
