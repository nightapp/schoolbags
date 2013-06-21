<?php
$typesAllowed=array("T");
$postVariablesRequired=array("subjects");
include("checkAjax.php");
$sql="DELETE FROM teachersteach WHERE user=".$_SESSION["userID"]." AND schoolID=".$_SESSION["schoolID"];
$mysqlstring="INSERT INTO teachersteach VALUES"
$addComma=false;
print_r($_POST["subjects"]);
foreach($_POST["subjects"] as $subject){
	if($addComma) $mysqlstring.=","
	$mysqlstring.=" (".$_SESSION["schoolID"].",".$_SESSION["userID"].",".$subject.")";
	$addComa=true;
}
echo mysql_num_rows(mysql_query($mysqlstring))." Subjects Are now linked to you";
?>
