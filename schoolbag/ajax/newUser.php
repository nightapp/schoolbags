<?php
$justInclude=true;
include("../config.php");
$typesAllowed="none";
$postValuesRequired=array("selectSchool","password","email", "firstName","lastName");
include("checkAjax.php");
if(($_POST["password"]=="")||($_POST["email"]=="")) die("Cannot create a user without a password or username");
$sql1="SELECT * FROM schoolinfo where schoolID='".$_POST["selectSchool"]."' LIMIT 1";

$result1=mysql_query($sql1);
$row=mysql_fetch_array($result1);
$type="";
if($_POST["accessCode"]==$row["AccessCode"]){
	$type='P';
	$extra="";
}
if($_POST["accessCode"]==$row["TeacherAccessCode"]){
	$type='T';
	$extra="";
}
$_SESSION["schoolPath"]=$row["SchoolPath"];
if($type!='P') $extra=" AND password='".$_POST["password"]."'";
	
if($type!=""){
	$sql_existing="SELECT * FROM users where email='".str_replace("'","\'",$_POST["email"])."'".$extra." LIMIT 1";
	if(mysql_num_rows(mysql_query($sql_existing)) ==0){
		$sql="INSERT INTO `users` (`userID`, `schoolID`, `year`, `FirstName`, `LastName`, `Type`, `email`, `password`) VALUES (NULL, '".$_POST["selectSchool"]."', '".$_POST["year"]."', '".addslashes($_POST["firstName"])."', '".str_replace("'","\'",$_POST["lastName"])."', '".$type."', '".str_replace("'","\'",$_POST["email"])."', '".addslashes($_POST["password"])."')";
		$result=mysql_query($sql);
		
		if($result){
			echo "Account Created.";
			$row=mysql_fetch_array(mysql_query($sql_existing));
			$sql2="SELECT * FROM users where email='".str_replace("'","\'",$_POST["email"])."' LIMIT 1";
			mkdir("../".$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]);
			mkdir("../".$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]."/ebooks");
			if($row["Type"]=="P"){
				mkdir("../".$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]."/homework");
			} else {
				mkdir("../".$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]."/dropBox");
			}
			$_SESSION["userID"]=$row["userID"];
			$_SESSION["schoolID"]=$row["schoolID"];
			$_SESSION["firstName"]=$row["FirstName"];
			$_SESSION["userType"]=$row["Type"];
			$_SESSION["year"]=$row["year"];
			$passwords=$row["password"];
			$styleFile="../schoolBag.css";
			$fp=@fopen($styleFile,"r");
			$styleContent=@fread($fp,@filesize($styleFile));
			@fclose($fp);
			
			$templateFile="../includes/newUserTemplate.html";
			$fp=@fopen($templateFile,"r");
			$htmlContent=@fread($fp,@filesize($templateFile));
			@fclose($fp);
		
		
		
		
			//echo $sql;
			//print_r($row);
			$thtml=sprintf($htmlContent,$websiteURL."/".$_SESSION["schoolPath"],$websiteURL."/".$_SESSION["schoolPath"],$row["userID"],$row["email"],$passwords,$websiteURL,$websiteURL);
			$styleContent=str_replace("url(","url(".$websiteURL."/",$styleContent);
			$thtml=str_replace("\n","\r\n",$thtml);
			if(!is_file("../".$_SESSION["schoolPath"]."S/crest.jpg")){
				$thtml=str_replace($websiteURL."/".$_SESSION["schoolPath"]."S/crest.jpg",'" style="display:none',$thtml);
			}
			include('../includes/mshell_mail.php');
			$to = $row["email"];
			$from = $siteAdministrator;
			$cc = $siteAdministrator;
			$bcc="damien@onsight.ie";
			// Create an instance of the mshell_mail class.
			$Mail = new mshell_mail();
			foreach($mailHeaders as $k=>$v){
				$Mail->set_header($k, $v);
			}

			
			// Send an html message.
			$Mail->clear_bodytext();
			$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");
			$Mail->sendmail($to, "Welcome to ".$website_title.", ".$row["FirstName"]." ".$row["LastName"]);
			
			if($row["Type"]=="T"){
				$_SESSION["displayName"]=$row["FirstName"]." ".$row["LastName"];
			} else {
				$_SESSION["displayName"]=$row["FirstName"];
			}
			
		} else {
			echo "Unable To Create Account".mysql_error();
		};
	} else {
		
		echo "Account Not Created as email address is already used."; 
		if($type=="T"){
			echo "Teachers may use the same Email Address but must use different passwords if they are both the school administrator and a teacher";
		}
	}
} else {
	echo "Invalid Access Code";
};
session_unset();
?>