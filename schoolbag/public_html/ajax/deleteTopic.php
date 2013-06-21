<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("T","S","A");
$postVariablesRequired=array("topic");
include("checkAjax.php");

$sql="DELETE FROM topics WHERE schoolID=".$_SESSION["schoolID"]." AND topicID='".$_POST["topic"]."' AND topicOwner=".$_SESSION["userID"];
//echo $sql;
$result=mysql_query($sql);
if(mysql_affected_rows($result)==1){
$sql="DELETE FROM posts WHERE topicID='".$_POST["topic"]."'";
mysql_query($sql) or die("Error");
echo "Topic and all related posts deleted";
} else {
echo "Error";
}
?>