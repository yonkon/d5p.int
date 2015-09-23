<?php
/**
 * Регистрация пользователей на сайте
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00 12.07.2009
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_SESSION['USER_IDU'])){ header("location:/"); exit; }

if(isset($_REQUEST['fb_act']) && $_REQUEST['fb_act']=="CheckLogin"){
	$r = $db -> Execute("SELECT login FROM ".$_conf['prefix']."users WHERE login='".mysql_real_escape_string($_REQUEST['login'])."'");
	if($r -> RecordCount() > 0) echo "<font color='red'>".sprintf($lang_ar['reg_er1'], stripslashes($_REQUEST['login']))."</font>";
}
if(isset($_REQUEST['fb_act']) && $_REQUEST['fb_act']=="CheckEmail"){
	$r = $db -> Execute("SELECT email FROM ".$_conf['prefix']."users WHERE email='".mysql_real_escape_string($_REQUEST['email'])."'");
	if($r -> RecordCount() > 0) echo "<font color='red'>".sprintf($lang_ar['reg_er2'], stripslashes($_REQUEST['email']))."</font>";
}

if(isset($_REQUEST['fb_act']) && $_REQUEST['fb_act']=="sendRegisterData"){
	$res = array();
	$res['state'] = "OK";
	$res['errormsg'] = "";
	$res['successmsg'] = "";
	
	if(trim($_REQUEST['login'])=="" || trim($_REQUEST['pass'])=="" || trim($_REQUEST['fio'])=="" || trim($_REQUEST['mphone'])=="" || trim($_REQUEST['email'])=="" || trim($_REQUEST['check_code'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er3']."\n";
	}
	if($_REQUEST['pass']!=$_REQUEST['pass1']){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er4']."\n";
	}

	if($_REQUEST['check_code']!=$_SESSION['check_code']){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er5']."\n";
	}
	$r = $db -> Execute("SELECT login FROM ".$_conf['prefix']."users WHERE login='".mysql_real_escape_string($_REQUEST['login'])."'");
	if($r -> RecordCount() != 0){
		$res['state'] = "ERROR";
		$res['errormsg'] .= sprintf($lang_ar['reg_er6'], stripslashes($_REQUEST['login']))."\n";
	}
	$e = $db -> Execute("SELECT email FROM ".$_conf['prefix']."users WHERE email='".mysql_real_escape_string($_REQUEST['email'])."'");
	if($e -> RecordCount() != 0){
		$res['state'] = "ERROR";
		$res['errormsg'] .= sprintf($lang_ar['reg_er7'], stripslashes($_REQUEST['email']))."\n";
	}
	/**
	*  Если нет ошибок  - регистрируем
	*/
	if($res['state'] == "OK"){
		$res['successmsg'] = "";
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."users (email, login, password, dreg, dacc, ip, group_code, state) VALUES
		('".mysql_real_escape_string($_REQUEST['email'])."', 
		'".mysql_real_escape_string($_REQUEST['login'])."', '".mysql_real_escape_string($_REQUEST['pass'])."', 
		'".time()."','".time()."', '".$_SERVER['REMOTE_ADDR']."', 'client', 'new')");
		$idu = $db -> Insert_ID();
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."users_add (idu, fio, contact, city, icq, phone, mphone) VALUES
		('$idu', '".mysql_real_escape_string($_REQUEST['fio'])."', 
		'".mysql_real_escape_string($_REQUEST['contact'])."', '".mysql_real_escape_string($_REQUEST['company'])."', 
		'','', '".mysql_real_escape_string($_REQUEST['mphone'])."')");

		if(isset($_FILES['avatar']) && $_FILES['avatar']['name']!=""){
			include "include/uploader.php";
			$upl = new uploader;
			if(!is_dir("files/avatars")) $upl -> MakeDir("files/avatars");
			
			include "include/imager.php";
			$img = new imager;
				$img -> crop = array("");
				$img -> whatcrop = array("");
				$img -> desttype = array("thumb");
				$width = array($_conf['avatar_w']);
				$height = array($_conf['avatar_w']);
				$name = array("files/avatars/".$idu.".jpg");
				$img -> width = $width;
				$img -> height = $height;
				$img -> fname = $name;
				$ares = $img -> ResizeImage($_FILES['avatar']);
				if($ares != 1){
					$res['successmsg'] .= $ares."\n";
				}
		}

		
		$smarty -> assign("fio", stripslashes($_REQUEST['fio']));
		$smarty -> assign("login", stripslashes($_REQUEST['login']));
		$smarty -> assign("password", stripslashes($_REQUEST['pass']));
		$smarty -> assign("sitename", $_conf['www_patch']);
		$message = $smarty -> fetch("db:reguser_".$_SESSION['lang'].".tpl");
		SendEmail(0, $_conf['sup_email'], $_conf['site_name'], 0, stripslashes($_REQUEST['email']), stripslashes($_REQUEST['fio']), $_conf['site_name']." - Регистрация на сайте", $message);
		
		$res['successmsg'] .= "<strong>".$lang_ar['reg_success']."</strong>";
		
	}
	$GLOBALS['_RESULT'] = $res;
}

if(!isset($_REQUEST['fb_act'])){
	$PAGE = $smarty -> fetch("register.tpl");
	
}
?>