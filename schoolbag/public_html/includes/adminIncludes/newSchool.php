<?php
$enabled=true;
$showHtmlContent="";
if(isset($_POST["schoolName"])){
	if(!isset($_FILES)){
		?><h2>Error no crest uploaded</h2><?php	
	} else {
		$typesAllowed=array("A");
		$postVariablesRequired=array("schoolName","schoolAddress","allTY","schoolEmail","schoolPassword");
		include("ajax/checkAjax.php");
		
		if(isset($_POST["fileName"])){
			$checkFileType=$_FILES['fileData']['name'];
			$checkFileType=explode(".",$checkFileType);
			$checkFileType=strtolower($checkFileType[1]);
			$checkFileType2=explode(".",$_POST["fileName"]);
			$checkFileType2=strtolower($checkFileType2[1]);
			if($checkFileType!=$checkFileType2){
				$ok=false;
		?><script language="javascript" type="text/javascript">alert("Unable to upload file, Incorrect file type, Please upload a <?php echo $checkFileType2; ?>")</script><?php
			} else {
		
				$schoolName=addslashes($_POST["schoolName"]);
				$schoolAddress=addslashes($_POST["schoolAddress"]);
				$allTY=$_POST["allTY"];
				$SAC=addslashes(substr(md5("S".$_POST["schoolName"].$_POST["Address"]),0,8));
				$TAC=addslashes(substr(md5("T".$_POST["schoolName"].$_POST["Address"]),0,8));
				
				$sql='INSERT INTO `schoolinfo` (`schoolID`, `SchoolName`, `Address`, `SchoolPath`, `AccessCode`, `TeacherAccessCode`,`allTY`) VALUES (NULL, "'.$schoolName.'", "'.$schoolAddress.'","", "'.$SAC.'","'.$TAC.'","'.$allTY.'")';
		//		echo $sql;
				$resultINSERT=mysql_query($sql) or die(mysql_error());
				$schoolID=mysql_insert_id();
				$schoolPath="information/".$schoolID."/";
				mkdir($schoolPath);
				mkdir($schoolPath."/S/");
				mkdir($schoolPath."/T/");
				mkdir($schoolPath."/P/");
				$_SESSION["schoolID"]=$schoolID;
				$_SESSION["userType"]="S";//set to school for upload file
				$_SESSION["schoolPath"]=$schoolPath;
		//		echo $_SESSION["schoolPath"];
$_GET["noRedirect"]=true;
				$crestUp=include("upload.php");
				if($crestUp==0) die();
				unset($_SESSION["schoolPath"]);//set back to admin 3 lines
				$_SESSION["schoolID"]=0;
				$_SESSION["userType"]="A";
				/////////////////////////////////		
				$email=$_POST["schoolEmail"];
				$password=$_POST["schoolPassword"];
				
				$sql2='UPDATE schoolinfo SET SchoolPath="'.$schoolPath.'" WHERE schoolID="'.$schoolID.'"';
				$resultUPDATE=mysql_query($sql2);
				$sql3='INSERT INTO `users` (`userID`, `schoolID`, `year`, `FirstName`, `LastName`, `Type`, `email`, `password`) VALUES (NULL, "'.$schoolID.'", "0", "School", "Administrator", "S", "'.addslashes($email).'", "'.addslashes($password).'")';
		//		echo $sql2.":".$sql3;
				$result=mysql_query($sql3);
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
				$bcc="damien@onsight.ie";
				// Create an instance of the mshell_mail class.
				$Mail = new mshell_mail();
				foreach($mailHeaders as $k=>$v){
					$Mail->set_header($k, $v);
				}
		
				
				// Send an html message.
				$Mail->clear_bodytext();
				$Mail->htmltext("<html><style>".$styleContent."</style><body>" .$thtml."</body></html>");
				$Mail->sendmail($to, "Notification for ".$row["SchoolName"]." from ".$website_title);
				?>
				<h2>Success</h2>
				<?php
				$_SESSION["schoolID"]=0;
				$_SESSION["userType"]="A";
		


			}
		
		}
		
	};
};
?>
<script type="text/javascript" language="javascript">

$(document).ready(function(){
	$("#addSchoolForm").submit(function(){
			$("#buttonID").hide();
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
				alert("All Fields must be completed");
				$("#buttonID").show();
				return false;
			}
	})
});
</script>
<?php echo $showHtmlContent;?>
<h3>Add School</h3><br />
<form method="post" action="adminPage.php?subPage=newSchool" id="addSchoolForm" enctype="multipart/form-data">
<label>School Name:</label><input id="schoolName" class="required" name="schoolName" /><br />
<label>School Address:</label><input id="schoolAddress" class="required" name="schoolAddress" /><br />
<label>School Email:</label><input id="schoolEmail" class="required" name="schoolEmail" /><br />
<label>School Password:</label><input id="schoolPassword" class="required" name="schoolPassword" /><br />
<label>Transition Year Configuration:</label><select id="allTY" name="allTY"><option value="0">No students do transition year</option><option value="1">Some students do transition year</option><option value="2">All students do transition year</option></select><br /><br />
<label>School Crest:</label><input type="file" id="schoolCrest" class="required" name="fileData" /><br />
<input type="hidden" name="fileName" value="crest.jpg" />
<input type="submit" id="buttonID" value="Add School" />

</form>