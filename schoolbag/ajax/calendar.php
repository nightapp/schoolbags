<?php 
$justInclude=true;
include("../config.php"); ?>
<?php 
if (isset($_GET["direct"])) echo $queryCalendarNews."<br /><br />";
if (isset($_GET["direct"])) echo "<table style='width:216px'>";
$m=$_GET["m"];
$y=$_GET["y"];
$d=date("j");
$startDay=date("w",mktime(0,0,0,$m,1,$y))+1;
$firstOfMonth=mktime(0,0,0,$m,1,$y);
$today=date("Y-m-d");
?><tr><td colspan="7" style="font-weight:bold;color:navy;text-align:center"><a href="#" class="mNav" rel="next" title="<?php echo date("F Y",strtotime("+1 month",$firstOfMonth)); ?>" style="font-size:18px;margin-right:3px;margin-top:-4px;color:#006699;float:right;display:block">&raquo;</a><a href="#" class="mNav" rel="prev" title="<?php echo date("F Y",strtotime("-1 month",$firstOfMonth)); ?>" style="font-size:18px;margin-left:3px;margin-top:-4px;color:#006699;float:left;display:block">&laquo;</a><h5 id="mTitle" title="<?php echo date("F ",mktime(0,0,0,$m,1,$y)).$y; ?>" style="margin:0px;cursor:pointer"><?php echo date("F ",mktime(0,0,0,$m,1,$y)).$y; ?></h5></td></tr>
<tr><?php $days="SMTWTFS"; for ($x=0;$x<7;$x++) { ?><td class="calendarHeader" style="text-align:right"><?php echo substr($days,$x,1); ?></td><?php } ?></tr>
<tr style="height:1px;background-color:#006699"><td colspan="7"></td></tr>
<tr>
<?php for ($x=1;$x<$startDay;$x++) { ?>
<td></td>
<?php } ?>
<?php for ($x=$startDay;$x<$startDay+31;$x++) { ?>
<td style="text-align:right" class="<?php 
// past dates
$thisDay=date("Y-m-d",mktime(0,0,0,$m,$x-$startDay+1,$y));
if ($thisDay<$today) { 
	echo "prevDay";
} elseif ($thisDay==$today) { 
	echo "toDay";
} else {
	echo "otherDay";
} ?> clickableCell" id="<?php echo date("d|m|Y",strtotime($thisDay));?>">
<?php echo $x-$startDay+1; ?>
</td>
<?php if (($x%7)==0) { ?>
</tr><tr>
<?php } 
	if (date("m",mktime(0,0,0,$m,$x-$startDay+2,$y))!=$m) break;
 } ?>
</tr>
<?php
if (isset($_GET["direct"])) echo "</table>";
?>