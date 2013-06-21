<?php 
if(isset($_POST["SubSubFolder"])){
//include("upload.php");
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
include("includes/generic/incl_listdir.php");
include("includes/getFriendsSelect.php");

if(isset($_GET["class"])){
	if(strpos($_GET["class"],"./")!==false) die("Error: Access Denied");
		$addPath=$_GET["class"]."/";
}
$myBooksPath=$schoolPath.strtoupper($_SESSION["userType"])."/".$dispAs."/ebooks/".$addPath;
$myBooksPath=str_replace("//","/",$myBooksPath);
if(strrpos("/",$myBooksPath)===0) substr($myBooksPath,0,strlen($myBooksPath));
$myBooks=array();
if(is_dir($myBooksPath)){//there are eBooks
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#ebookUploadForm').slideUp(1);	
	$('#uploadLink').click(function(){
		$("#uploadLink").slideUp();
		$('#ebookUploadForm').slideDown();
		return false;
	});
})
</script>
	<div id="ebookListHeading" class="subHeading">
	Books

	</div>
	<div style="font-size:14px"><a id="uploadLink" href="" style="cursor:pointer"><img src="background_images/newBook.gif" /></a>
		<div id="ebookUploadForm" style="overflow:hidden">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<em>Max upload size <?php echo ini_get('upload_max_filesize');?></em><br />
				<?php $changeGET=false;?>
				<label>For Class: </label><?php include("includes/teacherIncludes/getClassSelect.php");?><br />
				<input type="hidden" value="ebooks" name="SubFolder" />
				<input type="submit" value="Upload Book" />
			</form>
		</div>
	</div>
<ul class="ulul">
<?php
	include_once("includes/getSubjects.php");
	if(!isset($_GET["class"])){
		$directories=getfilelist($myBooksPath."/","DIR");
		$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND teacherID='".$dispAs."'";
			$result=mysql_query($sql);
			while($row=mysql_fetch_array($result)){
			$classes[$row["classID"]]=$row;
			}
		
		foreach($directories as $dir){
			if(strrpos("/",$dir)===0) substr($dir,0,strlen($dir));
			if(!isset($classes[basename($dir)])) continue;
			$row=$classes[basename($dir)];
			$subject=$subjects[$row["subjectID"]];
		
	?>
			<li><a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&class=<?php echo basename($dir);?>"><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"];?></a></li>
<?php //Class header ?>
	<?php
		} ?>
		</ul>
		<?php
	} else {
	$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".$_GET["class"]."' LIMIT 1";
			$result=mysql_query($sql);
		
			$row=mysql_fetch_array($result);
			$subject=$subjects[$row["subjectID"]];
			
		$dir=$myBooksPath;
		$myBooks=array();
		$dir=trim($myBooksPath,"/");
		$myBooks=recursive_listdir_array($dir,$bookFileTypes,true);
		
		?><h3><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"];?></h3><ul><?php
				foreach($myBooks as $v){
					$v=str_replace("//","/",$v);
					if(strpos(strtolower($v),"pdf")){
						$img=str_ireplace("pdf","gif",$v);
					} else {
						$img="dummyImgPath";
					}
			?>
			<li><a href="<?php echo $v;?>" target="_blank"><?php if(file_exists($img)){?><img style="border:none;margin-left:20px" src="<?php echo $img;?>" width="80px"/><br /><?php }?><?php echo basename($v);?></a></li>
			<?php 
		}
		?>
		</ul>
		<?php
	}
} else {
?>
<div id="ebookListHeading" class="subHeading">
You currently do not have any eBooks
</div>
	<div style="font-size:14px">
		<div id="ebookUploadForm">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<em>Max upload size <?php echo ini_get('upload_max_filesize');?></em><br />
					<?php $changeGET=false;?>
				<label>For Class: </label><?php include("includes/teacherIncludes/getClassSelect.php");?><br />
				<input type="hidden" value="ebooks" name="SubFolder" />
				<input type="submit" value="Upload Book" />
			</form>
		</div>
	</div>
<?php
}
?>
</div>