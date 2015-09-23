<?php
/**
 * Вывод блока меню на сайте, формируемого на основании списка текстовых страниц
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;
	$dir = $_conf['upldir'].'/'.$_conf['hp_path'];
	
	$pname = $_SERVER['REQUEST_URI'];
	if($pname=="/") $pname = "main";
	else{
		$pn = explode("?",$pname);
		$pname = $pn[0];
		$pname = substr($pname,1,strlen($pname)-2);
	}
		//echo $pname;
	$r = $db -> Execute("select * from ".$_conf['prefix']."headphoto where
	FIND_IN_SET('".mysql_real_escape_string($pname)."',pages) order by rand() limit 0,1");
	if($r -> RecordCOunt()>0){
			$t = $r -> GetRowAssoc(false);
			$photo = $dir.'/'.stripslashes($t['file']);
	}else{
		$photo = $_conf['www_patch'].'/'.$_conf['tpl_dir'].'images/himg.jpg';
	}
	$smarty -> assign("photo",$photo);
	$hp_block = $smarty->fetch("headphoto/hp_block.tpl");


?>