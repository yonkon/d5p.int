<?
/**
* Основной скрипт кабинета автора
* @package ShiftCMS
* @subpackage Remote
* @author Volodymyr Demchuk http://shiftcms.net
* @version 1.00 15.02.2011
*/
/*
$fp = fopen("request.txt","w");
fwrite($fp,print_r($_REQUEST,1));
fclose($fp);
*/
session_start();
ob_start();
error_reporting(E_ALL & ~E_NOTICE);

define('SHIFTCMS',true);
require(dirname(__FILE__)."/include/config/config.php");
define("uchet_addr", $_conf['remote_server']);
define("uchetwsdl", false);
define("uchetdebug", false);
require(dirname(__FILE__)."/client.php");

if(!isset($_SESSION['A_USER_IDU']) && isset($_COOKIE['A_USER_IDU'])) Authorize();
if(isset($_REQUEST['act']) && $_REQUEST['act']=="authorize" && !isset($_SESSION['A_USER_IDU'])) include(dirname(__FILE__)."/include/auth.php");
if(isset($_REQUEST['act']) && $_REQUEST['act']=="restorePass" && !isset($_SESSION['A_USER_IDU'])) include(dirname(__FILE__)."/include/restorepass.php");
if(!isset($_SESSION['A_USER_IDU'])) {include(dirname(__FILE__)."/template/enter.php"); header("Content-Type: text/html; charset=Windows-1251"); ob_end_flush(); exit;}

$p = isset($_REQUEST['p']) ? stripslashes($_REQUEST['p']) : 'main';
$p = array_key_exists($p, $_conf['pages']) ? $p : 'main';
$PAGE = ''; $HEADER = '';
$PAGETITLE = $_conf['pages'][$p][2];


if(isset($_REQUEST['JsHttpRequest'])){
	require_once(dirname(__FILE__)."/include/ajax/config.php");
	require_once(dirname(__FILE__)."/include/ajax/JsHttpRequest.php");
	//$JsHttpRequest =& new JsHttpRequest("windows-1251");
	function & ref_new(&$new_statement) { return $new_statement; }
	$JsHttpRequest =& ref_new(new JsHttpRequest("windows-1251"));
	
	isset($_REQUEST['q']) ? $q = $_REQUEST['q'] : $q="";
	$_RESULT = array("q" => $q, "md5" => md5($q), 'hello' => isset($_SESSION['hello'])? $_SESSION['hello'] : null, 'upload'=> print_r($_FILES, 1)); 
	if (strpos($q, 'error') !== false) { callUndefinedFunction(); }
	if(!stristr($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) exit;
	include($_conf['pages'][$p][1]);
	header("Content-Type: text/html; charset=Windows-1251");
	echo trim($PAGE);
}else{
	include($_conf['pages'][$p][1]);
	include(dirname(__FILE__)."/template/admin.php");
	header("Content-Type: text/html; charset=Windows-1251");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	//echo '<pre>'.print_r($res,1).'</pre>';
	//echo '<pre>'.print_r($_REQUEST,1).'</pre>';
}
/*
$fp = fopen("page.txt","w");
fwrite($fp,$PAGE);
fclose($fp);
*/
ob_end_flush();
exit;

?>