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
	
		$("#addToNoticeBoard").submit(function(){
			if($("#elm1").val()=="Type Notice Item") return false;
			if($("#classChecked").attr("checked")!==true){
				$("#classSelect").attr("disabled","disabled");
				$("#classSelect").remove();
			}
			if($("#fileData").val()=="") $("#fileData").parent("form").attr("enctype","");
//			return false;
		});
		$(".tinymce").keyup(function(){
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
		})
		
		
		if($("#elm1").val().length==0){
//			alert("K");
			$("#elm1").val("Type Notice Item");
		}
		
				
		$("#elm1").focus(function(){
			if($(this).val()=="Type Notice Item"){
				$(this).val("");
			}
		}).blur(function(){
			if($(this).val()==""){
				$(this).val("Type Notice Item");
			}
		});
});
</script>
<div class="middleDiv" id="formWrapper">
<?php
//print_r($_POST);
	$created="Added";
if(isset($_POST["text"])){
	$date=date("Y-m-d H:i:s");
	if(!empty($_FILES)){
			$newFile=true;
			if(isset($_POST["oldFile"]) && $_POST["oldFile"]!=""){
				@unlink($_SESSION["schoolPath"]."T/".$_SESSION["userID"]."/noticeboard/".$_POST["oldFile"]);
				$changeFile=", fileAttached=''";
			}
			$changeFile=", fileAttached='".basename($targetFile)."'";
	}

	if(isset($_POST["date"])){
	$date=$_POST["date"];
// echo $_POST["text"];
 } else {

}

	
	
	if(isset($_POST["date"]) && $_POST["date"]!=""){
	// echo $_POST["text"];
		$created="Updated";
		$c='NULL';
		if($_POST["visibleTo"]=="C") $c=$_POST["SubSubFolder"];
		$sql="UPDATE noticeboard SET classID='".$c."', text='".addslashes(urldecode(stripslashes($_POST["text"])))."'".$changeFile." WHERE schoolID='".$_SESSION["schoolID"]."' AND date='".$date."' AND uploadedBy=".$_SESSION["userID"];
	} else {
		$c='NULL';
		if($_POST["visibleTo"]=="C") $c=$_POST["SubSubFolder"];
		$sql="INSERT INTO noticeboard SET classID='".$c."', text='".addslashes(urldecode(stripslashes($_POST["text"])))."'".$changeFile.", schoolID='".$_SESSION["schoolID"]."', date='".$date."', userType='".$_POST["visibleTo"]."', uploadedBy=".$_SESSION["userID"];
//		$sql="INSERT INTO noticeboard VALUES ('".$_SESSION["schoolID"]."','".$date."','".addslashes(urldecode(stripslashes($_POST["text"])))."','".$_POST["visibleTo"]."',".$_SESSION["userID"].",".$c.")";

	}
//	echo $sql;
	$result=mysql_query($sql) or die(mysql_error());
	$styleFile="../schoolBag.css";
	$fp=@fopen($styleFile,"r");
	$styleContent=@fread($fp,@filesize($styleFile));
	@fclose($fp);
	$templateFile="includes/noticeboardTemplate.html";
	$fp=@fopen($templateFile,"r");
	$htmlContent=@fread($fp,@filesize($templateFile));
	@fclose($fp);

	$thtml=sprintf($htmlContent,$websiteURL."/".$_SESSION["schoolPath"],$websiteURL."/".$_SESSION["schoolPath"],$_SESSION["displayName"],addslashes($_POST["text"]));
	$styleContent=str_replace("url(","url(".$websiteURL."/",$styleContent);
	$thtml=str_replace("\n","\r\n",$thtml);
	if(!is_file("../".$_SESSION["schoolPath"]."S/crest.jpg")){
		$thtml=str_replace($websiteURL."/".$_SESSION["schoolPath"]."S/crest.jpg",'" style="display:none',$thtml);
	}

	include('includes/mshell_mail.php');
	// Create an instance of the mshell_mail class.
	$Mail = new mshell_mail();
	$Mail->set_header("From", "info@schoolbag.ie");
	// Send an html message.
	$Mail->clear_bodytext();
	$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");
	$sql="SELECT * FROM users WHERE schoolID='".$_SESSION["schoolID"]."' AND Type IN (".$visibleNoticeBoards[$_POST["visibleTo"]].")";
	if($_POST["visibleTo"]=="C"){
		$sql="SELECT * FROM users,classlistofusers,classlist WHERE users.Type='P' AND users.userID=classlistofusers.studentID AND classlist.classID='".$_POST["SubSubFolder"]."' AND users.schoolID='".$_SESSION["schoolID"]."'";
	}
	$emails_result=mysql_query($sql);
	while($row=mysql_fetch_assoc($emails_result)){
		if($row["Type"]!="A") $Mail->sendmail($row["email"],translate("Note added to noticeboard on schoolbag.ie"));
	}
?>
<div id="noticeBoardHeader" class="subHeading">Notice <?php echo $created;?></div>
<?php
} else {
?>
<div id="noticeBoardHeader" class="subHeading">School Notice Board</div>
<?php if($_SESSION["userType"]!="P"){?>
<div style="height:74px;overflow:hidden;margin-left:255px;text-align:center">
<div class="option" title="Go to noticeboard (full)" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=noticeboard"><img src="background_images/noticeboard.gif" /><br />Full</div>
<div class="option" title="Go to noticeboard (staff only)" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=noticeboard&noticeBoard=T"><img src="background_images/staffnoticeboard.gif" /><br />Staff only</div>
<div class="option" title="Add to noticeboard" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=addToNoticeboard&noticeBoard=<?php echo $_GET["noticeBoard"];?>"><img src="background_images/addtonoticeboard.gif" /><br />Add new</div></div>
<?php 
}
?>
<form id="addToNoticeBoard" method="post" action="<?php echo basename($_SERVER["PHP_SELF"]);?>?subPage=addToNoticeboard&noRedirect=true" enctype="multipart/form-data">
<?php
$text="";
$oneSelected='P';
if(isset($_GET["date"])){
	$sql="SELECT * from noticeboard WHERE date='".urldecode($_GET["date"])."' AND schoolID='".$_GET["schoolID"]."' AND uploadedBy=".$_SESSION["userID"];
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$text=$row["text"];
	$oneSelected=$row["userType"];?>
	<input type="hidden" value="<?php echo $_GET["date"];?>" name="date" />
	<?php
} else {
if(isset($_GET["noticeBoard"])){
	$oneSelected=$_GET["noticeBoard"];
}
}
?>
<textarea id="elm1" name="text" rows="5" cols="80" style="width:610px" class="tinymce"><?php echo $text;?></textarea><br />
<div id="charCount">255 characters remaining</div>
<?php 
foreach($visibleNoticeBoards as $key=>$currentOption){
	$tmpArray=explode(",",$currentOption);
	$display=true;
	foreach($tmpArray as $k=>$userType){
		$tmpArray[$k]=$fullTextUserType[str_replace("'","",$userType)]."s";
//		echo isset($tmpArray[$k])." && ".$_SESSION["userType"]."==S && ".$tmpArray[$k]."==S<br />";
		if($tmpArray[$k]=="Administrators") unset($tmpArray[$k]);
		if(isset($tmpArray[$k]) && ($_SESSION["userType"]=="S" || $_SESSION["userType"]=="T") && $tmpArray[$k]=="Schools") unset($tmpArray[$k]);
		if(count($tmpArray)==0) $display=false;
	}
	if($display){
	?>
<input type="radio" name="visibleTo" <?php if($oneSelected===false || $oneSelected==$key){?>checked <?php }?>value="<?php echo $key;?>" />
<?php 
	echo implode(", ",$tmpArray)."<br />";
	}
} ?>
<input type="radio" name="visibleTo" <?php if($oneSelected=="C"){?>checked <?php }?>value="C" id="classChecked" />
Class <?php include("includes/teacherIncludes/getClassSelect.php");?>
<br>
<input type="hidden" name="SubFolder" value="noticeboard" />
<label><?php echo $addreplace;?> File</label><input type="file" name="fileData" id="fileData"><br>
<input type="submit" value="Add"/>
</form>
<?php } ?>
</div>