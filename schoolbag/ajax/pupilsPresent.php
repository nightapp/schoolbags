<?php
$justInclude=true;
include("../config.php");
$typesAllowed=array("T","S");
$postVariablesRequired=array("details","students","updating","timeslotID","date");
include("checkAjax.php");
if(count($_POST["details"])!=count($_POST["updating"])) die("ERROR IN REQUEST");
$mysqlstring="";
$addComma=false;
foreach($_POST["details"] as $k=>$v) {
	if(isset($_POST["updating"][$k])){
		if(isset($_POST["details"][$k])){
			if($_POST["updating"][$k]==0){
				if($addComma) $mysqlstring.=",";
				$mysqlstring.=" (".$_SESSION["schoolID"].",".$k.",'".date("Y-m-d",strtotime($_POST["date"]))."',".(isset($_POST["students"][$k])?"1":"0").",'".$_POST["timeslotID"]."','".(isset($_POST["students"][$k])?"0":"F")."')";
				$addComma=true;
			} else {
				$sql="UPDATE present SET present=".(isset($_POST["students"][$k])?"1":"0").", notes='".addslashes(urldecode($_POST["details"]))."' WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$k." AND date='".date("Y-m-d",strtotime($_POST["date"]))."' AND timeslotID='".$_POST["timeslotID"]."'";
				mysql_query($sql) or die(mysql_error());
			} 
		}
		
	}
}
if($mysqlstring!=""){
$mysqlstring="INSERT INTO present VALUES".$mysqlstring;
	$res=mysql_query($mysqlstring)or die(mysql_error());
}
echo "Roll Call Saved";
?>