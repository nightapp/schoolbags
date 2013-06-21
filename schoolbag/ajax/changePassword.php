<?php 
$justInclude=true;
include("../config.php");
if(!isset($_POST["newPass"]) || !isset($_POST["oldPass"])){
	echo("No password Recieved");
} else {
	$sql="UPDATE users SET password='".addslashes($_POST["newPass"])."' WHERE schoolID='".$_SESSION["schoolID"]."' AND userID='".$_SESSION["userID"]."' AND password='".addslashes($_POST["oldPass"])."'";
	$sqlresult=mysql_query($sql);
	if(!(mysql_affected_rows() > 0)){ 
		echo("Incorrect Old Password");
	} else {
		echo("Password Changed Successfully");
	}
}
?>