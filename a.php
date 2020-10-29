<?php
//$s_host="localhost";
$s_host="172.16.40.48";
$s_user="root";
$s_pword="root";
$s_db="cis_db";

$startingdate="2017-08-01";
date_default_timezone_set("Asia/Manila");
$conn = mysqli_connect("localhost", "root", "root", "cis_db");

/*
$pq=mysqli_query($conn,"select * from items");
while($p=mysqli_fetch_array($pq)){

	$serverName = "HO780CB8525102L\JUNDRIE";
	$connectionInfo = array( "Database"=>"inventory_db", "UID"=>"sa", "PWD"=>"@Temp123!" );
	$connd = sqlsrv_connect( $serverName, $connectionInfo);

	$q = sqlsrv_query($connd, "insert into products (created_at,code,name,user_id)values('".date('Y-m-d h:i:s')."','".$p['code']."','".$p['name']."',1)");

}
*/
$pq=mysqli_query($conn,"select * from employees");
while($p=mysqli_fetch_array($pq)){
	$uuu = mysqli_query($conn,"update payrolls set fullname='".$p['fullName']."' where employee_id='".$p['id']."'");
}
die();
?>
<?php 
/*
$con = mysqli_connect("localhost", "root", "root", "cis_db");




$data='';
$e = mysqli_query($con,"SELECT `id`,CONCAT(lname, ', ', fName,' ', mName) as fn,`hiredDate`,`tin`,`philhealth`,`sss`,`hdmf`,`birthDate`,`emergencyContactPerson`,`address`,`emergencyContactNo` FROM `employees` where lname <>''");
while($r=mysqli_fetch_array($e)){

	$data.='<tr>
				<td>'.$r['id'].'</td>
				<td>'.$r['fn'].'</td>
				<td></td>
				<td>'.$r['hiredDate'].'</td>
				<td>'.$r['tin'].'</td>
				<td>'.$r['philhealth'].'</td>
				<td>'.$r['sss'].'</td>
				<td>'.$r['hdmf'].'</td>
				<td>'.$r['birthDate'].'</td>
				<td>'.$r['emergencyContactPerson'].'</td>
				<td></td>
				<td>'.$r['address'].'</td>
				<td>'.$r['emergencyContactNo'].'</td>
				<td>Contractor</td>
				<td>December 31, 2017</td>
				<td></td>
				<td></td>
	</tr>';
}
	
*/

?>

<table width="100%" class="table table-striped table-condensed">
	
		<?php //echo $data; ?>

</table>