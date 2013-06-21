<h2>Teachers List</h2>
<?php 
$sql="SELECT * FROM users WHERE schoolID='".$_SESSION["schoolID"]."' AND Type='T' ORDER BY LastName";
$result=mysql_query($sql);

$num=mysql_num_rows($result);
$inCol=ceil($num/5);
$i=0;
?>
<div class="teacherColumn">
<?php
while($row=mysql_fetch_array($result)){
if($i==$inCol){
$i=0;
?>
</div><div class="teacherColumn">
<?php 
} else {
	if($i>0){
?>
		<br>
<?php
	}
}
$i=$i+1;
echo $row["FirstName"]." ".$row["LastName"];
?>
<?php 
}
?>
</div>