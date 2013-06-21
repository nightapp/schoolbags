<?php
$justInclude=true;
include_once("../config.php");
$debug=false;
if($debug) $fp=fopen("logging.txt",'w');
if($debug) fwrite($fp,$_POST);

$typesAllowed=array("T");
$postVariablesRequired=array("SubSubFolder");
include("checkAjax.php");
include("../includes/generic/listdir.php");
$books=array();
$resources=array();
/*if(is_dir("../".$_SESSION["schoolPath"]."T/".$_SESSION["userID"]."/ebooks/".$_POST["SubSubFolder"])){
$books=getfilelist("../".$_SESSION["schoolPath"]."T/".$_SESSION["userID"]."/ebooks/".$_POST["SubSubFolder"],"DIR");
}
if(is_dir("../".$_SESSION["schoolPath"]."T/".$_SESSION["userID"]."/ebooks/".$_POST["SubSubFolder"])){
$resources=getfilelist("../".$_SESSION["schoolPath"]."T/".$_SESSION["userID"]."/dropbox/".$_POST["SubSubFolder"],"DIR");
}
$tmp=count($files)+count($resources);*/
$tmp=0;
$sql="SELECT * FROM classlistofusers WHERE classlistofusers.classID=".$_POST["SubSubFolder"];

if(mysql_num_rows(mysql_query($sql))==0 && $tmp==0){
	$sql="DELETE FROM classlist WHERE classlist.classID=".$_POST["SubSubFolder"]." AND classlist.teacherID=".$_SESSION["userID"];
//	echo $sql;
	mysql_query($sql) or die(mysql_error());
	$sql="DELETE FROM timetableslots WHERE timetableslots.classID=".$_POST["SubSubFolder"];
//	echo $sql;
	mysql_query($sql) or die(mysql_error());
	echo "<div class='subHeading'>Class deleted</div>";
} else {
	echo "<div class='subHeading'>You cannot delete a class with students already joined</div>";
}
?>