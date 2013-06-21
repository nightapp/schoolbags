<?php
$justInclude=true;
include("../config.php");

$typesAllowed=array("P","T");
$postVariablesRequired=array("params","check");
include("checkAjax.php");

$post=explode("&",$_POST["params"]);
$postValues=array();
foreach($post as $v){
	$tmp=explode("=",$v);
	$postValues[$tmp[0]]=$tmp[1];
	if($tmp[0]=="teacher") $postValues[$tmp[0]]=str_replace("_","'",$postValues[$tmp[0]]);
}
$_POST["check"]=$_POST["check"]?1:0;
$student=$_SESSION["userID"];
if(isset($postValues["student"])) $student=$postValues["student"];
if($_POST["text"]==""){
//		$checkSql="DELETE FROM notes WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
//		mysql_query($checkSql);
	echo "No Text";
} else {
	$styleFile="../schoolBag.css";
	$fp=@fopen($styleFile,"r");
	$styleContent=@fread($fp,@filesize($styleFile));
	@fclose($fp);
	$templateFile="../includes/noteTemplate.html";
	$fp=@fopen($templateFile,"r");
	$htmlContent=@fread($fp,@filesize($templateFile));
	@fclose($fp);

	$thtml=sprintf($htmlContent,$websiteURL."/".$_SESSION["schoolPath"],$websiteURL."/".$_SESSION["schoolPath"],$_SESSION["displayName"],addslashes($_POST["text"]));
	$styleContent=str_replace("url(","url(".$websiteURL."/",$styleContent);
	$thtml=str_replace("\n","\r\n",$thtml);
	if(!is_file("../".$_SESSION["schoolPath"]."S/crest.jpg")){
		$thtml=str_replace($websiteURL."/".$_SESSION["schoolPath"]."S/crest.jpg",'" style="display:none',$thtml);
	}
	include('../includes/mshell_mail.php');
	// Create an instance of the mshell_mail class.
	$Mail = new mshell_mail();
	$Mail->set_header("From", "schoolbag@live.ie");
	// Send an html message.
	$Mail->clear_bodytext();
	$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");

		$checkSql="SELECT * FROM pnotes WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
//		echo $checkSql;
	$res=mysql_query($checkSql);
	$checkResult=mysql_num_rows($res);
	if($checkResult==0){
		$insertSql="INSERT INTO pnotes SET status=".$_POST["check"].", text='".addslashes($_POST["text"])."', schoolID=".$_SESSION["schoolID"].", studentID=".$student.", timeslotID='".$postValues["timeslotID"]."', date='".implode("-",array_reverse(explode("|",$postValues["date"])))."',classID=".$postValues["class"];
		$updated=false;
		mysql_query($insertSql);
		
		$sql="SELECT * FROM users,classlist WHERE teacherID=userID AND classID='".$postValues["class"]."' AND Type='T'";
		$iresult=mysql_query($sql);
		$irow=mysql_fetch_array($iresult);
		//print_r($row);
		$Mail->sendmail($irow["email"],"Note added on ".$website_title);
		echo "Email sent";
		
	} else {
		
		$arr=mysql_fetch_array($res);
		
		if($_POST["check"]!=$arr["status"] && $arr["status"]!='1'){
			$checkSql="UPDATE notes SET status=".$_POST["check"]." WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
			mysql_query($checkSql);
		}
		echo 'Update failed';
	}
}
?>