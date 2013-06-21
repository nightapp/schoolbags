<?php 
$add="";
if($upOneLevel){ $add="../"; }?>
<script src="<?php echo $add;?>scripts/vmenu.js"></script>
<link rel="stylesheet" href="<?php echo $add;?>vmenu.css" type="text/css" />

<div class="vmenu formOverlayNoHide" id="vmenu">
<div style="clear:both;width:100%;height:28px;display:block;"></div>
	<div class="first_li">
			<span>Change Address</span> 
	</div>
	<div class="first_li">
			<span>Change Password</span>
	</div>
	<div class="first_li">
			<span>Change Email</span>
	</div>
	<div class="first_li">
			<span>Change Crest</span>
	</div>
	<div class="first_li">
			<span>Change Policies</span>
	</div>
	<div class="first_li">
			<span>Change Map</span>
	</div>
		<?php include("includes/generic/schoolLinks.php");?>
	<div class="first_li">
		<span>Log Out</span>
	</div>	
</div>