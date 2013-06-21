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
	
		$("#addComment").submit(function(){
			if($("#elm1").val()=="Type Notice Item") return false;
			$.post("ajax/addComment.php",$(this).serialize(),function(data){
				if(data!=1){
					$('#formWrapper').prepend("An Error occured, Please Try again.<br />"+data);
				} else {
					$('#formWrapper').html("Your comment was successfully added");
				}
			});
			return false;
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
			$("#elm1").val("Type Comment");
		}
		
				
		$("#elm1").focus(function(){
			if($(this).val()=="Type Comment"){
				$(this).val("");
			}
		}).blur(function(){
			if($(this).val()==""){
				$(this).val("Type Comment");
			}
		});
});
</script>
<div class="middleDiv" id="formWrapper">
<div id="noticeBoardHeader" class="subHeading">School Notice Board</div>
<form id="addComment">
<?php
$text="";
if(isset($_GET["date"])){
	$sql="SELECT * from noticeboard WHERE date='".urldecode($_GET["date"])."' AND schoolID='".$_GET["schoolID"]."' AND uploadedBy=".$_GET["uplBy"];
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	$text=$row["text"];
	?>
	<input type="hidden" value="<?php echo $_GET["date"];?>" name="dateOfNews" />
	<input type="hidden" value="<?php echo $_GET["uplBy"];?>" name="uplBy" />
	<?php
} else {
}
?>
<p><?php echo $text;?></p>
<textarea id="elm1" name="text" rows="5" cols="80" style="width:610px" class="tinymce"></textarea><br />
<div id="charCount">255 characters remaining</div>
<input type="submit" value="Add"/>
</form>
</div>