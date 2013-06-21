<?php
$justInclude=true;
include("../config.php");
$typesAllowed=array("T");
$postVariablesRequired=array("friends");
include("checkAjax.php");
$mysqlstring="INSERT INTO friends VALUES";
$addComma=false;
include("../includes/getTeachersFull.php");
//print_r($_POST["subjects"]);
include('../includes/mshell_mail.php');
// Create an instance of the mshell_mail class.
$Mail = new mshell_mail();
foreach($mailHeaders as $k=>$v){
	$Mail->set_header($k, $v);
}
$styleFile="../schoolBag.css";
$fp=@fopen($styleFile,"r");
$styleContent=@fread($fp,@filesize($styleFile));
@fclose($fp);

$templateFile="../includes/friendRequestTemplate.html";
$fp=@fopen($templateFile,"r");
$htmlContent=@fread($fp,@filesize($templateFile));
@fclose($fp);




//echo $sql;
//print_r($row);
$styleContent=str_replace("url(","url(".$websiteURL."/",$styleContent);

			
foreach($_POST["friends"] as $teacher){
	if($addComma) $mysqlstring.=",";
	$mysqlstring.=" (".$_SESSION["userID"].",".$teacher.",0)";
	$addComma=true;
	// Send an html message.
	$thtml=sprintf($htmlContent,$websiteURL."/".$_SESSION["schoolPath"],$websiteURL."/".$_SESSION["schoolPath"],$teachers[$teacher]["FirstName"]." ".$teachers[$teacher]["LastName"],$teachers[$_SESSION["userID"]]["FirstName"]." ".$teachers[$_SESSION["userID"]]["LastName"],$websiteURL."/verify.php?t1=".$_SESSION["userID"]."&t2=".$teacher."&cc=".substr(md5("schoolbag.ie".$_SESSION["userID"]." ".$teacher),0,8));
	$thtml=str_replace("\n","\r\n",$thtml);
	if(!is_file("../".$_SESSION["schoolPath"]."S/crest.jpg")){
		$thtml=str_replace($websiteURL."/".$_SESSION["schoolPath"]."S/crest.jpg",'" style="display:none',$thtml);
	}
	$Mail->clear_bodytext();
	$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");
	$Mail->sendmail($teachers[$teacher]["email"], "Friend request on ".$website_title);

}
//echo $mysqlstring;
$res=mysql_query($mysqlstring);
echo "Friend requests sent";
?>