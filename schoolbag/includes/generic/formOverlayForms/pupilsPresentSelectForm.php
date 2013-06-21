<?php $justInclude=true; include_once("../../../config.php"); ?>
<div class="subHeading" style="width:100%">Roll Call</div><br />
<form id="pupilsPresentSelectForm" class="formInOverlay" style="margin:5px;">
<?php 
date_default_timezone_set('Europe/Dublin');
$startTime=date("H:i:s");
$date=$datedmy=date("Y-m-d");
$teacher=$_SESSION["userID"];
if(isset($_GET["date"]) && $_GET["date"]!=="") $date=$_GET["date"];
if(isset($_GET["teacher"]) && $_GET["teacher"]!=="" && $_SESSION["Type"]=="S") $teacher=$_GET["teacher"];
$date=strtotime($date);
$datedmy=date("Y-m-d",$date);
$day=date("w",$date);

$schyear=date("Y",strtotime("-".$cutoffMonth." months",$date));

$sql="SELECT *,timetableconfig.timeslotID AS timeslt from (classlistofusers,classlist,users,timetableslots,timetableconfig) LEFT JOIN present ON (present.date='[DATE]' AND present.timeslotID=timetableslots.timeslotID AND present.studentID=users.userID) WHERE timetableconfig.schoolID=".$_SESSION["schoolID"]." AND [TIME_FACTOR] AND timetableslots.timeslotID=timetableconfig.timeslotID AND timetableslots.day=[DAY] AND classlist.classID=timetableslots.classID AND classlist.schyear=[SCHYEAR] AND classlist.teacherID=[TEACHER] AND classlistofusers.classID=classlist.classID AND users.userID=classlistofusers.studentID";

if(isset($_GET["time"])){
	$timeFactor="timetableconfig.timeslotID='".$_GET["time"]."'";
} else {
	$timeFactor="timetableconfig.starttime<'[TIME]' AND timetableconfig.endtime>'[TIME]'";
}
$sql=str_replace("[TIME_FACTOR]",$timeFactor,$sql);
$sql=str_replace("[TIME]",$startTime,$sql);
$sql=str_replace("[DATE]",date("Y-m-d",$date),$sql);
$sql=str_replace("[TEACHER]",$teacher,$sql);
$sql=str_replace("[DAY]",$day,$sql);
$sql=str_replace("[SCHYEAR]",$schyear,$sql);
//echo $sql;
$result=mysql_query($sql);
//echo $sql;
//echo mysql_num_rows($result);
$timeslotID="";
while($row=mysql_fetch_assoc($result)){
	if($timeslotID=="") $timeslotID=$row["timeslt"];
	$updating=true;
	$checked="";
	$display="rel='updating' ";
	if($row["present"]===NULL){
		$row["present"]=1;
		$display="";
		$updating=false;
	}
	if(	$row["present"]==1) {$checked="checked='checked' "; $display.="title='Present/Not Present' ";}

?><div style="display:inline;float:left;width:33%;text-align:left;<?php echo $color;?>"><input type="checkbox" <?php echo $display;?>name="students[<?php echo $row["userID"];?>]" <?php echo $checked;?>value="<?php echo $k;?>"/>
<?php
echo $row["FirstName"]." ".$row["LastName"];
?>
<input type="hidden" name="updating[<?php echo $row["userID"];?>]" style="display:none" <?php echo $updating?"value='1'":"value='0'";?> />
<input type="hidden" name="details[<?php echo $row["userID"];?>]" title="Details" value="<?php echo $row["notes"];?>"/></div>
<?php }
?><br />
<br />
<input type="hidden" name="date" value="<?php echo $datedmy;?>" />
<input type="hidden" name="timeslotID" value="<?php echo $timeslotID;?>" />
<div style="width:100%;clear:both">
<input type="checkbox" style="display:none" name="students[0]" checked="checked"/>
<input id="submit" type="button" value="Save Roll Call &raquo;" /></div>
</form>
