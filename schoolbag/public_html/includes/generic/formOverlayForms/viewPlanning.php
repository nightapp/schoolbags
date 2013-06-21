<?php $justInclude=true; include_once("../../../config.php");?>
<div class="subHeading" style="width:100%">View Planning</div>
<?php
if($_POST["filePath"]){
	if(!isset($_POST["studentID"])){
		$studentID=$dispAs;
		$type=$_SESSION["userType"];
	} else {
		$studentID=$_POST["studentID"];
		$type="P";
	}
	$fileDate=explode(".",basename($_POST["filePath"]));
	$fileDate=$fileDate[0];
	$fileDate=implode("|",array_reverse(explode("-",$fileDate)));
	$class=explode("/",$_POST["filePath"]);
	$topic=$class[1];
	$class=$class[0];
	$sql="SELECT * FROM users,classlist,subjects WHERE users.userID=classlist.teacherID AND classID=$class AND subjects.ID=classlist.subjectID";
//	echo $sql;
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	echo '<a href="'.$userTypePage[$_SESSION["userType"]].'?subPage=journal&iframePage=planning&date='.$fileDate.'&class='.$class.'&subject='.$row["subject"].'&teacher='.$row["FirstName"]." ".$row["LastName"].'&extraRef='.$row["extraRef"].'&folder='.$topic.'">Edit this copy</a>';
	$file="../../../".$_SESSION["schoolPath"].$type."/".$studentID."/planning/".$_POST["filePath"];
	$file=str_replace("//","/",$file);
//	echo $file;
	$fp=fopen($file,"r");
	$contents=html_entity_decode(fread($fp,filesize($file)));
	echo $contents;
	/*require_once("../../../dompdf/dompdf_config.inc.php"); 
	$html = $contents; 
	$dompdf = new DOMPDF(); 
	$dompdf->load_html($html); 
	$dompdf->render(); 
	$pdfoutput = $dompdf->output(); 
	$filename = str_replace(".txt",".pdf",$file); 
	$pdffp = fopen($filename, "w"); 
	fwrite($pdffp, $pdfoutput); 
	fclose($pdffp); */
	
	$html = "<html><body>".$contents."</body></html>"; 
	$filename = str_replace(".txt",".doc",$file); 
	$docfp = fopen($filename, "w"); 
	fwrite($docfp, $html); 
	fclose($docfp);
	fclose($fp);
} else {
	echo "Unknown file";
}
?>