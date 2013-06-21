<?php
session_start();
 	$_GET["date"]=str_replace("|","/",$_GET["date"]);
	$dateArray=explode("/",$_GET["date"]);
	$dateString=implode("/",array_reverse($dateArray));
	$displayDateString=implode("/",$dateArray);
	$day=date("l",strtotime($dateString));//THATS A SMALL L
	$day_num=date("N",strtotime($dateString));
	if(!isset($_POST["studentID"])){
		$studentID=$_SESSION["userID"];
		$type=$_SESSION["userType"];
	} else {
		$studentID=$_POST["studentID"];
		$type="P";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Full featured example using jQuery plugin</title>
<link type="text/css" href="../schoolBag.css" rel="stylesheet" />
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
<script type="text/javascript" language="javascript">
saved=true;
function goTo(dir){
	<?php 
	$queryString=$_SERVER['REQUEST_URI'];
	$queryString=str_replace("schoolBag/","",$queryString);
	$queryString=str_replace("schoolBag.ie/","",$queryString);
	$queryString=explode("&",$queryString);
	foreach($queryString as $k=>$current){
		$current=explode("=",$current);
		if($current[0]=="folder"){
			unset($queryString[$k]);
			break;
		}
	}

	?>
	window.location.href="<?php echo implode("&",$queryString);?>&folder="+dir;
}
	$().ready(function() {
		if($("#SubSubFolder").val()!="new"){
			$("#newFolder").attr({disabled:'disabled'});
		} else {
			$("#newFolder").attr({disabled:false});
		}
		<?php 
		if(strpos($_SERVER['HTTP_USER_AGENT'],'iPad')===false){
		?>
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '../tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "preview,print,|,search,replace,fontselect,fontsizeselect,bold,italic,underline,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent",
			theme_advanced_buttons2 : "bullist,numlist,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,|,charmap,iespell,|,pagebreak,|,fullscreen,help",
			theme_advanced_buttons3 : "pastetext,pasteword,selectall",
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
			media_external_list_url : "lists/media_list.js",
			save_onsavecallback: function(){
				$("#homeworkForm").submit();
			},
			// Replace values for the template plugin
			setup : function(ed) { 
					ed.onChange.add(function(ed,e,o){
						saved=false;
					})
					
			}

		});
		<?php } else {?>
		$('textarea.tinymce').keypress(function(){saved=false;});
		<?php }?>
		setInterval(function(){
			if(confirm("Do you want to save this file.\nIt is recommended that you save your work regularly")){
				$("#homeworkForm").submit();
			}
		},600000);
		$("#homeworkForm").submit(function(){
			if($("#subFSelect").val()=="new" && $("#newFolder").val()==""){
				alert("You must create a topic folder or select an existing one");
				return false;
			}
			s=$("#elm1").val();
			numposts=Math.ceil(s.length/1000);
			for(i=0;i<numposts;i++){
				f="<textarea sytle='display:none' name='csv"+i+"'>"+s.substr(1000*i,1000)+"</textarea>";
				$("#posts").append(f);
			}
			$.post("../writeFile.php",$("#homeworkForm").serialize(),function(data){
			$("#posts").html("");
				if(data!="File saved"){
					alert("The file was not saved\nPlease try again");
				} else {
					saved=true;
					alert("File saved");
//					alert(data);
				}
			});
			return false;
		});
		$(".tinymce").change(function(){
			saved=false;
		});
		$("#subFSelect").change(function(){
			if(!saved){
				if(confirm("Do you want to save this file before exiting?")){
					$.post("../writeFile.php",$("#homeworkForm").serialize(),function(data){
						if(data==0){
							alert("The file Was Not saved");
						} else {
							saved=true;
							goTo($(this).val());
						}
					});
				}
			}
			if($(this).val()=="new"){
				$("#newFolder").removeAttr("disabled");
			} else {
				goTo($(this).val());
			}
		})
		<?php if(isset($_GET["folder"]) && $_GET["folder"]!="new"){} else {?>
			 $("#newFolder").removeAttr("disabled");
			 <?php }; ?>
	});
</script>
<!-- /TinyMCE -->

</head>
<body bgcolor="transparent" style="background-image:none">
<div class="subHeading">Planning</div>
<form id="homeworkForm" method="post" action="../writeFile.php">
	<div>
		<h3>Planning notes for: <?php echo $_GET["subject"]." - ". $_GET["extraRef"];?><br />
			Date: <?php echo $displayDateString;?></h3>
			<?php include_once("../includes/generic/listdir.php"); 
			if(!isset($_GET["folder"])) $_GET["folder"]="";
			
			$basedir="../".$_SESSION["schoolPath"].$_SESSION["userType"]."/";
			if(!is_dir($basedir)) mkdir($basedir);
			$basedir.=$_SESSION["userID"]."/";
			if(!is_dir($basedir)) mkdir($basedir);
			$basedir.="planning/";
			if(!is_dir($basedir)) mkdir($basedir);
			$basedir.=$_GET["class"]."/";;
			if(!is_dir($basedir)) mkdir($basedir);
			$dir=$basedir.$_GET["folder"]."/";
			$dir=str_replace("//","/",$dir);
			$dirList=getfilelist($basedir,"DIR");
//			if(count($dirList)==0) $dirList=array();
			?>
			Please select the topic before you start typing: 
			<select id="subFSelect" name="SubSubSubFolder">
			<option value="new">New Folder</option>
			<?php
			foreach($dirList as $directory){
			?>
				<option <?php if($_GET["folder"]==basename($directory)){?>selected="selected"<?php } ?> value="<?php echo basename($directory);?>"><?php echo basename($directory);?></option>
			<?php
			}
			?>
			</select><br />

		<label>Create Topic: </label><input type="text" value="" disabled="disabled" id="newFolder" name="newFolder" />

		<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
		<div>
			<textarea id="elm1" name="fileData" rows="15" cols="80" style="width:610px" class="tinymce">
<?php 
$file="../".$_SESSION["schoolPath"].$type."/".$studentID."/planning/".$_GET["class"]."/".$_GET["folder"]."/".date("Y-m-d",strtotime($dateString)).".txt";
$file=str_replace("//","/",$file);
if(file_exists($file)){
$fs=filesize($file);
	if($fs>0){
		$fp=fopen($file,"r");
		
		echo fread($fp,$fs);
		fclose($fp);
	}
}?>

			</textarea>
		</div>

		<!-- Some integration calls -->
		<!-- a href="javascript:;" onmousedown="$('#elm1').tinymce().show();">[Show]</a -->
		<!-- a href="javascript:;" onmousedown="$('#elm1').tinymce().hide();">[Hide]</a -->
		<!-- a href="javascript:;" onmousedown="$('#elm1').tinymce().execCommand('Bold');">[Bold]</a -->
		<!-- a href="javascript:;" onmousedown="alert($('#elm1').html());">[Get contents]</a -->
		<!-- a href="javascript:;" onmousedown="alert($('#elm1').tinymce().selection.getContent());">[Get selected HTML]</a -->
		<!-- a href="javascript:;" onmousedown="alert($('#elm1').tinymce().selection.getContent({format : 'text'}));">[Get selected text]</a -->
		<!-- a href="javascript:;" onmousedown="alert($('#elm1').tinymce().selection.getNode().nodeName);">[Get selected element]</a -->
		<!-- a href="javascript:;" onmousedown="$('#elm1').tinymce().execCommand('mceInsertContent',false,'<b>Hello world!!</b>');">[Insert HTML]</a -->
		<!-- a href="javascript:;" onmousedown="$('#elm1').tinymce().execCommand('mceReplaceContent',false,'<b>{$selection}</b>');">[Replace selection]</a -->

		<br />
		<input type="hidden" value="planning" name="SubFolder" />
		<input type="hidden" value="<?php echo $_GET["class"];?>" name="SubSubFolder" />
		<input type="hidden" value="<?php echo date("Y-m-d",strtotime($dateString));?>" name="fileName" />
		<input type="submit" name="save" value="Save" />
	</div>
	<div id="posts" style="display:none"></div>
</form>
<script type="text/javascript">
if (document.location.protocol == 'file:') {
	alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script>
</body>
</html>
