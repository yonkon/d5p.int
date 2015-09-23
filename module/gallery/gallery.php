<?php
/**
 * Вывод фотогалереи
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01	30.06.2009
 02.08.2009 - Додано поле для сортування фото по вказаному порядку від меньшого значення до більшого
 */
if(!defined("SHIFTCMS")) exit;

/*
if(!isset($_REQUEST['ids'])){

	$PAGE = out_site_text("objects");
	
}else{
*/


$ids = null;
if(isset($_REQUEST['ids'])){
	$r = $db -> Execute("select ids from ".$_conf['prefix']."galleries where ids='".mysql_real_escape_string(stripslashes($_REQUEST['ids']))."'");
	if($r -> RecordCount() > 0) $ids = $_REQUEST['ids'];
}else{
	/*
	$r = $db -> Execute("select ids from ".$_conf['prefix']."galleries order by rand() limit 0,1");
	$t = $r -> GetRowAssoc(false);
	$ids = $t['ids'];
	*/
	$ids = null;
}
/* ******************************** */

if($ids == null){
	$q="select *,
	(select count(*) from ".$_conf['prefix']."gal_photos as gh where gh.ids=".$_conf['prefix']."galleries.ids) as photos
	from ".$_conf['prefix']."galleries
	left join ".$_conf['prefix']."gal_photos using(ids) 
	WHERE ".$_conf['prefix']."gal_photos.ids IS NOT NULL GROUP BY ".$_conf['prefix']."galleries.ids order by ".$_conf['prefix']."galleries.name_".$_SESSION['lang'];
	$rs = $db -> Execute($q);
	$gal_ar = array(); $i=0;
	while(!$rs -> EOF){
		$tmp = $rs -> GetRowAssoc(false);
		//print_r($tmp);
		//echo '<br />';
		$field = "name_".$_SESSION['lang'];
		$sel = $ids==$tmp['ids'] ? 'y' : 'n';
		$gal_ar[$i]=array(
			'ids'=>$tmp['ids'],
			'date'=>$tmp['date'],
			'name'=>stripslashes($tmp[$field]),
			'img'=>$_conf['gal_thumb_patch']."/".$tmp['idp'].".jpg",
			'photos'=>$tmp['photos'],
			'sel'=>$sel,
		);
		$i++;
		$rs -> MoveNext();
	}
	$smarty -> assign("gal_ar",$gal_ar);
	$smarty -> assign("thumb_col",$_conf['thumb_col']);
	$smarty -> assign("twidth",$_conf['gal_thumb_w']);
	$smarty -> assign("gtype","gallist");
	$PAGE = $smarty -> fetch("gallery/gallery.tpl");	

}else{
	
/* ***************************** */

$q="select * from ".$_conf['prefix']."galleries WHERE ids='$ids'";
//$q="select * from ".$_conf['prefix']."galleries";
$rs = $db -> Execute($q);
$galinf = $rs -> GetRowAssoc();


	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];
	$interval=$_conf['thumb_col']*$_conf['thumb_row'];
	$q="select COUNT(*) from ".$_conf['prefix']."gal_photos WHERE ids='".$ids."'";
	//$q="select COUNT(*) from ".$_conf['prefix']."gal_photos";
	$rs = $db -> Execute($q);
	$t = $rs -> GetRowAssoc();
	$all = $t['COUNT(*)'];

	$q="select * from ".$_conf['prefix']."gal_photos WHERE ids='".$ids."' ORDER BY g_order,idp LIMIT $start,$interval";
	//$q="select * from ".$_conf['prefix']."gal_photos ORDER BY g_order,idp LIMIT $start,$interval";
	$rs = $db -> Execute($q);
	$photos='';
	$items=0;
	$pstart=0;
	$dw=$_conf['gal_thumb_w']; $dw=$dw."px";
	//$pagelist=Paging($all,$interval,$start,"?p=gallery&act=OutPhoto&ids=$ids&start=%start1%","");
	$pagelist=Paging($all,$interval,$start,"?p=gallery&ids=$ids&start=%start1%","");
	//$pagelist=Paging($all,$interval,$start,"?p=gallery&start=%start1%","");
	$photos.=$pagelist;
	$ph_ar=array();
	$ph_br=array();
	while(!$rs -> EOF){
		$tmp = $rs -> GetRowAssoc();
		$items++;
		$ph_ar[$pstart]=array(
			'IMG'=>$_conf['gal_thumb_patch']."/".$tmp['IDP'].".jpg",
			'BIGIMG'=>$_conf['gal_photo_patch']."/".$tmp['IDP'].".jpg",
			'COMMENTS'=>htmlspecialchars(stripslashes($tmp['COMMENTS_'.strtoupper($_SESSION['lang'])])),
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

	/* list of galeries */
	$q="select *,
	(select count(*) from ".$_conf['prefix']."gal_photos as gh where gh.ids=".$_conf['prefix']."galleries.ids) as photos
	from ".$_conf['prefix']."galleries
	left join ".$_conf['prefix']."gal_photos using(ids) 
	WHERE ".$_conf['prefix']."gal_photos.ids IS NOT NULL GROUP BY ".$_conf['prefix']."galleries.ids order by ".$_conf['prefix']."galleries.name_".$_SESSION['lang'];
	$rs = $db -> Execute($q);
	$gal_ar = array(); $i=0;
	while(!$rs -> EOF){
		$tmp = $rs -> GetRowAssoc(false);
		//print_r($tmp);
		//echo '<br />';
		$field = "name_".$_SESSION['lang'];
		$sel = $ids==$tmp['ids'] ? 'y' : 'n';
		$gal_ar[$i]=array(
			'ids'=>$tmp['ids'],
			'date'=>$tmp['date'],
			'name'=>stripslashes($tmp[$field]),
			'img'=>$_conf['gal_thumb_patch']."/".$tmp['idp'].".jpg",
			'photos'=>$tmp['photos'],
			'sel'=>$sel,
		);
		$i++;
		$rs -> MoveNext();
	}

	$smarty -> assign("gal_ar",$gal_ar);

	$smarty -> assign("thumb_col",$_conf['thumb_col']);
	$smarty -> assign("twidth",$_conf['gal_thumb_w']);
	
	//$smarty -> assign("gal_list",$gal_list);
	$smarty -> assign("gal_ar",$gal_ar);
	$smarty -> assign("thumb_col",$_conf['thumb_col']);
	$smarty -> assign("twidth",$_conf['gal_thumb_w']);
	$smarty -> assign("ph_ar",$ph_ar);
	$smarty -> assign("dw",$dw);
	$smarty -> assign("IDS",$ids);
	$smarty -> assign("ids",$ids);
	$smarty -> assign("pagelist",$pagelist);
	$field = "NAME_".strtoupper($_SESSION['lang']);
	$smarty -> assign("NAME",stripslashes($galinf[$field]));
	$field = "OPIS_".strtoupper($_SESSION['lang']);
	$smarty -> assign("OPIS",stripslashes($galinf[$field]));
	$smarty -> assign("gtype","photolist");
	$PAGE = $smarty -> fetch("gallery/gallery.tpl");	
}
?>