<?php

$sqlClasses="SELECT * from classlistofusers WHERE schoolID='".$_SESSION["schoolID"]."' AND studentID='".$_SESSION["userID"]."'";
//echo $sqlClasses;
$resClasses=mysql_query($sqlClasses);
$notIn=array();
while($class=mysql_fetch_array($resClasses)){
	$notIn[count($notIn)]=$class["classID"];
}
$addsql="";
if(count($notIn)>0){
	$addsql=" AND classID NOT IN (".implode(",",$notIn).")";
}
if(isset($_POST["subject"])){
	if($_POST["subject"]>0){
		$addsql.=" AND subjectID=".$_POST["subject"];
	} else {
		unset($_POST["subject"]);
	}
}
$sqlclasses="SELECT * from classlist WHERE year=".$_SESSION["year"]." AND schyear=".date("Y",strtotime("-".$cutoffMonth." months",time()))." AND schoolID=".$_SESSION["schoolID"].$addsql;
$resultclasses=mysql_query($sqlclasses);
$classes=array();
while($row=mysql_fetch_array($resultclasses)){
	$classes[$row["classID"]]=$row;
}
?>