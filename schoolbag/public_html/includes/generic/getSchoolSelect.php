<select id="selectSchool" name="selectSchool">
<?php 
$sql="SELECT * FROM schoolinfo";
$result=mysql_query($sql);
while($row = mysql_fetch_array($result)){
?>
<option value="<?php echo $row["schoolID"];?>"><?php echo $row["SchoolName"].", ".$row["Address"];?></option>
<?php
}
?>
</select>