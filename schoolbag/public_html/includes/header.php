<?php 
if(!empty($_FILES)){
if(isset($_POST["classSelect"])){
	$_POST["SubSubFolder"]=$_POST["classSelect"];
//include("upload.php");
}
include("upload.php");
}?>
<div id="header" style="text-align:center">
<div style="height:28px;clear:both;width:800px"></div>
<div id="photoHolder">
<?php if(is_file($schoolPath.$_SESSION["userType"]."/".$_SESSION["userID"]."/image.jpg")){ ?>
<img src="<?php echo $schoolPath.$_SESSION["userType"]."/".$_SESSION["userID"]."/image.jpg";?>" />
<?php } else { ?>
<img src="background_images/<?php echo $_SESSION["userType"];?>_no_image.jpg" />
<?php
}
?>
</div>
<?php include("includes/vmenu.php");?>


<div id="headerText">
<font size="+3"><?php echo $_SESSION["displayName"]."'s Schoolbag";?></font><br />
<font size="2"><?php if($_SESSION["userType"]=="T"){ include("includes/teacherIncludes/teacherExtraHeader.php");?><br><?php }?>
<?php echo $schoolInfo;?></font>
</div>
<div id="formOverlay"></div>

<div id="crestHolder">
<?php if(is_file($schoolPath."S/crest.jpg")){ ?>
<img src="<?php echo $schoolPath."S/crest.jpg";?>" />
<?php } else {?>
<img src="background_images/no_crest.jpg" />
<?php }?>
</div>

</div>
<div style="clear:both"></div>