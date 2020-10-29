<?php 

$ip = '172.16.44.121';
$start = '2018-08-09';
$end = '2018-08-14';
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



$tad = (new TADFactory(['ip'=>$ip, 'com_key'=>0]))->get_instance();
$users = $tad->get_att_log();
$logs = $users->filter_by_date(
     ['start' => $start,'end' => $end]
 );

date_default_timezone_set("Asia/Manila");
$logs =  json_encode( json_decode( json_encode( simplexml_load_string( $logs ) ), TRUE )["Row"] );
echo $logs;


?>