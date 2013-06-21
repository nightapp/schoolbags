<?php
$teacherTeaches=array();
$teacherExtraSQL="SELECT * FROM teachersteach where userID='".$_SESSION["userID"]."'";
$teacherExtraResult=mysql_query($teacherExtraSQL);
while($rowTeacher=mysql_fetch_array($teacherExtraResult)){
	$teacherTeaches[count($teacherTeaches)]=$rowTeacher;
}
?>