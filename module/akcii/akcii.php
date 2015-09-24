<?php
/**
 * Вывод новостей сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.04.05
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) && $_REQUEST['id']>0){
	$ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."akcii
	WHERE id='".mysql_real_escape_string(stripslashes($_REQUEST['id']))."'");
	if($ms->RecordCount()!=0){ // всего тем
		$tmpm = $ms->GetRowAssoc(false);
	//----------------------------------------------------------------------
		//$_REQUEST['category'] = $tmpm['NTRANS'];
		if(file_exists($tmpm['aphoto'])) $photo = stripslashes($tmpm['aphoto']);
		else $photo = "no";
		$akcia=array(
			'id'=>$tmpm['id'],
			'date'=>$tmpm['date'],
			'title'=>htmlentities(stripslashes($tmpm['title_'.$_SESSION['lang']]),ENT_QUOTES, $_conf['encoding']),
			'text'=>stripslashes($tmpm['text_'.$_SESSION['lang']]),
			'photo'=>stripslashes($photo),
			'anons'=>stripslashes($tmpm['anons_'.$_SESSION['lang']])
		);
		
		$smarty -> assign("act","full");
		$smarty -> assign($akcia);
	}else{
		$smarty->assign("newsnotfound",$lang_ar['newsnotfound']);
	}


}else{

	//SelectLimit($sql,$numrows=-1,$offset=-1,$inputarr=false)
	$id = 0;
	$akcii = array();
	$rss_items = 0;
	$interval = $_conf['a_count1'];
	if(!isset($_REQUEST['start'])) $start = 0;
	else $start = $_REQUEST['start'];

	$q = "select SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."akcii ORDER BY date DESC";
	$q .= " LIMIT ".$start.", ".$interval;

	$ms = $db -> Execute($q);

	$r1 = $db -> Execute("select found_rows()");
	$t1 = $r1 -> GetRowAssoc(false);
	$all = $t1['found_rows()'];

	$list_page = GetPaging($all,$interval,$start,"index.php?p=akcii&start=%start1%");
	while (!$ms->EOF) { 
		$tmpm = $ms -> GetRowAssoc(false);
		if(file_exists($tmpm['aphoto'])) $photo = stripslashes($tmpm['aphoto']);
		else $photo = "no";
	$akcii[$rss_items]=array(
		'id'=>$tmpm['id'],
		'date'=>$tmpm['date'],
		'title'=>htmlentities(stripslashes($tmpm['title_'.$_SESSION['lang']]),ENT_QUOTES, $_conf['encoding']),
		'anons'=>stripslashes($tmpm['anons_'.$_SESSION['lang']]),
		'text'=>stripslashes($tmpm['text_'.$_SESSION['lang']]),
		'photo'=>stripslashes($photo)
	);
	$rss_items++;
	$ms->MoveNext(); 
}
		$smarty -> assign("paging",$list_page);
		$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
		$smarty -> assign("act","list");
		$smarty -> assign("akcii",$akcii);
}

$PAGE = $smarty->fetch("akcii/akcii.tpl");

//$CURPATCH=$TITLE=$KEYWORDS=$lang_ar['news'];
?>