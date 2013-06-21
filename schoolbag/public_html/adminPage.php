<?php 
$required=array('S');
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="schoolBag.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/options.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".subHeading:last").css({borderBottomColor:'white'});
})
</script>
<?php if(isset($_GET["subPage"])){
?>
<style>
#options{
	position:absolute;
	left:50%;
	margin-left:-165px;
	top:178px;
	height:104px;	
	width:530px;
}

.option {
	width:78px;
	height:104px;
	margin-left:2px;
	margin-right:2px;
	font-size:8px;
}
.option img{
	margin:2px;
	height:104px;
	width:74px;
}

</style>
<?php
} else {
?>
<style>
#options{
margin-left:120px;
}
</style>
<?php
};?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SchoolBag Administration Panel</title>
</head>

<body>
<div id="centeredContent">
<?php include("includes/adminIncludes/adminHeader.php");?>
<?php 
if(isset($_GET["subPage"]) && strpos($_GET["subPage"],"../")===false && is_file("includes/adminIncludes/".$_GET["subPage"].".php")){
	include("includes/adminIncludes/".basename($_GET["subPage"]).".php");
}
?>
<div class="divider"></div>
<?php include("includes/adminIncludes/adminOptions.php");?>
</div>
<?php include("includes/footer.php");?>
</body>
</html>
