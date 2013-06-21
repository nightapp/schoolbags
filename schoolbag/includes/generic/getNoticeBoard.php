<?php if(!isset($_GET["noticeBoard"])) $_GET["noticeBoard"]="P";?>
<div id="noticeBoard" class="middleDiv">

<?php
if(!isset($_GET["smallnoticeboard"])){
?>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$(".deleteNewsItem").click(function(){
		if(confirm("Are you sure you want to delete this notice")){
			clicked=$(this);
			$.post("ajax/deleteFromNoticeBoard.php",$(this).parent().serialize(),function(data){
				alert(data);
				clicked.parent().parent().parent().remove();
			})
		}
	})
	$(".editNewsItem").click(function(){
		document.location.href=$(this).attr("rel");
	})
})
$(document).ready(function(){
	$(".viewComments").click(function(){
		c=$(this).parent().parent().parent().find(".comments");
		if(c.text()==""){
			$.get("ajax/getComments.php",$(this).parent().serialize(),function(data){
				c.html(data);
			})
		} else {
			c.html("");
		}
	})
	$(".deleteComment").live("click",function(){
		if(confirm("Are you sure you want to delete this comment")){
			clicked=$(this);
			$.post("ajax/deleteComment.php",$(this).parent().serialize(),function(data){
				alert(data);
//				clicked.parent().html(data);
				clicked.parent().parent().remove();
			})
		}
	})
	$(".editComment").live("click",function(){
		document.location.href=$(this).attr("rel");
	})
	$(".addComment").click(function(){
		document.location.href=$(this).attr("rel");
	})
})
</script>
<?php } ?>
<div id="noticeBoardHeader" class="subHeading">School Notice Board</div>
<?php if($_SESSION["userType"]!="P" && !isset($_GET["smallnoticeboard"])){?>
<div style="height:74px;overflow:hidden;margin-left:275px;text-align:center">
<div class="option" title="Go to noticeboard (full)" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=noticeboard&noticeBoard=P"><img src="background_images/noticeboard.gif" /><br />Full</div>
<div class="option" title="Go to noticeboard (staff only)" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=noticeboard&noticeBoard=T"><img src="background_images/staffnoticeboard.gif" /><br />Staff only</div>
<div class="option" title="Add to noticeboard" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=addToNoticeboard&noticeBoard=<?php echo $_GET["noticeBoard"];?>"><img src="background_images/addtonoticeboard.gif" /><br />Add new</div>
</div>
<?php
}
$from=0;
$more=false;
if(isset($_GET["startFrom"]) && $_GET["startFrom"]>0) $from=$_GET["startFrom"];
$valuesArray=array();
$val="'".$_SESSION["userType"]."'";
if(isset($_GET["noticeBoard"])){
	$tmp=$visibleNoticeBoards[$_GET["noticeBoard"]];
	unset($visibleNoticeBoards);
	$visibleNoticeBoards[$_GET["noticeBoard"]]=$tmp;
}
foreach($visibleNoticeBoards as $k=>$currentList){
	$tmpArray=explode(",",$currentList);
	if(in_array($val,$tmpArray)){
		$valuesArray[]=$k;
	}
}
$classes=array();
$extra="";
if($_SESSION["userType"]=="P"){
$extra=" AND classlistofusers.studentID=".$_SESSION["userID"];
} else {
$extra=" GROUP BY classlist.classID";
}
$date=date("Y",strtotime("-7 months"));
$sql="SELECT * FROM classlistofusers,classlist,subjects WHERE classlistofusers.classID=classlist.classID AND classlist.subjectID=subjects.ID AND classlist.schyear='".$date."'".$extra;
$result=mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_assoc($result)){
	$classes[$row["classID"]]=$row;
}
$datas=array();
if(isset($_GET["smallnoticeboard"])){
		$sql="SELECT * FROM noticeboard,users WHERE (users.schoolID='".$_SESSION["schoolID"]."' || users.schoolID=0) AND noticeboard.userType IN('".implode("', '",$valuesArray)."','C') AND users.userID=noticeboard.uploadedBy ORDER BY date DESC LIMIT ".$from.",8";
//		echo $sql;
		$result=mysql_query($sql) or die(mysql_query());
		$idx=0;
		while(($row=mysql_fetch_array($result)) && $idx<4){
//		var_dump($row);
//		echo $row["userType"];
		if($row["userType"]!='C'){
				$datas[$idx]=$row;
				$idx++;
//				echo "<br>NC<br>";
			} else {
//				echo "U<br>";
				if($row["userType"]=="C" && isset($classes[$row["classID"]])){
	//				echo "C<br>";
					$datas[$idx]=array_merge($row,$classes[$row["classID"]]);
					
					$idx++;
				}
			}
		}
} else{
	if($_GET["noticeBoard"]=="T"){
		$sql="SELECT * FROM noticeboard,users WHERE (users.schoolID='".$_SESSION["schoolID"]."' || users.schoolID=0) AND noticeboard.userType IN('".implode("', '",$valuesArray)."','C') AND users.userID=noticeboard.uploadedBy ORDER BY date DESC LIMIT ".$from.",11";
		while($row=mysql_fetch_array($result)){
			if($row["userType"]!="C"){
				$datas[]=$row;
			} else {
				if($row["userType"]=="C" && isset($classes[$row["classID"]])){
					$datas[]=array_merge($row,$classes[$row["classID"]]);
				}
			}
		}
	} else {
		$sql="SELECT * FROM noticeboard,users WHERE (users.schoolID='".$_SESSION["schoolID"]."' || users.schoolID=0) AND noticeboard.userType IN('".implode("', '",$valuesArray)."','C') AND users.userID=noticeboard.uploadedBy ORDER BY date DESC LIMIT ".$from.",11";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)){
			if($row["userType"]!="C"){
				$datas[]=$row;
			} else {
				if($row["userType"]=="C" && isset($classes[$row["classID"]])){
					$datas[]=array_merge($row,$classes[$row["classID"]]);
				}
			}
		}
		//		die($sql);
	}
}
?>
<?php
$i=0;
$result=mysql_query($sql);
foreach($datas as $row){
$i++;
$more=false;
if($i<=10){
?>
<div class="notice" style="display:block">
	<div class="noticeLeft" style="text-align:center">
		<?php echo date("d/m/Y",strtotime($row["date"]));?><br>
		<?php echo date("H:i",strtotime($row["date"]));?>
		<?php if($_SESSION["userID"]==$row["uploadedBy"] && $_SESSION["schoolID"]==$row["schoolID"]){?><br />
		<a title="Edit News Item" class="editNewsItem" style="display:inline" rel="<?php echo $_SERVER['PHP_SELF'];?>?subPage=addToNoticeboard&date=<?php echo $row["date"];?>&schoolID=<?php echo $row["schoolID"];?>"><img src="background_images/edit-icon.png" style="height:20px"/></a>
		<form style="display:inline">		<a title="Delete News Item" class="deleteNewsItem"><img src="background_images/Delete-icon.png" style="height:20px"/></a>
		<input type="hidden" value="<?php echo $row["date"];?>" name="date" />
		</form>
		<?php } ?><br />
		<?php if($_SESSION["userType"]!="P"){?>
		<a title="Add comment" class="addComment" style="display:inline" rel="<?php echo $_SERVER['PHP_SELF'];?>?subPage=addComment&uplBy=<?php echo $row["uploadedBy"];?>&date=<?php echo $row["date"];?>&schoolID=<?php echo $row["schoolID"];?>"><img src="background_images/addComment.png" style="height:20px"/></a>
		<?php }?>
		<form style="display:inline">		<a title="View Comments" class="viewComments"><img src="background_images/viewComments.png" style="height:20px"/></a>
		<input type="hidden" value="<?php echo $row["date"];?>" name="dateofnews" />
		<input type="hidden" value="<?php echo $row["uploadedBy"];?>" name="newsowner" />
		</form>
	</div>
	
	<div class="noticeRight">
	<p><?php echo $row["text"];?><?php 	if($row["fileAttached"]!=""){
		$c="/";
		if($row["userType"]=="C"){
			$c="/".$row["classID"]."/";
		}
		$attachedFile=$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]."/noticeboard".$c.$row["fileAttached"];
		if(file_exists($attachedFile)){
	?><a href="<?php echo $attachedFile;?>" title="View attached file"><img src="background_images/attachedFile.png" style="width:20px;float:right" /></a>
	<?php } 
	}
	?>
</p>
	<?php 
	if($row["Type"]=="A"){
		$imgfile="background_images/smallLogo.gif";
	} elseif($row["Type"]=="S"){
		$imgfile=$_SESSION["schoolPath"]."S/crest.jpg";	
	} else {
		$imgfile=$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]."/image.jpg";	
	}
	if(file_exists($imgfile)){
	?><img src="<?php echo $imgfile;?>" style="width:70px;float:right;margin-top:4px" />	<?php } ?>
<br style="clear:both;" />
	<i style="float:right;font-size:9px">Added By <?php echo $row["FirstName"]." ".$row["LastName"];?></i><br>
	<?php if(isset($row["subject"])){?>
	<i style="float:right;font-size:9px">Class <?php echo $row["subject"]." ".$row["extraRef"];?></i><br>
	<?php } ?>
	</div>
	<div class="comments"></div>
</div>
<?php 
	} else {
		$more=true;
	}
}?><br>
<br>
<div class="subFooter"><div style="width:50%;float:left;display:block;text-align:left"><?php if($from>0){?><a href="<?php echo $_SERVER['SCRIPT_NAME']."?subPage=noticeboard&startFrom=".($from-10);?>">&laquo; back</a><?php } ?></div><div style="width:50%;float:left;display:block;text-align:right"><?php if($more){?><a href="<?php echo $_SERVER['SCRIPT_NAME']."?subPage=noticeboard&startFrom=".($from+10);?>">more &raquo;</a><?php } ?></div>
</div>
</div>