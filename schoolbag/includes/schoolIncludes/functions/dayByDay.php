
<?php
$sql="SELECT *,SUM(present) AS 'Classes Attended',date,GROUP_CONCAT(notes SEPARATOR '') AS NOTE
			FROM users,present,classlistofusers,timetableslots
			WHERE timetableslots.timeslotID=present.timeslotID AND timetableslots.classID=classlistofusers.classID AND timetableslots.day=(DAYOFWEEK(present.date)-1) AND users.userID=classlistofusers.studentID AND users.userID=present.studentID AND users.schoolID=present.schoolID AND users.schoolID=classlistofusers.schoolID AND [DATE_FACTOR] [YEAR_FACTOR] [CLASS_FACTOR] classlistofusers.studentID=users.userID AND users.schoolID=".$_SESSION["schoolID"]." 
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
			$result=mysql_query($sql);
$absent=array();
//echo $sql;
$dates=array();
$absent=array();
while($row=mysql_fetch_assoc($result)){ 
//	var_dump($row);
	if(!isset($absent[$row["userID"]]["First Name"])){
		$absent[$row["userID"]]=array();
		$absent[$row["userID"]]["First Name"]=$row["FirstName"];
		$absent[$row["userID"]]["Last Name"]=$row["LastName"];
		$absent[$row["userID"]]["Class/Year"]=$row["year"];
		$start=strtotime($start_date);
		$end=strtotime($end_date);
		while($start<=$end){
	//		echo $d;
			$d=date("d-m-Y",$start);
			$e=date("Y-m-d",$start);
			$absent[$row["userID"]][$d]="-";
			$start=strtotime($e." +1 day");
		}
		$absent[$row["userID"]]["Total In"]=0;
		
	}
	$start=strtotime($row["date"]);
	$d=date("d-m-Y",$start);
	$absent[$row["userID"]][$d]=($row["Classes Attended"]>0?1:0);
	$absent[$row["userID"]]["Total In"]+=($row["Classes Attended"]>0?1:0);
}
//var_dump($absent);
array_to_csv($absent,$_GET["key"]."_".date("U").".csv",false);
?>