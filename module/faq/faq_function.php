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

function _buildfaqStructure($ar, $parent, $level, $v){
	global $db, $CMS, $_conf;
		return '';
}

function _buildfaqBreadCrumbs(){
	global $db, $CMS, $_conf;
	return '';
}

function _search_in_faq($tmptab, $stext_q){
	global $db, $CMS, $_conf;
	$q = "select * from ".$_conf['prefix']."faq
	where MATCH(q_quest_".$_SESSION['lang'].",q_reply_".$_SESSION['lang'].") AGAINST ('".$stext_q."'  IN BOOLEAN MODE)
	AND q_state='y'";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$cont = substr(strip_tags($t['q_reply_'.$_SESSION['lang']]),0,400).'...';
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string(stripslashes($t['q_quest_'.$_SESSION['lang']]))."', 
		stext='".mysql_real_escape_string(stripslashes($cont))."', 
		slink='?p=faq&q_id=".$t['q_id']."'");
		$r -> MoveNext();
	}
}
function _buildSitemap_faq(){
	global $db, $_conf, $smarty;
	$smaps = array();
			$r = $db -> Execute("select * from ".$_conf['prefix']."faq WHERE q_state='y' ORDER BY q_date DESC");
			while(!$r->EOF){
				$t = $r -> GetRowAssoc(false);
				if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/faq/q_id/'.stripslashes($t['q_id']).'/';
				else $full_link = $_conf['www_patch'].'/?p=faq&amp;q_id='.stripslashes($t['q_id']);
				$smaps[] = array(
					'link'=>'?p=faq&amp;q_id='.stripslashes($t['q_id']),
					'parent'=>0,
					'full_link'=>$full_link,
					'title'=>stripslashes($t['q_quest_'.$_SESSION['lang']]),	
					'priority'=>'0.6',
					'dchange'=>date("c",$t['q_date']),
					'changefreq'=>'monthly',
					'type'=>'xml',
					'sub'=>'',
				);
				$r -> MoveNext();
			}
	if(count($smaps)>0) return $smaps;
	else return '';
}

function _alertfaq(){
	global $db, $_conf;
	$q = "SELECT count(*) FROM ".$_conf['prefix']."faq WHERE q_state='n'";
	$r = $db -> Execute($q);
	$t = $r -> GetRowAssoc(false);
	if($t['count(*)'] > 0) return "<a title='Новые вопросы с страницы Вопрос-Ответ' href='admin.php?p=admin_faq'>Новые вопросы с страницы Вопрос-Ответ (".$t['count(*)'].")</a><br />";
	else return false;
}


?>