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
include("includes/getFriendsSelect.php");
?>
	<div id="ebookListHeading" class="subHeading">
	Resources
	</div>
	<div><a id="uploadLink" href="" style="cursor:pointer"><img src="background_images/newResource.gif" /></a>
		<div id="ebookUploadForm" style="overflow:hidden">
			<form action="<?php $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];?>" method="post"  enctype="multipart/form-data" id="uploadBookForm">
				<label>File: </label><input type="file" name="fileData" id="fileToUpload" /><br />
				<em>Max upload size <?php echo ini_get('upload_max_filesize');?></em><br />
				<label>For Class: </label><?php if($_SESSION["userType"]){ include("includes/teacherIncludes/getClassSelect.php");} else {include("includes/studentIncludes/getClassSelect.php");}?><br />
				<?php 
				if(isset($_GET["class"])){
					if(strpos($_GET["class"],"./")!==false) die("Error: Access Denied");
						$addPath=$_GET["class"]."/";
				}
				$myBooksPath=$schoolPath.strtoupper($_SESSION["userType"])."/".$dispAs."/dropbox/".$addPath;
				$myBooksPath=str_replace("//","/",$myBooksPath);
				if(strrpos("/",$myBooksPath)===0) substr($myBooksPath,0,strlen($myBooksPath));
				$myBooks=array();
				$path=$myBooksPath;
				include_once("includes/generic/incl_listdir.php");
				$f=recursive_listdir($path,".",true);
				?>
				<input type="hidden" value="dropbox" name="SubFolder" />
				<label>Create new folder</label><input type="checkbox" id="createNewFolder" /><br />

<?php 
?><div style="display:inline;float:left">
				<label id="subFolderIn">Sub Folder</label><select id="parentFolder"  name="SubSubSubFolder">
				<option value="root">Default</option>
				<?php foreach ($f as $v){
				$v=str_replace("//","/",$v);
				$v=substr($v,strlen($path));
				$d=str_replace("/"," : ",$v);
				?>
				<option value="<?php echo $v;?>"><?php echo $d;?></option>
				<?php }?>
				</select></div><div id="newFolderIn" style="float:left;display:none"><label>New Folder Name</label><input type="text" id="newFolderName" name="SubSubSubSubFolder"/><input type="button" value="Create" id="createFolder"/></div><br /><br />

				<input type="submit" value="Upload resource" />
			</form>
		</div>
	</div>
<ul>
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
		} ?></ul><?php
	} else {
	$sql="SELECT * from classlist WHERE schoolID='".$_SESSION["schoolID"]."' AND classID='".$_GET["class"]."' LIMIT 1";
			$result=mysql_query($sql);
		
		$row=mysql_fetch_array($result);
		$subject=$subjects[$row["subjectID"]];
		$dir=trim($myBooksPath,"/");
		$myBooks=array();
		$myBooks=array_merge($myBooks,recursive_listdir_array($dir,$bookFileTypes,true));
		$filelist=array();
		$dirlist=array();			
		$myBooks=dirsort($myBooks);
		?><h3><?php echo ordinalize($row["year"])." Class/Yr, ".$subject." ".$row["extraRef"];?></h3><?php
		$currentD="";
		foreach($myBooks as $v=>$s){
			$v=str_replace("//","/",$v);
			$tmpdirs=$v;
			$exp=explode("/",$tmpdirs);
			$indent=(count($exp)-1)*28;
//			echo $tmpdirs."<br />";
			$tmpdirs=basename($tmpdirs);
?>				</ul>
				<h3 style="padding-left:<?php echo $indent;?>px"><?php echo ($tmpdirs!=""?"<img src='background_images/folder.png' width='20px' style='margin-right:5px' />".trim($tmpdirs," : "):"");?></h3>
				<ul style="padding-left:<?php echo $indent+10;?>px">
				<?php
			foreach($s as $f){
			$p=str_replace($_SESSION["schoolPath"].$_SESSION["userType"]."/".$dispAs."/dropbox/".$_GET["class"],"",dirname($f));
			if(strpos($p,"/")===0){
				$p=substr($p,1,strlen($p)-1);
			} else {
				$p="root";
			}
?>			<li><a href="<?php echo $f;?>" target="_blank"><?php echo basename($f);?></a><?php if($dispAs==$_SESSION["userID"]){ ?><img src="background_images/Delete-icon.png" width="15px" style="margin-left:5px" title="Delete this file" rel="<?php echo $p;?>|<?php echo basename($f);?>" class="deleteFile" /><?php } ?></li>
			<?php 
			}
		}
		
	}
if(is_dir($myBooksPath)){//there are eBooks
?>
<script type="text/javascript">
$(document).ready(function(){
	<?php if(!isset($_GET["form"])){?>
	$('#ebookUploadForm').slideUp(1);	
	<?php }?>
	$('#uploadLink').click(function(){
		$("#uploadLink").slideUp();
		$('#ebookUploadForm').slideDown();
		return false;
	});
	
})
</script>
<?php }?>
<script type="text/javascript">
$(document).ready(function(){
	$("#classSelect").change(function(){
		document.location.href="<?php echo $_SERVER['PHP_SELF']."?subPage=dropBox&form=1&class=";?>"+$(this).val();
	})
	$("#createNewFolder").change(function(){
		if($(this).attr("checked")==true){
			$("#subFolderIn").text("Create folder in : ");
			$("#newFolderIn").show().find("input").removeAttr("disabled");
		} else {
			$("#subFolderIn").text("Add file to folder:");
			$("#newFolderIn").hide().find("input").attr("disabled","disabled");
		}
	})
	$(".deleteFile").click(function(){
		t=$(this).attr("rel");
		t=t.split("|");
		p=t[0];
		f=t[1];
		$.post("ajax/deleteFile.php",{folder:p,fileName:f,c:'<?php echo $_GET["class"];?>',type:'dropbox'},function(data){
		alert(data);
			if(data.indexOf("Error")==-1) document.location.href="<?php echo $_SERVER['PHP_SELF'];?>?subPage=dropBox&class=<?php echo $_GET["class"];?>&form=1"; else alert(data);
		})
	})
})
</script>
 
</div>