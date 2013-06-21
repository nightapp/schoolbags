<script src="<?php echo $add;?>scripts/vmenu.js"></script>
<link rel="stylesheet" href="<?php echo $add;?>vmenu.css" type="text/css" />

<div class="vmenu formOverlayNoHide" id="vmenu">
<div style="clear:both;width:100%;height:28px;display:block;"></div>
	<div class="first_li"><span>Edit Profile &raquo;</span>
		<div class="inner_li">
			<span>Change Picture</span> 
			<span>Change Password</span>
			<span>Change Email</span>
		</div>
	</div>
	<div class="first_li"><span>Join Classes</span></div>
	<div class="first_li">
				<span>List of Teachers</span>
	</div>
<?php if(isset($_SESSION["actualUserType"]) && $_SESSION["actualUserType"]=="T"){?>
		<div class="first_li">
			<span>Back to teacher</span>
		</div>
<?php }?> 
	<?php if(!isset($_SESSION["schoolLinks"])){ include("includes/generic/schoolLinks.php");} else {echo $_SESSION["schoolLinks"];}?>
		<div class="first_li">
			<span>Log Out</span>
		</div>
	
</div>