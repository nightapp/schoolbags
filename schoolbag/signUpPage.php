<?php 
$required=array('S','T','A','P');
$justInclude=true;
include("config.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="javascript" type="text/javascript" src="scripts/jquery.js"></script>
<script language="javascript" type="text/javascript">
tmp="P";
$(document).ready(function(){
	$("#signUpForm label").each(function(){
		$(this).append("<font style='color:red;size:0.5'>*</font>:")
	})
	$("#signUpForm").submit(function(){
	<?php if(1){?>
			notFilled=Array();
			notFilled[0]="";
			$(".required").each(function(){
				if($(this).val()=="" || $(this).val()==null){
					notFilled[notFilled.length]=$(this).attr("id");
					$(this).css({backgroundColor:'#FFB5B5'});
				} else {
					$(this).css({backgroundColor:'inherit'});
				}
			});
			if(notFilled.length>1){
				alert("<?php echo translate("All Fields must be completed");?>");
				return false;
			}
			if($("#password").val()!=$("#confirmPassword").val()){
				$("#confirmPassword").click();
				$("#confirmPassword").val("");
				alert("<?php echo translate("Passwords do not match");?>");	
			} else {
				if($("#email").val().lastIndexOf("@")<$("#email").val().lastIndexOf(".")){
					if($("#email").val()!=$("#confirmEmail").val()){
						$("#confirmEmail").click();
						$("#confirmEmail").val("");
						alert("<?php echo translate("Email Addresses do not match");?>");	
					} else {
						$.post("ajax/newUser.php",$(this).serialize(),function(data2){
							$("#retStatus").html(data2);
							$("#retStatus").slideDown(function(){
								$(this).css({border:'none'});
								if(data2=="<?php echo translate("Account Created");?>"){	
									//$("#retStatus").append("<br /><?php echo translate("You Will now be redirected to your Page");?>");
									setTimeout(function(){
										window.location.href="index.php";							
									},1000)						
								} else {
									setTimeout(function(){
										$("#retStatus").slideUp('normal',function(){
											$(this).html("");
											$(this).slideDown(function(){
												$(this).css({border:'1px solid brown'})
											});
										});		
																
									},5000);
								}
							});
						});
					}
				} else {
					alert("<?php echo translate("Email provided is not valid");?>");
				}
			}
		return false;
	});
	<?php } ?>
	$(".userType").click(function(){
		if($(this).val()!=tmp){
			$(".togglers").toggle();
			if($(this).val()=="T"){
				$("#firstName").removeClass("required");
				$("#title").addClass("required");
				$("#firstName").removeAttr("name");
				$("#title").attr("name","firstName");
				$("#year").removeClass("required");
				tmp="T";
			} else {
				$("#firstName").addClass("required");
				$("#title").removeClass("required");
				$("#firstName").attr("name","firstName");
				$("#title").removeAttr("name");
				$("#year").addClass("required");
				tmp="P";
			}
		}
	});
});
</script>
<link rel="stylesheet" type="text/css" href="schoolBag.css" />
<title><?php echo translate("Welcome to");?> <?php echo translate($websiteTitle);?></title>
<style>
input.required{margin-top:1px;margin-bottom:1px;}
</style>
</head>

<body>
<div id="centeredContent">
<div id="header" style="height:40px"></div>
<form id="signUpForm">
<?php // echo "<label style='width:auto'>New sign ups for schoolbag.ie is currently disabled</label><br/>.";?>
<h3><?php echo translate("Your Info");?></h3>
<div><label><?php echo translate("I am a");?>:</label> <?php echo translate("Student");?><input type="radio" class="userType" checked="checked" value="P" name="userType"/> <?php echo translate("or");?> <?php echo translate("Teacher");?><input type="radio" value="T" name="userType"  class="userType" /></div>
<div class="togglers"><label><?php echo translate("First Name");?></label><input type="text" name="firstName" id="firstName" class="required" /></div>
<div class="togglers" style="display:none"><label><?php echo translate("Title");?></label><select id="title">
<option value="Mr."><?php echo translate("Mr");?>.</option>
<option value="Ms."><?php echo translate("Ms");?>.</option>
<option value="Mrs."><?php echo translate("Mrs");?>.</option>
</select></div>
<div><label><?php echo translate("Last Name");?></label><input type="text" name="lastName" id="lastName" class="required"  /></div>
<div><label><?php echo translate("Password");?></label><input type="password" id="password" name="password" class="required"  /></div>
<div><label><?php echo translate("Confirm Password");?></label><input type="password" id="confirmPassword" class="required" /></div>
<div><label><?php echo translate("Email Address");?></label><input type="text"  name="email" id="email" class="required"  /></div>
<div><label><?php echo translate("Confirm Email");?></label><input type="text" id="confirmEmail" class="required" /></div><hr />
<h3><?php echo translate("Your School's Info");?></h3>
<div><label><?php echo translate("Select School");?></label><?php  include("includes/generic/getSchoolSelect.php");?></div>
<div><label><?php echo translate("Enter Access Code");?></label><input type="text" name="accessCode" class="required"  /></div>
<div class="togglers"><label><?php echo translate("Year/Class");?></label>
<select name='year'>
<option value="-1"><?php echo translate("Juniors");?></option>
<option value="0"><?php echo translate("Seniors");?></option>

<?php
for($currentYear=1;$currentYear<=6;$currentYear++){
?>
<option value="<?php echo $currentYear;?>"><?php echo $currentYear;?></option>
<?php
}?>
</select></div>
<div style="text-align:center;width:30%;float:left;display:inline"><input class=".button" type="submit" value="Sign Up"  /></div>
</form>
<?php if(isset($_SESSION["invalidLogin"])){
?>
<div id="invalidLogin"><?php echo translate("The details provided were not valid");?></div>
<?php 
unset($_SESSION["invalidLogin"]);
}?>
</div>
<div style="position:absolute;left:50%;width:300px;margin-left:-150px;top:100px;background-color:#FFFFFF" id="retStatus"></div>
</body>
</html>