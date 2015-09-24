<?php
/**
 * Главный файл Сайта - "движок"
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.02.07
 */
$debug = $_SERVER['REMOTE_ADDR']=="127.0.0.1" ? false : false;
if($debug == true){$ttt = microtime();$ttt = ((double)strstr($ttt, ' ') + (double)substr($ttt,0,strpos($ttt,' ')));}

ob_start();
session_start();
define('SHIFTCMS',true);
$CMS = array();
$HEADER = "";

include("./include/config/set.inc.php"); 

if(!isset($_SESSION['USER_GROUP'])) $_SESSION['USER_GROUP'] = "guest";  
if(isset($_REQUEST['lang'])) $_SESSION['lang'] = $_REQUEST['lang'];
if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $_conf['def_lang'];

if($_conf['url_type'] == 1) include("./module/main/urlparse.php"); 

define('ADODB_ERROR_LOG_TYPE',3); 
define('ADODB_ERROR_LOG_DEST', $_SERVER['DOCUMENT_ROOT']."/tmp/log/sql_error.log"); 
$ADODB_CACHE_DIR = './tmp/ADOdbcache'; 
include('./include/adodb/adodb-errorhandler.inc.php'); 
include('./include/adodb/adodb.inc.php'); 
include('./include/main_function.php');
include('./include/user_function.php');

			if($debug == true){
				$CACHED = $EXECS = 0;
				function &CountExecs($db, $sql, $inputarray){
					global $EXECS;
					if (!is_array($inputarray)) $EXECS++;
					else if (is_array(reset($inputarray))) $EXECS += sizeof($inputarray);
					else $EXECS++;
					$null = null;
					return $null;
				}
				function CountCachedExecs($db, $secs2cache, $sql, $inputarray){global $CACHED; $CACHED++;}
			}
    $db = ADONewConnection("mysql"); 
	if (!$db) die("Connection failed");
    //$db->debug = true; 
    $db -> Connect($host, $user, $pass, $base); 
	//$db -> cacheSecs = 60;
			if($debug == true){
				$db -> LogSQL(); // turn on logging
				$db -> fnExecute = 'CountExecs';
				$db -> fnCacheExecute = 'CountCachedExecs';
			}
    $rs = $db -> _Execute('SET NAMES '.$_conf['encoding_db']); 

	if(!isset($_SESSION['fl'])){
		$fl = GetLangField(); $_SESSION['fl'] = $fl; 
	}
	if(!in_array($_SESSION['lang'],$_SESSION['fl'])) $_SESSION['lang'] = $_conf['def_lang'];
	$lang_ar = load_conf_var();
	
	loadModuleFunction();
	loadSiteStructure();

	if(!isset($_REQUEST['p'])) $_REQUEST['p'] = "main";
	if($_conf['url_type'] == 1 && ($_REQUEST['p'] != "404" && $_REQUEST['p'] != "403")){
		if(stristr($_SERVER['REQUEST_URI'], '?p=') !== FALSE) $_REQUEST['p'] = "404";
	}
	$p = $_REQUEST['p'];

	require($_conf['disk_patch']."include/smarty/Smarty.class.php");
	require($_conf['disk_patch']."include/smarty/sysplugins/smarty_custom_mysql.php");
	$smarty = new Smarty();
	//$smarty -> debugging = true;
	// ASSIGN SMARTY TEMPLATE DIRECTORY PATHS
	$smarty->setTemplateDir($_conf['disk_patch'].$_conf['tpl_dir']);
	$smarty->setCompileDir($_conf['disk_patch']."tmp/templates_c".templateSubdir());
	$smarty->setCacheDir($_conf['disk_patch']."tmp/cache");
	$smarty->setConfigDir($_conf['disk_patch']."include/smarty/configs");
	$smarty->registerResource('db', new Smarty_Resource_Mysql());

	$smarty -> assign("lang", $lang_ar);

	if(isset($_COOKIE['USER_IDU'])) authenticate($_COOKIE['USER_IDU']);

	$rs = $db -> _Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pname='".mysql_real_escape_string(stripslashes($p))."' AND siteshow='y'");
	$ptmp = $rs -> GetRowAssoc(false);
	if($rs -> RecordCount() == 0){
		header("HTTP/1.0 404"); header("Status: 404");
		if($_conf['url_type'] == 1) header("location:/404/");
		else header("location:/?p=404");
		exit;
	}
	$LASTMODIFIED = $ptmp['lastedit']!=0 ? $ptmp['lastedit'] : $ptmp['added'];
	$ug = explode(",",$ptmp['pgroups']);  
	if(!in_array($_SESSION['USER_GROUP'],$ug)){
		header("HTTP/1.0 301"); header("Status: 301");
		header("Location:/");
		exit;
	}
	if($ptmp['ptitle'] == "link"){
		header("HTTP/1.0 301"); header("Status: 301");
		header("location:".stripslashes($ptmp['pfile'])); exit;
	}

	/* включаем основной файл страницы */
	$smarty -> assign("tpldir",$_conf['tpl_dir']);
	$smarty -> assign("tpl_dir",$_conf['tpl_dir']);
	$smarty -> assign("wwwadres",$_conf['www_patch']);
	$smarty -> assign("timestamp",time());
	$smarty -> assign("conf",$_conf);
	$smarty -> assign("p",$p);

	loadBreadCrumbs();
	if(trim($ptmp['page_blocks'])!="") IncludePageBlocks(explode(",",$ptmp['page_blocks']));
	
	if(trim($ptmp['content_'.$_SESSION['lang']])=="" && $_SESSION['lang']!=$_conf['def_lang']) $ptmp['content_'.$_SESSION['lang']] = $ptmp['content_'.$_conf['def_lang']];
	$pcont = parseContent(stripslashes($ptmp['content_'.$_SESSION['lang']]), "page", $ptmp['pname']);
	if($ptmp['ptitle'] == "base"){
		$smarty -> assign("content",$pcont);
		$PAGE = $smarty -> fetch("showpage.tpl");
		$smarty -> assign("PAGE",$PAGE);
	}else{
		$smarty -> assign("content",$pcont);
		include($_conf['disk_patch'].$ptmp['pfile']);
		$smarty -> assign("PAGE",$PAGE);
	}

	if(trim($ptmp['p_title_'.$_SESSION['lang']])=="" && $_SESSION['lang']!=$_conf['def_lang']) $ptmp['p_title_'.$_SESSION['lang']] = $ptmp['p_title_'.$_conf['def_lang']];	
	if(isset($TITLE) && trim($TITLE) != "") $O_TITLE = $TITLE;
	elseif(isset($ptmp['p_title_'.$_SESSION['lang']]) && trim($ptmp['p_title_'.$_SESSION['lang']]) != "") $O_TITLE = stripslashes($ptmp['p_title_'.$_SESSION['lang']]);
	else $O_TITLE = htmlspecialchars($lang_ar['seo_def_title']);

	if(trim($ptmp['p_keywords_'.$_SESSION['lang']])=="" && $_SESSION['lang']!=$_conf['def_lang']) $ptmp['p_keywords_'.$_SESSION['lang']] = $ptmp['p_keywords_'.$_conf['def_lang']];	
	if(isset($KEYWORDS) && trim($KEYWORDS) != "") $O_KEYWORDS = $KEYWORDS;
	elseif(isset($ptmp['p_keywords_'.$_SESSION['lang']]) && trim($ptmp['p_keywords_'.$_SESSION['lang']]) != "") $O_KEYWORDS = stripslashes($ptmp['p_keywords_'.$_SESSION['lang']]);
	else $O_KEYWORDS = htmlspecialchars($lang_ar['seo_def_keywords']);

	if(trim($ptmp['p_description_'.$_SESSION['lang']])=="" && $_SESSION['lang']!=$_conf['def_lang']) $ptmp['p_description_'.$_SESSION['lang']] = $ptmp['p_description_'.$_conf['def_lang']];	
	if(isset($DESCRIPTION) && trim($DESCRIPTION) != "") $O_DESCRIPTION = $DESCRIPTION;
	elseif(isset($ptmp['p_description_'.$_SESSION['lang']]) && trim($ptmp['p_description_'.$_SESSION['lang']]) != "") $O_DESCRIPTION = stripslashes($ptmp['p_description_'.$_SESSION['lang']]);
	else $O_DESCRIPTION = htmlspecialchars($lang_ar['seo_def_description']);

	if(!isset($CURPATCH)) $CURPATCH = "";

	$smarty -> assign("HEADER",isset($HEADER) ? $HEADER : "");
	$smarty -> assign("TITLE",$O_TITLE);
	$smarty -> assign("KEYWORDS",$O_KEYWORDS);
	$smarty -> assign("DESCRIPTION",$O_DESCRIPTION);
	$smarty -> assign("CURPATCH",$CURPATCH);
	$smarty -> assign("debug",$debug);
	$smarty -> assign("langs",$_SESSION['fl']);

	if(isset($_SESSION['USER_IDU'])) WorkerCount();

	/* Базовый (структурный) шаблон заданный для файла в каталоге СТРУКТУРА */
	$FULLPAGE = $smarty -> fetch($ptmp['ptemplate']);
	if($_conf['url_type'] == 1) $FULLPAGE = rewrite_url($FULLPAGE,$_conf);

	if($p == "403"){
		header("HTTP/1.0 403"); 
		header("Status: 403");
	}else if ($p == "404"){
		header("HTTP/1.0 404"); 
		header("Status: 404");
	}else{
		header("HTTP/1.0 200 OK"); 
		header("Status: 200");
	}
	header("Content-Type: text/html; charset=".$_conf['encoding']);
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	if($LASTMODIFIED=="" || $LASTMODIFIED==0) $LASTMODIFIED = time()-72000;
	header("Last-Modified: " . date("D, d M Y H:i:s", $LASTMODIFIED) . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	$_SESSION['curpage'] = $_conf['www_patch'].$_SERVER['REQUEST_URI'];

$db -> Close();

echo $FULLPAGE;
			
			if($debug == true){
				$ddd = microtime(); $ddd = ((double)strstr($ddd, ' ') + (double)substr($ddd,0,strpos($ddd,' ')));
				$time_ind = number_format(($ddd - $ttt),3);
				$totq = $EXECS + $CACHED;
				$str = date("H:i:s",time())."<br />
				<strong>memory_get_usage: ".get_filesize(memory_get_usage())."</strong><br />
				<strong>memory_get_peak_usage: ".get_filesize(memory_get_peak_usage(true))."</strong><br />
				<strong>Время генерации страницы: ".$time_ind." сек</strong><br />
				<strong>Всего запросов к БД: ".$totq."</strong><br />
				&nbsp;&nbsp;Выполненных запросов: ".$EXECS."<br />
				&nbsp;&nbsp;Кешированных запросов: ".$CACHED."<br />
				<strong>REQUEST:</strong><pre>".print_r($_REQUEST, 1)."</pre>
				<strong>SESSION:</strong><pre>".print_r($_SESSION, 1)."</pre>
				<strong>COOKIE:</strong><pre>".print_r($_COOKIE, 1)."</pre>
				<strong>CMS:</strong><pre>".print_r($CMS, 1)."</pre>
				<strong>SERVER:</strong><pre>".print_r($_SERVER, 1)."</pre>
				";
				echo "<br /><br /><div id='debug1' style='border:solid 1px blue; padding:3px; background:#E8F1F7; text-align:left;'>".$str."</div>";
			}

ob_end_flush();
exit;

?>