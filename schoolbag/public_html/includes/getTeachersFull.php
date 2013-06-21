<?php
$sqlteachers="SELECT * from users WHERE type='T' && schoolID='".$_SESSION['schoolID']."'";
$resultteachers=mysql_query($sqlteachers);
while($row=mysql_fetch_array($resultteachers)){
	$teachers[$row["userID"]]=$row;
}
?>