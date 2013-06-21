<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("T","S","A");
$postVariablesRequired=array("date");
include("checkAjax.php");

$sql="DELETE FROM noticeboardcomments WHERE date='".$_POST["date"]."' AND addedBy='".$_SESSION["userID"]."'";
//echo $sql;
$result=mysql_query($sql);
echo "Comment Deleted"
?>