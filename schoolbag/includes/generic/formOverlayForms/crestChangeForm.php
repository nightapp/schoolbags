<div class="subHeading" style="width:100%">Change Crest</div><br />
<form id="pictureChangeForm" action="<?php echo $_SERVER['HTTP_REFERER'];?>" enctype="multipart/form-data" method="post" class="formInOverlay" style="margin:5px;">
<label>New Image:</label><input type="file" id="fileData" name="fileData" /><br /><br />
<input type="hidden" name="fileName" value="crest.jpg" />
<input type="submit" value="Change Image &raquo;" />
</form>