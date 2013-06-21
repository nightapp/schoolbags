<div class="subHeading" style="width:100%">Change Map</div><br />
<form id="mapChangeForm" action="<?php echo $_SERVER['HTTP_REFERER'];?>" enctype="multipart/form-data" method="post" class="formInOverlay" style="margin:5px;">
<label>New Map:</label><input type="file" id="fileData" name="fileData" /><br /><br />
<input type="hidden" name="fileName" value="map.jpg" />
<input type="submit" value="Change Map &raquo;" />
</form>