<div class="middleDiv extraLinks" style="display:none">
<div style="width:266px;display:block;float:left"><a id="listofteachers" href="<?php echo $_SERVER['PHP_SELF']."?subPage=teacherList";?>">List Of Teachers</a></div>
<div style="width:267px;display:block;float:left"><?php if(file_exists($schoolPath."S/map.jpg")){?><a id="schoolmap" href="<?php echo $_SERVER['PHP_SELF']."?subPage=schoolMap";?>">School Map</a><?php }?></div>
<div style="width:267px;display:block;float:left"><?php if(file_exists($schoolPath."S/policies.pdf")){?><a id="schoolpolicies" href="<?php echo $schoolPath."S/policies.pdf";?>">School Policies</a><?php }?></div>
</div>
<div id="footer">&copy; <?php echo date("Y");?> schoolbag.ie</div>
<div id="backToHome" style="position:absolute;left:50%;margin-left:-389px;width:144px;height:47px;display:block;top:3px"></div>
<?php $_GET["smallnoticeboard"]=true;?>
<div id="miniNoticeboard"><?php include_once("includes/generic/getNoticeBoard.php");?></div>
<?php unset($_GET["smallnoticeboard"]);?>
<script>
$(document).ready(function(){
	$("#backToHome").click(function(){
		document.location.href="index.php";
	})
});
</script>