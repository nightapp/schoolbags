<?php
$justInclude=true;
include("config.php");
if(!isset($_GET["schoolID"])) die("");
$schoolID=$_GET["schoolID"];
$styleFile="schoolBag.css";
$fp=@fopen($styleFile,"r");
$styleContent=@fread($fp,@filesize($styleFile));
@fclose($fp);

$styleContent=str_replace("url(","url(".$websiteURL."/",$styleContent);

$templateFile="includes/newSchoolEmailTemplate.html";

$fp=@fopen($templateFile,"r");
$htmlContent=@fread($fp,@filesize($templateFile));
@fclose($fp);

$sql="SELECT * FROM users,schoolinfo WHERE users.schoolID=".$schoolID." AND users.Type='S' AND users.schoolID=schoolinfo.schoolID";
$row=mysql_fetch_array(mysql_query($sql));

$thtml=sprintf($htmlContent,$websiteURL."/".$row["SchoolPath"],$websiteURL."/".$row["SchoolPath"],$row["userID"],$row["email"],$row["password"],$row["AccessCode"],$row["TeacherAccessCode"],$websiteURL,$websiteURL);
$showHtmlContent=explode("<p>",$thtml);
$showHtmlContent="<p>".$showHtmlContent[1];
$showHtmlContent=substr($showHtmlContent,0,count($showHtmlContent)-7);;

$thtml=str_replace("\n","\r\n",$thtml);

include('includes/mshell_mail.php');
$to = $row["email"];
$from = $siteAdministrator;
$cc = $siteAdministrator;
$mailHeaders["cc"]="schoolbag@live.ie";
//$mailHeaders["bcc"]="damien@onsight.ie";
// Create an instance of the mshell_mail class.
$Mail = new mshell_mail();
foreach($mailHeaders as $k=>$v){
	$Mail->set_header($k, $v);
}


// Send an html message.
$Mail->clear_bodytext();
$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");
$Mail->sendmail( $to,"Notification for ".$row["SchoolName"]." from ".$website_title);
?>