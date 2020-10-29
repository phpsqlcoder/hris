<?php 
$bm = array(

        '172.16.'
);

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
//$tad = (new TADFactory(['ip'=>'172.16.19.123']))->get_instance();
//$comands = TAD::commands_available();
$zklib_commands = TAD::commands_available();
// foreach($zklib_commands as $z){
//     echo $z."<br>";
// }

$tad = (new TADFactory(['ip'=>$_POST['ip'], 'com_key'=>0]))->get_instance();
$users = $tad->get_att_log();
$logs = $users->filter_by_date(
     ['start' => date('Y-m-d'),'end' => date('Y-m-d')]
 );
//print_r($logs);
//echo $logs[1];
//$array =  (array) $logs;
$logs =  json_encode( json_decode( json_encode( simplexml_load_string( $logs ) ), TRUE )["Row"] );
echo $logs;

/*
foreach($array as $a){
     echo $a."<br>";
   /* foreach($a as $x){
        //echo $x."<br>";
        foreach($x as $y){
            echo $y."<br>";
        }
        
    }
}*/
//$logs = $tad->get_att_log();
//$dt = $tad->get_date();
//echo $dt;
// Get attendance logs for all users;
//$att_logs = $tad->get_att_log();

// Now, you want filter the resulset to get att logs between '2014-01-10' and '2014-03-20'.
// $logs = $att_logs->filter_by_date(
//     ['start' => '2018-06-06','end' => '2018-06-06']
// );
//$users = $tad->get_all_user_info();
//var_dump($logs);
// foreach($logs as $k => $v){
//      //print_r($l)."<br><br><br>";
//      echo $v[0]."<br><br><br>";
//  }
?>