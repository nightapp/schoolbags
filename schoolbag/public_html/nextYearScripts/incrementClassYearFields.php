<?php
if(!isset($_POST["pwd"]) || $_POST["pwd"]!=md5("schoolBag")) die("Error in request"); 
$justInclude=true;

include_once("../config.php");

$sql="UPDATE class SET year=year+1";
echo $sql;
$sqlresult=mysql_query($sql);
echo mysql_affected_rows();

?>