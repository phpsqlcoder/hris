<?php 
$ip = '172.16.44.120';
$start = '2018-08-09';
$end = '2018-08-14';
include("../config.php");
require '../vendor/autoload.php';
require '../lib/TADFactory.php';
require '../lib/TAD.php';
require '../lib/TADResponse.php';
require '../lib/Providers/TADSoap.php';
require '../lib/Providers/TADZKLib.php';
require '../lib/Exceptions/ConnectionError.php';
require '../lib/Exceptions/FilterArgumentError.php';
require '../lib/Exceptions/UnrecognizedArgument.php';
require '../lib/Exceptions/UnrecognizedCommand.php';
use TADPHP\TADFactory;
use TADPHP\TAD;

$zklib_commands = TAD::commands_available();


$tad = (new TADFactory(['ip'=>$ip, 'com_key'=>0]))->get_instance();
$users = $tad->get_att_log();
$logs = $users->filter_by_date(
     ['start' => $start,'end' => $end]
 );

date_default_timezone_set("Asia/Manila");
$logs =  json_encode( json_decode( json_encode( simplexml_load_string( $logs ) ), TRUE )["Row"] );
var_dump($logs);
/*
if (!empty($logs)) {
	$delete = mysqli_query($conn,"delete from biometric_logs where ip='".$ip."' and log>='".$start."' and log<='".$end."'");
	$obj = json_decode($logs);
	$ins="";
	$counter=0;
	foreach($obj as $r){
		//echo $r->PIN."=".$r->DateTime."<br>";
		$counter++;
		if($counter==200){
			$insert = mysqli_query($conn,"insert into biometric_logs (ip,biometric_id,log,type,download_date,log_date,log_time) 
			values ".rtrim($ins,',')."");
			$ins="";
		}
		$ins.="('".$ip."','".$r->PIN."','".$r->DateTime."','".$r->Status."','".date('Y-m-d H:i:s')."','".date('Y-m-d',strtotime($r->DateTime))."','".date('H:i:s',strtotime($r->DateTime))."'),";

	}
	$insert = mysqli_query($conn,"insert into biometric_logs (ip,biometric_id,log,type,download_date,log_date,log_time) 
			values ".rtrim($ins,',')."");
}
*/



?>