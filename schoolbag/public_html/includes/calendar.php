<div id="calendarContainer"><table id="calendarDiv"> 
<tr><td>&nbsp;</td></tr> 
<tr><td>&nbsp;</td></tr> 
<tr><td>&nbsp;</td></tr> 
<tr><td>&nbsp;</td></tr> 
<tr><td>&nbsp;</td></tr> 
<tr><td>&nbsp;</td></tr> 
<tr><td>&nbsp;</td></tr> 
</table> 
<script type="text/javascript"> 
calM=<?php echo date("m")?>;
calY=<?php echo date("Y")?>;
 
function loadCal() {
	$.get("ajax/calendar.php",{m:calM,y:calY},function(data) {
		$("#calendarDiv").html(data);
		$("#previewLinks").css({display:"none"});
		$("#mTitle").click(function() {
			$("#previewLinks").css({display:"none"});	
			return false;		
		});
		$(".mNav").click(function() {
			if ($(this).attr('rel')=="prev") {
				calM--;
				if (calM==0) {
					calM=12;
					calY--;
				}
			} else {
				calM++;
				if (calM==13) {
					calM=1;
					calY++;
				}
 
			}
			loadCal();
			return false;
		})
		$(".clickableCell").click(function() {
			<?php if($_SESSION["Type"]!="P"){?>
				$("#dateIframe").attr("src","iframes/getJournal.php?date="+$(this).attr("id")+"&dispAs="+$("#displayAs").val());
			<?php } else { ?>
				$("#dateIframe").attr("src","iframes/getJournal.php?date="+$(this).attr("id"));
			<?php } ?>
			return false;
		});
		<?php if($_SESSION["Type"]!="P" && $_GET["iframePage"]!="planning"){?>
		$("#displayAs").change(function(){
			a=$("#dateIframe").attr("src").split("&");
			if(a.length>1) a.pop();
			a=a[0];
			$("#dateIframe").attr("src",a+"&dispAs="+$("#displayAs").val());
		})
		<?php } ?>
	
		$("#calendarDiv td a").click(function() {
			if ($(this).is(".mNav")) return false;
			$(this).parent().click();
			return false;
		});
	});
	return false;
}
 
$(document).ready(function() {
	loadCal();
});
</script></div>