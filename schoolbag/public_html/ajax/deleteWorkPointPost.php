<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("T","S","A","P");
$postVariablesRequired=array("topic","date");
include("checkAjax.php");

$sql="DELETE FROM work_point_posts WHERE topicID='".$_POST["topic"]."' AND date='".$_POST["date"]."' AND postOwner='".$_SESSION["userID"]."'";
mysql_query($sql) or die("Error");
echo translate("Post deleted");
?>