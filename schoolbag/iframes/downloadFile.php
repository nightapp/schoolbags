<?php
session_start();
header('Content-Disposition: attachment; filename="homework.html"');
if(!isset($_SESSION["schoolPath"]) || strpos($_GET["file"],"../")!==FALSE) die ("Error downloading");

if(isset($_GET["file"])){
	$file="../".$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/".$_GET["file"];
	if(file_exists($file)){
		$fp=fopen($file,"r");
		echo html_entity_decode(fread($fp,filesize($file)));
		fclose($fp);
	} else {
		echo translate("The homework File could not be found.");
	}
} else {
	echo translate("Error in Request");
}
?>
