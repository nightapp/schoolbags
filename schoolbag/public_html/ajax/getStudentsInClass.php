<?php
$typesAllowed=array("T");
include("checkAjax.php");
?>

<select name="studentID" id="studentID">
<?php
$sql="SELECT * FROM classlistofusers,users WHERE classlistofusers.classID=".$_GET["class"]." AND classlistofusers.studentID=users.userID && users.Type='P'";
$result=mysql_query($sql);
if(isset($_GET["studentID"])){
	$selected=$_GET["studentID"];
	$currentStudent=$_GET["studentID"];
} else {
	$selected=-1;
	$currentStudent=-1;
	
}
while($row=mysql_fetch_array($result)){
	if($currentStudent==-1) $currentStudent=$row["userID"];
	?>
		<option <?php if($row["userID"]==$selected){;?> selected="selected"<?php }; ?> value="<?php echo $row["userID"];?>"><?php echo $row["FirstName"]." ".$row["LastName"];?></option>
	<?php
}
?>
</select>