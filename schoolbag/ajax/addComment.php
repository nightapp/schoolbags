<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("S","A","T");
$postVariablesRequired=array("text","uplBy","dateOfNews");
include("checkAjax.php");
$date=date("Y-m-d H:i:s");
if(isset($_POST["date"])){
	$date=$_POST["date"];
// echo $_POST["text"];
	$sql="UPDATE noticeboardcomments SET comment='".addslashes(urldecode(stripslashes($_POST["text"])))."' WHERE datedateofnews='".$_POST["dateOfNews"]."' AND newsOwner=".$_POST["uplBy"]."' AND addedBy=".$_SESSION["userID"];
} else {
	$sql="INSERT INTO noticeboardcomments SET comment='".addslashes(urldecode(stripslashes($_POST["text"])))."', date='".date("Y-m-d H:i:s")."', dateofnews='".$_POST["dateOfNews"]."', newsOwner='".$_POST["uplBy"]."', addedBy=".$_SESSION["userID"];
}
//echo $sql;
$result=mysql_query($sql);
echo $result;
?>