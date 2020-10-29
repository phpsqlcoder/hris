<?php
$devices = array(
'Mill New Admin' => '172.16.21.9',
'Mine Hospital' => '172.16.40.253',
'Mill New Admin2' => '172.16.21.8',
'ECS' => '172.16.19.123',
);
?>
<html>
	<head>
		<link href="metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
		<link href="metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
		<!-- END PAGE LEVEL PLUGIN STYLES -->
		<!-- BEGIN PAGE STYLES -->
		<link href="metronic/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
		<!-- END PAGE STYLES -->
		<!-- BEGIN THEME STYLES -->
		<link href="metronic/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
		<link id="style_color" href="metronic/assets/admin/layout/css/themes/light.css" rel="stylesheet" type="text/css"/>
		<link href="metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
	</head>
</html>
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
	<div class="page-container">
		<table width="100%" class="table">
			<thead>
				<tr align="right">
					<th>Device</th>
					<th>Total</th>
					<th>In</th>
					<th>Out</th>
					<th>Current Count</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$counter = 0;
					$processes = '';
					foreach($devices as $name => $ip){
						$counter++;
						echo '
							<tr align="right">
								<td>'.$name.'</td>
								<td><span id="all'.$counter.'"></span></td>
								<td><span id="in'.$counter.'"></span></td>
								<td><span id="out'.$counter.'"></span></td>
								<td><span id="variance'.$counter.'"></span></td>
							</tr>
						';
						$processes .='setTimeout(submitrpt("'.$ip.'",'.$counter.'),180000); ';
					}

				?>
				
			</tbody>
		</table>
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat blue-madison">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<div class="details">
						<div class="number" id="all'.$counter.'">
							 1349
						</div>
						<div class="desc">
							 Total Logs
						</div>
					</div>
					<a class="more" href="#">
					View more <i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat red-intense">
					<div class="visual">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="details">
						<div class="number" id="in'.$counter.'">
							 12,5M$
						</div>
						<div class="desc">
							 Login
						</div>
					</div>
					<a class="more" href="#">
					View more <i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat green-haze">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number" id="out'.$counter.'">
							 549
						</div>
						<div class="desc">
							 Logout
						</div>
					</div>
					<a class="more" href="#">
					View more <i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="dashboard-stat purple-plum">
					<div class="visual">
						<i class="fa fa-globe"></i>
					</div>
					<div class="details">
						<div class="number" id="variance'.$counter.'">
							 +89%
						</div>
						<div class="desc">
							 Active
						</div>
					</div>
					<a class="more" href="#">
					View more <i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
		</div>

	</div>

<script src="metronic/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="metronic/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="metronic/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.js" type="text/javascript"></script>
<script src="metronic/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="metronic/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="metronic/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

<script>
    function submitrpt(a,x){          
        $.ajax({
          method: "POST",
          url: "BM/process.php",
          data: { ip: a }
        })
        .done(function( html ) {
        	var data = JSON.parse(html);
        	var all = data.length;
        	var in_log = 0;
        	var out_log = 0;
        	var variance = 0;
        	for (var i = 0; i < data.length; i++) { 
			    //console.log(data[i].PIN);
			    
			    if(data[i].Status=='0'){
			    	in_log = in_log + 1;
			    }
			    else{
			    	out_log = out_log + 1;
			    }
			    
			}
			
			variance = in_log - out_log;
			$( "#all"+x ).html( all );
			$( "#in"+x ).html( in_log );
			$( "#out"+x ).html( out_log );
			$( "#variance"+x ).html( variance );
            //$( "#resultpage" ).html( data[1].PIN );
            //$( "#resultpage2" ).html( html );
          });

    }
    //submitrpt('x');
   
</script>
<script>
jQuery(document).ready(function() {    
	 <?php echo $processes; ?>
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout

});
</script>

</body>