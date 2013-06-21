<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("P");
$postValuesRequired=array("classID");
include("checkAjax.php");

$valuesArray=array();
$dirToMake1="../".$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/ebooks";
if(!is_dir($dirToMake1)) mkdir($dirToMake1);
$dirToMake2="../".$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/homework";
if(!is_dir($dirToMake2)) mkdir($dirToMake2);
$tmpdirToMake1=$dirToMake1;
$tmpdirToMake2=$dirToMake2;
foreach($_POST["classID"] as $classID){
	$valuesArray[count($valuesArray)]="('".$_SESSION['schoolID']."','".$classID."', '".$_SESSION["userID"]."')";	
	$dirToMake1.="/".$classID;
	$dirToMake2.="/".$classID;
	if(!is_dir($dirToMake1)) mkdir($dirToMake1);
	if(!is_dir($dirToMake2)) mkdir($dirToMake2);
	$dirToMake1=$tmpdirToMake1;
	$dirToMake2=$tmpdirToMake2;
}
$sql="INSERT INTO classlistofusers VALUES ".implode(" , ",$valuesArray);
$result=mysql_query($sql);
echo mysql_affected_rows()." classes Joined";
?>