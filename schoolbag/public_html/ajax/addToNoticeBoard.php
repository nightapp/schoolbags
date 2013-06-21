<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("S","A","T");
$postVariablesRequired=array("text","visibleTo");
include("checkAjax.php");
$date=date("Y-m-d H:i:s");
if(isset($_POST["date"])){
	$date=$_POST["date"];
// echo $_POST["text"];
	$sql="UPDATE noticeboard SET text='".addslashes(urldecode(stripslashes($_POST["text"])))."' WHERE schoolID='".$_SESSION["schoolID"]."' AND date='".$date."' AND uploadedBy=".$_SESSION["userID"];
 } else {
 $c='NULL';
 if($_POST["visibleTo"]=="C") $c=$_POST["SubSubFolder"];
$sql="INSERT INTO noticeboard VALUES ('".$_SESSION["schoolID"]."','".$date."','".addslashes(urldecode(stripslashes($_POST["text"])))."','".$_POST["visibleTo"]."',".$_SESSION["userID"].",".$c.")";

}

//echo $sql;
$result=mysql_query($sql);
echo $result;
?>