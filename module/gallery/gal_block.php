<?php
/**
 * Блок для вывода последних или случайных фото из галереи
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	30.06.2009
 */
if(!defined("SHIFTCMS")) exit;

if(!isset($_REQUEST['ids'])) $ids = 0;
else $ids = $_REQUEST['ids'];
/* ******************************** */

/*
		$q="select * from ".$_conf['prefix']."galleries ORDER BY rand() LIMIT 0,1";
		$rs = $db -> Execute($q);
		
if($rs -> RecordCount() == 0) $smarty -> assign("nofoto", "nofoto");
else{
		
		$galinf = $rs -> GetRowAssoc(false);
		
		$ids = $galinf['ids'];
*/	
	$q="select * from ".$_conf['prefix']."gal_photos ORDER BY rand() LIMIT 0,2";
	$rs = $db -> Execute($q);
		if($rs -> RecordCount() == 0) $smarty -> assign("nofoto", "nofoto");
	$photos='';
	$items=0;
	$pstart=0;
	$dw=$_conf['gal_thumb_w']; $dw=$dw."px";
	$ph_ar=array();
	$ph_br=array();
	while(!$rs -> EOF){
		$tmp = $rs -> GetRowAssoc(false);
		$items++;
		$ph_ar[$pstart]=array(
			'IDP'=>$tmp['idp'],
			'IDS'=>$tmp['ids'],
			'IMG'=>$_conf['gal_thumb_patch']."/".$tmp['idp'].".jpg",
			'BIGIMG'=>$_conf['gal_photo_patch']."/".$tmp['idp'].".jpg",
			'COMMENTS'=>stripslashes($tmp['comments_'.$_SESSION['lang']]),
			'ITEMS'=>$items,
			'PSTART'=>$pstart,
			'ITEMS'=>$items
		);
		if($items==$_conf['thumb_col']){
			$items=0;
		}	
		$pstart++;
		$rs -> MoveNext();
	}
	
$smarty -> assign("thumb_col",$_conf['thumb_col']);
$smarty -> assign("twidth",$_conf['gal_thumb_w']);
$smarty -> assign("ph_ar",$ph_ar);
$smarty -> assign("dw",$dw);
$smarty -> assign("ids",$ids);

//$smarty -> assign("IDS",$tmp['ids']);
//$smarty -> assign("NAME",stripslashes($galinf['name_'.$_SESSION['lang']]));
//$smarty -> assign("OPIS",stripslashes($galinf['opis_'.$_SESSION['lang']]));
//}
$gal_block = $smarty -> fetch("gallery/gal_block.tpl");	

?>