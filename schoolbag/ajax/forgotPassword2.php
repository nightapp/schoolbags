<?php 
$justInclude=true;
include("../config.php");
$typesAllowed="external";
$_POST["email"]="damien@onsight.ie";
$postVariablesRequired=array("email");
include_once("checkAjax.php");

$sql="SELECT * FROM users,schoolinfo WHERE users.email='".addslashes($_POST["email"])."' AND users.schoolID=schoolinfo.schoolID";
$result=mysql_query($sql);
$passwords="";
$row=array();
if(mysql_num_rows($result)>0){
	$styleFile="../schoolBag.css";
	$fp=@fopen($styleFile,"r");
	$styleContent=@fread($fp,@filesize($styleFile));
	@fclose($fp);
	
	$templateFile="../includes/forgotPasswordTemplate.html";
	$fp=@fopen($templateFile,"r");
	$htmlContent=@fread($fp,@filesize($templateFile));
	@fclose($fp);

	if(mysql_num_rows($result) == 1){
		$row=mysql_fetch_array($result);
		$htmlContent=str_replace("log-in",strtolower($fullTextUserType[$row["Type"]]." log-in")	,$htmlContent);
		$passwords=$row["password"];
	} else {
		$passwords="<ul>";
		while($rowtmp=mysql_fetch_array($result)){
			$passwords.="<li>".$fullTextUserType[$rowtmp["Type"]].": ".$rowtmp["password"]."</li>";
			if($rowtmp["FirstName"]!="School"){
				$row=$rowtmp;
			}
		};
		$passwords.="</ul>";
	}




	//echo $sql;
	//print_r($row);
	$thtml=sprintf($htmlContent,$websiteURL."/".$row["SchoolPath"],$websiteURL."/".$row["SchoolPath"],$row["userID"],$row["email"],$passwords,$websiteURL,$websiteURL);
	$styleContent=str_replace("url(","url(".$websiteURL."/",$styleContent);
	$thtml=str_replace("\n","\r\n",$thtml);
	
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
	$Mail->sendmail($to, "Password Reminder for ".$row["FirstName"]." ".$row["LastName"]." from ".$website_title);
	echo "A password reminder has been sent to ".$row["email"].".";
} else {
	echo "No records found for this email address";
}
?>