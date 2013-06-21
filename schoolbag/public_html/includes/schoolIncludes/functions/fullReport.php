<?php
$sql="SELECT ".	
	" users.FirstName AS 'First Name',users.LastName  AS 'Last Name',CONCAT('Year ',classlist.year,' - ',subjects.subject,' ',classlist.extraRef) AS 'Taken At',timetableconfig.startTime AS Time,date AS Date,present AS Present,notes AS Reason   ".
	"FROM (classlistofusers,classlist,users,timetableslots,timetableconfig,present,subjects) WHERE users.schoolID=present.schoolID AND users.schoolID=classlistofusers.schoolID AND [DATE_FACTOR] [YEAR_FACTOR] present.timeslotID=timetableslots.timeslotID AND present.studentID=users.userID AND classlistofusers.schoolID=".$_SESSION["schoolID"]." AND timetableconfig.schoolID=".$_SESSION["schoolID"]." AND [TIME_FACTOR] timetableslots.timeslotID=timetableconfig.timeslotID AND classlist.classID=timetableslots.classID AND classlist.schyear=YEAR(DATE_SUB(present.date,INTERVAL 7 MONTH)) AND classlistofusers.classID=classlist.classID AND users.userID=classlistofusers.studentID AND subjects.ID=classlist.subjectID ";			
$k=$_GET["key"];
$yearFactor="";
if($year!="all") $yearFactor=" users.year=".$year." AND";
$classFactor="";
if($class!="all") $classFactor=" classlist.classID=".$class." AND";
$dateFacttor="";
if($start_date!="") $dateFactor.=" present.date>='".$start_date."' AND";
if($end_date!="") $dateFactor.=" present.date<='".$end_date."' AND";
$sql=str_replace("[DATE_FACTOR]",$dateFactor,$sql);
$sql=str_replace("[YEAR_FACTOR]",$yearFactor,$sql);
$sql=str_replace("[TIME_FACTOR]",$timeFactor,$sql);
$sql=str_replace("[CLASS_FACTOR]",$classFactor,$sql);
// output as an attachment
//echo $sql;
query_to_csv($conn, $sql, $_GET["key"]."_".date("U").".csv", false);

?>