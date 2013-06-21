<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("S");
$postValuesRequired=array("ID");
include("checkAjax.php");

$ID=str_replace("timeslot","",$_POST["ID"]);
$sql="DELETE FROM timetableconfig WHERE schoolID=".$_SESSION["schoolID"]." AND timeSlotID='".$ID."' LIMIT 1";
$result=mysql_query($sql);
?>
<b>Current Slots</b><br>	
<?php
$sql="SELECT * FROM timetableconfig WHERE schoolID='".$_SESSION["schoolID"]."' ORDER BY timeslotID";
$result=mysql_query($sql);
//echo $sql;
while($time=mysql_fetch_array($result)){
echo date("H:i",strtotime($time["startTime"]))." - ".date("H:i",strtotime($time["endTime"]))." - ".$time["Preset"]."<img src='background_images/Delete-icon.png' style='height:10px;width:10px' id='timeslot".$time["timeslotID"]."' /><br>";
}
?>