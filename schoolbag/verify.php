<?php 
$required=array('S','T','A','P');
$justInclude=true;
include("config.php");
if(!isset($_GET["t1"]) || !isset($_GET["t2"]) || !isset($_GET["cc"])){
	die("fail1");
	header("Location:index.php");
	die("");
}
if(!($_GET["cc"]==substr(md5("schoolbag.ie".$_GET["t1"]." ".$_GET["t2"]),0,8))){
	die("fail2");
	header("Location:index.php");
	die("");
}
$sql="UPDATE friends SET Verified=1 WHERE TeacherFrom=".$_GET["t1"]." AND TeacherTo=".$_GET["t2"]." AND Verified=0";
$result=mysql_query($sql);
if(mysql_affected_rows()==0){
	header("Location:index.php");
	die("");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="schoolBag.css" />
<title>Friend request confirmed</title>
<script src="scripts/jquery.js" type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$('#animation').css({marginLeft:'-1024px',opacity:1});
})
</script>
</head>

<body style="overflow:hidden;background-image:url(background_images/blueStrip.gif);background-position:center -1px">
<div id="animation" style="left:50%;background-image:url(background_images/loginLogo.gif);position:absolute;display:block;height:190px;width:2048px;z-index:10;opacity:1"></div>
<div id="centeredContent" style="background-color:none;background-image:none;padding-top:200px;height:504px">
<br /><br />
Friend request confirmed. Click <a href="index.php">here</a> to log-in.
</div>

</body>
</html>
