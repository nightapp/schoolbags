<?php
$justInclude=true;
include_once("../config.php");

$typesAllowed=array("S");
$postVariablesRequired=array("startH","startM","endH","endM","Preset");
include("checkAjax.php");

$ID=str_pad($_POST["startH"],2,"0",STR_PAD_LEFT).str_pad($_POST["startM"],2,"0",STR_PAD_LEFT);
$startTime=$_POST["startH"].":".$_POST["startM"].":00";
$endTime=$_POST["endH"].":".$_POST["endM"].":00";
$sql="INSERT INTO timetableconfig VALUES (".$_SESSION["schoolID"].",'".$ID."','".$startTime."','".$endTime."','".addslashes($_POST["Preset"])."')";
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