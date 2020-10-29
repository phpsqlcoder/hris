<?php 

include("config.php");
$bms = array("172.16.44.120","172.16.44.121","172.16.44.118");

$d = "";
$q = mysqli_query($conn,"select biometric_id,ip,count(id) as tot from biometric_logs_test where log>='2018-08-01 00:00:00' and log<'2018-09-01 00:00:00' group by biometric_id,ip order by ip,biometric_id");
while($r = mysqli_fetch_array($q)){
	$check = mysqli_fetch_array(mysqli_query($conn,"select * from employees where biometricId='".$r['biometric_id']."'"));
	if(!$check['id']){
		if($r['ip'] == '172.16.44.120'){
			$b = 'Mine Timehouse1';
		}
		elseif($r['ip'] == '172.16.44.121'){
			$b = 'Mine Timehouse2';
		}
		elseif($r['ip'] == '172.16.44.118'){
			$b = 'Level 8';
		}
		$d.='<tr><td>'.$r['biometric_id'].'</td><td>'.$b.'</td><td>'.$r['tot'].'</td></tr>';
	}

	//$d.='</tr>';
}


?>

<table width="100%">
	<tr>
		<td>Biometric ID</td>
		<td>Location</td>
		<td>Total Logs</td>
		
	</tr>
	<?php echo $d; ?>
</table>