<?php
/**
 * Управление каталогом товаров
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010
 * @link http://shiftcms.net
 * @version 1.00.02 06.08.2010
 */
if((isset($_REQUEST['act']) && !isset($_SERVER['HTTP_REFERER'])) || !defined("SHIFTCMS")) exit;

/* *********************** */
/* Стандартные функции CMS */
/* *********************** */
function _buildarticlesStructure($ar, $parent, $level, $v){
	global $db, $CMS, $_conf;
	return '';
}
function _buildarticlesBreadCrumbs(){
	global $db, $CMS, $_conf;
	return '';
}
function _search_in_articles($tmptab, $stext_q){
	global $db, $CMS, $_conf;
	$q = "select r_id, r_title, r_avtor, r_abstract, r_content
	from ".$_conf['prefix']."articles
	where 
	CONCAT_WS(' ', r_title, r_avtor, r_abstract, r_content) LIKE '%".$stext_q."%' 
	ORDER BY r_title DESC";

	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string($t['r_title'])." (".stripslashes($t['r_avtor']).")', 
		stext='".mysql_real_escape_string(stripslashes($t['r_abstract']))."', 
		slink='?p=articles&r_id=".$t['r_id']."'");
		$r -> MoveNext();
	}
}

function _buildSitemap_articles(){
	global $db, $CMS, $_conf;
	$smaps = array();
	$r = $db -> Execute("select r_id, r_dadd, r_dedit, r_title from ".$_conf['prefix']."articles order by r_dadd");
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
			if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/articles/r_id/'.$t['r_id'].'/';
			else $full_link = $_conf['www_patch'].'/?p=articles&amp;r_id='.$t['r_id'];
			$smaps[] = array(
				'link'=>'?p=articles&r_id='.stripslashes($t['r_id']),
				'parent'=>'articles',
				'full_link'=>$full_link,
				'title'=>stripslashes($t['r_title']),	
				'priority'=>'0.8',
				'dchange'=>$t['r_dedit']!=0 ? date("c",$t['r_dedit']) : date("c",$t['r_dadd']),
				'changefreq'=>'daily',
				'type'=>'html',
				'sub'=>'',
			);
		$r -> MoveNext();
	}
	if(count($smaps)>0) return $smaps;
	else return '';
}
function _alertarticles(){
	global $db, $_conf;
	return false;
}

?>