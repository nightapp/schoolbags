<?php
//$slotsArray=new array(new array(),new array(),new array(),new array(),new array(),new array());
$slotsArray=array();
$homeworkArray=array();
$notesArray=array();

if(!isset($_GET["date"])) {
	$day="all";
} else {
	if(!is_array($dateArray)){
		$_GET["date"]=str_replace("|","/",$_GET["date"]);
		$dateArray=explode("/",$_GET["date"]);
		$_GET["date"]=implode("/",array_reverse($dateArray));
		$day=date("l",strtotime($_GET["date"]));//THATS A SMALL L
		$day_num=date("N",strtotime($_GET["date"]));
	};
}
if($day=="all"){
	$retval='<div id="timetableHeaderFull"><div class="timetableCell timetableHeader" style="width:128px">Time</div><div class="timetableCell timetableHeader">Monday</div><div class="timetableCell timetableHeader">Tuesday</div><div class="timetableCell timetableHeader">Wednesday</div><div class="timetableCell timetableHeader">Thursday</div><div class="timetableCell timetableHeader">Friday</div><div class="timetableCell timetableHeader">Saturday</div></div>';
} else {
?>
<script src="../scripts/jquery.hoverIntent.js">
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".rollCallLink").click(function(){
		t=$(this).attr('rel');
		t=t.split("&");
		
		$.get("../includes/generic/formOverlayForms/pupilsPresentSelectForm.php",{"date":t[0],"time":t[1]},function(data){
			top.showFormOverlayWithDimentions(data,600,600);
		})
	})
})
</script>
<script>
var showOverlay=true;
currentCell="";
currentCellType="";
currentCellTType="";
saved=true;	
keyupTrigger=null;
function showOverlayFunction(clicked){
	saved=true;
	h=clicked.height()+'px';
	w=clicked.width()+'px';
	t=(parseInt(clicked.offset().top))-1+'px';
	l=(parseInt(clicked.offset().left))-1+'px';
//	alert(t+":"+l);
	$("#expandOverlay").html(clicked.html()+"<input type='button' value='save' id='save' /><div id='charCount'></div>");
	
	$("#expandOverlay").find("textarea").attr("id","expandedTextarea");
	$("#expandedTextarea").val(clicked.find("textarea").val());
	$("#expandOverlay").find("input:checkbox").attr("checked",clicked.find('input:checkbox').attr("checked"))
	$("#expandOverlay").css({height:h,width:w,top:t,left:l});
	$("#expandOverlay").addClass("expandedOverlay");
	$("#expandedTextarea").removeClass("homeworkToDo");
	$("#expandedTextarea").removeClass("notesToDo");
	$("#expandedTextarea").removeClass("pnotesToDo");
//	$("#expandedTextarea").addClass("notesToDo");
	$("#expandOverlay").stop().animate({height:'235px'})
	keyupTrigger=clicked;	
	$("#expandedTextarea").keyup();
	$("#expandTextarea").focus();

}
$(document).ready(function(){
	$("#expandedTextarea").live('keyup',function() {
		if(keyupTrigger==null) saved=false;
		keyupTrigger=null;	
		allowed=255;
		tmp=$(this).val();
		tmp=tmp.length;
		allowed-=tmp;
		if(allowed<0){
			alert("You can only use 255 characters");
			$(this).val($(this).val().substr(0,255));
			allowed=0
		}
		$("#charCount").text(allowed+" characters remaining");
	});

/*	$(".homeworkToDo").blur(function(){
			$.post("../ajax/addHomework.php",{params:$(this).attr("id"),text:$(this).val()},function(data){
			})
	})*/
	$(".homeworkToDo").parent().parent().hoverIntent(function(){
//		alert(">"+$(this).html()+"<");
		if(showOverlay){
			currentCell=$(this);
			currentCellType="Homework";
			currentCellTType="Homework";
			showOverlayFunction($(this));
		}
	},function(){
//		alert($(this).val());	
	})
	$(".notesToDo.noEdit").attr("disabled","disabled");
	$(".pnotesToDo.noEdit").attr("disabled","disabled");
	$(".notesToDo").parent().parent().hoverIntent(function(){
//		alert(">"+$(this).html()+"<");
		if(showOverlay){
			currentCell=$(this);
			currentCellType="Notes";
			currentCellTType="Note";
			showOverlayFunction($(this));
		}
	},function(){
//		alert($(this).val());	
	})
	$(".pnotesToDo").parent().parent().hoverIntent(function(){
//		alert(">"+$(this).html()+"<");
		if(showOverlay){
			currentCell=$(this);
			currentCellType="PNotes";
			currentCellTType="Note";
			showOverlayFunction($(this));
		}
	},function(){
//		alert($(this).val());	
	})
	$(".doneCheckbox").live('change',function(){
		saved=false;
	})
	$("#expandOverlay").live('mouseleave',function(){
		$(this).animate({height:'0px'},function(){
			$(this).removeClass("expandedOverlay");
		});
		if(currentCellTType.replace("s","")!=""){
			if(!saved){
				if(confirm("Do you want to save this "+currentCellTType+"?")){
					$(this).find("#save").click();
				}
			}
		}
		currentCellType="";
	})
		status=0;
	$("#expandOverlay #save").live('click',function(){
		status=0;
		if($(this).parent().find(".doneCheckbox").is(":checked")){
			status=1;
		}
		$.post("../ajax/add"+currentCellType+".php",{params:$(this).parent().find("textarea").attr("rel"),text:$(this).parent().find("textarea").val(),check:$(this).parent().find(".doneCheckbox").is(":checked")?"1":"0"},function(data){
			saved=true;
			alert(data);
			currentCell.find("textarea").val($("#expandOverlay").find("textarea").val());
			currentCell.find(".doneCheckbox").attr('checked',$("#expandOverlay").find(".doneCheckbox").attr('checked'));
			currentCell=null;
		})
	})
	
/*	$(".notesToDo").blur(function(){
		$.post("../ajax/addNotes.php",{params:$(this).attr("id"),text:$(this).val()},function(data){
		})
	})*/
	
});
</script>
<?php
	$retval='
	<div id="timetableHeaderSmall"><div class="timetableCell timetableHeader">Time</div>
		<div class="timetableCell timetableHeader">Subject</div><div class="wideCell timetableCell timetableHeader">Homework</div><div class="timetableCell timetableHeader wideCell">Teacher Notes</div><div class="timetableCell timetableHeader wideCell">Parent Notes</div></div>
	';
}
echo $retval;
?>
<div id="timetableTimes">
<?php
$sql="SELECT * FROM timetableconfig WHERE schoolID='".$_SESSION["schoolID"]."' ORDER BY startTime ASC";
$result=mysql_query($sql);
$columns=7;
if($day!="all"){$columns=5;}
$rowClass="";
while($row=mysql_fetch_array($result)){
	for($i=1;$i<$columns;$i++){
		if($row["Preset"]!==NULL && $row["Preset"]!==""){
			$slotsArray[$row["timeslotID"]][$i]=$row["Preset"];
		} else {
			$slotsArray[$row["timeslotID"]][$i]="";
		}
	}
	$tmpClass="";
	if(!$row["Preset"]==NULL && !$row["Preset"]==""){
		 $tmpClass=" presetCell";
	} else {
		if($rowClass==""){
			$rowClass=" altRow";
		} else {
			$rowClass="";
		}
	}
	
?>
<div class="timetableCell timetableSlot<?php echo $tmpClass;?>" id="timeSlot<?php echo $row["timeslotID"];?>" <?php if($row["Preset"]==NULL || $row["Preset"]=="") echo 'rel="'.$row["timeslotID"].'"';?>><br />
<?php echo date("H:i",strtotime($row["startTime"]))." - ".date("H:i",strtotime($row["endTime"]));?></div>
<?php	
}
?>
</div>

<?php //////// Get and add slots
if($_SESSION["userType"]=="P"){
	$getsql="SELECT * from classlistofusers WHERE studentID='".$dispAs."' AND schoolID='".$_SESSION["schoolID"]."'";
} else {
	$getsql="SELECT * from classlist WHERE  teacherID='".$dispAs."' AND schoolID='".$_SESSION["schoolID"]."'";
}
$getresult=mysql_query($getsql);
if(mysql_num_rows($getresult)>0){
	$valuesString="";
	while($row=mysql_fetch_array($getresult)){
		if(strlen($valuesString)>0) $valuesString.=",";
		$valuesString.=$row["classID"];
	}
	if($day!='all'){
		$sqlextra=" AND timetableslots.Day='".$day_num."'";
	} else {
		$sqlextra="";
	}
	
	$sql2=sprintf("SELECT * from timetableslots,classlist WHERE classlist.classID=timetableslots.classID AND classlist.classID IN (%s) %s AND classlist.schyear=".date("Y",strtotime("-".$cutoffMonth." months",time()))." ORDER BY Day,timeslotID",$valuesString,$sqlextra);
//	echo $sql2;
	$result2=mysql_query($sql2);
	if(file_exists("includes/getTeachers.php")){
		include_once("includes/getTeachers.php");
		include_once("includes/getSubjects.php");
	} else {
		include_once("../includes/getTeachers.php");
		include_once("../includes/getSubjects.php");
	}
	if($_SESSION["userType"]!="T"){
		if($day!='all'){
			$homeworksql="SELECT * from homework WHERE studentID='".$dispAs."' AND date='".implode("-",array_reverse($dateArray))."'";
			$homeworkresult=mysql_query($homeworksql);
			if(mysql_num_rows($homeworkresult)>0){
			while($homework=mysql_fetch_array($homeworkresult)){
				$homeworkArray[$homework["timeslotID"]]=array();
				$homeworkArray[$homework["timeslotID"]][0]=$homework["text"];
				$homeworkArray[$homework["timeslotID"]][1]=$homework["status"];
			}
			}
			$notessql="SELECT * from notes WHERE studentID='".$dispAs."' AND date='".implode("-",array_reverse($dateArray))."'";
			$notesresult=mysql_query($notessql);
			if(mysql_num_rows($notesresult)){
			while($notes=mysql_fetch_array($notesresult)){
				$notesArray[$notes["timeslotID"]]=array();
				$notesArray[$notes["timeslotID"]][0]=$notes["text"];
				$notesArray[$notes["timeslotID"]][1]=$notes["status"];
			}
			}
			$pnotessql="SELECT * from pnotes WHERE studentID='".$dispAs."' AND date='".implode("-",array_reverse($dateArray))."'";
			$pnotesresult=mysql_query($pnotessql);
			if(mysql_num_rows($pnotesresult)){
			while($notes=mysql_fetch_array($pnotesresult)){
				$pnotesArray[$notes["timeslotID"]]=array();
				$pnotesArray[$notes["timeslotID"]][0]=$notes["text"];
				$pnotesArray[$notes["timeslotID"]][1]=$notes["status"];
			}
			}
		}
	}
	while($row=mysql_fetch_array($result2)){
	//	echo  $row["timeslotID"];
		if($day!='all'){
			$slotsArray[$row["timeslotID"]][1][0]=$subjects[$row["subjectID"]];
			$slotsArray[$row["timeslotID"]][1][1]=$teachers[$row["teacherID"]];
			$slotsArray[$row["timeslotID"]][1][2]=$row["Room"];
			$slotsArray[$row["timeslotID"]][1][3]=$row["extraRef"];
			
			$slotsArray[$row["timeslotID"]][1][4]=$row["year"]=="-1"?"Juniors":($row["year"]=="0"?"Seniors":"Year ".$row["year"]);		
			if($_SESSION["userType"]=="T"){
				$slotsArray[$row["timeslotID"]][2]="<a href='goToHomework.php?date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".str_replace("'","_",$teachers[$row["teacherID"]])."&extraRef=".$row["extraRef"]."&year=".$row["year"]."&timeslotID=".$row["timeslotID"]."'><img src='../background_images/viewCopy.jpg' title='View these copies' /></a>".
				"<a class='rollCallLink' rel='".implode("-",$dateArray)."&".$row["timeslotID"]."'><img src='../background_images/rollCall.gif' title='Roll Call' /></a>";			
			}else{
				if(!isset($homeworkArray[$row["timeslotID"]][0])) $homeworkArray[$row["timeslotID"]][0]=""; 
				$done="";
				if(isset($homeworkArray[$row["timeslotID"]][1]) && $homeworkArray[$row["timeslotID"]][1]==1) $done="checked='checked' ";
				$slotsArray[$row["timeslotID"]][2]="<div class='textareaholder'><textarea class='homeworkToDo' rel='date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".str_replace("'","_",$teachers[$row["teacherID"]])."&extraRef=".$row["extraRef"]."&timeslotID=".$row["timeslotID"]."'>".$homeworkArray[$row["timeslotID"]][0]."</textarea></div><div class='goToHomework' title='Go to homework'><a  style='float:left;display:inline;text-decoration:none' href='doHomework.php?date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".$teachers[$row["teacherID"]]."&extraRef=".$row["extraRef"]."'><img height='15px' width='15px' style='height:15px;width:15px;border:none;margin-left:8px' class='rightArrowTimetable' src='../background_images/Right Arrows.gif' /></a><br /><input type='checkbox' class='doneCheckbox' title='Complete' ".$done."/></div>";
			}
	
	////////////////notes Section
			if($_SESSION["userType"]=="T"){
				$slotsArray[$row["timeslotID"]][3]="<a href='goToNotes.php?date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".str_replace("'","_",$teachers[$row["teacherID"]])."&extraRef=".$row["extraRef"]."&year=".$row["year"]."&timeslotID=".$row["timeslotID"]."'><img src='../background_images/viewNotes.gif' title='View these notes' /></a>";			
			}else{
				$class2="";
				if(!isset($notesArray[$row["timeslotID"]][0])){
					$notesArray[$row["timeslotID"]][0]=""; 
				}
				if($notesArray[$row["timeslotID"]][0]!="") $class2=" noEdit";
				$done="";
				if(isset($notesArray[$row["timeslotID"]][1]) && $notesArray[$row["timeslotID"]][1]==1) $done="checked='checked' ";
				$slotsArray[$row["timeslotID"]][3]="<div class='textareaholder'><textarea class='notesToDo".$class2."' rel='date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".str_replace("'","_",$teachers[$row["teacherID"]])."&extraRef=".$row["extraRef"]."&timeslotID=".$row["timeslotID"]."'>".$notesArray[$row["timeslotID"]][0]."</textarea></div><div class='goToNotes' title='Go to notes'><input type='checkbox' class='doneCheckbox' title='Mark as read' ".$done."/></div>";
			}
	/////////////////pnotes Section
			if($_SESSION["userType"]=="T"){
				$slotsArray[$row["timeslotID"]][4]="<a href='goToNotes.php?date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".str_replace("'","_",$teachers[$row["teacherID"]])."&extraRef=".$row["extraRef"]."&year=".$row["year"]."&timeslotID=".$row["timeslotID"]."'><img src='../background_images/viewNotes.gif' title='View these notes' /></a>";			
			}else{
				$class2="";
				if(!isset($pnotesArray[$row["timeslotID"]][0])){
					$pnotesArray[$row["timeslotID"]][0]=""; 
				}
				if($pnotesArray[$row["timeslotID"]][0]!="") $class2=" noEdit";
				$done="";
				if(isset($pnotesArray[$row["timeslotID"]][1]) && $pnotesArray[$row["timeslotID"]][1]==1) $done="checked='checked' ";
				$slotsArray[$row["timeslotID"]][4]="<div class='textareaholder'><textarea class='pnotesToDo".$class2."' rel='date=".implode("|",$dateArray)."&class=".$row["classID"]."&subject=".$subjects[$row["subjectID"]]."&teacher=".str_replace("'","_",$teachers[$row["teacherID"]])."&extraRef=".$row["extraRef"]."&timeslotID=".$row["timeslotID"]."'>".$pnotesArray[$row["timeslotID"]][0]."</textarea></div><div class='goToNotes' title='Go to notes'><input type='checkbox' class='doneCheckbox' title='Mark as read' ".$done."/></div>";
			}
		} else {
			$slotsArray[$row["timeslotID"]][$row["Day"]][0]=$subjects[$row["subjectID"]];
			$slotsArray[$row["timeslotID"]][$row["Day"]][1]=$teachers[$row["teacherID"]];
			$slotsArray[$row["timeslotID"]][$row["Day"]][2]=$row["Room"];
			$slotsArray[$row["timeslotID"]][$row["Day"]][3]=$row["extraRef"];
			$slotsArray[$row["timeslotID"]][$row["Day"]][4]=$row["year"]=="-1"?"Juniors":($row["year"]=="0"?"Seniors":"Year ".$row["year"]);		
		}
	}
}
foreach($slotsArray as $k=>$v){
	foreach($v as $i=>$j){
//		echo '['.$k.']['.$i.']='.$j.'<br /><br />';
		$addClasses="";
		if($day!='all' && $i>1) $addClasses="wideCell";
		if(is_array($j)){
//			echo ("<div class='timetableCell'><div style='width:60%;height:100%;float:left;display:inline;font-size:15px;border-right:1px dotted brown'>".$j[0]."<br>".$j[3]."</div><div style='display:inline;float:left;width:39%;height:17px;font-size:11px'>".$j[1]."</div><div style='display:inline;float:left;width:39%;height:17px;font-size:11px'>".$j[2]."</div></div>");
			if($_SESSION["userType"]!="T"){
				echo ("<div class='timetableCell'><b style='font-size:12px'>".$j[0]."</b><br><em>".$j[1]."</em><br>".$j[2]."</div>");
			} else {
				echo ("<div class='timetableCell'><b style='font-size:12px'>".$j[0]."</b><br><em>".$j[4]." - ".$j[3]."</em><br>".$j[2]."</div>");
			}
		} elseif($j==""){
			echo ("<div class='".$addClasses." timetableCell'></div>");
		} elseif(strpos($j,"textarea") || strpos($j,"<")===0) {
			echo ("<div class='".$addClasses." timetableCell wideCell'>".$j."</div>");
		} else {
			echo ("<div class='".$addClasses." timetableCell presetCell'><span>".str_replace(" ","<br />",$j)."</span></div>");
		}
	}
}
?>
<div id="expandOverlay" style="position:absolute;overflow:hidden"></div>