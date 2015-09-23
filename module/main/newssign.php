<?php
/**
 * Форма обратной связи для сайта
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01 06.07.2009
 */

if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['nsact']) && $_REQUEST['nsact']=="NewSign"){
	$res = array();
	$res['state'] = "OK";
	$res['errormsg'] = "";
	$res['successmsg'] = "";
	if(trim($_REQUEST['ns_name'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['fb_er1']."\n";
	}
	if(trim($_REQUEST['ns_email'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['ns_er_email']."\n";
	}
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."news_signed WHERE email='".mysql_real_escape_string(stripslashes($_REQUEST['ns_email']))."'");
	if($r -> RecordCount() > 0){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['ns_er_email1']."\n";
	}
	
	
	if($res['state'] == "OK"){
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."news_signed (name, email, time) VALUES
		('".mysql_real_escape_string($_REQUEST['ns_name'])."', 
		'".mysql_real_escape_string(strip_tags($_REQUEST['ns_email']))."',
		'".time()."')");
		$res['successmsg'] = $lang_ar['ns_ok_sign'];
		
	}
	$GLOBALS['_RESULT'] = $res;
}else{
	$newssign = $smarty->fetch("newssign.tpl");
}

?>