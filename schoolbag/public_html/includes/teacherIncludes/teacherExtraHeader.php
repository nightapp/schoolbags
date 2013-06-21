<div id="teachersSubjects" style="width:352px;margin-left:64px;margin-right:64px;text-align:center;overflow-x:hidden;overflow-y:hidden;height:30px;text-wrap:">
<?php 
include_once("includes/getSubjects.php");
include_once("includes/teacherTeaches.php");
$border=false;
$borderExtra="";
foreach($teacherTeaches as $rowTeachers){
	if($border){
		$borderExtra=";border-left:1px solid brown";
	}
	$border=true;
	?>
<span style=""><?php echo str_replace(" ","&nbsp;",$subjects[$rowTeachers["subject"]]);?></span> <?php }?></div>