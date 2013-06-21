<?php
if(!isset($_POST["pwd"]) || $_POST["pwd"]!=md5("schoolBag")) die("Error in request"); 
$justInclude=true;
if($_SESSION["userID"]!=1) die("Access denied");
if($_SESSION["incremented"]===true) die("You have preformed this action in this session already<br>This means you probably refreshed this page.");
include_once("../config.php");
$sqlif="if(users.year<>3,users.year+1,if(schoolinfo.allTY=0,users.year+2,if(schoolinfo.allTY=2,users.year+1,9)))";

$sql="UPDATE users,schoolinfo SET users.year=".$sqlif." WHERE users.schoolID=schoolinfo.schoolID AND users.Type='P'";
echo $sql;
$_SESSION["incremented"]=true;
die("This feature has been locked to ensure it cannot be repeated during the year. Contact damien@onsight.ie / liam@onsight.ie to unlock this.");
$sqlresult=mysql_query($sql);
echo mysql_affected_rows();
?>