<?php

$s_host="localhost";
$s_user="root";
$s_pword="root";
$s_db="cis_db";

$conn=mysqli_connect($s_host,$s_user,$s_pword,$s_db);
$s = mysqli_query($conn,"select * from employees where birthDate='0000-00-00'");
while($r = mysqli_fetch_array($s)){
	$q = mysqli_fetch_array(mysqli_query($conn,"select lName,STR_TO_DATE( `birthDate`,'%d/%m/%Y') as bday,STR_TO_DATE( `hiredDate`,'%d/%m/%Y') as hired from `table 22` where lName='".$r['lName']."' and fName='".$r['fName']."' and mName='".$r['mName']."'"));
	if($q['lName']){
			$upd = mysqli_query($conn,"update employees set birthDate='".$q['bday']."',hiredDate='".$q['hired']."' where id='".$r['id']."'");
			echo $r['lName']." - ".$q['lName']." - ".$q['bday']." - ".$q['hired']."<br>";
	}
}
?>


