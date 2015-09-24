<?php
/**
 * Главный файл для выполнения AJAX-запросов
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.01.02
 */
$debug = $_SERVER['REMOTE_ADDR']=="127.0.0.1" ? true : false;
if($debug == true){$ttt = microtime();$ttt = ((double)strstr($ttt, ' ') + (double)substr($ttt,0,strpos($ttt,' ')));}

if(!isset($_REQUEST['JsHttpRequest'])) exit;
if(!stristr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) exit;

ob_start("ob_gzhandler");
session_start();
define('SHIFTCMS',true);
$CMS = array();

if($_REQUEST['PHPSESSID'] != session_id()) exit;
include('./include/config/set.inc.php'); 

if(!isset($_SESSION['admin_lang'])) $_SESSION['admin_lang'] = $_conf['def_admin_lang'];
if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $_conf['def_lang'];

require_once "./include/ajax/config.php";
require_once "./include/ajax/JsHttpRequest.php";

function & ref_new(&$new_statement) { return $new_statement; }
$JsHttpRequest =& ref_new(new JsHttpRequest($_conf['encoding']));

isset($_REQUEST['q']) ? $q = $_REQUEST['q'] : $q="";

$_RESULT = array(
  "q"     => $q,
  "md5"   => md5($q),
  'upload'=> print_r($_FILES, 1),
); 

if (strpos($q, 'error') !== false) { callUndefinedFunction(); }
if (isset($_REQUEST['dt'])) { sleep($_REQUEST['dt']); }

define('ADODB_ERROR_LOG_TYPE',3); 
define('ADODB_ERROR_LOG_DEST', $_SERVER['DOCUMENT_ROOT'].$_conf['www_dir']."/tmp/log/sql_error.log"); 
$ADODB_CACHE_DIR = './tmp/ADOdbcache'; 

include('./include/adodb/adodb-errorhandler.inc.php'); 
include('./include/adodb/adodb.inc.php'); 
include('./include/main_function.php');
require "./include/user_function.php";

			if($debug == true){
				$CACHED=$EXECS=0;
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
//    $db->debug = true; 
    $db -> Connect($host, $user, $pass, $base); 
	$db -> cacheSecs = 60;
    $rs = $db -> Execute('SET NAMES '.$_conf['encoding_db']); 

			if($debug == true){
				$db->LogSQL(); // turn on logging
				$db->fnExecute = 'CountExecs';
				$db->fnCacheExecute = 'CountCachedExecs';
			}	
	$lang_db = load_conf_var();
	
	loadModuleFunction();
	loadSiteStructure();

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

$alang_ar = $lang_ar = $lang_db;
$smarty -> assign("lang", $lang_ar);
$smarty -> assign("alang", $alang_ar);

	if(isset($_COOKIE['USER_IDU'])) authenticate($_COOKIE['USER_IDU']);

$p="not_found";
if(isset($_REQUEST['p'])) $p=$_REQUEST['p'];

$rs = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pname='".mysql_real_escape_string($p)."'");
  $ptmp = $rs -> GetRowAssoc();
  if($rs -> RecordCount() == 0){
     $rs = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pname='main'");
     $ptmp = $rs -> GetRowAssoc();
  }
  
if(!isset($_SESSION['USER_GROUP'])) $_SESSION['USER_GROUP']="guest";  
$ug = explode(",",$ptmp['PGROUPS']);  
if(!in_array($_SESSION['USER_GROUP'],$ug)){
 header("Location:/");
 exit;
}

//--------------PARSE ACTION--------------------------------
$smarty->assign("tpldir",$_conf['tpl_dir']);
$smarty->assign("tpl_dir",$_conf['tpl_dir']);
$smarty->assign("wwwadres",$_conf['www_patch']);

$smarty->assign("tpldir",$_conf['tpl_dir']);
$smarty->assign("wwwadres",$_conf['www_patch']);
$smarty->assign("conf",$_conf);

WorkerCount();

$PAGE=get_include_contents($ptmp['PFILE'],$_conf);//.$_SERVER['PHP_SELF'].' = '.$_SERVER['REQUEST_URI'];

			if($debug == true){
				$ddd=microtime(); $ddd=((double)strstr($ddd, ' ')+(double)substr($ddd,0,strpos($ddd,' ')));
				$time_ind=number_format(($ddd-$ttt),3);

				$totq = $EXECS+$CACHED;
				$str = date("H:i:s",time())."<br />
				<strong>Использовано памяти: ".get_filesize(memory_get_usage())."</strong><br />
				<strong>Время генерации страницы: $time_ind сек</strong><br />
				<strong>Всего запросов к БД: $totq</strong><br />
				&nbsp;&nbsp;Выполненных запросов: $EXECS<br />
				&nbsp;&nbsp;Кешированных запросов: $CACHED<br />
				<strong>REQUEST:</strong><pre>".print_r($_REQUEST, 1)."</pre>
				<strong>SESSION:</strong><pre>".print_r($_SESSION, 1)."</pre>
				<strong>COOKIE:</strong><pre>".print_r($_COOKIE, 1)."</pre>";
				$str = str_replace("\n","<br />",$str);
				$str = str_replace("\r","",$str);

				$PAGE .= '
					<script type="text/javascript">
						ShowDebug("'.$str.'");
					</script>
				';
				}

$smarty -> assign("PAGE", $PAGE);

header("HTTP/1.0 200 OK"); 
header("Status: 200");
header("Content-Type: text/html; charset=".$_conf['encoding']);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$smarty -> display("db:asimple.tpl");

$db -> Close();
ob_end_flush();
?>
