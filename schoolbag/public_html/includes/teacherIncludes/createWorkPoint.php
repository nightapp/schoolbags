<script type="text/javascript" src="tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
/*		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : 'tinymce/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,preview,print,|,search,replace,fontselect,fontsizeselect,bold,italic,underline,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent",
			theme_advanced_buttons2 : "bullist,numlist,|,forecolor,backcolor,|,tablecontrols,|,hr,removeformat,|,charmap,iespell,|,pagebreak,|,fullscreen,help",
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
			media_external_list_url : "lists/media_list.js"
			

			// Replace values for the template plugin
		});*/
	
		$("#addTopic").submit(function(){
			if($("#elm1").val()=="Type topic text") return false;
			if($("#title").val()=="") return false;
			if($("#fileData").val()=="") $("#fileData").parent("form").attr("enctype","");
			
//			return false;
		});
		$(".tinymce").keyup(function(){
			allowed=1024;
			tmp=$(this).val();
			tmp=tmp.length;
			allowed-=tmp;
			if(allowed<0){
				alert("You can only use 1024 characters");
				$(this).val($(this).val().substr(0,1024));
				allowed=0
			}
			$("#charCount").text(allowed+" characters remaining");
		})
		
		
		if($("#elm1").val().length==0){
//			alert("K");
			$("#elm1").val("Type topic text");
		}
		
				
		$("#elm1").focus(function(){
			if($(this).val()=="Type topic text"){
				$(this).val("");
			}
		}).blur(function(){
			if($(this).val()==""){
				$(this).val("Type topic text");
			}
		});
});
</script>
<div class="middleDiv" id="formWrapper">
<?php
//print_r($_POST);
$created="Created";
if(isset($_POST["text"])){
	$date=date("Y-m-d H:i:s");
	if(!empty($_FILES)){
			$newFile=true;
			if(isset($_POST["oldFile"]) && $_POST["oldFile"]!=""){
				@unlink($_SESSION["schoolPath"].$_SESSION["Type"]."/".$_SESSION["userID"]."/workPointPosts/".$_POST["oldFile"]);
				$changeFile=", fileAttached=''";
			}
			$changeFile=", fileAttached='".basename($targetFile)."'";
	}
	if(isset($_POST["topic"]) && $_POST["topic"]!=""){
	// echo $_POST["text"];
		$created="Updated";
		$sql="UPDATE work_point_topics SET text='".addslashes(urldecode(stripslashes($_POST["text"])))."'".$changeFile.",class_id='".$_POST["classID"]."',  title='".addslashes(urldecode(stripslashes($_POST["title"])))."' WHERE topicID=".$_POST["topic"]." AND topicOwner=".$_SESSION["userID"];
	} else {
		$sql="INSERT INTO work_point_topics SET text='".addslashes(urldecode(stripslashes($_POST["text"])))."', title='".addslashes(urldecode(stripslashes($_POST["title"])))."', date='".$date."', class_id='".$_POST["classID"]."', topicOwner=".$_SESSION["userID"].", schoolID=".$_SESSION["schoolID"].$changeFile;

	}
//	echo $sql;
	$result=mysql_query($sql);
?>
<div id="noticeBoardHeader" class="subHeading">Topic <?php echo $created;?></div>
<?php
} else {
?>
<div id="noticeBoardHeader" class="subHeading"><?php echo (!isset($_GET["topic"]))?"Add":"Edit";?> Topic</div>
<form id="addTopic" method="post" action="<?php echo $userTypePages[$_SESSION["Type"]];?>?subPage=createWorkPoint&noRedirect=true" enctype="multipart/form-data">
<?php
$text="";
$row=array();
$row["topicID"]=$_GET["topic"];
$row["date"]=date("Y-m-d H:i:s");
$row["title"]="";
$addreplace="Attach";
	function ordinalize($number) {
if (in_array(($number % 100),range(11,13))){
			return translate($number.'th class/year');
		} else if($number==-1){
			return translate("Juniors");
		} else if($number==0){
			return translate("Seniors");
		} else {
			switch (($number % 10)) {
				case 1:
					return translate($number.'st class/year');
				break;
					case 2:
				return translate($number.'nd class/year');
					break;
				case 3:
					return translate($number.'rd class/year');
				default:
					return translate($number.'th class/year');
				break;
			}
		}
	}

if(isset($_GET["topic"])){
	$sql="SELECT * from work_point_topics WHERE date='".urldecode($_GET["date"])."' AND topicID='".$_GET["topic"]."' AND topicOwner=".$_SESSION["userID"];
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$text=$row["text"];
	$addreplace="Replace";
	?>
	<input type="hidden" name="oldFile" value="<?php echo $row["fileAttached"];?>">
	<?php
} else {
}
?>
<label>Topic Title:</label><input type="text" value="<?php echo $row["title"];?>" name="title" />
<input type="hidden" value="<?php echo $row["date"];?>" name="date" />
<input type="hidden" value="<?php echo $row["topicID"];?>" name="topic" /><br style="clear:both">
<label>Class:</label>
<select name="classID">
<?php
	include_once("includes/getSubjects.php");
	$dispAs=$_SESSION["userID"];
	$sql="SELECT * from classlist,subjects WHERE subjects.ID=classlist.subjectID AND classlist.schoolID='".$_SESSION["schoolID"]."' AND teacherID='".$dispAs."' AND classlist.schyear=".date("Y",strtotime("-".$cutoffMonth." months",time()))." ";
	echo $sql;
	$result=mysql_query($sql) or die(mysql_error());
	while($row=mysql_fetch_assoc($result)){
		$subject=$subjects[$row["subjectID"]];
		echo "<option value='".$row["classID"]."'>".ordinalize($row["year"]).", ".$subject." ".$row["extraRef"]."</option>";
	}
?>
</select>
<input type="hidden" value="workPointPosts" name="SubFolder" />
<textarea id="elm1" name="text" rows="5" cols="80" style="width:610px" class="tinymce"><?php echo $text;?></textarea><br />
<div id="charCount">1024 characters remaining</div>
<label><?php echo $addreplace;?> File</label><input type="file" name="fileData" id="fileData">
<br>

<input type="submit" value="Add Topic"/>
</form>
<?php } ?>
</div>