<?php
session_start();
if(isset($_SESSION["actualUserID"])){
	$_POST["username"]=$_SESSION["actualUserID"];
	$_POST["userType"]=$_SESSION["actualUserType"];
	unset($_SESSION["actualUserID"]);
	unset($_SESSION["actualUserType"]);
	$_SESSION["passwordOverRide"]=true;
} else {
	if($_SESSION["userType"]=="T"){
		$_SESSION["actualUserID"]=$_SESSION["userID"];		
		$_SESSION["actualUserType"]=$_SESSION["userType"];	
		$_POST["userType"]="P";	
			
		$_POST["username"]=$_GET["userID"];
		$_SESSION["passwordOverRide"]=true;
	}
}
//print_r($_SESSION);
//print_r($_POST);
include("config.php");
?>