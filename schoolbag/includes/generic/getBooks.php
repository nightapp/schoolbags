<?php

//params $myBooksPath
//		 $display		book resource
//		 $subFolder		eBooks resource
//		 $_GET["class"]	Possible

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
	Please click on a <?php echo $display;?> to view.
	</div>
	<div class="subHeading" style="font-size:14px"><a id="uploadLink" href="" style="cursor:pointer">Upload a resource&raquo;</a>
		<div id="ebookUploadForm" style="overflow:hidden">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<label>For Class: </label><?php if($_SESSION["userType"]){ include("includes/teacherIncludes/getClassSelect.php");} else {include("includes/studentIncludes/getClassSelect.php");}?><br />
				<input type="hidden" value="<?php echo $subFolder;?>" name="SubFolder" />
				<input type="submit" value="Upload <?php echo $display;?>" />
			</form>
		</div>
	</div>
<ul>
<?php
	include_once("includes/getSubjects.php");
	if(!isset($_GET["class"])){
		$directories=getfilelist($myBooksPath."/","DIR");
		foreach($directories as $dir){
			if(strrpos("/",$dir)===0) substr($dir,0,strlen($dir));
			
	$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".basename($dir)."' LIMIT 1";
			$result=mysql_query($sql);
		
			$row=mysql_fetch_array($result);
			$subject=$subjects[$row["subjectID"]];
		
	?>
			<li><a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&class=<?php echo basename($dir);?>"><?php echo ordinalize($row["year"])." year, ".$subject." ".$row["extraRef"];?></a></li>
<?php //Class header ?>
	<?php
		} ?></ul><?php
	} else {
	$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".$_GET["class"]."' LIMIT 1";
			$result=mysql_query($sql);
		
			$row=mysql_fetch_array($result);
			$subject=$subjects[$row["subjectID"]];
		$dir=$myBooksPath;
		$myBooks=array();
		foreach($bookFileTypes as $extention){
			$myBooks=array_merge($myBooks,getfilelist($dir."/",$extention));
		}
		ksort($myBooks);
		?><h3><?php echo ordinalize($row["year"])." year, ".$subject." ".$row["extraRef"];?></h3><ul><?php
		foreach($myBooks as $v){
			$v=str_replace("//","/",$v);
			?>
			<li><a href="<?php echo $v;?>" target="_blank"><?php echo basename($v);?></a></li>
			<?php 
		}
		?>
		</ul>
		<?php
	}
} else {
?>
<div id="ebookListHeading" class="subHeading">
You currently do not have any <?php echo $display;?>s
</div>
	<div class="subHeading" style="font-size:14px">
		<div id="ebookUploadForm">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<label>For Class: </label><?php include("includes/teacherIncludes/getClassSelect.php");?><br />
				<input type="hidden" value="<?php echo $subFolder;?>" name="SubFolder" />
				<input type="submit" value="Upload <?php echo $display;?>" />
			</form>
		</div>
	</div>
<?php
}
?>
