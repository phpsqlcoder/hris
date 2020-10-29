<?php 

$con = mysqli_connect("localhost", "root", "root", "cis_db");

$data='';
$e = mysqli_query($con,"SELECT distinct e.id,CONCAT(e.lname, ', ', e.fName,' ', e.mName) as fn FROM payrolls p left join `employees` e on e.id=p.employee_id where e.lname <>''");
while($r=mysqli_fetch_array($e)){

	$data.='<tr>
				<td>'.$r['fn'].'</td>';
	$q = mysqli_query($con,"select * from cutoffs where id<38 order by id");
	while($i = mysqli_fetch_array($q)){
		$t = mysqli_fetch_array(mysqli_query($con,"select * from payrolls where employee_id='".$r['id']."' and cutoff_id='".$i['id']."'"));
		$data.='<td>'.$t['present'].'</td>';
	}
				
	$data.='</tr>';
}
	


?>

<table width="100%" class="table table-striped table-condensed">
	<tr><td>Name</td>
		<?php
			$q = mysqli_query($con,"select * from cutoffs where id<38 order by id");
			while($i = mysqli_fetch_array($q)){
				echo '<td>'.$i['payroll'].'</td>';
			}
		?>
	</tr>
		<?php echo $data; ?>

</table>