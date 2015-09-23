<?php
/**
 * Управление фотогалерей
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.02.02	30.06.2009
 02.08.2009 - Додано поле для сортування фото по вказаному порядку від меньшого значення до більшого
 */
if(!defined("SHIFTCMS")) exit;

/* Форма додавання нової галереї */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="AddGallery"){
	$fl = GetLangField();
	echo "<div class='block'>
	<form action='javascript:void(null)' id='AddGalleryForm' enctype='multipart/form-data'>
	<input type='hidden' name='p' value='gallery_act' />
	<input type='hidden' name='act' value='SaveNewGallery' />
	<br />".$lang_ar['agal_date'].": <input type='text' id='date' name='date' value='".date("d.m.Y", time())."' size='18' class='datetextbox' readonly='readonly' /><br />";
	echo '<div id="tabs">';
	echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';
			echo $lang_ar['agal_name'].":<br />
			<input type='text' name='name_".$k."' id='name_".$k."' value='' style='width:400px;' /><br />
			".$lang_ar['agal_desc'].":<br />
			<textarea name='opis_".$k."' id='opis_".$k."' style='width:400px;height:100px;'></textarea>";
		echo '</div>';
		$i++;
	}
	echo "</div><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' value='".$lang_ar['create']."' onclick=\"doLoad('AddGalleryForm','FormGalleryArea');\" />
	<input type='button' value='".$lang_ar['save']."' onclick=\"document.getElementById('EditGalleryArea').innerHTML='';\" />
	</form>
	</div>";
	echo '
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	<script type="text/javascript">
	$(function() {
		$("#date").datetimepicker({
			dateFormat: "dd.mm.yy",
			timeFormat: "hh:ii",
		});
	});
	</script>
	';
}


/* Зберігаємо нову галерею */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="SaveNewGallery"){
	$fl = GetLangField();
	$keys = $vals = '';
	while(list($k,$v)=each($fl)){
		$keys .= ",name_".$k.",opis_".$k;
		$vals .= ",'".mysql_real_escape_string(stripslashes($_REQUEST['name_'.$k]))."','".mysql_real_escape_string(stripslashes($_REQUEST['opis_'.$k]))."'";
	}
	$q="INSERT INTO ".$_conf['prefix']."galleries (date".$keys.") VALUES ('".strtotime($_REQUEST['date'])."'".$vals.")";
	$rs = $db -> Execute($q);
	echo msg_box($lang_ar['agal_added']);
	$mainact="MainForm";
}

/* Зберігаємо порядок сортування */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="ChOrder"){
	//print_r($_REQUEST);
	$g_order = (int)$_REQUEST['g_order'];
	$q="UPDATE ".$_conf['prefix']."gal_photos SET g_order='$g_order' WHERE idp='$_REQUEST[idp]'";
	$rs = $db -> Execute($q);
	//$mainact="MainForm";
}

/* Форма додавання нової галереї */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="EditGallery"){
	$q="SELECT * FROM ".$_conf['prefix']."galleries WHERE ids='".(int)$_REQUEST['ids']."'";
	$rs = $db -> Execute($q);
	$t = $rs -> GetRowAssoc(false);

	$fl = GetLangField();
	echo "<div class='block'>
	<form action='javascript:void(null)' id='EditGalleryForm' enctype='multipart/form-data'>
	<input type='hidden' name='p' value='gallery_act' />
	<input type='hidden' name='act' value='UpdateGallery' />
	<input type='hidden' name='ids' value='".(int)$_REQUEST['ids']."' />
	<br />".$lang_ar['agal_date'].": <input type='text' id='date' name='date' value='".date("d.m.Y", $t['date'])."' size='18' class='datetextbox' readonly='readonly' /><br />";
	echo '<div id="tabs">';
	echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';
			echo $lang_ar['agal_name'].":<br />
			<input type='text' name='name_".$k."' id='name_".$k."' value=\"".htmlspecialchars(stripslashes($t['name_'.$k]))."\" style='width:400px;' /><br />
			".$lang_ar['agal_desc'].":<br />
			<textarea name='opis_".$k."' id='opis_".$k."' style='width:400px;height:100px;'>".htmlspecialchars(stripslashes($t['opis_'.$k]))."</textarea>";
		echo '</div>';
		$i++;
	}
	echo "</div><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type='button' value='".$lang_ar['save']."' onclick=\"doLoad('EditGalleryForm','FormGalleryArea');\" />
	<input type='button' value='".$lang_ar['cancel']."' onclick=\"document.getElementById('EditGalleryArea').innerHTML='';\" />
	</form>
	</div>";
	echo '
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	<script type="text/javascript">
	$(function() {
		$("#date").datetimepicker({
			dateFormat: "dd.mm.yy",
			timeFormat: "hh:ii",
		});
	});
	</script>
	';
}


/* Оновлюємо галерею */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="UpdateGallery"){
	$fl = GetLangField();
	$vals = '';
	while(list($k,$v)=each($fl)){
		$vals .= ",name_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['name_'.$k]))."',opis_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['opis_'.$k]))."'";
	}
	$q="UPDATE ".$_conf['prefix']."galleries SET ids='".(int)$_REQUEST['ids']."'".$vals." WHERE ids='".$_REQUEST['ids']."'";
	$rs = $db -> Execute($q);
	echo msg_box($lang_ar['agal_updated']);
	$mainact="MainForm";
}


/* Видаляємо галерею */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="DeleteGallery"){
	$data=SecureRequest($_REQUEST);
	$q="DELETE FROM ".$_conf['prefix']."galleries WHERE ids='".(int)$_REQUEST['ids']."'";
	$rs = $db -> Execute($q);
	$q="select * from ".$_conf['prefix']."gal_photos WHERE ids='".(int)$_REQUEST['ids']."'";
	$rs = $db -> Execute($q);
	while(!$rs -> EOF){
		$tmp = $rs -> GetRowAssoc();
		@unlink($_conf['gal_thumb_patch']."/".$tmp['IDP'].".jpg");
		@unlink($_conf['gal_photo_patch']."/".$tmp['IDP'].".jpg");
		$rs -> MoveNext();
	}
	$q="DELETE FROM ".$_conf['prefix']."gal_photos WHERE ids='".(int)$_REQUEST['ids']."'";
	$rs = $db -> Execute($q);
	echo msg_box($lang_ar['agal_galdeleted']);
	$mainact="MainForm";
}


/* Управління фотографіями галереї */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="ManagePhoto"){

	echo "<div class='block'>
	<form enctype='multipart/form-data' id='LoadPhotoForm' action='javascript:void(null)'>
	<table border='0'><tr><td valign='top'>
	".$lang_ar['agal_uplphoto'].":<br />";
	//<input type='file' name='file' size='30' />
	echo '<input type="file" class="uploadinputbutton" maxsize="2097152" name="file[]" onchange="add_file(\'file\', 1);" /><br />
	<span id="file_1"><input type="button" value="Додати інший" onclick="add_file(\'file\', 1);" /></span><br />';
	echo "<input type='hidden' name='p' id='p' value='gallery_act' />
	<input type='hidden' name='act' id='act' value='UploadPhoto' />
	<input type='hidden' name='ids' id='ids' value='".(int)$_REQUEST['ids']."' /><br />
	<input type='checkbox' name='crop' value='yes' checked='checked' onclick=\"if(this.checked==false) document.getElementById('CropSelect').style.display='none'; else document.getElementById('CropSelect').style.display='block';\" /> ".$lang_ar['agal_crophint']." ".$_conf['gal_thumb_w']." x ".$_conf['gal_thumb_h']."<br />
	<div id='CropSelect' style='display:block;'>
		".$lang_ar['agal_crop']."
		<input type='radio' name='whatcrop' value='top' /> ".$lang_ar['agal_topcrop']."
		<input type='radio' name='whatcrop' value='center' checked='checked' /> ".$lang_ar['agal_centrcrop']."
		<input type='radio' name='whatcrop' value='bottom' /> ".$lang_ar['agal_botcrop']."
	</div>
	<br /><br /><br /><br />
	<input type='button' onclick=\"doLoadGPhoto('LoadPhotoForm','PhotoArea');\" value='".$lang_ar['upload']."' />";
	echo '</td><td valign="top">';
	$fl = GetLangField();
	echo '<div id="tabs">';
	echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>'; $i++;}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';
			echo $lang_ar['agal_comment'].":<br />
			<textarea name='comments_".$k."' id='comments_".$k."' cols='40' rows='3'></textarea>";
		echo '</div>';
		$i++;
	}
	echo "</div>	
	</form>";
	echo '
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	';
	echo '</td></tr></table>';
	echo "</div>";
	/* out all photos from gallery */
	echo "<div id='PhotoArea' class='blockf'>";
	$photos=GetPhotos($_REQUEST['ids']);
	echo $photos;
	echo "</div>";
	echo "<div style='clear:both;'></div>";
}

/* Вивід фото */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="OutPhoto"){
	$photos=GetPhotos($_REQUEST['ids']);
	echo $photos;
}


/* Прийом і обробка фото */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="UploadPhoto"){
	$js = array();
	$js['state'] = "OK";
	$js['msg'] = '';
	$js['photo'] = '';
	$dw = $_conf['gal_thumb_w'] + 30; $dw = $dw."px";
	include "include/uploader.php";
	$upl = new uploader;
	if(!file_exists($_conf['gal_thumb_patch'])) $upl -> MakeDir($_conf['gal_thumb_patch']);
	if(!file_exists($_conf['gal_photo_patch'])) $upl -> MakeDir($_conf['gal_photo_patch']);
	
	include "include/imager.php";
	$img = new imager;
	$farr = $img->ConvertFileArray("file");
	
	for($i=0;$i<count($farr);$i++){
		$idp = time();
		$img = new imager;
		$width = array($_conf['gal_thumb_w'], $_conf['gal_photo_w']);
		$height = array($_conf['gal_thumb_h'], $_conf['gal_photo_h']);
		$name = array($_conf['gal_thumb_patch']."/".$idp.".jpg", $_conf['gal_photo_patch']."/".$idp.".jpg");
		$img -> width = $width;
		$img -> height = $height;
		$img -> fname = $name;
		if(isset($_REQUEST['crop']) && $_REQUEST['crop']=="yes") $img -> crop = array("yes","");
		else $img -> crop = array("","");
		if(isset($_REQUEST['whatcrop'])) $img -> whatcrop = array($_REQUEST['whatcrop'],"");
		else $img -> whatcrop = array("","");
		$img -> desttype = array("thumb","photo");
		$img -> sign = array("","");
		$res = $img -> ResizeImage($farr[$i]);
		if($res == 1){
			$fl = GetLangField();
			$keys = $vals = '';
			while(list($k,$v)=each($fl)){
				$keys .= ",comments_".$k;
				$vals .= ",'".mysql_real_escape_string(stripslashes($_REQUEST['comments_'.$k]))."'";
			}
			$q="INSERT INTO ".$_conf['prefix']."gal_photos (idp,ids,date".$keys.")VALUES('".$idp."', '".(int)$_REQUEST['ids']."','".time()."'".$vals.")";
			$rs = $db -> Execute($q);
			//echo msg_box($lang_ar['agal_uploaded']);
			$js['msg'] .= msg_box($lang_ar['agal_uploaded']);
			if(trim($_REQUEST['comments_'.$_SESSION['admin_lang']])=="") $_REQUEST['comments_'.$_SESSION['admin_lang']]="без комментариев";
			$photo = "<div id='PHOTO".$idp."' style='float:left;padding:5px;border:solid 1px #cccccc; background:#eeeeee; margin:5px;width:".$dw.";'>
			<table border='0' width='100%'><tr><td><a href='javascript:void(null)' onclick=\"getdata('','get','?p=gallery_act&idp=".$idp."&act=DeletePhoto&ids=".$_REQUEST['ids']."','ActionRes');delelem('PHOTO".$idp."')\">".$lang_ar['delete']."</a></td>
			<td align='right'>№<input type='text' name='g_order".$idp."' id='g_order".$idp."' style='width:30px;' value='0' onkeyup=\"getdata('','post','?p=gallery_act&idp=".$idp."&act=ChOrder&g_order='+document.getElementById('g_order".$idp."').value,'ChOrderRes".$idp."')\" /><span id='ChOrderRes".$idp."'></span></td></tr></table>
			<a href='admin.php?p=gallery_act&act=ShowBigPhoto&idp=".$idp."&oldact=ManagePhoto&ids=".$_REQUEST['ids']."' ><img src='".$_conf['gal_thumb_patch']."/".$idp.".jpg' width='".$_conf['gal_thumb_w']."' height='".$_conf['gal_thumb_h']."' alt='".$lang_ar['agal_viewedit']."' /></a><br />
			".$_REQUEST['comments_'.$_SESSION['admin_lang']]."<br />
			<small>".$lang_ar['agal_comtitle'].": 0</small>
			</div>";
			$js['photo'] .= $photo;
		}else{
			//echo msg_box($res);
			$js['msg'] .= msg_box($res);
		}
		sleep(1);
	}//for
	//$photos=GetPhotos($_REQUEST['ids']);
	//echo $photos;
	$GLOBALS['_RESULT'] = $js;
}

/* видалення фото */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="DeletePhoto"){
	if(file_exists($_conf['gal_thumb_patch']."/".$_REQUEST['idp'].".jpg")) @unlink($_conf['gal_thumb_patch']."/".$_REQUEST['idp'].".jpg");
	if(file_exists($_conf['gal_photo_patch']."/".$_REQUEST['idp'].".jpg")) @unlink($_conf['gal_photo_patch']."/".$_REQUEST['idp'].".jpg");
		$q="DELETE FROM ".$_conf['prefix']."gal_photos WHERE idp='$_REQUEST[idp]'";
		$rs = $db -> Execute($q);
		echo msg_box($lang_ar['agal_photodeleted']);
	//$photos=GetPhotos($_REQUEST['ids']);
	//echo $photos;
}



/* Зберігаємо нову галерею */
if(isset($mainact) && $mainact=="MainForm"){
/**
*  Автоматическое создание разделов галереи на основании разделов текстовых страниц
*/
/*
$q="select * from ".$_conf['prefix']."info_".$_SESSION['lang']." WHERE parent_idi=0 AND siteshow='yes' AND menushow='yes' order by link_pos";
$rs = $db -> Execute($q);
while(!$rs -> EOF){
	$t = $rs -> GetRowAssoc();
	$rc = $db -> Execute("SELECT * FROM ".$_conf['prefix']."galleries WHERE idi='$t[IDI]'");
	$tmp = $rc -> GetRowAssoc();
	if($rc -> RecordCount() == 0){
		$ri = $db -> Execute("INSERT INTO ".$_conf['prefix']."galleries (name, opis, date, idi)VALUES
		('$t[LINKNAME]', '$t[P_TITLE]', '".time()."', '$t[IDI]')");
	}else{
		$ri = $db -> Execute("UPDATE ".$_conf['prefix']."galleries SET 
		name='$t[LINKNAME]', opis='$t[P_TITLE]' WHERE idi='$t[IDI]'");
	}
	$rs -> MoveNext();
}
*/
	echo '<div style="display:none" id="ViewPhotoBox">
	<img src="tmpl/lite/adm_img/binary.png" style="float: left; margin-right: 10px;" name="thumbnail" id="thumbnail" alt="Create Thumbnail" />
	<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:100px; height:100px;">
	<img src="tmpl/lite/adm_img/binary.png" style="position: relative;" alt="Thumbnail Preview" />
			</div>
			<br style="clear:both;"/>
			<form id="thumbForm" name="thumbForm" action="javascript:void(null)" method="post" enctype="multipart/form-data">
				<input type="hidden" name="p" value="gallery_act" id="p" />
				<input type="hidden" name="act" value="CreateThumbnail" id="act" />
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
				<input type="button" name="upload_thumbnail" value="'.$lang_ar['save'].'" id="save_thumb" onclick="doLoad(\'thumbForm\',\'WorkAreaThumb\')" />
			</form>
		</div>';

$gal_list="<select id='ids' name='ids'>";
$q="select * from ".$_conf['prefix']."galleries order by name_".$_SESSION['admin_lang']."";
$rs = $db -> Execute($q);
while(!$rs -> EOF){
	$tmp = $rs -> GetRowAssoc();
	$gal_list.="<option value='".$tmp['IDS']."'>".$tmp['IDS'].": ".stripslashes($tmp['NAME_'.strtoupper($_SESSION['admin_lang'])])."</option>";
	$rs -> MoveNext();
}
$gal_list.="</select>";
echo "<div class='block'>
<form action='javascript:void(null)' id='GalleryForm' enctype='multipart/form-data'>
<input type='hidden' name='p' value='gallery_act' />
<input type='hidden' name='act' value='EditGallery' />
<input type='button' value='".$lang_ar['agal_galcreate']."' onclick=\"document.getElementById('ManageGalleryArea').innerHTML='';document.getElementById('EditGalleryArea').style.display='block';getdata('','get','?p=gallery_act&act=AddGallery','EditGalleryArea');\" />
&nbsp;&nbsp;&nbsp;&nbsp;
".$lang_ar['agal_gallist'].": ".$gal_list."
<input type='button' value='".$lang_ar['agal_editphoto']."' onclick=\"document.getElementById('EditGalleryArea').innerHTML='';document.getElementById('ManageGalleryArea').style.display='block';getdata('','get','?p=gallery_act&act=ManagePhoto&ids='+document.getElementById('ids').value,'ManageGalleryArea');\" />
<input type='button' value='".$lang_ar['agal_galedit']."' onclick=\"document.getElementById('EditGalleryArea').style.display='block';document.getElementById('ManageGalleryArea').innerHTML='';getdata('','get','?p=gallery_act&act=EditGallery&ids='+document.getElementById('ids').value,'EditGalleryArea');\" />
<input type='button' value='".$lang_ar['agal_galdel']."' onclick=\"document.getElementById('ManageGalleryArea').innerHTML='';document.getElementById('EditGalleryArea').style.display='none';getdata('','get','?p=gallery_act&act=DeleteGallery&ids='+document.getElementById('ids').value,'FormGalleryArea');\" />
<strong><a href='admin.php?p=galphoto_packet'>".$lang_ar['agal_packet']."</a></strong>
</form>
</div>";

}

/* відміна збереження коментарів до фото */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="ShowBigPhoto"){
	if(isset($_REQUEST['nact']) && $_REQUEST['nact']=="delcom"){
		$rc = $db -> Execute("DELETE FROM ".$_conf['prefix']."comments WHERE id='$_REQUEST[idc]'");
		echo msg_box($lang_ar['agal_commdeleted']);
	}
/* ****************** */
	$smarty -> assign("PAGETITLE","<h2>".$lang_ar['agal_editphoto']."</h2>");

	$rs = $db -> Execute("select * from ".$_conf['prefix']."gal_photos WHERE idp='".(int)$_REQUEST['idp']."'");
	$t = $rs -> GetRowAssoc(false);

	$current_large_image_width = getWidth($_conf['gal_photo_patch']."/".$_REQUEST['idp'].".jpg");
	$current_large_image_height = getHeight($_conf['gal_photo_patch']."/".$_REQUEST['idp'].".jpg");
	$proportion = $_conf['gal_thumb_w']/$_conf['gal_thumb_h'];
$HEADER = '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/external/jquery.imgareaselect.min.js"></script>
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript">
function preview(img, selection) { 
	var scaleX = '.$_conf['gal_thumb_w'].' / selection.width; 
	var scaleY = '.$_conf['gal_thumb_h'].' / selection.height; 
	$("#thumbnail + div > img").css({ 
		width: Math.round(scaleX * '.$current_large_image_width.') + "px", 
		height: Math.round(scaleY * '.$current_large_image_height.') + "px",
		marginLeft: "-" + Math.round(scaleX * selection.x1) + "px", 
		marginTop: "-" + Math.round(scaleY * selection.y1) + "px"
	});
	$("#x1").val(selection.x1);
	$("#y1").val(selection.y1);
	$("#x2").val(selection.x2);
	$("#y2").val(selection.y2);
	$("#w").val(selection.width);
	$("#h").val(selection.height);
} 
$(document).ready(function () { 
	$("#save_thumb").click(function() {
		var x1 = $("#x1").val();
		var y1 = $("#y1").val();
		var x2 = $("#x2").val();
		var y2 = $("#y2").val();
		var w = $("#w").val();
		var h = $("#h").val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("'.$lang_ar['agal_warn1'].'");
			return false;
		}else{
			doLoad("thumbForm","WorkAreaThumb")
			return true;
		}
	});
}); 
$(window).load(function () { 
	$("#thumbnail").imgAreaSelect({ aspectRatio: "1:'.$proportion.'", minWidth: '.$_conf['gal_thumb_w'].', minHeight: '.$_conf['gal_thumb_h'].', onSelectChange: preview }); 
});
</script>
';	
	$smarty -> assign("HEADER", $HEADER);
	$th_h = $_conf['gal_thumb_h']+40;
	echo '<a href="admin.php?p=gallery_manage"><strong>'.$lang_ar['agal_back'].'</strong></a><br /><br />';
	echo '<div align="center">
	<p align="left">'.$lang_ar['agal_warn2'].'</p>
	<img src="'.$_conf['gal_photo_patch'].'/'.$_REQUEST['idp'].'.jpg" style="float: left; margin-right: 10px;" name="thumbnail" id="thumbnail" alt="Create Thumbnail" />
	
	<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:'.$_conf['gal_thumb_w'].'px; height:'.$_conf['gal_thumb_h'].'px;">
	<img src="'.$_conf['gal_photo_patch'].'/'.$_REQUEST['idp'].'.jpg" style="position: relative;" alt="Thumbnail Preview" />
	</div>
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<div id="WorkAreaThumb" style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:'.$_conf['gal_thumb_w'].'px; height:'.$th_h.'px;">
	<img src="'.$_conf['gal_thumb_patch'].'/'.$_REQUEST['idp'].'.jpg" style="position: relative;" alt="Current thumbnail" />
	</div>

			<br style="clear:both;"/>
			<form id="thumbForm" name="thumbForm" action="javascript:void(null)" method="post" enctype="multipart/form-data">
				<input type="hidden" name="p" value="gallery_act" id="p" />
				<input type="hidden" name="act" value="CreateThumbnail" id="act" />
				<input type="hidden" name="idp" id="idp" value="'.$_REQUEST['idp'].'" />
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
		</div>';
		$fl = GetLangField();
		echo '<div id="tabs">';
		echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>'; $i++;}
		echo '</ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<div id="tabs-'.$i.'">';
				echo $lang_ar['agal_comment'].":<br />
				<textarea name='comments_".$k."' id='comments_".$k."' cols='40' rows='3'>".htmlspecialchars(stripslashes($t['comments_'.$k]))."</textarea>";
			echo '</div>';
			$i++;
		}
		echo "</div><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type=\"button\" name=\"upload_thumbnail\" value=\"".$alang_ar['save']."\" id=\"save_thumb\" style='width:200px;' />
		</form>";
		echo "</div>";
		echo '
		<script type="text/javascript">
		$(function(){
			$("#tabs").tabs();
		});
		</script>
		';


/**
* Комментарии к новости
*/
/*
			echo "<br /><hr /><h3>Комментарии</h3><br />";
			$cominterval=20;
			if(!isset($_REQUEST['comstart'])) $comstart=0;
			else $comstart=$_REQUEST['comstart'];
			$q = $_conf['prefix']."comments LEFT JOIN ".$_conf['prefix']."users USING(idu) WHERE service='gallery' AND id_item=".$_REQUEST['idp']." ORDER BY date";
			$rc = $db -> Execute("SELECT * FROM ".$q." LIMIT $comstart, $cominterval");
			$rc1 = $db -> Execute("SELECT count(*) FROM ".$q);
			$tc1 = $rc1 -> GetRowAssoc(false);
			$comlist_page=GetPaging($tc1['count(*)'],$cominterval,$comstart,"admin.php?p=gallery_act&act=ShowBigPhoto&idp=$_REQUEST[idp]&oldact=ManagePhoto&ids=$_REQUEST[ids]&comstart=$comstart");
			$smarty -> assign("paging",$comlist_page);
			$comlistpage = $smarty -> fetch("db:paging.tpl");
			echo $comlistpage;
			while (!$rc->EOF) { 
				$tc = $rc -> GetRowAssoc(false);
				echo "
				<strong>".stripslashes($tc['login'])."</strong> | <small>".date("d.m.Y H:i",$tc['date'])."</small>&nbsp;&nbsp;&nbsp;
				<a href='admin.php?p=gallery_act&act=ShowBigPhoto&idp=$_REQUEST[idp]&oldact=ManagePhoto&ids=$_REQUEST[ids]&comstart=$comstart&nact=delcom&idc=$tc[id]'>Удалить</a>&nbsp;&nbsp;&nbsp;
				<!--<a href=''>Редактировать</a>-->
				<br />
				".stripslashes($tc['comtext'])."<br />";
				$rc->MoveNext(); 
			}
			echo $comlistpage;
*/			
//-----------------------------------------

		
}

/* створення превю фото по видыленому фрагменту */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="CreateThumbnail"){
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
	//Scale the image to the thumb_width set above
	require_once("include/imager.php");
	$imager = new imager;
	$scale = $_conf['gal_thumb_w']/$w;
	$thumb_image_location = $_conf['gal_thumb_patch'].'/'.$_REQUEST['idp'].'.jpg';
	$large_image_location = $_conf['gal_photo_patch'].'/'.$_REQUEST['idp'].'.jpg';
	$cropped = $imager -> resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);
	echo '<img src="'.$cropped.'?'.time().'" style="position: relative;" alt="Current thumbnail" />';

	$fl = GetLangField();
	$vals = '';
	while(list($k,$v)=each($fl)){
		$vals .= ",comments_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['comments_'.$k]))."'";
	}
	$q="UPDATE ".$_conf['prefix']."gal_photos SET idp='".(int)$_REQUEST['idp']."'".$vals." WHERE idp='".$_REQUEST['idp']."'";
	$rs = $db -> Execute($q);
	echo msg_box($lang_ar['agal_saved']);
}


/* FUNCTION */
function GetPhotos($ids){
global $_conf,$db,$smarty,$lang_ar;
	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];
	$interval = 100;//$_conf['thumb_col']*$_conf['thumb_row'];
	$q="select COUNT(*) from ".$_conf['prefix']."gal_photos WHERE ids='".$ids."'";
	$rs = $db -> Execute($q);
	$t = $rs -> GetRowAssoc();
	$all = $t['COUNT(*)'];

	$q="select *, (select count(*) from ".$_conf['prefix']."comments where service='gallery' AND id_item=idp) as comtext from ".$_conf['prefix']."gal_photos WHERE ids='".$ids."' ORDER BY g_order,idp DESC LIMIT ".$start.",".$interval;
	$rs = $db -> Execute($q);
	$photos='';
	$items=0;
	$dw=$_conf['gal_thumb_w'] + 30; $dw=$dw."px";
	$pagelist=Paging($all,$interval,$start,"javascript:void(null)","onclick=\"getdata('','get','?p=gallery_act&act=OutPhoto&ids=".$ids."&start=%start1%','PhotoArea')\"");
	$photos.=$pagelist;
	while(!$rs -> EOF){
		$tmp = ClearSleshes($rs -> GetRowAssoc());
		if(trim($tmp['COMMENTS_'.strtoupper($_SESSION['admin_lang'])])=="") $tmp['COMMENTS_'.strtoupper($_SESSION['admin_lang'])]="без комментариев";
		$photos.="<div id='PHOTO".$tmp['IDP']."' style='float:left;padding:5px;border:solid 1px #cccccc; background:#eeeeee; margin:5px;width:".$dw.";'>
		<table border='0' width='100%'><tr><td><a href='javascript:void(null)' onclick=\"getdata('','get','?p=gallery_act&idp=".$tmp['IDP']."&act=DeletePhoto&ids=".$ids."&start=".$start."','ActionRes');delelem('PHOTO".$tmp['IDP']."');\">".$lang_ar['delete']."</a></td>
		<td align='right'>№<input type='text' name='g_order".$tmp['IDP']."' id='g_order".$tmp['IDP']."' style='width:30px;' value='".$tmp['G_ORDER']."' onkeyup=\"getdata('','post','?p=gallery_act&idp=".$tmp['IDP']."&act=ChOrder&g_order='+document.getElementById('g_order".$tmp['IDP']."').value,'ChOrderRes".$tmp['IDP']."')\" /><span id='ChOrderRes".$tmp['IDP']."'></span></td></tr></table>
		<a href='admin.php?p=gallery_act&act=ShowBigPhoto&idp=".$tmp['IDP']."&oldact=ManagePhoto&ids=".$ids."' ><img src='".$_conf['gal_thumb_patch']."/".$tmp['IDP'].".jpg' width='".$_conf['gal_thumb_w']."' height='".$_conf['gal_thumb_h']."' alt='".$lang_ar['agal_viewedit']."' /></a><br />
		".$tmp['COMMENTS_'.strtoupper($_SESSION['admin_lang'])]."<br />
		<small>".$lang_ar['agal_comtitle'].": ".$tmp['COMTEXT']."</small>
		</div>";
		$items++;
		/*
		if($items==5){
			$items=0;
			$photos.="<div style='clear:both;'></div>";
		}
		*/	
		$rs -> MoveNext();
	}
	$photos.="<div style='clear:both;'></div>".$pagelist;
return $photos;
}


//You do not need to alter these functions
function getHeight($image) {
	$size = getimagesize($image);
	$height = $size[1];
	return $height;
}
//You do not need to alter these functions
function getWidth($image) {
	$size = getimagesize($image);
	$width = $size[0];
	return $width;
}
?>