<?php
//$slotsArray=new array(new array(),new array(),new array(),new array(),new array(),new array());
$slotsArray="";
if(!isset($_GET["date"])) {
	$day="all";
} else {
	$_GET["date"]=str_replace("|","/",$_GET["date"]);
	$dateArray=explode("/",$_GET["date"]);
	$_GET["date"]=implode("/",array_reverse($dateArray));
	$day=date("l",strtotime($_GET["date"]));//THATS A SMALL L
	$day_num=date("N",strtotime($_GET["date"]));
}
if($day=="all"){
	$retval='<div id="timetableHeaderFull"><div class="timetableCell timetableHeader" style="border-left:1px solid brown">Time</div><div class="timetableCell timetableHeader">Monday</div><div class="timetableCell timetableHeader">Tuesday</div><div class="timetableCell timetableHeader">Wednesday</div><div class="timetableCell timetableHeader">Thursday</div><div class="timetableCell timetableHeader">Friday</div><div class="timetableCell timetableHeader">Saturday</div></div>';
} else {
	$retval='
	<div id="timetableHeaderSmall"><div class="timetableCell timetableHeader" style="border-left:1px solid brown">Time</div>
		<div class="timetableCell timetableHeader">'.$day.'</div><div class="wideCell timetableHeader ">Homework</div><div class="wideCell timetableHeader ">Notes</div></div>
	';
}
echo $retval;
?>
<div id="timetableTimes">
<?php
$sql="SELECT * FROM timetableconfig WHERE schoolID='".$_SESSION["schoolID"]."' ORDER BY startTime ASC";
$result=mysql_query($sql);
$columns=7;
if($day!="all"){$columns=4;}
while($row=mysql_fetch_array($result)){
	for($i=1;$i<$columns;$i++){
		if($row["Preset"]!==NULL && $row["Preset"]!==""){
			$slotsArray[$row["timeslotID"]][$i]=$row["Preset"];
		} else {
			$slotsArray[$row["timeslotID"]][$i]="";
		}
	}
?>
<div class="timetableCell timetableSlot" id="timeSlot<?php echo $row["timeslotID"];?>" <?php if($row["Slot"]==NULL || $row["Slot"]=="") echo 'rel="'.$row["timeslotID"].'"';?>><?php echo date("H:i",strtotime($row["startTime"]))." - ".date("H:i",strtotime($row["endTime"]));?></div>
<?php	
}
?>
</div>

<?php //////// Get and add slots
$getsql="SELECT * from classlistofusers WHERE studentID='".$_SESSION["userID"]."' AND schoolID='".$_SESSION["schoolID"]."'";
$getresult=mysql_query($getsql);
$valuesString="";
while($row=mysql_fetch_array($getresult)){
	if(strlen($valuesString)>0) $valuesString.=",";
	$valuesString.=$row["classID"];
}
if($day!='all'){
	$sqlextra=" AND timetableslots.Day='".$day_num."'";
} else {
	$sqlextra="";
}
$sql2=sprintf("SELECT * from timetableslots,classlist WHERE classlist.classID=timetableslots.classID AND classlist.classID IN (%s) %s ORDER BY Day,timeslotID",$valuesString,$sqlextra);
$result2=mysql_query($sql2);
if(is_file("includes/getTeachers.php")){
	include_once("includes/getTeachers.php");
	include_once("includes/getSubjects.php");
} else {
	include_once("../includes/getTeachers.php");
	include_once("../includes/getSubjects.php");
}
$homeworkArray="";
if($day!='all'){
	$homeworksql="SELECT * from homework WHERE studentID='".$_SESSION["userID"]."' AND date='".implode("-",array_reverse($dateArray))."'";
	$homeworkresult=mysql_query($homeworksql);
	while($homework=mysql_fetch_array($homeworkresult)){
		$homeworkArray[$homework["timeslotID"]][0]=$homework["text"];
		$homeworkArray[$homework["timeslotID"]][1]=$homework["status"];
	}
}
while($row=mysql_fetch_array($result2)){
//	echo  $row["timeslotID"];
	if($day!='all'){
		$slotsArray[$row["timeslotID"]][1][0]=$subjects[$row["subjectID"]];
		$slotsArray[$row["timeslotID"]][1][1]=$teachers[$row["teacherID"]];
		$slotsArray[$row["timeslotID"]][1][2]=$row["Room"];
		$slotsArray[$row["timeslotID"]][1][3]=$row["extraRef"];
		if(is_array($homeworkArray[$row["timeslotID"]])){
			$slotsArray[$row["timeslotID"]][2]="<textarea style='background-color:white;border:none;margin:0px;width:92%;height:89%;z-index:999'>".$homeworkArray[$row["timeslotID"]][0]."</textarea>";
		} else {
			$slotsArray[$row["timeslotID"]][2]="<textarea style='background-color:white;border:none;margin:0px;width:92%;scrollable:false;height:89%;z-index:999'></textarea>";
		}
	} else {
		$slotsArray[$row["timeslotID"]][$row["Day"]][0]=$subjects[$row["subjectID"]];
		$slotsArray[$row["timeslotID"]][$row["Day"]][1]=$teachers[$row["teacherID"]];
		$slotsArray[$row["timeslotID"]][$row["Day"]][2]=$row["Room"];
		$slotsArray[$row["timeslotID"]][$row["Day"]][3]=$row["extraRef"];
	}
}
foreach($slotsArray as $k=>$v){
	foreach($v as $i=>$j){
		$class="timetableCell";
		if($i>1) $class="wideCell";
//		echo '['.$k.']['.$i.']='.$j.'<br /><br />';
		if(is_array($j)){
//			echo ("<div class='timetableCell'><div style='width:60%;height:100%;float:left;display:inline;font-size:15px;border-right:1px dotted brown'>".$j[0]."<br>".$j[3]."</div><div style='display:inline;float:left;width:39%;height:17px;font-size:11px'>".$j[1]."</div><div style='display:inline;float:left;width:39%;height:17px;font-size:11px'>".$j[2]."</div></div>");
			echo ("<div class='timetableCell'><b style='font-size:12px'>".$j[0]."</b><br><em>".$j[1]."</em><br>".$j[2]."</div>");
		} elseif($j==""){
			echo ("<div class='".$cell."' style='font-size:18px;'></div>");
		} elseif(strpos($j,"textarea")) {
			echo ("<div class='".$cell."'>".$j."</div>");
		} else {
			echo ("<div class='".$cell."' style='font-size:18px;background-color:#CCFFFF'>".$j."</div>");
		}
	}
}
?>
