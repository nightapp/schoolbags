<div class="subHeading" style="width:100%">Change Policies</div><br />
<form id="mapChangeForm" action="<?php echo $_SERVER['HTTP_REFERER'];?>" enctype="multipart/form-data" method="post" class="formInOverlay" style="margin:5px;">
<label>New Policies:</label><input type="file" id="fileData" name="fileData" /><br /><br />
<input type="hidden" name="fileName" value="policies.pdf" />
<input type="submit" value="Change Policies &raquo;" />
</form>