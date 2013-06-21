<?php 
if(isset($_POST["classSelect"])){
	$_POST["SubSubFolder"]=$_POST["classSelect"];
//include("upload.php");
}
	function ordinalize($number) {
		if (in_array(($number % 100),range(11,13))){
			return $number.'th';
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

$myBooksPath=$schoolPath.strtoupper($_SESSION["userType"])."/".$_SESSION["userID"]."/ebooks";
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
	Please click on a book to view.
	</div>
	<div class="subHeading" style="font-size:14px"><a id="uploadLink" href="#" style="cursor:pointer">Upload a book&raquo;</a>
		<div id="ebookUploadForm" style="overflow:hidden">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<label>For Class: </label><?php include("includes/studentIncludes/getClassSelect.php");?><br />
				<input type="hidden" value="ebooks" name="SubFolder" />
				<input type="submit" value="Upload Book" />
			</form>
		</div>
	</div>

<?php
	$directories=getfilelist($myBooksPath."/","DIR");
	foreach($directories as $dir){
		if(strrpos("/",$dir)===0) substr($dir,0,strlen($dir));
	
		$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".basename($dir)."' LIMIT 1";
		$result=mysql_query($sql);
	
		$row=mysql_fetch_array($result);
	
		$sql2="SELECT * from subjects WHERE ID='".$row["subjectID"]."' LIMIT 1";
		$res2=mysql_query($sql2);
	
		$row2=mysql_fetch_array($res2);
		$subject=$row2["subject"];
	
?>
		<a class="head"><?php echo ordinalize($row["year"])." year, ".$subject." ".$row["extra"];?></a> <?php //Class header ?>
		<div>
		<ul>
<?php
		$myBooks=array();
		foreach($bookFileTypes as $extention){
			$myBooks=array_merge($myBooks,getfilelist($dir."/",$extention));
		}
		foreach($myBooks as $v){
			$v=str_replace("//","/",$v);
			?>
			<li><a href="<?php echo $v;?>" target="_blank"><?php echo basename($v);?></a></li>
			<?php 
		}
		?>
		</ul>
		</div>
		<?php
	}
} else {
?>
<div id="ebookListHeading" class="subHeading">
You currently do not have any eBooks
</div>
	<div class="subHeading" style="font-size:14px">
		<div id="ebookUploadForm">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<label>For Class: </label><?php include("includes/studentIncludes/getClassSelect.php");?><br />
				<input type="hidden" value="ebooks" name="SubFolder" />
				<input type="submit" value="Upload Book" />
			</form>
		</div>
	</div>
<?php
}
?>
</div>