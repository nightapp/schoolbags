<?php $justInclude=true; include_once("../../../config.php"); ?>
<div class="subHeading" style="width:100%">Select Subjects</div><br />
<form id="teacherSubjectSelectForm" class="formInOverlay" style="margin:5px;">
<?php 
include("../../getSubjects.php");
$sql="SELECT * from teachersteach WHERE userID=".$_SESSION["userID"];

$result=mysql_query($sql);
$doTeach=array();
//echo $sql;
//echo mysql_num_rows($result);
while($row=mysql_fetch_array($result)){
	$doTeach[$row["subject"]]="L";
}

foreach($subjects as $k=>$subject){
$checked="";
if(isset($doTeach[$k])) $checked="checked='checked' ";
?><div style="display:inline;float:left;width:33%;text-align:left"><input type="checkbox" name="subjects[]" <?php echo $checked;?>value="<?php echo $k;?>"/>
<?php
echo $subject."</div>";
}
?><br />
<br />
<div style="width:100%;clear:both">
<input id="submit" type="button" value="Change Subjects &raquo;" /></div>
</form>