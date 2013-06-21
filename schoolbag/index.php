<?php 
$required=array('S','T','A','P');
include("config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="schoolBag.css" />
<title>Welcome to <?php echo $websiteTitle;?></title>
<script src="scripts/jquery.js" type="text/javascript" language="javascript"></script>
<script src="scripts/vmenu.js" type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	$("#forgotPassword").click(function(){
		if($("#email").val()!=""){
			$.post("includes/generic/formOverlayForms/forgotPassword.php",{email:$("#email").val()},function(data){
				showFormOverlay("<div class='subHeading'>Sending Password Reminder...</div>");
				$.post("ajax/forgotPassword.php",{email:$("#email").val()},function(data){
					showFormOverlay("<div class='subHeading'>Password Reminder</div>"+data);
				})
			})
		} else {
			alert("Please enter your email address");
		}
	})
	$("#passwordReminderForm #submit").live("click",function(){
		showFormOverlay("<div class='subHeading'>Sending Password Reminder...</div>");
		$.post("ajax/forgotPassword.php",{email:$("#forgot_email").val()},function(data){
			showFormOverlay("<div class='subHeading'>Password Reminder</div>"+data);
		})
	})
	hgt=$(window).height()-30;
	wth=$(window).width();
	$("#emailLink").css({marginTop:hgt+'px'});
	$("#infoLink").css({marginTop:hgt+'px'});
	$('body').width(wth);
	$('#animation').css({marginTop:'-150px',marginLeft:'-1024px'});
	$('#animation').animate({marginTop:'0px',opacity:1},2000);
})
</script>
</head>

<body style="background-image:url(background_images/schoolbag-bgx.png); background-repeat: repeat-x; background-color: #FFFFFF;">
<div id="homeheader" style="width: 100%; max-width:800px; margin-left:auto; margin-right:auto; height: 165px;">
	
  <div id="headerlogo" style="display:block; width: 300px; margin-top:30px; float:left ">
  <img src="background_images/schoolbag-logo-white-400px.png" />
   </div>
	
    <div id="headercontact" style="color:#FFFFFF; display:block; float:right; margin-top:30px; text-align:left">
    E: <a href="mailto:info@schoolbag.ie" style="color:#FFFFFF; text-decoration:none;">info@schoolbag.ie</a><br /><br />T: 086 8190 728
  </div>
    
</div>

<div id="holder" style="width: 100%; max-width:800px; margin-left:auto; margin-right:auto; margin-top:30px; clear:both; margin-bottom: 30px; height: 200px;;">

  <div id="homelogin" style="display:block; height: 200px; float:left; width:47%; -moz-box-shadow: 3px 3px 3px 3px #DDDDDD; -webkit-box-shadow: 3px 3px 3px 3px #DDDDDD; box-shadow: 3px 3px 3px 3px #DDDDDD; padding:5px;">
	<h2 style="color:#999999; text-align:left">Log In</h2>
    <form id="loginForm" method="post">
	  <div style="float:left;clear:both;margin-bottom:10px;"><label style="color:#333333; text-align:left;">Email Address: </label><input type="text" name="username" id="email" /></div>
		<div style="float:left;clear:both;margin-bottom:10px;"><label style="color:#333333; text-align:left;">Password: </label><input type="password"  name="password" /></div>
		<div style="float:left;clear:both;margin-bottom:10px;"><input type="submit" value="Log In" class="indexLinks" style="margin-left:0px;"  /></div>
	</form>
		<div style="float:right;">
		<a href="#" id="forgotPassword" style="text-decoration:none; color:#666666; font-size:11px; margin-right:10px;">Forgot Password</a>	  </div>
	<div id="formOverlay">
</div>
<?php if(isset($_SESSION["invalidLogin"])){
?>
<div id="invalidLogin" style="float:left;clear:both;margin-bottom:10px;"><b style="color:#FF0000">The details provided were not valid</b></div>
<?php 
unset($_SESSION["invalidLogin"]);
}
?>
</div>

		<div id="signup" style="text-align:left; display:block; height: 200px; float:right; width:47%; -moz-box-shadow: 3px 3px 3px 3px #DDDDDD; -webkit-box-shadow: 3px 3px 3px 3px #DDDDDD; box-shadow: 3px 3px 3px 3px #DDDDDD; padding:5px;">
		<h2 style="color:#999999; text-align:left">Sign Up</h2>
        <p style="color:#666666">If your school or organisation is already using Schoolbag you can sign up as a user here.</p>
        <a href="signUpPage.php" class="indexLinks" style="margin-left:0px;">Sign Up</a>
		</div>
    </div>
    
<div id="homepagecontent" style="display: block; clear: both; width: 100%; max-width:790px; margin-left:auto; margin-right:auto; margin-top: 30px; margin-top:30px; -moz-box-shadow: 3px 3px 3px 3px #DDDDDD; -webkit-box-shadow: 3px 3px 3px 3px #DDDDDD; box-shadow: 3px 3px 3px 3px #DDDDDD; color:#333333; text-align:left; padding:10px; ">
	<h2 style="color:#999999; text-align:left">What is Schoolbag?</h2>
    <p>SchoolBag   replaces the heavy physical schoolbag which students traditionally carry to   school on a daily basis.</p>
    <p>It is   a digital workspace and e-portfolio system where students can organise their   study notes and digital learning content. Using SchoolBag students can do their   homework online and present it electronically to their teachers for correction. </p>
    <p>The   platform has been developed by teachers and can be used at primary, secondary or   third level. </p>
  <h2 style="color:#999999; text-align:left">Features</h2>
    <ul>
      <li>Facilitates online communication between teachers and   students. </li>
      <li>Attendance records for all classes. </li>
      <li>Easy message posting into all students' online journals with email   alerts. </li>
      <li>Teacher shared workspace for planning sharing resources. </li>
      <li>School, teacher, class and parent notice boards to give the right   information to the right people </li>
      <li>Digital workspaces that restrict students using copy and   paste </li>
      <li>Storage of all ebooks for all subjects in the one easy to access   area. </li>
      <li>Students have their own online schoolbag with no student-to-student   communication facility. </li>
      <li>Students have online journals which can be accessed by parents and   teachers. </li>
      <li>Students and teachers have on-line access to their   timetables. </li>
      <li>All   teachers handouts stored and easily accessible forever. </li>
  </ul>
  <h2 style="color:#999999; text-align:left">Benefits</h2>
        <ul>
          <li>Reducing costs in your school. </li>
          <li>Improve communication and documentation processes </li>
          </ul>
</div>
<div id="homefooter" style="display: block; clear:both; background-color:#666666; width:100%; color:#FFFFFF; height:100px; padding-top:30px; margin-top:30px;">
	&copy; SchoolBag. All rights reserved.
</div>
</body>
</html>
