<?php 
$justInclude=true;
include_once("../../../config.php");
include_once("../../teacherTeaches.php");
include_once("../../getSubjects.php");

//print_r($teacherTeaches);
$class["classID"]="";
$class["year"]=1;
$class["subjectID"]="";
$class["extraRef"]="";
$header="Create";
$submit="Create";
$slots=array();

if(isset($_POST["SubSubFolder"])){
	$header="Edit";
	$submit="Save changes to";
	$_POST["class"]=$_POST["SubSubFolder"];
	$sql1="SELECT * FROM classlist WHERE classID=".$_POST["class"];
	$class=mysql_fetch_array(mysql_query($sql1));
	$sql2="SELECT * FROM timetableslots WHERE classID=".$_POST["class"];
	$res2=mysql_query($sql2);
	while($slot=mysql_fetch_array($res2)){
		$slots[$slot["Day"]."|".$slot["timeslotID"]]=$slot;
	}
}
?>
<div class="subHeading" style="width:100%"><?php echo $header;?> Class</div><br />
<form id="createClassForm" class="formInOverlay" style="margin:5px;">
<label>Subject:</label><select name="subject" id="subject">
<?php foreach($teacherTeaches as $row){
?>
<option value="<?php echo $row["subject"];?>" <?php if($class["subjectID"]==$row["subject"]){?>selected="selected"<?php }?>><?php echo $subjects[$row["subject"]];?></option>
<?php
}?>
</select><br /><br />
<label>Class/Year:</label><select id="year" name="year" >
<option value="-1">Juniors</option>
<option value="0">Seniors</option>
<?php for($i=1;$i<=6;$i++){
?>
<option value="<?php echo $i;?>" <?php if($class["year"]==$i){?>selected="selected"<?php }?>><?php echo $i;?></option>
<?php
}?></select><br /><br />
<label>Extra Reference:</label><input type="text" id="extraRef" name="extraRef" value="<?php echo $class["extraRef"];?>" />
<p>Please note create one class per group of students, do not create a class for each time you have class with them. Instead select all the times and rooms below.</p>
<?php if(isset($_POST["class"])){?><label>Class ID:</label><input type="text" readonly="readonly" name="classID" value="<?php echo $_POST["class"];?>" /><br /><br /><?php }?>
<label style="width:600px">Select Timetable Slots</label><br />

<?php 
include("../../teacherIncludes/getTimetableTimesSelect.php");
?>
<input id="submit" type="button" value="<?php echo $submit;?> class &raquo;" />
</form><?php ?>