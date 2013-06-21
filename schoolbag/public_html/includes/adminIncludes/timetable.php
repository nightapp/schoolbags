<style>
#currentSlots img{
	cursor:pointer;
}
</style>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#addSlotForm").submit(function(){
		if($("#endH").val()<$("#startH").val()){
			alert("End Time must be after start time");
			return false;
		} else {
			if(($("#endH").val()==$("#startH").val()) && $("#endM").val()<=$("#startM").val()){
				alert("End Time must be after start time");
				return false;
			}
		}
		$.post("ajax/updateTimeSlots.php",$(this).serialize(),function(data){
			$("#currentSlots").html(data);
		});
		return false;
	});
	$("#currentSlots img").live("click",function(){
		$.post("ajax/deleteTimeSlots.php",{ID:$(this).attr("id")},function(data){
			$("#currentSlots").html(data);
		});		
	});
});
</script>
<div class="middleDiv">
<form style="width:50%;float:left;display:inline" id="addSlotForm">
Add New Slot:<br>
<label>Start Time:</label><select name="startH" id="startH"><?php for($i=0;$i<24;$i++){?><option value="<?php echo $i;?>"><?php echo $i;?></option>"<?php }?></select> : <select name="startM" id="startM"><?php for($i=0;$i<60;$i++){?><option value="<?php echo $i;?>"><?php echo $i;?></option>"<?php }?></select><br>
<label>End Time:</label><select name="endH"  id="endH"><?php for($i=0;$i<24;$i++){?><option value="<?php echo $i;?>"><?php echo $i;?></option>"<?php }?></select> : <select id="endM" name="endM"><?php for($i=0;$i<60;$i++){?><option value="<?php echo $i;?>"><?php echo $i;?></option>"<?php }?></select><br>
<label>Preset</label><input type="text" name="Preset" /><br>
<input type="submit" value="Add &raquo;" />
</form>
<div style="width:49%;border-left:1px solid brown;float:left;display:inline" id="currentSlots">
<b>Current Slots</b><br>	
<?php
$sql="SELECT * FROM timetableconfig WHERE schoolID='".$_SESSION["schoolID"]."' ORDER BY timeslotID";
$result=mysql_query($sql);
//echo $sql;
while($time=mysql_fetch_array($result)){
echo date("H:i",strtotime($time["startTime"]))." - ".date("H:i",strtotime($time["endTime"]))." - ".$time["Preset"]."<img src='background_images/Delete-icon.png' style='height:10px;width:10px;' id='timeslot".$time["timeslotID"]."' /><br>";
}
?>
</div>

</div>