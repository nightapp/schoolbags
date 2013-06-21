<?php $justInclude=true; include_once("../../../config.php"); ?>
<div class="subHeading" style="width:100%">Select Friends</div><br />
<form id="teacherFriendsSelectForm" class="formInOverlay" style="margin:5px;">
<?php 
include("../../getTeachers.php");
$sql="SELECT * from friends WHERE TeacherFrom=".$_SESSION["userID"]." OR TeacherTo=".$_SESSION["userID"];

$result=mysql_query($sql);
$friends=array();
//echo $sql;
//echo mysql_num_rows($result);
while($row=mysql_fetch_array($result)){
	$v="X";
	if($row["Verified"]=='1') $v="V";
	if($_SESSION["TeacherTo"]==$_SESSION["userID"]){
		$friends[$row["TeacherFrom"]]=$v;
	} else {
		$friends[$row["TeacherTo"]]=$v;
	}
}
foreach($teachers as $k=>$teacher){
$checked="";
$color="";
$display="";
if(isset($friends[$k]) && $friends[$k]=="V") {$checked="checked='checked' "; $display="disabled='disabled' title='Friend request sent' ";}
if(isset($friends[$k]) && $friends[$k]=="X") { $color="color:red"; $display="disabled='disabled' title='Friend request sent' ";}

?><div style="display:inline;float:left;width:33%;text-align:left;<?php echo $color;?>"><input type="checkbox" <?php echo $display;?>name="friends[]" <?php echo $checked;?>value="<?php echo $k;?>"/>
<?php
echo $teacher."</div>";
}
?><br />
<br />
<div style="width:100%;clear:both">
<input id="submit" type="button" value="Add friends &raquo;" /></div>
</form>