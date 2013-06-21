<?php 

$justInclude=true;
include("../config.php");

$typesAllowed=array("P");
$postVariablesRequired=array("year");
include("checkAjax.php");

$year=4;
if($_POST["year"]=="yes"){
	$year=4;
} elseif($_POST["year"]=="no"){
	$year=5;
} else {
	die("An Error Occured");
}
$sql="UPDATE users SET year=".$year." WHERE userID=".$_SESSION["userID"];
$result=mysql_query($sql);
echo "Update Complete";
?>