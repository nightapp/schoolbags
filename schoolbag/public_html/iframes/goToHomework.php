<?php
$justInclude=true;
include("../config.php");
 	$_GET["date"]=str_replace("|","/",$_GET["date"]);
	$dateArray=explode("/",$_GET["date"]);
	$dateString=implode("/",array_reverse($dateArray));
	$displayDateString=implode("/",$dateArray);
	$day=date("l",strtotime($dateString));//THATS A SMALL L
	$day_num=date("N",strtotime($dateString));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" href="../schoolBag.css" rel="stylesheet" />

<title>Full featured example using jQuery plugin</title>

<!-- Load jQuery -->
<script type="text/javascript" src="../scripts/jquery.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("body").bind('contextmenu',function(e){
		top.vMenu(e,window);
				return false;

	})
})
</script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			content_css : "tinymcedefaults.css",
			theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
			font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
			// Theme options
			theme_advanced_buttons1 : "newdocument,save,preview,print,|,search,replace,fontselect,fontsizeselect,bold,italic,underline,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,bullist,numlist,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,|,charmap,iespell,|,pagebreak,|,fullscreen,help",
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
$(document).ready(function(){
	
})
</script>
</head>
<body bgcolor="transparent" style="background-image:none">
<div class="subHeading">Homework Copies</div>
<form id="homeworkForm" method="post">
	<div>
		<h3>Year <?php echo $_GET["year"].", ".$_GET["subject"]." - ". $_GET["extraRef"];?><br />
			Date: <?php echo $displayDateString;?><br />
			Student: <?php include_once("../ajax/getStudentsInClass.php");$studentID=$currentStudent;?><br />
			Topic: <select name="topic" id="topic"><?php 
				$dir="../".$_SESSION["schoolPath"]."P/".$studentID."/homework/".$_GET["class"]."/";
				$tmp=true;//there is no topics
				$topic="";
				if(is_dir($dir)){
					echo $dir."<br />";
					include_once("../includes/generic/listdir.php");
					$dirs=getfilelist($dir,"DIR");
					print_r($dirs);
					foreach($dirs as $currentDir){
					$file=$currentDir."/".date("Y-m-d",strtotime($dateString)).".txt";				
						if(file_exists($file)){
							$tmp=false;
							if(!isset($_GET["topic"])) $_GET["topic"]=basename($currentDir);
							if(basename($currentDir)==$_GET["topic"]) $add='" selected="selected';
							?>
							<option value="<?php echo basename($currentDir).$add;?>"><?php echo basename($currentDir);?></option><?php
						}
					}
				}
			?></select>
			<?php
				if($tmp){
					?><br />

					No homework found for any topics
					<?php
					}
				?>
				</h3>

		<p>
			
		</p>

		<div id="displayHomework">
<?php 
$studentID=$currentStudent;
if(!isset($_GET["topic"])) $_GET["topic"]="";
$file="../".$_SESSION["schoolPath"]."P/".$studentID."/homework/".$_GET["class"]."/".$_GET["topic"]."/".date("Y-m-d",strtotime($dateString)).".txt";
//echo $file;
if(file_exists($file)){
	$fp=fopen($file,"r");
	echo html_entity_decode(fread($fp,filesize($file)));
	fclose($fp);
} else {
	echo "The homework File could not be found";
}
?>
		</div>
		<br />
		<input type="hidden" value="<?php echo $_GET["class"];?>" id="classID" name="SubSubFolder" />
		<input type="hidden" value="<?php echo date("Y-m-d",strtotime($dateString));?>" id="date" name="fileName" />
	</div>
</form>
<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
$(document).ready(function(){
			$("#studentID").change(function(){
		
			<?php
			unset($_GET["SubSubFolder"]);
			unset($_GET["topic"]);
			$queryString="";
			foreach($_GET as $k=>$v){
				$queryString.=$k."=".$v."&";
			}
			?>
			document.location.href="goToHomework.php?<?php echo $queryString;?>"+$("#homeworkForm").serialize();
		});
		$("#topic").change(function(){
			$("#displayHomework").html("Finding Homework...");
			$.post("../ajax/getHomeworkFile.php",{classID:$("#classID").val(),topic:$(this).val(),studentID:$("#studentID").val(),date:$("#date").val()},function(data){
				$("#displayHomework").html("<div class='displayHomework'>".data."</div>");
			});
		});
})
</script>
</body>
</html>
