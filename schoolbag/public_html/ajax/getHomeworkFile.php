<?php
session_start();
$dateString=$_POST["date"];

$postVariablesRequired=array("studentID","classID","topic");

if(isset($_POST["studentID"])){
	$studentID=$_POST["studentID"];

	$file="../".$_SESSION["schoolPath"]."P/".$studentID."/homework/".$_POST["classID"]."/".$_POST["topic"]."/".date("Y-m-d",strtotime($dateString)).".txt";
	if(file_exists($file)){
//		echo "HOMEWORK: ".$file."<br />";
		$fp=fopen($file,"r");
		echo html_entity_decode(fread($fp,filesize($file)));
		fclose($fp);
	} else {
		echo "The homework File could not be found.";
	}
} else {
	echo "Error in Request";
}
?>
