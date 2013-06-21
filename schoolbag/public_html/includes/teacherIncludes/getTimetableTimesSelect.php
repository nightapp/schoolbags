<?php
$justInclude=true;
include_once("../../../config.php");
?>
<div style="width:100%">
<script type="text/javascript" src="../../../scripts/jquery.js" language="javascript"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$(".tab").click(function(){
		$(".tab").each(function(){
			$(this).removeClass("currentTab");
			$(this).addClass("otherTab");
		})
		$(this).removeClass("otherTab");
		$(this).addClass("currentTab");
		$(".tabContent").hide();
		$("."+$(this).attr("rel")).show();
	})
	$("input.selectTime").change(function(){
		val=!($(this).next().attr("disabled"));
		$(this).next().attr("disabled",val);
	});
	$("#defaultTab").click();
})
</script>
<?php
$sql="SELECT * FROM timetableconfig WHERE schoolID='".$_SESSION["schoolID"]."' AND (Preset IS NULL || Preset='') ORDER BY startTime";
$result=mysql_query($sql);
$timesArray=array();
//echo $sql;
while($row=mysql_fetch_array($result)){
	$timesArray[count($timesArray)]=$row;
}
$days[1]="Monday";
$days[2]="Tuesday";
$days[3]="Wednesday";
$days[4]="Thursday";
$days[5]="Friday";
$days[6]="Saturday";
?>
<div id="tabsHeader">
<?php 
$class="currentTab";
for($i=1;$i<=6;$i++){
?>
<div class="tab <?php echo $class;?>" <?php if($i==1){?>id="defaultTab" <?php }?>rel="tab<?php echo $i?>"><?php echo $days[$i];?></div>
<?php
$class="otherTab";
}
?>
</div>
<?php

for($i=1;$i<7;$i++){
?>
<div class="tabContent tab<?php echo $i;?>">
<?php
	foreach($timesArray as $timeslot){
?>
<?php echo $days[$i]." at ".date("H:i",strtotime($timeslot["startTime"]));?><input type="checkbox" value="<?php echo $i."|".$timeslot["timeslotID"];?>" class="selectTime"  <?php if(isset($slots[$i."|".$timeslot["timeslotID"]])){?>checked="checked"<?php }?> name="timeslotsArray[]" /> Room : <input type="text" class="roomInput" name="<?php echo "Room".$i."|".$timeslot["timeslotID"];?>" <?php if(!isset($slots[$i."|".$timeslot["timeslotID"]])){?>disabled="disabled"<?php } else {?>value="<?php echo $slots[$i."|".$timeslot["timeslotID"]]["Room"];?>"<?php }?> /><br />


<?php
	}?>
</div>
<?php
}
?>
</div>