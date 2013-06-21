<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("T","S","A");
$postVariablesRequired=array("date");
include("checkAjax.php");

$sql="DELETE FROM noticeboard WHERE schoolID=".$_SESSION["schoolID"]." AND date='".$_POST["date"]."'";
//echo $sql;
$result=mysql_query($sql);
echo "Notice Deleted"
?>