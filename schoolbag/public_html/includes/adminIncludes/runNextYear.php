<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#currentStatus").html("Incrementing Years for students...");
	$.post("nextYearScripts/incrementStudentYearFields.php",{pwd:'<?php echo md5("schoolBag");?>'},function(data){
		$("#currentStatus").html(data);		
	})
})
</script>
<div id="currentStatus">Starting...</div>