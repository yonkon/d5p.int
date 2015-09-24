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

function _buildnewsStructure($ar, $parent, $level, $v){
	global $db, $CMS, $_conf;
	$r = $db -> Execute("select * from ".$_conf['prefix']."news_category order by ".$_SESSION['lang']);
	if($r -> RecordCount()==0){
		return '';
	}else{
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
				$retarray[stripslashes($t['ntrans'])] = array(
					'pid'=>$t['id'],
					'pname'=>"news/category/".stripslashes($t['ntrans']),
					'pparent'=>'news',
					'ptitle'=>stripslashes($t[$_SESSION['lang']])." : ".stripslashes($v['ptitle']),
					'level'=>$level,
					'linkpos'=>$t['id'],
					'link'=>"?p=news&category=".stripslashes($t['ntrans']),
					'linkname'=>stripslashes($t[$_SESSION['lang']]),
					'linktitle'=>stripslashes($t[$_SESSION['lang']]),
					'siteshow'=>'y',
					'menushow1'=>'y',
					'menushow2'=>'n',
					'menushow3'=>'n',
					'sel'=>isset($_REQUEST['category'])&&trim($_REQUEST['category'])==$t['ntrans'] ? 'y' : 'n',
					'sub'=>''
				);
			$r -> MoveNext();
		}
	return $retarray;
	}
}

function _buildnewsBreadCrumbs(){
	global $db, $CMS, $_conf;
	$ntrans = '';
	if(isset($_REQUEST['idn'])){
		$r = $db->Execute("SELECT idn,id,ntrans FROM ".$_conf['prefix']."news_".$_SESSION['lang']."
		LEFT JOIN ".$_conf['prefix']."news_category USING(id)
		WHERE idn='".mysql_real_escape_string(stripslashes($_REQUEST['idn']))."'");
		if($r -> RecordCount() > 0){
			$t = $r -> GetRowAssoc(false);
			$_REQUEST['category'] = stripslashes($t['ntrans']);
			
		}
	}
	if(isset($_REQUEST['category']) && isset($CMS['structure']['news']['sub'][trim($_REQUEST['category'])])) $ntrans = trim(stripslashes($_REQUEST['category']));
	if($ntrans!=''){
		$CMS['structure']['news']['sub'][trim($_REQUEST['category'])]['sel'] = 'y';
		return array($CMS['structure']['news']['sub'][$ntrans]);
	}
	else return '';
}

function _search_in_news($tmptab, $stext_q){
	global $db, $CMS, $_conf;
	$q = "select * from ".$_conf['prefix']."news_".$_SESSION['lang']."
	where MATCH(ntitle,ntext) AGAINST ('".$stext_q."'  IN BOOLEAN MODE)";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$cont = substr(strip_tags($t['ntext']),0,400).'...';
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string(stripslashes($t['ntitle']))."', 
		stext='".mysql_real_escape_string(stripslashes($cont))."', 
		slink='?p=news&idn=".$t['idn']."'");
		$r -> MoveNext();
	}
}
function _buildSitemap_news(){
	global $db, $_conf, $smarty;
	$smaps = array();
		$nc = getNewsCategoryArray();
		if($nc!=''){
			while(list($k,$v)=each($nc)){
				if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/news/category/'.stripslashes($v['ntrans']).'/';
				else $full_link = $_conf['www_patch'].'/?p=news&amp;category='.stripslashes($v['ntrans']);
				$smaps[] = array(
					'link'=>'?p=news&amp;category='.stripslashes($v['ntrans']),
					'parent'=>0,
					'full_link'=>$full_link,
					'title'=>stripslashes($v['name']),	
					'priority'=>'0.7',
					'dchange'=>date("c",time()-72000),
					'changefreq'=>'monthly',
					'type'=>'html',
					'sub'=>'',
				);
			}
		}
			$r = $db -> Execute("select * from ".$_conf['prefix']."news_".$_SESSION['lang']." order by date desc");
			while(!$r->EOF){
				$t = $r -> GetRowAssoc(false);
				if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/news/idn/'.stripslashes($t['idn']).'/';
				else $full_link = $_conf['www_patch'].'/?p=news&amp;idn='.stripslashes($t['idn']);
				$smaps[] = array(
					'link'=>'?p=news&amp;idn='.stripslashes($t['idn']),
					'parent'=>0,
					'full_link'=>$full_link,
					'title'=>stripslashes($t['ntitle']),	
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

function getNewsCategoryArray(){
	global $db, $CMS, $_conf;
	$r = $db -> Execute("select *,
	(select count(*) from ".$_conf['prefix']."news_".$_SESSION['lang']." where id=".$_conf['prefix']."news_category.id) as items 
	from ".$_conf['prefix']."news_category order by ".$_SESSION['lang']);
	if($r -> RecordCount()==0){
		return '';
	}else{
		$returnarray = array();
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
				$sel = isset($_REQUEST['category'])&&trim($_REQUEST['category'])==$t['ntrans'] ? 'y' : 'n';
				$t['sel'] = $sel;
				$t['name'] = $t[$_SESSION['lang']];
				while(list($k,$v)=each($t)) $t[$k] = stripslashes($v);
				$retarray[$t['id']] = $t;
			$r -> MoveNext();
		}
	return $retarray;
	}
}
?>