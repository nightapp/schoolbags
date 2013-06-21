<?php
$justInclude=true;
include("../config.php");

$typesAllowed=array("P");
$postVariablesRequired=array("params","check");
include("checkAjax.php");
$post=explode("&",$_POST["params"]);
$postValues=array();
foreach($post as $v){
	$tmp=explode("=",$v);
	$postValues[$tmp[0]]=$tmp[1];
	if($tmp[0]=="teacher") $postValues[$tmp[0]]=str_replace("_","'",$postValues[$tmp[0]]);

}
if($_POST["text"]==""){
		$checkSql="DELETE FROM homework WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$_SESSION["userID"]." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."'";
//		echo $checkSql;
		mysql_query($checkSql);
} else {
		$checkSql="UPDATE homework SET text='".addslashes($_POST["text"])."', status=".$_POST["check"]." WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$_SESSION["userID"]." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."'";
	$checkResult=mysql_affected_rows(mysql_query($checkSql));
	$updated=true;
	if($checkResult==0){
		$insertSql="INSERT INTO homework SET text='".addslashes($_POST["text"])."', status=".$_POST["check"].", schoolID=".$_SESSION["schoolID"].", studentID=".$_SESSION["userID"].", timeslotID='".$postValues["timeslotID"]."', date='".implode("-",array_reverse(explode("|",$postValues["date"])))."'";
		$updated=false;
		mysql_query($insertSql);
	}
}
?>