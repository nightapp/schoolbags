<option value="all">All classes</option>
<?php
$justInclude=true;
include_once("../config.php");
$typesAllowed=array("S");
include("checkAjax.php");
function ordinalise($i){
	switch($i){
		case 1: return "st";
		case 2: return "nd";
		case 3: return "rd";
		default: return "th";
	}
}

?>
<?php
$yr="";
if($_POST["year"]!="all") $yr=" AND users.year=".$_POST["year"];
$sql="SELECT * FROM classlist,subjects,users WHERE users.year=classlist.year AND classlist.teacherID=users.userID AND classlist.schoolID=".$_SESSION["schoolID"]." AND classlist.subjectID=subjects.ID".$yr." ORDER BY subject ASC";
$result=mysql_query($sql) or die("An error occured");
if(mysql_num_rows($result)==0){
?>
<?php
} else {
?>
<?php
while($row=mysql_fetch_array($result)){
	?>
	<option value="<?php echo $row["classID"];?>"><?php echo $row["subject"]." - ".$row["extraRef"].", ".$row["FirstName"]." ".$row["LastName"];?></option>
	<?php
}
}
?>
