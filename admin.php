<?php
/**
 * Главный файл системы управления
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.02.02
 */
$debug = $_SERVER['REMOTE_ADDR']=="127.0.0.1" ? true : false;
if($debug == true){$ttt = microtime();$ttt = ((double)strstr($ttt, ' ') + (double)substr($ttt,0,strpos($ttt,' ')));}

ob_start("ob_gzhandler");
session_start();
define('SHIFTCMS',true);
$CMS = array();
$HEADER = "";

include('./include/config/set.inc.php'); 

if(isset($_REQUEST['admin_lang'])) $_SESSION['admin_lang'] = $_REQUEST['admin_lang'];
if(!isset($_SESSION['admin_lang'])) $_SESSION['admin_lang'] = $_conf['def_admin_lang'];
if(isset($_REQUEST['lang'])) $_SESSION['lang'] = $_REQUEST['lang'];
if(!isset($_SESSION['lang'])) $_SESSION['lang'] = $_conf['def_lang'];

define('ADODB_ERROR_LOG_TYPE',3); 
define('ADODB_ERROR_LOG_DEST', $_SERVER['DOCUMENT_ROOT']."/tmp/log/sql_error.log"); 
$ADODB_CACHE_DIR = './tmp/ADOdbcache'; 
include('./include/adodb/adodb-errorhandler.inc.php'); 
include('./include/adodb/adodb.inc.php'); 
include('./include/main_function.php');
require('./include/user_function.php');

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
	//$db->debug = true; 
    $db -> Connect($host, $user, $pass, $base); 
	$db -> cacheSecs = 60;
			if($debug == true){
				$db -> LogSQL(); // turn on logging
				$db -> fnExecute = 'CountExecs';
				$db -> fnCacheExecute = 'CountCachedExecs';
			}
    $rs = $db -> _Execute('SET NAMES '.$_conf['encoding_db']); 

		if(!isset($_SESSION['fl'])){
			$fl = GetLangField(); $_SESSION['fl'] = $fl; 
		}
		if(!in_array($_SESSION['admin_lang'],$_SESSION['fl'])) $_SESSION['admin_lang'] = $_conf['def_admin_lang'];
	
	$alang_ar = $lang_ar = load_conf_var();
	
	loadModuleFunction();
	loadSiteStructure();

	require($_conf['disk_patch']."include/smarty/Smarty.class.php");
	require($_conf['disk_patch']."include/smarty/sysplugins/smarty_custom_mysql.php");
	$smarty = new Smarty();
	//$smarty -> debugging = true;
	// ASSIGN SMARTY TEMPLATE DIRECTORY PATHS
	$smarty->setTemplateDir($_conf['disk_patch'].$_conf['admin_tpl_dir']);
	$smarty->setCompileDir($_conf['disk_patch']."tmp/templates_c".atemplateSubdir());
	$smarty->setCacheDir($_conf['disk_patch']."tmp/cache");
	$smarty->setConfigDir($_conf['disk_patch']."include/smarty/configs");
	$smarty->registerResource('db', new Smarty_Resource_Mysql());


if(isset($_COOKIE['USER_IDU'])) authenticate($_COOKIE['USER_IDU']);

if(!isset($_SESSION['GROUP_ACCESS']) || $_SESSION['GROUP_ACCESS']!='y'){
		$rurl[2] = '?p=enter';
		$ru = $_conf['url_type'] == 1 ? _rewrite_url($rurl,false) : $rurl[2];
		header("Location:".$ru);
		exit;
}

if(isset($_REQUEST['p'])) $p = $_REQUEST['p'];
else $p = "admin_main";
/* ******* UNLOCK ACCAUNT *******************/
if(isset($_REQUEST['x']) && isset($_REQUEST['code']) && $_REQUEST['x'] == "unlock"){
	$er = unclock_accaunt();
		$rurl[2] = '?p=enter&er='.$check;
		$ru = $_conf['url_type'] == 1 ? _rewrite_url($rurl,false) : $rurl[2];
		header("Location:".$ru);
		exit;
}
//-----------check runtime acces ----------------------
	$rs = $db -> _Execute("SELECT * FROM ".$_conf['prefix']."users WHERE idu='".$_SESSION['USER_IDU']."'");
	$t = $rs -> GetRowAssoc();
	if($t['TIME_ACC'] != $_SESSION['TIME_ACC'] && $_SERVER['REMOTE_ADDR'] != $t['IP_ACC'] && $_SESSION['TIME_ACC'] - $t['TIME_ACC'] > 3600){
		block_accaunt();
		exit;
	}else if($t['BLOCK_ACC'] == '1'){
		$rurl[2] = '?p=enter&er=4';
		$ru = $_conf['url_type'] == 1 ? _rewrite_url($rurl,false) : $rurl[2];
		header("Location:".$ru);
		exit;
	}else{
		$tm = time();
		$_SESSION['TIME_ACC'] = $tm;
		$rs = $db -> _Execute("UPDATE ".$_conf['prefix']."users SET time_acc='".$tm."',ip_acc='".$_SERVER['REMOTE_ADDR']."' WHERE `idu`='".$_SESSION['USER_IDU']."'");
	 }


//--------------PARSE ACTION----------------------------------
$p="admin_main";
if(isset($_REQUEST['p'])) $p = $_REQUEST['p'];
$rs = $db -> _Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pname='".mysql_real_escape_string($p)."'");
	$ptmp = $rs -> GetRowAssoc();
	if($rs -> RecordCount() == 0){
		$rs = $db -> _Execute("SELECT * FROM ".$_conf['prefix']."page WHERE pname='admin_main'");
		$ptmp = $rs -> GetRowAssoc();
	}

$ug = explode(",",$ptmp['PGROUPS']);  
if(!in_array($_SESSION['USER_GROUP'],$ug)){
	header("Location:/");
	exit;
}

$TITLE = $ptmp['P_TITLE_'.strtoupper($_SESSION['admin_lang'])];
$inc_file = $ptmp['PFILE'];

$smarty -> assign("tpldir",$_conf['tpl_dir']);
$smarty -> assign("tpl_dir",$_conf['tpl_dir']);
$smarty -> assign("wwwadres",$_conf['www_patch']);
$smarty -> assign("conf",$_conf);

$PAGE = get_include_contents($inc_file,$_conf);

$smarty -> assign("PAGE",$PAGE);
$smarty -> assign("HELP",$ptmp['PHELP']);
$smarty -> assign("alang",$alang_ar);

//$smarty->assign("jsmenu",$jsmenu);
$smarty -> assign("HEADER",$HEADER);
$smarty -> assign("TITLE",$TITLE);

$smarty->assign("NewMessage", Informer());

$smarty -> assign("fly_menu",flyMenu());

$smarty -> assign("debug",$debug);
$langs = GetLangField();
if(count($langs) > 1){
	$smarty -> assign("langs",$langs);
	$smarty -> assign("lw",count($langs)*24);
}

/* Базовый (структурный) шаблон заданный для файла */
header("HTTP/1.0 200 OK"); 
header("Status: 200");
header("Content-Type: text/html; charset=".$_conf['encoding']);
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$FULLPAGE = $smarty -> fetch($ptmp['PTEMPLATE']);

			if($debug == true){
				$ddd = microtime(); $ddd = ((double)strstr($ddd, ' ') + (double)substr($ddd,0,strpos($ddd,' ')));
				$time_ind = number_format(($ddd - $ttt),3);

				$totq = $EXECS + $CACHED;
				$str = date("H:i:s",time())."<br />
				<strong>Использовано памяти: ".get_filesize(memory_get_usage())."</strong><br />
				<strong>Время генерации страницы: $time_ind сек</strong><br />
				<strong>Всего запросов к БД: $totq</strong><br />
				&nbsp;&nbsp;Выполненных запросов: $EXECS<br />
				&nbsp;&nbsp;Кешированных запросов: $CACHED<br />
				<strong>REQUEST:</strong><pre>".print_r($_REQUEST, 1)."</pre>
				<strong>SESSION:</strong><pre>".print_r($_SESSION, 1)."</pre>
				<strong>COOKIE:</strong><pre>".print_r($_COOKIE, 1)."</pre>
				<strong>CMS:</strong><pre>".print_r($CMS, 1)."</pre>
				<strong>FILES:</strong><pre>".print_r($_FILES, 1)."</pre>";
				echo $FULLPAGE."<br /><br /><div id='debug1' style='border:solid 1px blue; padding:3px; background:#E8F1F7;'>".$str."</div>";
			}else{
				echo $FULLPAGE;
			}
$db -> Close();
ob_end_flush();
exit;

/* ******************************************************************************* */
/* ***********************   function ******************************************** */
/* ******************************************************************************* */
function block_accaunt(){
	global $_conf,$db,$smarty;
	$rs = $db->_Execute("SELECT * FROM ".$_SESSION['conf']['prefix']."users WHERE idu='$_SESSION[ADMIN_IDU]'");
	$t=$rs->GetRowAssoc();
	$subject="$_conf[site_name] - Аккаунт заблокирован!";
	$message="<p><strong>Здравствуйте, $_SESSION[ADMIN_LOGIN]!</strong></p>
	<p>Ваш аккаунт был заблокирован в связи с одновременным входом в него с двух различных IP-адресов!</p>
	<p>1 пользователь: IP $_SERVER[REMOTE_ADDR]</p>
	<p>2 пользователь: IP $t[IP_ACC]</p>
	<p>Время входа второго пользователя: ".date("d/m/Y H:i",time())."</p>
	<p>Для того, чтобы разблокировать аккаунт, воспользуйтесь ссылкой ниже (щелкните по ней или скопируйте и вставьте в адресную строку броузера):</p>
	<p><a href='$_conf[www_patch]/admin.php?x=unlock&code=".session_id()."'>$_conf[www_patch]/admin.php?x=unlock&code=".session_id()."</a></p>
	<p>После разблокировки аккаунта, рекомендуется сменить пароль.</p>
	<p><a href='$_conf[www_patch]'>$_conf[site_name]</a></p>
	";
        	 $headers  = "MIME-Version: 1.0" . "\n";
	         $headers .= "Content-type: text/html; charset=utf-8" . "\n";
        	 $headers .= "From: $_conf[sup_email]" . "\n";
			 $headers .= "Reply-To: $_conf[sup_email]" . "\n";
    	     mail($_SESSION['ADMIN_EMAIL'], $subject, $message, $headers);
	$rs = $db->_Execute("UPDATE ".$_SESSION['conf']['prefix']."users SET block_acc='1',code_acc='".session_id()."' WHERE `idu`='$_SESSION[ADMIN_IDU]'");
}

function unclock_accaunt(){
	global $_conf,$db,$smarty;
	$rs = $db->_Execute("SELECT * FROM ".$_conf['prefix']."users WHERE code_acc='$_REQUEST[code]'");
	if($rs -> RecordCount() == 1){
		$rs = $db->_Execute("UPDATE ".$_conf['prefix']."users SET block_acc='0' WHERE code_acc='$_REQUEST[code]'");
		return 6;
	}else{
		return 7;
	}
}


?>
