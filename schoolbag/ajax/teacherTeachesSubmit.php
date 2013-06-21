<?php
$justInclude=true;
include("../config.php");
$typesAllowed=array("T");
$postVariablesRequired=array("subjects");
include("checkAjax.php");
$sql="DELETE FROM teachersteach WHERE userID=".$_SESSION["userID"]." AND schoolID=".$_SESSION["schoolID"];
mysql_query($sql);
$mysqlstring="INSERT INTO teachersteach VALUES";
$addComma=false;
//print_r($_POST["subjects"]);
foreach($_POST["subjects"] as $subject){
	if($addComma) $mysqlstring.=",";
	$mysqlstring.=" (".$_SESSION["schoolID"].",".$_SESSION["userID"].",".$subject.")";
	$addComma=true;
}
//echo $mysqlstring;
$res=mysql_query($mysqlstring);
echo count($_POST["subjects"])." Subjects Are now assigned to you";
?>
