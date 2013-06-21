<div class="subHeading" style="width:100%">Students Found</div>
<div style="overflow-y:scroll;overflow-x:hidden;height:550px;width:100%"><?php
$justInclude=true;
include_once("../config.php");
$debug=false;
if($debug) $fp=fopen("logging.txt",'w');
if($debug) fwrite($fp,$_POST);


$typesAllowed=array("T");
$postVariablesRequired=array("searchQuery");
include("checkAjax.php");
$sql="SELECT * FROM users,classlistofusers,classlist,subjects WHERE users.schoolID=classlistofusers.schoolID AND classlistofusers.schoolID=classlist.schoolID AND classlistofusers.classID=classlist.classID AND classlist.teacherID=".$_SESSION["userID"]." AND subjects.ID=classlist.subjectID AND CONCAT(TRIM(users.FirstName),' ',TRIM(users.LastName)) LIKE '%".str_replace(" ","%",addslashes(trim($_POST["searchQuery"])))."%' AND users.Type='P' AND classlist.schyear=".date("Y",strtotime("-".$cutoffMonth." months",time()))." AND users.userID=classlistofusers.studentID ORDER BY subject";
$result=mysql_query($sql);
if(mysql_num_rows($result)==0){
	echo "No students found matching your search";
} else {?>
	<table cellspacing="3" width="100%"><tr><th>ID</th><th>Name</th><th>Year</th><th>Subject</th><th>Class Ref.</th></tr>
<?php
	while($student=mysql_fetch_array($result)){
?>
	<tr><td><?php echo $student["userID"];?></td><td><a href="changeUserType.php?userID=<?php echo $student["userID"];?>"><?php echo $student["FirstName"]." ".$student["LastName"];?></a></td><td><?php echo $student["year"];?></td><td><?php echo $student["subject"];?></td><td><?php echo $student["extraRef"];?></td></tr>
<?php		
	}?></table><?php 
}
?></div>