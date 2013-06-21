<?php
$justInclude=true;
include("../config.php");
$typesAllowed=array("T","S");
$postVariablesRequired=array("details","student","date");
include("checkAjax.php");
$mysqlstring="";
$addComma=false;
$present=($_POST["details"]!="0"?"0":"1");
$k=$_POST["student"];
$r=$_POST["details"];
$mysqlstring.=" present=".$present.", notes='".$r."' ";


if($mysqlstring!=""){
	$mysqlstring="UPDATE present SET".$mysqlstring."WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$k." AND (present=0) AND date='".date("Y-m-d",strtotime($_POST["date"]))."'";
	echo $mysqlstring;
	$res=mysql_query($mysqlstring)or die(mysql_error());
}
?>