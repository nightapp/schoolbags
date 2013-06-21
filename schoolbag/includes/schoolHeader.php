<?php 
if(!empty($_FILES)){
if(isset($_POST["classSelect"])){
	$_POST["SubSubFolder"]=$_POST["classSelect"];
//include("upload.php");
}
include("upload.php");
}?>
<div id="header">
<div style="clear:both;width:800px;height:28px"></div>

<div id="photoHolder">
<?php if(is_file($schoolPath."S/crest.jpg")){ ?>
<img src="<?php echo $schoolPath."S/crest.jpg";?>" />
<?php } else { ?>
<img src="background_images/no_image.jpg" />
<?php
}
?>
</div>
<?php include("includes/vmenu.php");?>


<div id="headerText">
<font size="+3">School Control Panel</font><br>
<font size="2"><?php echo $schoolInfo;?></font><br />
<font size="+1">Student - <?php echo $SAC;?>, Teacher - <?php echo $TAC;?></font>
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