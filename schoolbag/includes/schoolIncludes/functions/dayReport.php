
<?php
$sql1="SELECT * FROM timetableconfig WHERE schoolID=".$_SESSION["schoolID"]." ORDER BY startTime";
$result1=mysql_query($sql1);
$times=array();
while($t=mysql_fetch_assoc($result1)){
	$times[]=$t;
}
$sql="SELECT *
			FROM users,present,classlistofusers,timetableconfig,timetableslots
			WHERE users.userID=classlistofusers.studentID AND timetableconfig.schoolID=timetableslots.schoolID AND timetableslots.schoolID=users.schoolID and timetableslots.timeslotID=timetableconfig.timeslotID AND timetableslots.classID=classlistofusers.classID AND users.userID=present.studentID AND users.schoolID=present.schoolID AND users.schoolID=classlistofusers.schoolID AND users.schoolID=".$_SESSION["schoolID"]." AND [DATE_FACTOR] [YEAR_FACTOR] [CLASS_FACTOR] timetableslots.day=(DAYOFWEEK(present.date)-1) AND classlistofusers.studentID=users.userID AND users.schoolID=".$_SESSION["schoolID"]." 
			GROUP BY timetableslots.timeslotID,userID
			ORDER BY date,timetableslots.timeslotID";
$yearFactor="";
if($year!="all") $yearFactor=" users.year=".$year." AND";
$classFactor="";
if($class!="all") $classFactor=" classlist.classID=".$class." AND";
$dateFactor="";
if($start_date!="") $dateFactor.=" present.date='".$start_date."' AND";
//if($end_date!="") $dateFactor.=" present.date<='".$end_date."' AND";

$sql=str_replace("[DATE_FACTOR]",$dateFactor,$sql);
$sql=str_replace("[YEAR_FACTOR]",$yearFactor,$sql);
$sql=str_replace("[CLASS_FACTOR]",$classFactor,$sql);
//echo $sql;
			$result=mysql_query($sql) or die($sql.":".mysql_error());
//echo $sql;
$absent=array();
while($row=mysql_fetch_assoc($result)){ 
	if(!isset($absent[$row["userID"]])){
		$absent[$row["userID"]]=array();
		$absent[$row["userID"]]["First Name"]=$row["FirstName"];
		$absent[$row["userID"]]["Last Name"]=$row["LastName"];	
		foreach($times as $r){
				$absent[$row["userID"]][$r["startTime"]."-".$r["endTime"]]="-";	
		}
		$absent[$row["userID"]]["Total"]=0;
	}
	$absent[$row["userID"]][$row["startTime"]."-".$row["endTime"]]=$row["present"];
	$absent[$row["userID"]]["Total"]+=$row["present"];
}
if(!empty($absent)) array_to_csv($absent,$_GET["key"]."_".date("U").".csv",false);
?>