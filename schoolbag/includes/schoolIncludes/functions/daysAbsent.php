
<?php
$sql="SELECT *,SUM(present) AS 'Classes Attended',date,GROUP_CONCAT(notes SEPARATOR '') AS NOTE
			FROM users,present,classlistofusers,timetableconfig,timetableslots
			WHERE users.userID=classlistofusers.studentID AND present.timeslotID=timetableconfig.timeslotID AND timetableconfig.schoolID=timetableslots.schoolID AND timetableslots.schoolID=users.schoolID and timetableslots.timeslotID=timetableconfig.timeslotID AND timetableslots.classID=classlistofusers.classID AND users.userID=present.studentID AND users.schoolID=present.schoolID AND users.schoolID=classlistofusers.schoolID AND timetableslots.day=(DAYOFWEEK(present.date)-1) AND [DATE_FACTOR] [YEAR_FACTOR] [CLASS_FACTOR] classlistofusers.studentID=users.userID AND users.schoolID=".$_SESSION["schoolID"]." 
			GROUP BY date,userID
			ORDER BY date";
$yearFactor=""; 
if($year!="all") $yearFactor=" users.year=".$year." AND";
$classFactor="";
if($class!="all") $classFactor=" classlistofusers.classID=".$class." AND";
$dateFacttor="";
if($start_date!="") $dateFactor.=" present.date>='".$start_date."' AND";
if($end_date!="") $dateFactor.=" present.date<='".$end_date."' AND";
$sql=str_replace("[DATE_FACTOR]",$dateFactor,$sql);
$sql=str_replace("[YEAR_FACTOR]",$yearFactor,$sql);
$sql=str_replace("[TIME_FACTOR]",$timeFactor,$sql);
$sql=str_replace("[CLASS_FACTOR]",$classFactor,$sql);
			$result=mysql_query($sql) or die(mysql_error());
$absent=array();
$dates=array();
while($row=mysql_fetch_assoc($result)){ 
	$absent[$row["userID"]][$row["date"]]=($row["Classes Attended"]>0?1:0);
	if(!isset($absent[$row["userID"]]["First Name"])){
		$absent[$row["userID"]]=array();
		$absent[$row["userID"]]["First Name"]=$row["FirstName"];
		$absent[$row["userID"]]["Last Name"]=$row["LastName"];
		$absent[$row["userID"]]["Year"]=$row["year"];
		$absent[$row["userID"]]["A"]=0;
		$absent[$row["userID"]]["B"]=0;
		$absent[$row["userID"]]["C"]=0;
		$absent[$row["userID"]]["D"]=0;
		$absent[$row["userID"]]["E"]=0;
		$absent[$row["userID"]]["F"]=0;
		$absent[$row["userID"]]["G"]=0;
	}
	if($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"A")!==FALSE) $absent[$row["userID"]]["A"]++;
	elseif ($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"B")!==FALSE) $absent[$row["userID"]]["B"]++;
	elseif ($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"C")!==FALSE) $absent[$row["userID"]]["C"]++;
	elseif ($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"D")!==FALSE) $absent[$row["userID"]]["D"]++;
	elseif ($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"E")!==FALSE) $absent[$row["userID"]]["E"]++;
	elseif ($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"G")!==FALSE) $absent[$row["userID"]]["G"]++;
	elseif (!($absent[$row["userID"]][$row["date"]]==0 && strpos($row["NOTE"],"0")!==FALSE)) $absent[$row["userID"]]["F"]++;

	$absent[$row["userID"]]["Total In"]+=($absent[$row["userID"]][$row["date"]]);
	$absent[$row["userID"]]["Total Absent"]+=(1-$absent[$row["userID"]][$row["date"]]);
	$absent[$row["userID"]]["Total recorded"]++;

	unset ($absent[$row["userID"]][$row["date"]]);

}
array_to_csv($absent,$_GET["key"]."_".date("U").".csv",false);
?>