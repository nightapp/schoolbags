<?php
$tmp="";
if(file_exists($schoolPath."S/map.jpg")){
$tmp.='<div class="first_li"><span>School Map</span></div>';
}	
if(file_exists($schoolPath."S/policies.pdf")){
$tmp.='<div class="first_li"><span>School Policies</span></div>';
}	
$sql="SELECT * FROM links WHERE schoolID=".$_SESSION["schoolID"];
$result=mysql_query($sql) or die(mysql_error());
while($row=mysql_fetch_array($result)){
	$tmp.='<div class="first_li"><span><a style="display:none" href="'.urldecode($row["link"]).'"></a>'.$row["display"].'</span></div>';
}
$_SESSION["schoolLinks"]=$tmp;
echo $tmp;
?>