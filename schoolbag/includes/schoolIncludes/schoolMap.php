<div class="middleDiv" style="text-align:center"><?php 
$mapPath=$schoolPath."S/map.jpg";
if(file_exists($schoolPath."S/map.jpg")){
?>
<a href="<?php echo $mapPath;?>"><img src="<?php echo $mapPath;?>" /></a><?php
} else {
echo "<p>No Map Could be found</p>";
}?>
</div>