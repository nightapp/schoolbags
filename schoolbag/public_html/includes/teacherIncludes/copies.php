<?php 
if(isset($_GET["studentID"])){
	$studentID=$_GET["studentID"];
	if(isset($_POST["SubSubFolder"])){
//		include("upload.php");
		
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
	$myBooksPathShort=$schoolPath."P/".$studentID."/homework/";
	$myBooksPath=$schoolPath."P/".$studentID."/homework/".$addPath;
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
			$.post("includes/generic/formOverlayForms/viewHomework.php",{filePath:$(this).attr("rel"),studentID:'<?php echo $_GET["studentID"];?>'},function(data){
				showFormOverlayWithDimentions(data,800,800);
			})
			return false;
		});
	})
	</script>
		<div id="copyListHeading" class="subHeading">
		Please click on a copy to view.
		</div>
	<?php
			include_once("includes/getSubjects.php");
			if(!isset($_GET["class"])){
			$directories=getfilelist($myBooksPath."/","DIR");
?><ul><?php
			foreach($directories as $dir){
				if(strrpos("/",$dir)===0) substr($dir,0,strlen($dir));
				$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND teacherID=".$_SESSION["userID"]." AND classID='".basename($dir)."' LIMIT 1";
				$result=mysql_query($sql);
				if(mysql_num_rows($result)>0){
				$row=mysql_fetch_array($result);
				$subject=$subjects[$row["subjectID"]];
			
		?>
				<img src="background_images/copies.jpg" height="20px" class="copiesPageSmallImage" /><li> <a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&class=<?php echo basename($dir);?>"><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"];?></a></li><?php //Class header 
				}
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
					<li><img src="background_images/viewCopy.jpg" width='16px' height="16px"/><a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&topic=<?php echo basename($subdir);?>"><?php echo basename($subdir);?></a></li>
	<?php		}?>
				</ul>
	<?php
				
			} else {			
				$myBooks=array();
	//			echo $myBooksPath;
				$myBooks=getfilelist($myBooksPath,"txt");
	//			print_r($myBooks);
	$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".$_GET["class"]."' LIMIT 1";
				$result=mysql_query($sql);
			
				$row=mysql_fetch_array($result);
				$subject=$subjects[$row["subjectID"]];
				?><h3><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"]." - ".$_GET["topic"];?></h3><ul>
	<?php			foreach($myBooks as $v){
					?>
					<li><img src="background_images/viewCopy.jpg" width='16px' height="16px"/><a class="copyLink" href="#" rel="<?php echo str_replace($myBooksPathShort,"",$v);?>" target="_blank"><?php echo makeDisplay(basename($v));?></a></li>
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
<?php } ?>