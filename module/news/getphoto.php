<?php
/**
 * Дополнительные функции к управлению новостями
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */

if(isset($_REQUEST['act']) && $_REQUEST['act']=="upload_photo"){
	include "include/imager.php";
	$img = new imager;
		$img -> crop = array("");
		$img -> whatcrop = array("");
		$img -> desttype = array("thumb");
	$width = array($_conf['nthumb_w']);
	$height = array($_conf['nthumb_h']);
	$name = array("files/newsanons/".$_REQUEST['idn'].".jpg");
	$img -> width = $width;
	$img -> height = $height;
	$img -> fname = $name;
	$res = $img -> ResizeImage($_FILES['file']);
	if($res == 1){
		$smarty->assign("info_message",$lang_ar['anews_imgloaded']."<br /><img src='".$name[0]."?".time()."' alt='' /><br />");
		echo $smarty->fetch("db:messeg.tpl");
	}else{
		$smarty->assign("info_message",$res);
		echo $smarty->fetch("db:messeg.tpl");
	}
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="delete_photo"){
	if(file_exists("files/newsanons/".$_REQUEST['idn'].".jpg")){
		@unlink("files/newsanons/".$_REQUEST['idn'].".jpg");
		$smarty->assign("info_message",$lang_ar['anews_imgdeleted']);
		echo $smarty->fetch("db:messeg.tpl");
	}else{
		$smarty->assign("info_message",$lang_ar['anews_imgnotfound']);
		echo $smarty->fetch("db:messeg.tpl");
	}
}
?>