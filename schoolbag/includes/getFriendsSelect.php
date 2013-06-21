<?php 
$tmp=$_GET["subPage"];
if(strpos($_SERVER["QUERY_STRING"],"journal")===false || $_GET["iframePage"]=="planning"){ 
	if($_GET["iframePage"]=="planning"){
		
		$_GET["subPage"]="planning";
	}
?>
<script>
$(document).ready(function(){
$("#displayAs").change(function(){
	document.location.href="<?php echo basename($_SERVER["PHP_SELF"])."?subPage=".$_GET["subPage"]."&dispAs="; ?>"+$(this).val();

})
})
</script>
<?php } 
$_GET["subPage"]=$tmp;

?>
<select id="displayAs" title="Display Journal Of">
<option value="<?php echo $_SESSION["userID"]; ?>">Choose another colleague:</option>
<?php
$sqlteachers="SELECT DISTINCT * from users,friends WHERE type='T' AND schoolID='".$_SESSION['schoolID']."' AND ((users.userID=friends.TeacherTo && friends.TeacherFrom=".$_SESSION["userID"].") OR (users.userID=friends.TeacherFrom && friends.TeacherTo=".$_SESSION["userID"].")) AND Verified=1";
$resultteachers=mysql_query($sqlteachers);
while($row=mysql_fetch_array($resultteachers)){
?>
<option <?php if($dispAs==$row["userID"]){ ?>selected='selected'<?php } ?> value="<?php echo $row["userID"];?>"><?php echo $row["FirstName"]." ".$row["LastName"];?></option>
<?php
}
?>
</select>