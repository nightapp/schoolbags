<html>
<body>
<?php
if(!isset($_GET["x"])) die();
$justInclude=true;
include("config.php");

?>
<hr>
<?php
$sql="SELECT * FROM users WHERE schoolID=33 AND CONCAT(TRIM(users.FirstName),' ',TRIM(users.LastName)) LIKE '%".addslashes(trim("Bryan Lawlor"))."%' AND users.Type='P'";
$res=mysql_query($sql) or die(mysql_error());
echo $sql."<br />";
while($row=mysql_fetch_assoc($res)){
	print_r($row)."<hr>";
}
?>
<hr>
<hr>
<?php
$sql="SELECT * FROM classlist WHERE teacherID=79 AND classID=129 AND schoolID=33";
$res=mysql_query($sql) or die(mysql_error());
echo $sql."<br />";
while($row=mysql_fetch_assoc($res)){
	print_r($row)."<hr>";
}
?>
<hr>
<hr>
<?php
$sql="SELECT * FROM classlistofusers WHERE studentID=80 AND classID=129 AND studentID=80";
$res=mysql_query($sql) or die(mysql_error());
echo $sql."<br />";
while($row=mysql_fetch_assoc($res)){
	print_r($row)."<hr>";
}
?>
<hr>
<hr>
<?php
$sql="SELECT * FROM subjects WHERE ID=50";
$res=mysql_query($sql) or die(mysql_error());
echo $sql."<br />";
while($row=mysql_fetch_assoc($res)){
	print_r($row)."<hr>";
}
?>
<hr>
<?php
$sql="SELECT * FROM users,classlistofusers,classlist,subjects WHERE users.schoolID=classlistofusers.schoolID AND classlist.teacherID=79 AND classlistofusers.schoolID=classlist.schoolID AND classlistofusers.classID=classlist.classID  AND subjects.ID=classlist.subjectID AND CONCAT(users.FirstName,' ',users.LastName) LIKE '%".addslashes(trim($_POST["searchQuery"]))."%' AND users.Type='P' AND classlist.schyear=".date("Y",strtotime("-".$cutoffMonth." months",time()))." AND users.userID=classlistofusers.studentID";
$res=mysql_query($sql) or die(mysql_error());
echo $sql;

while($row=mysql_fetch_assoc($res)){
	print_r($row);
	?><hr><?php
}	
?>

<hr>
<?php?>
</body>
</html>