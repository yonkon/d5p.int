<?php
/**
 * Вывод карты сайта и генерация файла карты сайта в формате sitemap.xml
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

$exclude = array('403','404','register','enter','remember','cron','pay_fail','pay_success','pay_result');

$smaps = array();

$r = $db -> Execute("SELECT 
pid, pname, pparent, ptitle, ppar, plevel, pgroups, ptype, siteshow,
lastedit, p_title_".$_SESSION['lang'].", linkname_".$_SESSION['lang']."
FROM ".$_conf['prefix']."page 
WHERE siteshow='y' AND FIND_IN_SET('".$_SESSION['USER_GROUP']."',pgroups) AND ptype='front'
ORDER BY linkpos");
$all = $r -> GetAll();


$smaps = OutPageList($all, "", 0);


$smarty->assign("smaps", $smaps);
$PAGE = $smarty->fetch("sitemap.tpl");

writeXML($smaps);
if(!file_exists("sitemap.xml")) writeXML($smaps);
else{
	$ft = filemtime("sitemap.xml");
	if((time()-$ft)>3600) writeXML($smaps);
}
/*
echo '<pre>';
print_r(getBaseCatSitemap());
echo '</pre>';
*/
/* ************************************************************** */
/*     карта сайта основных страниц                               */
/* ************************************************************** */
function OutPageList($all=array(), $pparent, $level){
	global $db, $_conf, $p, $lang_ar, $exclude, $CMS;
	$smaps = array(); $csub = ''; $ssub = '';
	if($level==0) $priority = 1.0;
	elseif($level==1) $priority = 0.8;
	elseif($level==2) $priority = 0.6;
	else $priority = 0.4;
	reset($all);
	$mod = $CMS['modules'];
  while(list($k,$v)=each($all)){
	  if($v['pparent'] == $pparent && !in_array($v['pname'],$exclude)){
	  	if($v['lastedit']==0) $v['lastedit'] = time();
		if($v['pname']=="main"){
			$full_link = $_conf['www_patch'].'/';
		}else{
			if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/'.stripslashes($v['pname']).'/';
			else $full_link = $_conf['www_patch'].'/?p='.stripslashes($v['pname']);
		}

		if(trim($v['linkname_'.$_SESSION['lang']])!="") $title = stripslashes($v['linkname_'.$_SESSION['lang']]);
		else $title = stripslashes($v['p_title_'.$_SESSION['lang']]);
		if(stripslashes($v['ppar'])!="") $v['pname'] = $v['pname'].'&'.$v['ppar'];
		
		$ssub = OutPageList($all, $v['pname'], $level+1);
		
		/* добавляем структуру для установленных модулей */
		if(isset($mod[$v['pname']])){
			$mod_func = '_buildSitemap_'.$v['pname'];
			if(function_exists($mod_func)){
				$csub = call_user_func($mod_func);
			}
		}else $csub = '';

		if($v['pname']=="forum") $csub = getForumSitemap();
		
		if($ssub!='' && $csub!='') $sub = array_merge($ssub,$csub);
		elseif($ssub=='' && $csub!='') $sub = $csub;
		elseif($ssub!='' && $csub=='') $sub = $ssub;
		else $sub = '';
		
	  	$smaps[] = array(
			'link'=>'?p='.stripslashes($v['pname']),
			'parent'=>stripslashes($v['pparent']),
			'full_link'=>$full_link,
			'title'=>$title,
			'priority'=>$priority,
			'dchange'=>date("c",$v['lastedit']),
			'changefreq'=>'weekly',
			'type'=>'html',
			'sub'=>$sub
		);
		
	  }
  }
  if(count($smaps)>0) return $smaps;
  else return '';
}

/* Добавляем форум */
function getForumSitemap(){
	global $db, $_conf, $smarty;
	$smaps = array();
			$r = $db -> Execute("select * from ".$_conf['prefix']."forum_theme order by tdate desc");
			while(!$r->EOF){
				$t = $r -> GetRowAssoc(false);
				if($_conf['url_type']==1) $full_link = $_conf['www_patch'].'/forum/show/msg/?t='.$t['idt'].'&amp;f='.$t['idf'];
				else $full_link = $_conf['www_patch'].'/?p=forum&amp;show=msg&amp;t='.$t['idt'].'&amp;f='.$t['idf'];
				$smaps[] = array(
					'link'=>'?p=forum&amp;show=msg&amp;t='.$t['idt'].'&amp;f='.$t['idf'],
					'parent'=>0,
					'full_link'=>$full_link,
					'title'=>stripslashes($t['tname']),	
					'priority'=>'0.6',
					'dchange'=>date("c",$t['tdate']),
					'changefreq'=>'weekly',
					'type'=>'xml',
					'sub'=>'',
				);
				$r -> MoveNext();
			}
	if(count($smaps)>0) return $smaps;
	else return '';
}

/* запись xml файла карты сайта */
function writeXML($map){
$fc = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
';
while(list($k,$v)=each($map)){
$fc .= '
	<url>
		<loc>'.$v['full_link'].'</loc>
		<priority>'.str_replace(",",".",$v['priority']).'</priority>
		<lastmod>'.$v['dchange'].'</lastmod>
		<changefreq>'.$v['changefreq'].'</changefreq>
	</url>
';
	if($v['sub']!="") $fc .= writeURL($v['sub']);
}
$fc .= '</urlset>';

	if(is_writable("sitemap.xml")){
		$fp = fopen("sitemap.xml","w");
		fwrite($fp,$fc);
		fclose($fp);
	}else add_to_log("Нет доступа для записи файла sitemap.xml","sitemap");
	if(is_writable("sitemap.xml.gz")){
		$gz = gzopen("sitemap.xml.gz", "w");
		gzwrite($gz, $fc);
		gzclose($gz);
	}else add_to_log("Нет доступа для записи файла sitemap.xml","sitemap");
}
function writeURL($xml){
$fc = '';
//print_r($xml);
while(list($k,$v)=each($xml)){
$fc .= '
	<url>
		<loc>'.$v['full_link'].'</loc>
		<priority>'.str_replace(",",".",$v['priority']).'</priority>
		<lastmod>'.$v['dchange'].'</lastmod>
		<changefreq>'.$v['changefreq'].'</changefreq>
	</url>
';
	if($v['sub']!="") $fc .= writeURL($v['sub']);
}
	return $fc;
}


?>