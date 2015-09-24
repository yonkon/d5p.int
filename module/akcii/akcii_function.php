<?php
/**
 * Набор функций для модуля новостей
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012
 * @link http://shiftcms.net
 * @version 1.03
 */
if(!defined("SHIFTCMS")) exit;

function _buildakciiStructure($ar, $parent, $level, $v){
	global $db, $CMS, $_conf;
	return '';
}

function _buildakciiBreadCrumbs(){
	global $db, $CMS, $_conf;
	return '';
}

function _search_in_akcii($tmptab, $stext_q){
	global $db, $CMS, $_conf;
	$q = "select * from ".$_conf['prefix']."akcii
	where MATCH(title_".$_SESSION['lang'].",text_".$_SESSION['lang'].") AGAINST ('".$stext_q."'  IN BOOLEAN MODE)";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$cont = substr(strip_tags($t['text_'.$_SESSION['lang']]),0,400).'...';
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string(stripslashes($t['title_'.$_SESSION['lang']]))."', 
		stext='".mysql_real_escape_string(stripslashes($cont))."', 
		slink='?p=akcii&id=".$t['id']."'");
		$r -> MoveNext();
	}
}
function _buildSitemap_akcii(){
	global $db, $_conf, $smarty;
	$smaps = array();
			$r = $db -> Execute("select * from ".$_conf['prefix']."akcii order by date desc");
			while(!$r->EOF){
				$t = $r -> GetRowAssoc(false);
				if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/akcii/id/'.stripslashes($t['id']).'/';
				else $full_link = $_conf['www_patch'].'/?p=akcii&amp;id='.stripslashes($t['id']);
				$smaps[] = array(
					'link'=>'?p=akcii&amp;id='.stripslashes($t['id']),
					'parent'=>0,
					'full_link'=>$full_link,
					'title'=>stripslashes($t['title_'.$_SESSION['lang']]),	
					'priority'=>'0.6',
					'dchange'=>date("c",$t['date']),
					'changefreq'=>'monthly',
					'type'=>'xml',
					'sub'=>'',
				);
				$r -> MoveNext();
			}
	if(count($smaps)>0) return $smaps;
	else return '';
}
?>