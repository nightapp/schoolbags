<?php 
$justInclude=true;//dont import page
include("../config.php");
if(!isset($_POST["newEmail"])){
	echo("No Email Recieved");
} else {
	$sql="UPDATE users SET email='".addslashes($_POST["newEmail"])."' WHERE schoolID='".$_SESSION["schoolID"]."' AND userID='".$_SESSION["userID"]."'";
	$sqlresult=mysql_query($sql);
	if(!(mysql_affected_rows() > 0)){ 
		echo("Email Address Not Changed.");
	} else {
		echo("Email Address Changed Successfully");
	}
}
?>