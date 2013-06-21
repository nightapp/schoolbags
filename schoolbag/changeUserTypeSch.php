<?php
session_start();
if(isset($_SESSION["schUserID"])){
	$_POST["username"]=$_SESSION["schUserID"];
	$_POST["userType"]=$_SESSION["schUserType"];
	unset($_SESSION["schUserID"]);
	unset($_SESSION["schUserType"]);
	$_SESSION["passwordOverRide"]=true;
} else {
	if($_SESSION["userType"]=="S"){
		$_SESSION["schUserID"]=$_SESSION["userID"];		
		$_SESSION["schUserType"]=$_SESSION["userType"];	
		$_POST["userType"]="T";	
			
		$_POST["username"]=$_GET["userID"];
		$_SESSION["passwordOverRide"]=true;
	}
}
//print_r($_SESSION);
//print_r($_POST);
include("config.php");
?>