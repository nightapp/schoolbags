<?php
$valuesArray=array();
$val="'".$_SESSION["userType"]."'";
foreach($visibleNoticeBoards as $k=>$currentList){
	$tmpArray=explode(",",$currentList);
	if(in_array($val,$tmpArray)){
		$valuesArray[count($valuesArray)]=$k;
	}
}
//echo implode(",",$valuesArray);
$sql="SELECT * FROM noticeboard WHERE schoolID='".$_SESSION["schoolID"]."' AND userType IN('".implode("','",$valuesArray)."') AND DATE(date)=DATE(NOW())";
//echo $sql;
$result=mysql_query($sql);
if(mysql_num_rows($result)>0){
	echo "background_images/noticesnoticeboard.gif";
} else {
	echo "background_images/nonoticesnoticeboard.gif";
}
?>