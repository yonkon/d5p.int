<?php
/**
 * Вывод обзоров сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010 
 * @link http://shiftcms.net
 * @version 1.00
 */

if(isset($_REQUEST['r_id'])){
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."articles WHERE r_id='".mysql_real_escape_string($_REQUEST['r_id'])."'");
	if($r -> RecordCount()!=0){ // всего тем
		$t = $r -> GetRowAssoc(false);
		/*
		if(function_exists("tidy_parse_string")){
			$config = array('char-encoding' => $_conf['encoding'], 'input-encoding' => $_conf['encoding'], 'output-encoding' =>  $_conf['encoding']);
			$tidy = '---------------------'.tidy_parse_string(stripslashes($t['r_content']), $config);
			tidy_clean_repair($tidy);
			//$tidy = tidy_repair_string(stripslashes($t['r_content']), $config);
			$tidy = stripslashes($t['r_content']);
		}else{
			$tidy = stripslashes($t['r_content']);
		}
		*/
		$tidy = stripslashes($t['r_content']);
		$r_array=array(
			'r_id'=>$t['r_id'],
			'r_dadd'=>$t['r_dadd'],
			'r_source'=>stripslashes($t['r_source']),
			'r_title'=>stripslashes($t['r_title']),
			'r_avtor'=>stripslashes($t['r_avtor']),
			'r_abstract'=>stripslashes($t['r_abstract']),
			'r_content'=>$tidy,
		);
		$smarty -> assign("act","full");
		$smarty -> assign("r",$r_array);
		$TITLE = htmlspecialchars(stripslashes($t['r_title']));
		$KEYWORDS = htmlspecialchars(stripslashes($t['r_title']));
		$DESCRIPTION = htmlspecialchars(stripslashes($t['r_abstract']));
	}else{
		$smarty->assign("newsnotfound",$lang_ar['newsnotfound']);
	}


}else{

	$r_array=array();
	$r_items = 0;
	$interval = 10;
	if(!isset($_REQUEST['start'])) $start = 0;
	else $start = $_REQUEST['start'];
	if(!is_numeric($start) || $start<0) $start = 0;
	$q = "SELECT SQL_CALC_FOUND_ROWS r_id, r_dadd, r_source, r_title, r_avtor, r_abstract FROM ".$_conf['prefix']."articles ORDER BY r_dadd DESC LIMIT ".$start.",".$interval;
	$r = $db -> Execute($q);
	$r1 = $db -> Execute("select found_rows()");
	$t1 = $r1 -> GetRowAssoc(false);
	$all = $t1['found_rows()'];
	$list_page=GetPaging($all,$interval,$start,"index.php?p=".$p."&start=%start1%");
	while (!$r->EOF) { 
		$t = $r -> GetRowAssoc(false);
		$r_array[$r_items]=array(
			'r_id'=>$t['r_id'],
			'r_dadd'=>$t['r_dadd'],
			'r_source'=>stripslashes($t['r_source']),
			'r_title'=>stripslashes($t['r_title']),
			'r_avtor'=>stripslashes($t['r_avtor']),
			'r_abstract'=>stripslashes($t['r_abstract']),
		);
		$r_items++;
		$r->MoveNext(); 
	}
	$smarty -> assign("paging",$list_page);
	$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
	$smarty -> assign("act","list");
	$smarty->assign("rfull",$r_array);
}

$PAGE = $smarty->fetch("articles/articles.tpl");

//$CURPATCH=$TITLE=$KEYWORDS=$lang_ar['news'];
?>