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

if(isset($_REQUEST['fb_act']) && $_REQUEST['fb_act']=="sendFeedBackData"){
	$res = array();
	$res['state'] = "OK";
	$res['errormsg'] = "";
	$res['successmsg'] = "";
	if(trim($_REQUEST['name'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['fb_er1']."\n";
	}
	if(trim($_REQUEST['phone'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['fb_er2']."\n";
	}
	if(trim($_REQUEST['ftext'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['fb_er3']."\n";
	}
	if($res['state'] == "OK"){
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."feedback (date, name, company, phone, ftext, state, email) VALUES
		('".time()."', '".mysql_real_escape_string($_REQUEST['name'])."', 
		'".mysql_real_escape_string($_REQUEST['company'])."', '".mysql_real_escape_string($_REQUEST['phone'])."', 
		'".mysql_real_escape_string(strip_tags($_REQUEST['ftext']))."', 'new', 
		'".mysql_real_escape_string(strip_tags($_REQUEST['email']))."')");
		
		$message = "<strong>".$lang_ar['fb_msg1']."</strong><br />
		<strong>".$lang_ar['fb_msg2'].":</strong> ".date("d.m.Y H:i",time())."<br />
		<strong>".$lang_ar['fb_msg3'].":</strong> ".stripslashes($_REQUEST['name'])."<br />
		<strong>".$lang_ar['fb_msg4'].":</strong> ".stripslashes($_REQUEST['company'])."<br />
		<strong>".$lang_ar['fb_msg5'].":</strong> ".stripslashes($_REQUEST['phone'])."<br />
		<strong>E-mail:</strong> ".stripslashes($_REQUEST['email'])."<br />
		<strong>".$lang_ar['fb_msg6'].":</strong><br />".strip_tags(stripslashes($_REQUEST['ftext']))."<br />";
		SendEmail(0, stripslashes($_REQUEST['email']), stripslashes($_REQUEST['name']), 0, $_conf['sup_email'], $_conf['site_name'], $_conf['site_name']." - ".$lang_ar['fb_msg7'], $message);
		$res['successmsg'] = $lang_ar['fb_msg8'];
		
	}
	$GLOBALS['_RESULT'] = $res;
}

if(!isset($_REQUEST['fb_act'])){
	$PAGE = $smarty -> fetch("feedback.tpl");
}
?>