<?php
$display="";
$url="";
$doaction="Add";
$sql="1";
if(isset($_GET["action"])){
	if(!isset($_GET["doaction"])){
		if($_GET["action"]=="delete"){
			$sql="DELETE FROM links WHERE schoolID='".$_SESSION["schoolID"]."' AND display='".addslashes($_GET["display"])."'";
			$display="";
			$url="";
			$doaction="Add";
		} else {
			$display=urldecode($_GET["display"]);
			$url=urldecode($_GET["url"]);
			$doaction="Update";
		}
	} elseif($_GET["doaction"]=="Add"){
		$sql="INSERT INTO links (`schoolID`, `display`, `link`) VALUES ('".$_SESSION["schoolID"]."', '".addslashes(ucwords($_GET["display"]))."', '".$_GET["url"]."');";
	} elseif($_GET["doaction"]=="Update"){
		$sql="UPDATE links SET display='".addslashes(ucwords($_GET["display"]))."', link='".$_GET["url"]."' WHERE schoolID='".$_SESSION["schoolID"]."' AND display='".addslashes($_GET["oldDisplay"])."'";
	} else{
	die("Unknown request");
	}
	mysql_query($sql);
}
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$(".deleteLinkCheck").click(function(){
		if(confirm("Are you sure you want to delete this link?")){
			window.location.href=$(this).attr("rel");
		} else {
			return false;
		}
	})
	$("#displayInput").keyup(function(){
		if($(this).val().length>15){
			alert("There is a limit of 15 characters on the display name");
			tmp=$(this).val();
			tmp=tmp.substr(0,15);
			$(this).val(tmp);
		}
	})
	$("#linkForm").submit(function(){
		if($("#linkURL").val().indexOf("http://")!=0 && $("#linkURL").val().indexOf("https://")!=0){
			alert("The url must start wil http:// or https://");
			return false;
		}
	})
})
</script>
<?php
if(!isset($_GET["action"])) $_GET["action"]="";	
if(!isset($_GET["display"])) $_GET["display"]="";	
if(!isset($_GET["url"])) $_GET["url"]="";	
?>
<form action="schoolPage.php" id="linkForm" method="get">
<table width=800>
<tr>
<th width=150>Display as</th>
<th width=610>URL</th>
<th width=40></th>
</tr>
<tr><td><input type="hidden" name="subPage" value="editlinks" /><input type="hidden" name="action" value="<?php echo $_GET["action"];?>" /><input type="hidden" name="oldDisplay" value="<?php echo $display;?>" /><input type="text" id="displayInput" name="display" value="<?php echo $display;?>"/></td><td><input name="url" type="text" style="width:99%" id="linkURL" value="<?php echo $url;?>"/></td><td><input type="submit" value="<?php echo $doaction;?>" name="doaction" /></td></tr>
<?php
$sql="SELECT * FROM links WHERE schoolID=".$_SESSION["schoolID"];
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)){
?>
<tr><td width="151"><?php echo $row["display"];?></td>
<td  width=465 style="overflow:hidden;word-wrap: break-word;"><textarea style="width:100%" readonly="readonly" disabled="disabled"><?php echo $row["link"];?></textarea></td><td><a href="schoolPage.php?subPage=editlinks&action=edit&display=<?php echo $row["display"];?>&url=<?php echo urlencode($row["link"]);?>"><img src="background_images/edit-icon.png" style="height:20px"/></a><a class="deleteLinkCheck" rel="schoolPage.php?subPage=editlinks&action=delete&display=<?php echo $row["display"];?>&url=<?php echo urlencode($row["link"]);?>"><img src="background_images/Delete-icon.png" style="height:20px"/></a></td></tr>
<?php
}
?>
</table></form>