<?php
$justInclude=true;
include_once("../config.php");
$typesAllowed=array("T","P","S");
include("checkAjax.php");

?>
<div>
<?php
$sql="SELECT * FROM noticeboardcomments,users WHERE noticeboardcomments.dateofnews='".$_GET["dateofnews"]."' AND noticeboardcomments.newsowner=".$_GET["newsowner"]." AND noticeboardcomments.addedBy=users.userID ORDER BY date ASC";
$result=mysql_query($sql) or die("An error occured");
if(mysql_num_rows($result)==0){
?>
<div class="comment">There are currently no comments</div>
<?php
} else {
while($row=mysql_fetch_array($result)){
	$img=$_SESSION["schoolPath"].$row["Type"]."/".$row["addedBy"]."/image.jpg";
	?>
		<div class="comment">
		<p><em><?php echo $row["FirstName"]." ".$row["LastName"];?></em>
		<br style="clear:both"><?php echo $row["comment"];?></p>
		<?php if(is_file("../".$img)){ ?>
		<img src="<?php echo $img;?>" class="profileimg" />
		<?php }?>
		<?php 
		if($_SESSION["userID"]==$row["addedBy"]){
		?>
		<a title="Edit Comment" class="editComment" style="display:inline" rel="<?php echo $userTypePage[$row["Type"]];?>?subPage=addComment&date=<?php echo $row["date"];?>&dateofnews=<?php echo $row["dateofnews"];?>"><img src="background_images/edit-icon.png" style="height:20px"/></a>
		<form style="display:inline">		<a title="Delete News Item" class="deleteComment"><img src="background_images/Delete-icon.png" style="height:20px"/></a>
		<input type="hidden" value="<?php echo $row["date"];?>" name="date" />
		</form><?php
		}?>
		</div>
	<?php
}
}
?>
</div>