<?php
$justInclude=true;
include_once("../config.php");
$debug=false;
if($debug) $fp=fopen("logging.txt",'w');
if($debug) fwrite($fp,$_POST);


$typesAllowed=array("T");
$postVariablesRequired=array("year","subject","extraRef","timeslotsArray");
include("checkAjax.php");
if(!isset($_POST["classID"])){
	$schyear=date("Y",strtotime("-".$cutoffMonth." months",time()));
	$sql="INSERT INTO classlist VALUES ('".$_SESSION['schoolID']."',NULL,'".$_POST["year"]."', '".$_POST["subject"]."','".addslashes($_POST["extraRef"])."','".$_SESSION["userID"]."',".$schyear.")";
//	echo $sql;
	$result=mysql_query($sql);
	$classID=mysql_insert_id();
	$newDir=$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/ebooks/".$classID;
	if(!is_dir($newDir)) mkdir($newDir);
	$newDir=$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/planning/";
	if(!is_dir($newDir)) mkdir($newDir);

	$newDir=$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/planning/".$classID;
	if(!is_dir($newDir)) mkdir($newDir);
	$newDir=$_SESSION["schoolPath"].$_SESSION["userType"]."/".$_SESSION["userID"]."/dropbox/".$classID;
	if(!is_dir($newDir)) mkdir($newDir);
	if(is_array($_POST["timeslotsArray"])){
		$valuesList=array();
		foreach($_POST["timeslotsArray"] as $k=>$currentTimeslot){
			$day=explode("|",$currentTimeslot);
			$timeSlotID=$day[1];
			$day=$day[0];
			$room=addslashes($_POST["Room".$currentTimeslot]);		
			$valuesList[count($valuesList)]="('".$_SESSION["schoolID"]."','".$day."','".$timeSlotID."','".$classID."','".$room."')";
		}
		$sql="INSERT INTO timetableslots VALUES ".implode(",",$valuesList);
		if($debug) fclose($fp);
		$result=mysql_query($sql) or die("Error Creating Class".mysql_error());
		echo "<div class='subHeading'>Class Created Successfully</div>";
	}
} else {
	$sql="UPDATE classlist SET year='".$_POST["year"]."', subjectID='".$_POST["subject"]."', extraRef='".addslashes($_POST["extraRef"])."' WHERE teacherID='".$_SESSION["userID"]."' AND classID=".$_POST["classID"];
//	echo $sql;
	$res=mysql_query($sql) or die("Error in update");
	if(is_array($_POST["timeslotsArray"])){
		$sql2="DELETE FROM timetableslots WHERE classID=".$_POST["classID"];
		$res2=mysql_query($sql2) or die("Error updating timetable");	
		$valuesList=array();
		foreach($_POST["timeslotsArray"] as $k=>$currentTimeslot){
			$day=explode("|",$currentTimeslot);
			$timeSlotID=$day[1];
			$day=$day[0];
			$classID=$_POST["classID"];
			$room=addslashes($_POST["Room".$currentTimeslot]);		
			$valuesList[count($valuesList)]="('".$_SESSION["schoolID"]."','".$day."','".$timeSlotID."','".$classID."','".$room."')";
		}
		$sql="INSERT INTO timetableslots VALUES ".implode(",",$valuesList);
		if($debug) fclose($fp);
		$result=mysql_query($sql) or die("Error Updating Class");
		echo "<div class='subHeading'>Class Updated Successfully</div>";
	}	
}
?>