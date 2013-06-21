<?php
session_start();
if(!isset($_POST["SubFolder"])) die("0");
if(!isset($_POST["SubSubFolder"])) die("0");
if(!isset($_POST["fileName"])) die("0");
if(!isset($_POST["csv0"])) die("0");

$targetPath=$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/";
//recursive subdir generator
$currentVar="SubFolder";
while(isset($_POST[$currentVar])){
	if($_POST[$currentVar]=="new") $_POST[$currentVar]=$_POST["newFolder"];	
	$targetPath=$targetPath.urldecode($_POST[$currentVar])."/";
	if(!is_dir($targetPath)) mkdir($targetPath);
	$currentVar="Sub".$currentVar;
}
$i=0;
$newContent="";

if(isset($_POST["csv".$i])){
	while(isset($_POST["csv".$i])){
		$newContent.=trim(urldecode($_POST["csv".$i]));
		$i++;
	}
} else {
	$newContent=$_POST["fileData"];
}
$targetFile=$targetPath.$_POST["fileName"].".txt";
$fp=fopen($targetFile,"w");
$done=fwrite($fp,htmlspecialchars($newContent));
fclose($fp);
if($done) {
	echo "File saved";
} else {
	echo 0;
}
?>