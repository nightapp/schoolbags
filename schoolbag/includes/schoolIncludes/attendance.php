<?php 

function ordinalise($number) {
		if (in_array(($number % 100),range(11,13))){
			return $number.'th';
		} else if($number==-1){
			return "Juniors";
		} else if($number==0){
			return "Seniors";
		} else {
			switch (($number % 10)) {
				case 1:
					return $number.'st';
				break;
					case 2:
				return $number.'nd';
					break;
				case 3:
					return $number.'rd';
				default:
					return $number.'th';
				break;
			}
		}
	}


?>
<script src="js/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" href="css/redmond/jquery-ui-1.8.16.custom.css" />
<div class="middleDiv">
<script>
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "today",
			changeMonth: false,
			numberOfMonths: 1,
			format:"yy-mm-dd",
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
	</script>
<script type="text/javascript">
$(document).ready(function(){
/*	$(".rollCallLink").click(function(){
		$.get("../includes/generic/formOverlayForms/pupilsPresentSelectForm.php",{"date":t[0],"time":t[1]},function(data){
			showFormOverlayWithDimentions(data,600,600);
		})
	})
	
	$(".search").click(function(){
		$.post("ajax/findStudent.php",{"searchQuery":$("#studentname").val()},function(data){
			showFormOverlayWithDimentions(data,600,600);
		})
		return false;
	})

	$(".studentSelected").live("click",function(){
		alert($(this).attr("rel"));
		return false;
	})
*/
	$("#dateField").change(function(){
		$.post("ajax/getAttendanceTable.php",{"date":$("#dateField").val()},function(data){
			$("#form").html(data);
			loadValues();
		})
		return false;
	})
	$("#dateField").change();
	$(".reasonForAbsence").live("change",function(){
		student=$(this).parent().find(".studentID").val();
//		alert(student);
		$.post("ajax/pupilsPresentSave.php",{"date":$("#dateField").val(),"details":$(this).val(),"student":student},function(data){
			
		}) 
	})
	$("#attendanceForm").submit(function(){return false;})
	$("#generate").submit(function(){
		$(".link").attr("href","#");
		$(".link").text("");
		//v=$(this).find("option:selected").attr("value");
		//if(v==0) return false;
		$.get("includes/schoolIncludes/getAttendanceRecord.php",$(this).serialize(),function(data){
			$(".link").attr("href",data);
			$(".link").text("Download");
			$("#op").text("(Right click and click 'save target as')");
		})
		return false;
	})
	$("#year").change(function(){
		$.post("ajax/getClassOptions.php",{year:$(this).val()},function(data){
			$("#class").html(data)
		})
	})
	$("#year").change();
	$("#dateField").datepicker();
	$(".dateField").datepicker( "option", "dateFormat", "yy-mm-dd" );
	$(".dateField").datepicker( "setDate", "<?php echo date("Y-m-d");?>" );
	$("#helpIcon").click(function(){
		$("#dialog").dialog();
	})
})
loading=false;
function loadValues(){
	loading=true;
	$(".reasonForAbsence").each(function(){
		$(this).val($(this).parent().attr("rel"));
	})
	loading=false;
}
</script>
<div class="subHeading">Select date/student to add reason for absence:</div><br>
<form style="width:100%;float:left;display:inline" id="attendanceForm">
<label>Date:</label><input type="text" value="<?php echo date("Y-m-d");?>" class="dateField" id="dateField" /><br>
<div id="form"></div>
</form>
<br style="clear:both">
<div class="subHeading" style="margin-top:20px">Generate Report</div>
<form id="generate">
<label>Select record type to generate:</label>
<select id="recordType" name="recordType">
<option value="0">Select Type:</option>
<option value="fullReport">Full report</option>
<option value="dayReport">Day report</option>
<option value="dayByDay">Day By Day</option>
<option value="daysAbsent">Days absent</option>
</select><img src="background_images/help.png" width="20px" title="Help" id="helpIcon" style="cursor:pointer" />
<br style="clear:both" />
<label>Date from:</label><input type="text" value="<?php echo date("Y-m-d");?>" name="startDate" class="dateField" id="from" /><br style="clear:both"><label> to </label><input type="text" class="dateField" name="endDate" id="to" />
<br style="clear:both" />
<label>Class/Year</label><select id="year" name="year"><option value="all">All years</option><?php for($i=1;$i<=6;$i++){ ?><option value="<?php echo $i; ?>"><?php echo ordinalise($i); ?></option><?php } ?></select>
<br style="clear:both" />
<label>Class</label><select id="class" name="class"></select><br style="clear:both" />
<input type="submit" value="Generate" />
<a href="" class="link"></a>
</form>
<div id="op"></div>
</div>
<div id="dialog" style="display:none" title="Attendance Help"><?php readfile("attendance_help.html");?></div>