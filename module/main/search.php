<?php
/**
 * Управление каталогом товаров
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010
 * @link http://shiftcms.net
 * @version 1.01 06.08.2010
 */
if(!defined("SHIFTCMS")) exit;
$tmptab = "su_search_".time();
$tmpq = "
CREATE TABLE `".$tmptab."` (
`id` BIGINT( 16 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`stitle` VARCHAR( 255 ) NOT NULL ,
`stext` TEXT NOT NULL ,
`slink` VARCHAR( 255 ) NOT NULL ,
INDEX ( `stitle` )
) ENGINE = MYISAM DEFAULT CHARSET=".$_conf['encoding_db']." AUTO_INCREMENT=1;
";
$tmpr = $db -> Execute($tmpq);

	$found = array();
	$addpar = "";
	$items = 0;
	if(isset($_REQUEST['stext']) && $_REQUEST['stext']!=""){ $stext_q = mysql_real_escape_string(stripslashes($_REQUEST['stext'])); }
	else{ $stext_q = ''; }

if($stext_q==""){
	$smarty -> assign("warn", "warn");
}else{
	if(isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) && $_REQUEST['start']>0) $start = (int)$_REQUEST['start'];
	else $start = 0;
	$interval = 10;//$_conf['cat_item_on_page'];
	$addpar .= "&stext=".htmlspecialchars(stripslashes($_REQUEST['stext']));


	/* поиск по текстовых страницах */	
	$q = "select * from ".$_conf['prefix']."page
	where MATCH(p_title_".$_SESSION['lang'].",content_".$_SESSION['lang'].") AGAINST ('".$stext_q."' IN BOOLEAN MODE)
	AND siteshow='y' AND ptype='front'";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$cont = substr(strip_tags($t['content_'.$_SESSION['lang']]),0,400).'...';
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string(stripslashes($t['p_title_'.$_SESSION['lang']]))."', 
		stext='".mysql_real_escape_string(stripslashes($cont))."', 
		slink='?p=".$t['pname']."'");
		$r -> MoveNext();
	}
	
	/**
	 * Поиск по каталогу
	*/
	if($_SERVER['REMOTE_ADDR'] == '37.45.242.237') {
		include_once(dirname(dirname(__FILE__)).'/catalog/core/catalog.php');
		$catalog = new Catalog();
		$foundInCatalog = $catalog->find($_REQUEST['stext']);
		if(count($foundInCatalog)) {
			foreach($foundInCatalog as $foundStuff) {
				$cont = substr(strip_tags($foundStuff['text']), 0, 400).'...';
				$db->Execute(
					'
						INSERT INTO '.$tmptab.'
						SET 
							`stitle` = ?, 
							`stext` = ?, 
							`slink` = ?',
					array($foundStuff['name'], $cont, $foundStuff['url']));
			}
		}
	}

	
	$mod = $CMS['modules'];
	while(list($k,$v)=each($mod)){
		$mod_func = '_search_in_'.$k;
		if(function_exists($mod_func)){
			call_user_func($mod_func, $tmptab, $stext_q);
		}
		
	}

	/* поиск по обзорах */	
	/*
	$q = "select * from ".$_conf['prefix']."reviews
	where MATCH(r_title_".$_SESSION['lang'].",r_abstract_".$_SESSION['lang'].") AGAINST ('".$stext_q."'  IN BOOLEAN MODE)";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string(stripslashes($t['r_title_'.$_SESSION['lang']]))."', 
		stext='".mysql_real_escape_string(stripslashes($t['r_abstract_'.$_SESSION['lang']]))."', 
		slink='?p=reviews&r_id=".$t['r_id']."'");
		$r -> MoveNext();
	}
	*/

	/* поиск по форуму */	
	/*
	$q = "select * FROM ".$_conf['prefix']."forum_theme
	LEFT JOIN ".$_conf['prefix']."users ON ".$_conf['prefix']."forum_theme.tavtor=".$_conf['prefix']."users.idu
	WHERE MATCH(tname) AGAINST ('".mysql_real_escape_string($stext_q)."' IN BOOLEAN MODE) 
	OR MATCH(ttext) AGAINST ('".mysql_real_escape_string($stext_q)."' IN BOOLEAN MODE)
	OR (SELECT count(*) FROM ".$_conf['prefix']."forum_msg WHERE ".$_conf['prefix']."forum_msg.idt=".$_conf['prefix']."forum_theme.idt AND MATCH(mtext) AGAINST ('".mysql_real_escape_string($stext_q)."' IN BOOLEAN MODE)!=0)
	GROUP BY ".$_conf['prefix']."forum_theme.idt
	ORDER BY tdate ASC";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$cont = substr(strip_tags($t['ttext']),0,400).'...';
		$ri = $db -> Execute("insert into ".$tmptab." set 
		stitle='".mysql_real_escape_string(stripslashes($t['tname']))."', 
		stext='".mysql_real_escape_string(stripslashes($cont))."', 
		slink='?p=forum&show=msg&t=".$t['idt']."&f=".$t['idf']."'");
		$r -> MoveNext();
	}
	*/


	
	$r = $db -> Execute("select SQL_CALC_FOUND_ROWS * from ".$tmptab." limit ".$start.", ".$interval);
	$r1 = $db -> Execute("select found_rows()");
	$t1 = $r1 -> GetRowAssoc(false);
	$all = $t1['found_rows()'];
	if($r -> RecordCount()==0){
		$smarty -> assign("warn","warn");
	}else{
	$pl_ar = sr_GetPageList($all, $interval, $start,"?p=search&start=%start1%".$addpar, "");
	$smarty -> assign("pagelist", $pl_ar);
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			$found[] = array(
				'stitle'=>stripslashes($t['stitle']),
				'stext'=>stripslashes($t['stext']),
				'slink'=>stripslashes($t['slink']),
			);
			$r -> MoveNext();
		}
	}	
	$smarty -> assign("addpar", $addpar);
	$smarty -> assign("found", $found);
}	
$PAGE = $smarty -> fetch("search.tpl");

$r = $db -> Execute("drop table ".$tmptab);


/**
*  Разбивка на страницы каталога
*/
function sr_GetPageList($all,$interval,$currentpage,$link,$linkappend){
	$pages = array();
	$pageinlist = 12; // должно быть парное число
	if($all <= $interval) return $pages;
	else{
		$pagecount = ceil($all/$interval);
		/**
		*  Если количество страниц меньше/равно допустимому количеству для вывода
		*/
		if($pagecount <= $pageinlist){
			if($currentpage>0){
			$pages[] = array(
				'link'=>str_replace("%start1%", $currentpage-1, $link),
				'number'=>1,
				'type'=>'back'
			);
			}
			for($i=0; $i<$pagecount; $i++){
				$pages[] = array(
					'link'=>str_replace("%start1%", $i, $link),
					'number'=>$i+1,
					'type'=> $currentpage == $i ? 'current' : 'number'
				);
			}
			if($currentpage < $i-1){
			$pages[] = array(
				'link'=>str_replace("%start1%", $currentpage+1, $link),
				'number'=>$currentpage+2,
				'type'=>'forward'
			);
			}
			return $pages;
		}
		/**
		*  Если количество страниц больше, чем допустимое количество для вывода
		*/
		if($pagecount > $pageinlist){
			if($currentpage>0){
			$pages[] = array(
				'link'=>str_replace("%start1%", $currentpage-1, $link),
				'number'=>1,
				'type'=>'back'
			);
			}
			$diff = round($pageinlist/2, 0);
			if($currentpage+1 < $diff) $start_i = 0;
			elseif($currentpage+1 > $pagecount-$pageinlist) $start_i = $pagecount-$pageinlist;
			elseif($currentpage+1 > $pageinlist || $currentpage+1 < $pagecount-$pageinlist) $start_i = $currentpage+1 - $diff;
			else $start_i = 0;
/*
			if($currentpage+1 < $pageinlist) $start_i = 0;
			elseif($currentpage+1 > $pagecount-$pageinlist) $start_i = $pagecount-$pageinlist;
			elseif($currentpage+1 > $pageinlist || $currentpage+1 < $pagecount-$pageinlist) $start_i = $currentpage+1 - round($pageinlist/2, 0);
			else $start_i = 0;
*/
			for($i=$start_i; $i<$start_i+$pageinlist; $i++){
				$pages[] = array(
					'link'=>str_replace("%start1%", $i, $link),
					'number'=>$i+1,
					'type'=> $currentpage == $i ? 'current' : 'number'
				);
			}
			if($currentpage < $i-1){
			$pages[] = array(
				'link'=>str_replace("%start1%", $currentpage+1, $link),
				'number'=>$currentpage+2,
				'type'=>'forward'
			);
			}
			return $pages;
		}
	}
}

?>