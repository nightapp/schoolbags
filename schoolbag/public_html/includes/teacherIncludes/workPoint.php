<div id="noticeBoard" class="middleDiv">
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$(".deleteNewsItem").click(function(){
		if(confirm("<?php echo translate("Are you sure you want to delete this topic");?>")){
			clicked=$(this);
			$.post("ajax/deleteWorkPointTopic.php",$(this).parent().serialize(),function(data){
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
			$.get("ajax/getWorkPointComments.php",$(this).parent().serialize(),function(data){
				c.html(data);
			})
		} else {
			c.html("");
		}
	})
	$(".deleteComment").live("click",function(){
		if(confirm("<?php echo translate("Are you sure you want to delete this comment");?>")){
			clicked=$(this);
			$.post("ajax/deleteWorkPointPost.php",$(this).parent().serialize(),function(data){
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
<div id="noticeBoardHeader" class="subHeading"><?php echo translate("Workpoint");?></div>
<?php if(!isset($_GET["smallnoticeboard"])){?>
<div style="height:74px;overflow:hidden;margin-left:275px;text-align:center">
<div class="option" title="<?php echo translate("View Workpoint");?>" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=workPoint"><img src="background_images/workpoint.gif" /><br /><?php echo translate("Forum topics");?></div>
<div class="option" title="<?php echo translate("Create Topic");?>" rel="<?php echo $userTypePage[$_SESSION["userType"]];?>?subPage=createWorkPoint"><img src="background_images/newworkpoint.gif" /><br /><?php echo translate("New Topic");?></div>
</div>
<?php
}
$from=0;
$more=false;
$add="";
if(isset($_GET["startFrom"]) && $_GET["startFrom"]>0) $from=$_GET["startFrom"];
if(isset($_GET["topic"])) $add="AND topicID=".$_GET["topic"]." ";
$sql="SELECT * FROM work_point_topics,users,classlist WHERE classlist.classID=work_point_topics.class_id AND classlist.teacherID=".$_SESSION["userID"]." AND (users.schoolID='".$_SESSION["schoolID"]."' || users.schoolID=0) ".$add."AND users.userID=work_point_topics.topicOwner ORDER BY date DESC LIMIT ".$from.",11";
if($_GET["debug"]==true) echo $sql;
$i=0;
$result=mysql_query($sql);
while($row = mysql_fetch_array($result)){
$i++;
$more=false;
if($i<=10){
?>
<div class="notice" style="display:block">
	<div class="noticeLeft" style="text-align:center">
		<?php echo date("d/m/Y",strtotime($row["date"]));?><br>
		<?php echo date("H:i",strtotime($row["date"]));?>
		<?php if($_SESSION["userID"]==$row["topicOwner"] && $_SESSION["schoolID"]==$row["schoolID"]){?><br />
		<a title="<?php echo translate("Edit Origional Post");?>" class="editNewsItem" style="display:inline" rel="<?php echo $_SERVER['PHP_SELF'];?>?subPage=createWorkPoint&date=<?php echo $row["date"];?>&schoolID=<?php echo $row["schoolID"];?>&topic=<?php echo $row["topicID"];?>"><img src="background_images/edit-icon.png" style="height:20px"/></a>
		<form style="display:inline">		<a title="<?php echo translate("Delete Topic");?>" class="deleteNewsItem"><img src="background_images/Delete-icon.png" style="height:20px"/></a>
		<input type="hidden" value="<?php echo $row["date"];?>" name="date" />
		<input type="hidden" value="<?php echo $row["topicID"];?>" name="topic" />
		</form>
		<?php } ?><br />
		<?php if(isset($_GET["topic"])){?>
		<a title="<?php echo translate("Add Post");?>" class="addComment" style="display:inline" rel="<?php echo $_SERVER['PHP_SELF'];?>?subPage=addWorkPointPost&topic=<?php echo $row["topicID"];?>&schoolID=<?php echo $row["schoolID"];?>"><img src="background_images/addComment.png" style="height:20px"/></a>
		<?php }?>
	</div>
	
	<div class="noticeRight">
	<a class="topicHeader" href="<?php echo $userTypePage[$_SESSION["Type"]];?>?subPage=workPoint&topic=<?php echo $row["topicID"];?>"><?php echo $row["title"];?></a>
	<p><?php echo $row["text"];?>
	<?php 	if($row["fileAttached"]!=""){
		$attachedFile=$_SESSION["schoolPath"].$row["Type"]."/".$row["userID"]."/workPointPosts/".$row["fileAttached"];
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
	?><img src="<?php echo $imgfile;?>" style="width:70px;float:right;margin-top:4px" />
	<?php } 
	?>
<br style="clear:both;" />
	<i style="float:right;font-size:9px"><?php echo translate("Created By");?> <?php echo $row["FirstName"]." ".$row["LastName"];?></i><br>
	</div>
	<div class="comments">
	<?php if(isset($_GET["topic"])){
	?>
	<?php
$sql2="SELECT * FROM work_point_posts,users WHERE work_point_posts.topicID='".$_GET["topic"]."' AND work_point_posts.postOwner=users.userID ORDER BY date ASC";
$result2=mysql_query($sql2) or die("An error occured");
if(mysql_num_rows($result2)==0){
?>
<div class="comment"><?php echo translate("There are currently no comments");?></div>
<?php
} else {
	while($comment=mysql_fetch_array($result2)){
		$img=$_SESSION["schoolPath"].$comment["Type"]."/".$comment["postOwner"]."/image.jpg";
		?>
			<div class="comment">
			<p><em><?php echo $comment["FirstName"]." ".$comment["LastName"];?></em>
			<br style="clear:both"><?php echo $comment["text"];?>
			<?php 	
			if($comment["fileAttached"]!=""){
				$attachedFile=$_SESSION["schoolPath"].$comment["Type"]."/".$comment["postOwner"]."/workPointPosts/".$comment["fileAttached"];
				if(file_exists($attachedFile)){
			?><a href="<?php echo $attachedFile;?>" title="<?php echo translate("View attached file");?>"><img src="background_images/attachedFile.png" style="width:20px;float:right" /></a>
			<?php } 
			}
			?>
			</p>
			<?php if(is_file($img)){ ?>
			<img src="<?php echo $img;?>" class="profileimg" />
			<?php }?>
			<?php 
			if($_SESSION["userID"]==$comment["postOwner"]){
			?>
			<a title="<?php echo translate("Edit Comment");?>" class="editComment" style="display:inline" rel="<?php echo $userTypePage[$comment["Type"]];?>?subPage=addWorkPointPost&date=<?php echo $comment["date"];?>&topic=<?php echo $comment["topicID"];?>"><img src="background_images/edit-icon.png" style="height:20px"/></a>
			<form style="display:inline">		<a title="<?php echo translate("Delete News Item");?>" class="deleteComment"><img src="background_images/Delete-icon.png" style="height:20px"/></a>
			<input type="hidden" value="<?php echo $comment["date"];?>" name="date" />
			<input type="hidden" value="<?php echo $comment["topicID"];?>" name="topic" />
			</form><?php
			}?>
			</div>
		<?php
	}
}
?>
	<?php
	}
	?>
	</div>
</div>
<?php 
	} else {
		$more=true;
	}
}?><br>
<br>
<div class="subFooter"><div style="width:50%;float:left;display:block;text-align:left"><?php if($from>0){?><a href="<?php echo $_SERVER['SCRIPT_NAME']."?subPage=noticeboard&startFrom=".($from-10);?>">&laquo; back</a><?php } ?></div><div style="width:50%;float:left;display:block;text-align:right"><?php if($more){?><a href="<?php echo $_SERVER['SCRIPT_NAME']."?subPage=noticeboard&startFrom=".($from+10);?>"><?php echo translate("more");?> &raquo;</a><?php } ?></div>
</div>
</div>