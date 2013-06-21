<h2>Teachers List</h2>
<div id="teachersList" style="width:800px;">
<?php 
$sql="SELECT * FROM users WHERE schoolID='".$_SESSION["schoolID"]."' AND Type='T' ORDER BY LastName";
$result=mysql_query($sql);

$num=mysql_num_rows($result);
$inCol=ceil($num/5);
$i=0;
?>
<?php
while($row=mysql_fetch_array($result)){
$i=$i+1;
echo "<div class='teacher' style='width:160px;display:inline;float:left'>".$row["FirstName"]." ".$row["LastName"]."</div>";
}
?>
</div>