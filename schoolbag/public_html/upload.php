<?php
// Uploadify v1.6.2
// Copyright (C) 2009 by Ronnie Garcia
// Co-developed by Travis Nickels

//modified for specific use slightly

//params	$_POST["fileName"] the fileName to be used (default= same as origional file)
//			$_POST["SubFolder"] the subfolder within the users folder to be used (default="")
//			$_POST["SubSubFolder"] the subfolder within the subFolder to be used (default="") This Sequence can be continued
//			file is also posted as 'fileData'
//session_start();
$debug = true;
$ok=true;
if(!isset($_GET["noRedirect"])) $_GET["noRedirect"]=false;
if ($debug) $fp=fopen("information/logging.txt","a");

if (!empty($_FILES) && $_FILES["fileData"]["size"]>0) {
	//clear browser cache
	header("Pragma: no-cache");
    header("Cache: no-cache");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	$ok=true;
	$tempFile = $_FILES['fileData']['tmp_name'];
	$checkFileType=$_FILES['fileData']['name'];
	$checkFileType=explode(".",$checkFileType);
	$checkFileType=strtolower($checkFileType[1]);
	if(isset($_POST["fileName"])){
		$checkFileType2=explode(".",$_POST["fileName"]);
		$checkFileType2=strtolower($checkFileType2[1]);
		if($checkFileType!=$checkFileType2){
			$ok=false;
?><script language="javascript" type="text/javascript">alert("Unable to upload file, Incorrect file type, Please upload a <?php echo $checkFileType2; ?>")</script><?php
		}
	} else {		
		if(!in_array($checkFileType,$bookFileTypes)){
			$ok=false;
?><script language="javascript" type="text/javascript">alert("Unable to upload file, File type not allowed")</script><?php
		}
	}
//	if ($debug) echo ($tempFile."<<<br /><br /><br />");
	if ($debug) fwrite($fp,$tempFile."\n");
	
	//recursive subdir generator
	$currentVar="SubFolder";
	$targetPath="";
	if($_SESSION["userType"]!="S"){
		$targetPath=$_SESSION["schoolPath"].strtoupper($_SESSION["userType"])."/".$_SESSION["userID"]."/".$targetPath;	
	} else {
		$targetPath=$_SESSION["schoolPath"].strtoupper($_SESSION["userType"])."/".$targetPath;
	}
	if(!is_dir($targePath)) @mkdir($targetPath);
		while(isset($_POST[$currentVar])){
		if($_POST[$currentVar]!="root" && $_POST[$currentVar]!=""){
			$targetPath.=urldecode($_POST[$currentVar])."/";
			if(!is_dir($targePath)) @mkdir($targetPath);
		}
		$currentVar="Sub".$currentVar;
	}
	if ($debug) fwrite($fp,$currentVar."\n");
	$tmp=explode("../",$targetPath);
	if (count($tmp)>1) die("0");
	
	if ($debug) fwrite($fp,"POST : ".$targetPath."\n");
//	if ($debug) echo "POST ";
	if ($debug) fwrite($fp,$targetPath."\n");
//	if ($debug) echo $targetPath."<br />";
//	if ($debug) echo "LAST SLASH : ".strrpos($targetPath,"/");
//	if ($debug) echo "LENGTH : ".strlen($targetPath);
	if (strrpos($targetPath,"/")!==strlen($targetPath)) $targetPath.="/";
//	if ($debug) echo $_FILES['fileData']['name']."<br/>";
	$targetPath = str_replace('//','/',$targetPath);
	if ($debug) fwrite($fp,$targetPath."\n");
//	$targetPath = realpath($targetPath."/");
//	if ($debug) @fwrite($fp,$targetPath."\n");
	if($ok){
		if(!isset($_POST["fileName"])){
			$targetFile = $targetPath.$_FILES['fileData']['name'];
		} else {
			$targetFile = $targetPath.$_POST["fileName"];	
		}
		if ($debug) @fwrite($fp,$targetFile."\n");
			
		// Uncomment the following line if you want to make the directory if it doesn't exist
		@mkdir(str_replace('//','/',$targetPath));
	
			if(is_file($targetFile)) @unlink($targetFile);
			$ret=move_uploaded_file($tempFile,$targetFile);
	
	//		if($ret) echo "file Moved Succesfully";
		if ($debug) @fwrite($fp,$ret."\n");
	
		if ($debug) @fwrite($fp,$targetFile."\n");
//		if ($debug)	echo $targetFile."<br />";
		if ($debug) @fwrite($fp,"1"."\n");
		if(!($_GET["noRedirect"])){
?><script language="javascript" type="text/javascript">document.location.href="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>";</script><?php	
die();
		}
	}
} else {
	if ($debug) @fwrite($fp,"NO FILE"."\n");
?><script language="javascript" type="text/javascript">alert("No file to upload")</script><?php
}
return $ok;
if ($debug) @fclose($fp);
?>