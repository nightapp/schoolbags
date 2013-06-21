<?php
$justInclude=true;
include("../config.php");
 	$_GET["date"]=str_replace("|","/",$_GET["date"]);
	$dateArray=explode("/",$_GET["date"]);
	$dateString=implode("/",array_reverse($dateArray));
	$displayDateString=implode("/",$dateArray);
	$day=date("l",strtotime($dateString));//THATS A SMALL L
	$day_num=date("N",strtotime($dateString));
	$_GET["teacher"]=str_replace("_","'",$_GET["teacher"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Full featured example using jQuery plugin</title>
<!-- Load jQuery -->
<script type="text/javascript" src="../scripts/jquery.js"></script>
<link type="text/css" href="../schoolBag.css" rel="stylesheet" />
<!-- Load TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="../scripts/jquery.hoverIntent.js"></script>

<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "newdocument,preview,print,|,search,replace,fontselect,fontsizeselect,bold,italic,underline,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,bullist,numlist,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,|,charmap,iespell,|,pagebreak,|,fullscreen,help",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			// Example content CSS (should be your site CSS)
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			paste_block_drop : "disabled",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			setup : function(ed) { 
					ed.onPaste.add( function(ed, e, o) {
					      alert("You cannot paste into this document");
				              return tinymce.dom.Event.cancel(e);
			        })
			}

		});

	});
</script>
<!-- /TinyMCE -->
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
	t=(parseInt(clicked.offset().top)+1)+'px';
	l=(parseInt(clicked.offset().left)+1)+'px';
//	alert(t+":"+l);
	$("#expandOverlay").html(clicked.html()+"<input type='button' value='save' id='save' /><div id='charCount'></div>");
	
	$("#expandOverlay").find("textarea").attr("id","expandedTextarea");
	$("#expandedTextarea").val(clicked.find("textarea").val());
$("#expandOverlay").css({height:h,width:w,top:t,left:l});
	$("#expandOverlay").addClass("expandedOverlay");
	$("#expandOverlay").stop().animate({height:'235px'})
	keyupTrigger=clicked;	
	$("#expandedTextarea").keyup();
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
	$(".homeworkToDo").parent().hoverIntent(function(){
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
	$(".notesToDo").parent().hoverIntent(function(){
//		alert(">"+$(this).html()+"<");
		if(showOverlay){
			currentCell=$(this);
			currentCellType="Notes";
			currentCellTType="Notes";
			showOverlayFunction($(this));
		}
	},function(){
//		alert($(this).val());	
	})
	$(".pnotesToDo").parent().hoverIntent(function(){
//		alert(">"+$(this).html()+"<");
		if(showOverlay){
			currentCell=$(this);
			currentCellType="Notes";
			currentCellTType="PNotes";
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
		if(currentCellType.replace("s","")!=""){
		if(!saved){
			if(confirm("Do you want to save this "+currentCellTType+"?")){
				$(this).find("#save").click();
			}
		}
		}
		currentCellType="";
	})
	$("#expandOverlay #save").live('click',function(){
		status=0;
		if($(this).parent().find(".doneCheckbox").is(":checked")){
			status=1;
		}
		$.post("../ajax/add"+currentCellType+".php",{params:$(this).parent().find("textarea").attr("rel"),text:$(this).parent().find("textarea").val(),check:status},function(data){
			saved=true;
			alert(data);
			currentCell.find("textarea").val($("#expandOverlay").find("textarea").val());
			currentCell.find(".doneCheckbox").attr('checked',$("#expandOverlay").find(".doneCheckbox").attr('checked'));
			currentCell=null;
			history.go(0);
		})
	})
	
/*	$(".notesToDo").blur(function(){
		$.post("../ajax/addNotes.php",{params:$(this).attr("id"),text:$(this).val()},function(data){
})
	})*/
	
});
</script>
</head>
<body bgcolor="transparent" style="background-image:none">
<div class="subHeading">Notes</div>
<form id="notesForm" method="post">
  <div>
    <h3>Year <?php echo $_GET["year"].", ".$_GET["subject"]." - ". $_GET["extraRef"];?><br />
      Date: <?php echo $displayDateString;?><br />
    </h3>
    <p> </p>
    <div id="displayNotes">
      <?php 
$getStudents="SELECT * FROM classlistofusers,users WHERE users.schoolID=classlistofusers.schoolID AND classlistofusers.schoolID=".$_SESSION["schoolID"]." AND classlistofusers.studentID=users.userID AND classlistofusers.classID=".$_GET["class"];////////////////////TODO
$resultStudents=mysql_query($getStudents);
$notesArray=array();
//echo $getStudents;
$notesArray["A"]=array();
$notesArray["A"]["name"]="All students in class";
$notesArray["A"]["ID"]="A";
$notesArray["A"]["text"]="<textarea class='notesToDo' style='width:200px' rel='date=".implode("|",$dateArray)."&class=".$_GET["class"]."&timeslotID=".$_GET["timeslotID"]."&student=A'>[noteText]</textarea><input type='checkbox' class='doneCheckbox' title='Complete' [checked] />";

while($row=mysql_fetch_array($resultStudents)){
	$notesArray[$row["userID"]]=array();
	$notesArray[$row["userID"]]["name"]=$row["FirstName"]." ".$row["LastName"];
	$notesArray[$row["userID"]]["ID"]=$row["userID"];
	$notesArray[$row["userID"]]["text"]="<textarea class='notesToDo' style='width:200px' rel='date=".implode("|",$dateArray)."&class=".$row["classID"]."&timeslotID=".$_GET["timeslotID"]."&student=".$row["userID"]."'>[noteText]</textarea><input type='checkbox' class='doneCheckbox' title='Complete' [checked] />";
	$notesArray[$row["userID"]]["pnotetext"]="<textarea class='pnotesToDo' style='width:200px' rel='date=".implode("|",$dateArray)."&class=".$row["classID"]."&timeslotID=".$_GET["timeslotID"]."&student=".$row["userID"]."'>[noteText]</textarea><input type='checkbox' class='doneCheckbox' title='Complete' [checked] />";
}
$sql="SELECT * FROM notes WHERE notes.schoolID=".$_SESSION["schoolID"]." AND notes.classID=".$_GET["class"]." AND notes.date='".$dateString."'";
//echo $sql;
$result=mysql_query($sql);


while($row=mysql_fetch_array($result)){
	$notesArray[$row["studentID"]]["note"]=$row["text"];
	$notesArray[$row["studentID"]]["status"]=$row["status"];
}
$sql="SELECT * FROM pnotes WHERE pnotes.schoolID=".$_SESSION["schoolID"]." AND pnotes.classID=".$_GET["class"]." AND pnotes.date='".$dateString."'";
//echo $sql;
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
	$notesArray[$row["studentID"]]["pnote"]=$row["text"];
	$notesArray[$row["studentID"]]["pstatus"]=$row["status"];
}

//print_r($notesArray);
?>
<table width="100%" id="notesTable" border="brown"><tr><th>Name</th><th>Teacher Note</th><th>Parent Note</th></tr>
<?php
foreach($notesArray as $row){
if(!isset($row["note"])) $row["note"]="";
if(!isset($row["status"])) $row["status"]=0;
if(!isset($row["pnote"])) $row["pnote"]="";
if(!isset($row["pstatus"])) $row["pstatus"]=0;
$checked="";
$pchecked="";
if($row["status"]==1) $checked="checked='checked'";
if($row["pstatus"]==1) $pchecked="checked='checked'";
$row["text"]=str_replace("[noteText]",$row["note"],$row["text"]);
$row["text"]=str_replace("[checked]",$checked,$row["text"]);
$row["pnotetext"]=str_replace("[noteText]",$row["pnote"],$row["pnotetext"]);
$row["pnotetext"]=str_replace("[checked]",$pchecked,$row["pnotetext"]);
if($row["note"]!="") $row["text"]=str_replace("notesToDo","notesToDo noEdit",$row["text"]);
$row["pnotetext"]=str_replace("notesToDo","notesToDo noEdit",$row["pnotetext"]);
?>
     <tr>
        <td width='240px'><?php echo $row["name"];?></td>
        <td width="190px"><?php echo $row["text"];?></td>
        <td width="190px"><?php echo $row["pnotetext"];?></td>
      </tr>
      <?php
}

?></table>
    </div>
    <br />
  </div>
</form>
<div id="expandOverlay" style="position:absolute;overflow:hidden"></div>
<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>
</body>
</html>
