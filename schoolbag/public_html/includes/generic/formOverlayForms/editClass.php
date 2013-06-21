<?php 
$justInclude=true;
include_once("../../../config.php");
include_once("../../teacherTeaches.php");
include_once("../../getSubjects.php");

//print_r($teacherTeaches);
?>
<div class="subHeading" style="width:100%">Edit Class</div><br />
<form id="editClassForm" class="formInOverlay" style="margin:5px;"  method="post" action="createClass.php">
<label>Class:</label><?php include("../../teacherIncludes/getClassSelect.php");?><br />
<input id="submit" type="button" value="Edit Class &raquo;" />
</form>