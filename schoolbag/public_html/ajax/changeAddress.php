<?php 
$justInclude=true;
include("../config.php");
if(!isset($_POST["address"])){
	echo("No Address Recieved");
} else {
	$sql="UPDATE schoolinfo SET Address='".addslashes(urldecode($_POST["address"]))."' WHERE schoolID='".$_SESSION["schoolID"]."'";
	$sqlresult=mysql_query($sql);
	if(!(mysql_affected_rows() > 0)){ 
		echo("An Error Occured");
	} else {
		echo("Address Changed Successfully");
	}
}
?>