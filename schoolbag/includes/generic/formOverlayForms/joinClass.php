<?php 
$justInclude=true;
include_once("../../../config.php");
include_once("../../getSubjects.php");
include_once("../../getTeachers.php");
include_once("../../getClasses.php");
//print_r($teacherTeaches);
?>
<div class="subHeading" style="width:100%">Join Class</div><br />
<form id="joinClassForm" style="text-align:center" class="formInOverlay" style="margin:5px;" action="ajax/joinClass.php" method="post">
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("#subjectSelect").live('change',function(){
		$.post("includes/generic/formOverlayForms/joinClass.php",{subject:$(this).val()},function(data){
			showFormOverlay(data);
		})
	});
});
</script>
<label>Filter by subject:</label> <select id="subjectSelect" style="width:230px"><option>Select a subject</option>
<?php
 foreach($subjects as $k=>$row){
?>
<option <?php if($_POST["subject"]==$k){?>selected="selected" <?php }?>value="<?php echo $k;?>"><?php echo $row;?></option>
<?php
}?>
</select>
<?php
if(count($classes)>0){
?>
<label>Select Class(es) to join:</label>
<select name="classID[]" multiple="multiple" id="classID" style="height:100px;width:230px">
<?php foreach($classes as $row){
?>
<option value="<?php echo $row["classID"];?>"><?php 
if(!(isset($_POST["subject"]))) {
	echo $subjects[$row["subjectID"]]." - ";
}
echo $row["extraRef"]." - ".$teachers[$row["teacherID"]];?></option>
<?php
}?>
</select><br /><br />
<input id="submit" type="button" value="Join Class &raquo;" />
<?php } else {?><p>There are currently no classes you can join</p><?php } ?>
</form>