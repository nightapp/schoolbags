<?php 
$add="";
if(!isset($upOneLevel)) $upOneLevel=false;
if($upOneLevel){ $add="../"; }?>
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
	<div class="first_li">
				<span>Edit Subjects</span>
	</div>
	<div class="first_li">
				<span>Create Class</span>
	</div>
	<div class="first_li">
				<span>Edit Class</span>
	</div>
	<?php 
//	if(date("n")==8 || (date("n")==9 && date("j")<10)){
	?>
	<div class="first_li">
				<span>Delete Class</span>
	</div>
	<?php //  } ?>
	<div class="first_li">
				<span>List of Teachers</span>
	</div>
	<div class="first_li">
				<span>Select Friends</span>
	</div>
	<div class="first_li">
				<span>Roll Call</span>
	</div>
	<?php if(isset($_SESSION["schUserType"]) && $_SESSION["schUserType"]=="S"){?>
		<div class="first_li">
			<span>Back to school</span>
		</div>
<?php }?> 

	<?php if(!isset($_SESSION["schoolLinks"])){ include("includes/generic/schoolLinks.php");} else {echo $_SESSION["schoolLinks"];}?>
		<div class="first_li">
			<span>Log Out</span>
		</div>
	
</div>