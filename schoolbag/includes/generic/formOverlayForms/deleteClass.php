<?php 
$justInclude=true;
include_once("../../../config.php");
include_once("../../teacherTeaches.php");
include_once("../../getSubjects.php");

//print_r($teacherTeaches);
?>
<div class="subHeading" style="width:100%">Delete Class</div><br />
<form id="deleteClassForm" class="formInOverlay" style="margin:5px;"  method="post" action="deleteClass.php">
<label>Class:</label><?php include("../../teacherIncludes/getClassSelect.php");?><br />
<input id="submit" type="button" value="Delete Class &raquo;" />
<p style="text-align:center">Note:<br />
You cannot delete a class containing students or books</p>
</form>