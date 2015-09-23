<form enctype="multipart/form-data" id="LoadPhoto" action="javascript:void(null)">
<?php
echo $lang_ar['anews_loadimg'];
?>
:<br />
<input type="file" name="file" size="30" />
<input type="hidden" name="p" value="getphoto" />
<input type="hidden" name="act" value="upload_photo" />
<input type="hidden" name="idn" value="<?php echo $next_idn; ?>" />
<input type="button" onclick="doLoad('LoadPhoto','loadphotores');" value="<?php echo $lang_ar['upload'];?>" />
</form>