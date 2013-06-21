<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("T","S","A","P");
$postVariablesRequired=array("topic");
include("checkAjax.php");

$sql="DELETE FROM work_point_topics WHERE schoolID=".$_SESSION["schoolID"]." AND topicID='".$_POST["topic"]."' AND topicOwner=".$_SESSION["userID"];
$result=mysql_query($sql) or die(mysql_error());
if(mysql_affected_rows()==1){
$sql="DELETE FROM posts WHERE topicID='".$_POST["topic"]."'";
mysql_query($sql) or die("Error");
echo translate("Topic and all related posts deleted");
} else {
echo "Error";
}
?>