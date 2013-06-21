<div class="subHeading" style="width:100%">Teachers Found</div>
<div style="overflow-y:scroll;overflow-x:hidden;height:550px;width:100%"><?php
$justInclude=true;
include_once("../config.php");
$debug=false;
if($debug) $fp=fopen("logging.txt",'w');
if($debug) fwrite($fp,$_POST);


$typesAllowed=array("S");
$postVariablesRequired=array("searchQuery");
include("checkAjax.php");
$sql="SELECT * FROM users WHERE CONCAT(TRIM(users.FirstName),' ',TRIM(users.LastName)) LIKE '%".str_replace(" ","%",addslashes(trim($_POST["searchQuery"])))."%' AND users.Type='T' AND users.schoolID=".$_SESSION["schoolID"];
$result=mysql_query($sql);
if(mysql_num_rows($result)==0){
	echo "No teachers found matching your search";
} else {?>
	<table cellspacing="3" width="100%"><tr><th>ID</th><th>Name</th></tr>
<?php
	while($student=mysql_fetch_array($result)){
?>
	<tr><td><?php echo $student["userID"];?></td><td><a href="changeUserTypeSch.php?userID=<?php echo $student["userID"];?>"><?php echo $student["FirstName"]." ".$student["LastName"];?></a></td></tr>
<?php		
	}?></table><?php 
}
?></div>