<?php
/**
 * Управление фотогалерей
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01.01	30.06.2009
 */
if(!defined("SHIFTCMS")) exit;
$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=gallery_manage'>".$lang_ar['gal_title']."</a> : <a href='admin.php?p=galphoto_packet'>".$lang_ar['agal_packet']."</a></h2>");
$smarty -> assign("modSet", "gallery");

echo "<div id='FormGalleryArea'>";
	$mainact="MainForm";
	include "module/gallery/gallery_act.php";
echo "</div>";

echo "<div id='EditGalleryArea' style='border:dotted 1px #cccccc;'></div>";

echo "<div id='ManageGalleryArea'></div>";

	$HEADER = '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/ui.datetimepicker.js"></script>
	<link rel="stylesheet" href="'.$_conf['www_patch'].'/js/jquery/themes/green/dark.datetimepicker.css" type="text/css">

	<script type="text/javascript">
		function doLoadGPhoto(formID,PhotoAreaID){
		document.getElementById("ARC").style.display="block";
		document.getElementById("ActionRes").innerHTML =\'<img src="/js/img/loader.gif" style="vertical-align:middle;" /> <span style="color:blue;">Загрузка фото...</span>\';
	    JsHttpRequest.query(
	        "loader.php",
	        {
	             "form": document.getElementById(formID)
	        },
	        function(result, errors){
	                //alert(errors); 
	                if(result){
						if(result["state"] == "ERROR"){
							document.getElementById("ActionRes").innerHTML = result["msg"]; 
						}else{
							document.getElementById("ActionRes").innerHTML = result["msg"]; 
							$("#"+PhotoAreaID).prepend(result["photo"]);
						}
	                }else alert("error");
	        },
	        true  // do not disable caching
	    );
	}
	</script>
	';

?>
