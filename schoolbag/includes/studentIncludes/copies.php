<?php 

if(isset($_POST["SubSubFolder"])){
//include("upload.php");
}
function makeDisplay($file) {
	return implode("/",array_reverse(explode("-",basename($file,".txt"))));
}

	function ordinalize($number) {
		if (in_array(($number % 100),range(11,13))){
			return $number.'th';
		} else if($number==-1){
			return "Juniors";
		} else if($number==0){
			return "Seniors";
		} else {
			switch (($number % 10)) {
				case 1:
					return $number.'st';
				break;
					case 2:
				return $number.'nd';
					break;
				case 3:
					return $number.'rd';
				default:
					return $number.'th';
				break;
			}
		}
	}
?>
<div class="middleDiv" id="ebookList">
<?php 
include("includes/generic/listdir.php");
if(isset($_GET["class"])){
	if(strpos($_GET["class"],"./")!==false) die("Error: Access Denied");
		$addPath=$_GET["class"]."/";
		if(isset($_GET["topic"])){
			if(strpos($_GET["class"],"./")!==false) die("Error: Access Denied");
				$addPath.=$_GET["topic"]."/";
		}
}
$myBooksPathShort=$schoolPath.strtoupper($_SESSION["userType"])."/".$_SESSION["userID"]."/homework/";
$myBooksPath=$schoolPath.strtoupper($_SESSION["userType"])."/".$_SESSION["userID"]."/homework/".$addPath;
$myBooks=array();
if(is_dir($myBooksPath)){//there are copies
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#ebookUploadForm').slideUp(1);	
	$('#uploadLink').click(function(){
		$("#uploadLink").slideUp();
		$('#ebookUploadForm').slideDown();
		return false;
	});
	$(".copyLink").click(function(){
		$.post("includes/generic/formOverlayForms/viewHomework.php",{filePath:$(this).attr("rel")},function(data){
			showFormOverlayWithDimentions(data,800,800);
		})
		return false;
	});
	$(".copiesPageSmallImage").click(function(){
		document.location.href=$(this).parent().attr("rel");
	});	
})
</script>
	<div id="copyListHeading" class="subHeading">
	Copies
	</div>
<?php
		include_once("includes/getSubjects.php");
	if(!isset($_GET["class"])){
		$directories=getfilelist($myBooksPath."/","DIR");
?><ul><?php
		foreach($directories as $dir){
			if(strrpos("/",$dir)===0) substr($dir,0,strlen($dir));
			$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".basename($dir)."' LIMIT 1";
			$result=mysql_query($sql);
		
			$row=mysql_fetch_array($result);
			$subject=$subjects[$row["subjectID"]];
			
		
	?>
			<li><a style="float:left" rel="studentPage.php?subPage=journal&iframePage=doHomework&date=<?php echo date("d|m|Y");?>&class=<?php echo basename($dir);?>&subject=<?php echo $subject;?>&extraRef=<?php echo $row["extraRef"];?>"><img src="background_images/newCopy.jpg" style="border:none" height="20px" class="copiesPageSmallImage" /> </a><a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&class=<?php echo basename($dir);?>"><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"];?></a></li><?php //Class header 
			}
			?>
			</ul>
			<?php
	} else {
		if(!isset($_GET["topic"])){
			$subdirectories=getfilelist($myBooksPath."/","DIR");
			$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".basename($myBooksPath)."' LIMIT 1";
			$result=mysql_query($sql);
		
			$row=mysql_fetch_array($result);
			$subject=$subjects[$row["subjectID"]];
			?><h3><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"];?></h3><ul>
			<?php
			foreach($subdirectories as $subdir){
			?>
				<li><a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&topic=<?php echo basename($subdir);?>"><img src="background_images/viewCopy.jpg" style="border:none" width='20px' height="20px"/><?php echo basename($subdir);?></a></li>
<?php		}?>
			</ul>
<?php
			
		} else {			
			$myBooks=array();
//			echo $myBooksPath;
			$myBooks=getfilelist($myBooksPath,"txt");
//			print_r($myBooks);
$sql="SELECT * from classlist WHERE classlist.schoolID='".$_SESSION["schoolID"]."' AND classlist.classID='".$_GET["class"]."' LIMIT 1";
			$result=mysql_query($sql);
			$row=mysql_fetch_array($result);
			$subject=$subjects[$row["subjectID"]];
			?><h3><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"]." - ".$_GET["topic"];?></h3><ul>
<?php			foreach($myBooks as $v){
				?>
				<li><a class="copyLink" href="#" rel="<?php echo str_replace($myBooksPathShort,"",$v);?>" target="_blank"><img src="background_images/viewCopy.jpg" style="border:none" width='16px' height="16px"/><?php echo makeDisplay(basename($v));?></a></li>
				<?php 
			}
			?></ul><?php
		}
		?>
		<?php
	}
} else {
?>
<div id="ebookListHeading" class="subHeading">
You currently do not have any copies
</div>
<?php
}
?>
</div>