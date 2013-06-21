<?php
$justInclude=true;
include("../config.php");

$typesAllowed=array("P","T");
$postVariablesRequired=array("c","type","folder","fileName");
include("checkAjax.php");

if(strpos($_POST["fileName"],"../")!==false) die("Error : Access denied");
if(strpos($_POST["type"],"../")!==false) die("Error : Access denied");
if(strpos($_POST["folder"],"../")!==false) die("Error : Access denied");
$_POST["folder"].="/";
$parent=array();
$parent[]="../".$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/".$_POST["type"]."/";
$parent[]=$_POST["c"]."/";
if($_POST["folder"]!="root" && $_POST["folder"]!="root/") $parent[]=$_POST["folder"]."/";
$p=implode("",$parent);
$p=str_replace("//","/",$p);
if(is_file($p.$_POST["fileName"])){
	if(unlink($p.$_POST["fileName"])){
		die("File Deleted");
	} else {
		die("Error file could not be deleted");
	}
} else {
	die("File not found");
}
?>