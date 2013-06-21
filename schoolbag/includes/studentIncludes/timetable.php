<div id="timeTable" style="overflow:hidden" class="middleDiv">
<div class="subHeading">
<?php echo $_SESSION["displayName"]."'s Weekly Timetable";?>
</div>
<?php
//echo file_exists("includes/generic/getTimeTable.php");
include("includes/generic/getTimeTable.php");
?>
</div>