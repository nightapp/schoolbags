<?php 
$justInclude=true;
include("../config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<script type="text/javascript" src="../scripts/jquery.js"></script>
<link type="text/css" href="../schoolBag.css" rel="stylesheet" />
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("body").bind('contextmenu',function(e){
		top.vMenu(e,window);
				return false;

	})
})
</script>
</head>

<body bgcolor="transparent" style="background-image:none">
<div class="subHeading">Journal</div>
<?php 
	$upOneLevel=true;
	$_GET["date"]=str_replace("|","/",$_GET["date"]);
	$dateArray=explode("/",$_GET["date"]);
	$dateString=implode("/",array_reverse($dateArray));
	$day=date("l",strtotime($dateString));//THATS A SMALL L
	$day_num=date("N",strtotime($dateString));
?>

<h4><?php echo $day." - ".date("d/m/Y",strtotime($dateString));?></h4>
<div id="timetableWrapper" style="width:800px;border-top:1px solid brown">
<?php 
include("../includes/generic/getTimeTable.php");
?>
</div>
</body>
</html>
