<?php 

///TO DO 
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
if(isset($_GET["class"])){
	$class=$_GET["class"];
}
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
		Resources
	</div>
	
<ul>
<?php
	$sql2="SELECT * from classlist,subjects,classlistofusers WHERE classlist.schoolID=classlistofusers.schoolID AND classlistofusers.schoolID=".$_SESSION["schoolID"]." AND classlist.classID=classlistofusers.classID AND classlistofusers.studentID=".$_SESSION["userID"]." AND classlist.subjectID=subjects.ID ORDER BY classlist.year DESC,subjects.subject ASC";
	$result2=mysql_query($sql2);
	while($row2=mysql_fetch_array($result2)){
			$classes[$row2["classID"]]=$row2;
	}
	if(!isset($_GET["class"])){
		foreach($classes as $class){
			if(strrpos("/",$dir)===0) substr($dir,0,strlen($dir));
			
	?>
			<li><a class="head" href="<?php echo $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];?>&class=<?php echo basename($class["classID"]);?>"><?php echo ordinalize($class["year"])." year, ".$class["subject"]." ".$class["extraRef"];?></a></li>
<?php //Class header ?>
	<?php
		} ?></ul><?php
	} else {
		include_once("includes/generic/incl_listdir.php");
		$class=$classes[$_GET["class"]];
		$dir=$_SESSION["schoolPath"]."T/".$class["teacherID"]."/dropbox/".$class["classID"];
		if(is_dir($dir)){
			$myBooks=array();
			$myBooks=array_merge($myBooks,recursive_listdir_array($dir,$bookFileTypes,true));
			$myBooks=dirsort($myBooks);
			?><h3><?php echo ordinalize($class["year"])." year, ".$class["subject"]." ".$class["extraRef"];?></h3><?php
			$currentD="";
			foreach($myBooks as $v=>$s){
				$v=str_replace("//","/",$v);
				$tmpdirs=str_replace($dir,"",$v."/");
				$exp=explode("/",$tmpdirs);
				$indent=(count($exp)-1)*25;
	//			echo $tmpdirs."<br />";
				$tmpdirs=implode(" : ",$exp);
	?>				</ul>
					<h3 style="padding-left:<?php echo $indent;?>px"><?php echo ($tmpdirs!=""?trim($tmpdirs," : "):"");?></h3>
					<ul style="padding-left:<?php echo $indent;?>px">
					<?php
				foreach($s as $f){
				?>
				<li><a href="<?php echo $f;?>" target="_blank"><?php echo basename($f);?></a></li>
				<?php 
				}
			}
		
		} else {
		?><p>There are currently no resources for <?php echo ordinalize($class["year"])." year, ".$class["subject"]." ".$class["extraRef"];?></p><?php
		}
	}
?>
</div>