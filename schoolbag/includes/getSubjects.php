<?php
$sqlsubjects="SELECT * from subjects";
$resultsubjects=mysql_query($sqlsubjects);
while($row=mysql_fetch_array($resultsubjects)){
	$subjects[$row["ID"]]=$row["subject"];
}
?>