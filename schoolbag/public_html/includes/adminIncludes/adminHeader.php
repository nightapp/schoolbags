<?php 

if(isset($_GET["subpage"]) && $_GET["subPage"]!="newSchool"){

if(!empty($_FILES)){
if(isset($_POST["classSelect"])){
	$_POST["SubSubFolder"]=$_POST["classSelect"];
//include("upload.php");
}
include("upload.php");
}
}?>
<div id="header">
<?php include("includes/vmenu.php");?>
<div style="clear:both;width:100%;height:28px;display:block"></div>

<div id="headerText" style="width:100%">
<img src="background_images/smallLogo.gif" height="60px" /><br>
<font size="+2">Admin Control Panel</font>
</div>
<div id="formOverlay"></div>

</div>
<div style="clear:both"></div>