<?php
$justInclude=true;
include("../config.php");

$typesAllowed=array("P","T");
$postVariablesRequired=array("c","parent","folderName");
include("checkAjax.php");

if(strpos($_POST["parent"],"../")!==false) die("Error : Access denied");
if(strpos($_POST["folderName"],"../")!==false) die("Error : Access denied");
$_POST["parent"].="/";
if($_POST["parent"]=='root/') $_POST["parent"]="";
$parent=array();
$parent[]="../".$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/"."dropbox/";
$parent[]=$_POST["c"]."/";
$parent[]=$_POST["parent"];
$parent[]=$_POST["folderName"]."/";
$p="";
foreach($parent as $v){
	$p.=$v;
	@mkdir($p);
}
echo 1;
?>