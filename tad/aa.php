<?php 

include("config.php");
$bms = array("172.16.44.120","172.16.44.121","172.16.44.118");

$d = "";
$q = mysqli_query($conn,"select * from employees order by resignedRemarks, lName, fName");
while($r = mysqli_fetch_array($q)){
	$d.='<tr>

			<td>'.$r['lName'].', '.$r['fName'].' '.$r['mName'].'</td>
			<td>'.$r['id'].'</td>
			<td>'.$r['biometricId'].'</td>
			<td>'.$r['hiredDate'].'</td>
			<td>'.$r['resignedDate'].'</td>
	';
	foreach($bms as $bm){
		$o = mysqli_fetch_array(mysqli_query($conn,"select count(id) as tot from biometric_logs_test where biometric_id='".$r['biometricId']."' and log>='2018-08-01 00:00:00' and log<'2018-09-01 00:00:00' and ip='".$bm."'"));
		if(!$o['tot']){
			$total = 0;
		}
		else{
			$total = $o['tot'];
		}
		$d.='<td>'.$total.'</td>';
	}
	$d.='</tr>';
}


?>

<table width="100%">
	<tr>
		<td>Name</td>
		<td>ID</td>
		<td>Biometric ID</td>
		<td>Hired Date</td>
		<td>Resigned Date</td>
		<?php 
			foreach($bms as $bx){
				if($bx == '172.16.44.120'){
					$b = 'Mine Timehouse1';
				}
				elseif($bx == '172.16.44.121'){
					$b = 'Mine Timehouse2';
				}
				elseif($bx == '172.16.44.118'){
					$b = 'Level 8';
				}
				echo '<td>'.$b.'</td>';
			}
		?>
	</tr>
	<?php echo $d; ?>
</table>