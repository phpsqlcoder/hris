<?php 
//die();
$ip = '172.16.21.9';
$start = '2018-09-01';
$end = '2018-09-12';
include("config.php");
require 'vendor/autoload.php';
require 'lib/TADFactory.php';
require 'lib/TAD.php';
require 'lib/TADResponse.php';
require 'lib/Providers/TADSoap.php';
require 'lib/Providers/TADZKLib.php';
require 'lib/Exceptions/ConnectionError.php';
require 'lib/Exceptions/FilterArgumentError.php';
require 'lib/Exceptions/UnrecognizedArgument.php';
require 'lib/Exceptions/UnrecognizedCommand.php';
use TADPHP\TADFactory;
use TADPHP\TAD;

$zklib_commands = TAD::commands_available();

/*
$start = $start.' 00:00:00';
$end = $end.' 23:59:59';
*/

$tad = (new TADFactory(['ip'=>$ip, 'com_key'=>0]))->get_instance();
$users = $tad->get_att_log();
$logs = $users->filter_by_date(
     ['start' => $start,'end' => $end]
 );

date_default_timezone_set("Asia/Manila");
$logs =  json_encode( json_decode( json_encode( simplexml_load_string( $logs ) ), TRUE )["Row"] );
echo $logs;
/*
if (!empty($logs)) {
	$delete = mysqli_query($conn,"delete from biometric_logs_test where ip='".$ip."' and log>='".$start."' and log<='".$end."'");
	$obj = json_decode($logs);
	$ins="";
	$counter=0;
	foreach($obj as $r){
		//echo $r->PIN."=".$r->DateTime."<br>";
		$counter++;
		if($counter==200){
			$insert = mysqli_query($conn,"insert into biometric_logs_test (ip,biometric_id,log,type,download_date,log_date,log_time) 
			values ".rtrim($ins,',')."");
			$ins="";
			$counter=0;
		}
		$ins.="('".$ip."','".$r->PIN."','".$r->DateTime."','".$r->Status."','".date('Y-m-d H:i:s')."','".date('Y-m-d',strtotime($r->DateTime))."','".date('H:i:s',strtotime($r->DateTime))."'),";

	}
	$insert = mysqli_query($conn,"insert into biometric_logs_test (ip,biometric_id,log,type,download_date,log_date,log_time) 
			values ".rtrim($ins,',')."");
}
*/


?>