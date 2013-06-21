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

	if($student!="A"){
			$checkSql="SELECT * FROM notes WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
		$res=mysql_query($checkSql);
		$checkResult=mysql_num_rows($res);
		$arr=mysql_fetch_array($res);
		if($checkResult==0){
			$insertSql="INSERT INTO notes SET status=".$_POST["check"].", text='".addslashes($_POST["text"])."', schoolID=".$_SESSION["schoolID"].", studentID=".$student.", timeslotID='".$postValues["timeslotID"]."', date='".implode("-",array_reverse(explode("|",$postValues["date"])))."',classID=".$postValues["class"];
			
			$updated=false;
			mysql_query($insertSql);
			
			$sql="SELECT * FROM users WHERE userID='".$student."' AND Type='P'";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			//print_r($row);
			$Mail->sendmail($row["email"],"Note added on ".$website_title);
			echo "Email sent";
		} else {
			
			
			if($_POST["check"]!=$arr["status"] && $arr["status"]!='1'){
				$checkSql="UPDATE notes SET status=".$_POST["check"]." WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
				mysql_query($checkSql);
			}
		}
	} else {
		$checkSql="SELECT * FROM classlistofusers,users WHERE users.schoolID=".$_SESSION["schoolID"]." AND studentID=userID AND classID=".$postValues["class"];
		$result=mysql_query($checkSql);
		$res=true;
		while($row=mysql_fetch_array($result)){
			$student=$row["studentID"];
			$checkSql="UPDATE notes SET status=".$_POST["check"]." WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
			mysql_query($checkSql);
			$checkSql="SELECT * FROM notes WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
			$res=mysql_query($checkSql);
			$checkResult=mysql_num_rows($res);
			$arr=mysql_fetch_array($res);
			if($checkResult==0){
				$insertSql="INSERT INTO notes SET status=".$_POST["check"].", text='".addslashes($_POST["text"])."', schoolID=".$_SESSION["schoolID"].", studentID=".$student.", timeslotID='".$postValues["timeslotID"]."', date='".implode("-",array_reverse(explode("|",$postValues["date"])))."',classID=".$postValues["class"];
				$updated=false;
				mysql_query($insertSql);
				
				$Mail->sendmail($row["email"],"Note added on ".$website_title);
				if($res) echo "Emails sent";
				$res=false;
			} else {
				
				
				if($_POST["check"]!=$arr["status"] && $arr["status"]!='1'){
					$checkSql="UPDATE notes SET status=".$_POST["check"]." WHERE schoolID=".$_SESSION["schoolID"]." AND studentID=".$student." AND timeslotID='".$postValues["timeslotID"]."' AND date='".implode("-",array_reverse(explode("|",$postValues["date"])))."' AND classID=".$postValues["class"];
					mysql_query($checkSql);
				}
			}
		}


	}
}

?>