<?php
/**
 * Редактирование личных данных пользователем
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00 12.07.2009
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['fb_act']) && $_REQUEST['fb_act']=="sendEditData"){
	$res = array();
	$res['state'] = "OK";
	$res['errormsg'] = "";
	$res['successmsg'] = "";
	if(trim($_REQUEST['login'])=="" || trim($_REQUEST['fio'])=="" || trim($_REQUEST['mphone'])=="" || trim($_REQUEST['email'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er3']."\n";
	}
	if(trim($_REQUEST['pass'])!="" && $_REQUEST['pass']!=$_REQUEST['pass1']){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er4']."\n";
	}
	$e = $db -> Execute("SELECT email FROM ".$_conf['prefix']."users WHERE email='".mysql_real_escape_string($_REQUEST['email'])."' AND email!='".mysql_real_escape_string($_REQUEST['email_old'])."'");
	if($e -> RecordCount() != 0){
		$res['state'] = "ERROR";
		$res['errormsg'] .= sprintf($lang_ar['reg_er7'], stripslashes($_REQUEST['email']))."\n";
	}
	/**
	*  Если нет ошибок  - регистрируем
	*/
	if($res['state'] == "OK"){
		$res['successmsg'] = "";
		$r = $db -> Execute("UPDATE ".$_conf['prefix']."users SET
		email='".mysql_real_escape_string($_REQUEST['email'])."'
		WHERE idu='$_SESSION[USER_IDU]'");
		$r = $db -> Execute("UPDATE ".$_conf['prefix']."users_add SET
		fio='".mysql_real_escape_string($_REQUEST['fio'])."', 
		contact='".mysql_real_escape_string($_REQUEST['contact'])."', 
		city='".mysql_real_escape_string($_REQUEST['company'])."', 
		mphone='".mysql_real_escape_string($_REQUEST['mphone'])."'
		WHERE idu='$_SESSION[USER_IDU]'");
		if(trim($_REQUEST['pass'])!=""){
			$r = $db -> Execute("UPDATE ".$_conf['prefix']."users SET
			password='".mysql_real_escape_string($_REQUEST['pass'])."'
			WHERE idu='$_SESSION[USER_IDU]'");
		}
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
				$name = array("files/avatars/".$_SESSION['USER_IDU'].".jpg");
				$img -> width = $width;
				$img -> height = $height;
				$img -> fname = $name;
				$ares = $img -> ResizeImage($_FILES['avatar']);
				if($ares != 1){
					$res['successmsg'] .= $ares."\n";
				}
		}
		$res['successmsg'] .= $lang_ar['uedit_saved'];
	}
	$GLOBALS['_RESULT'] = $res;
}

if(!isset($_REQUEST['fb_act'])){
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."users LEFT JOIN ".$_conf['prefix']."users_add USING(idu) WHERE idu='$_SESSION[USER_IDU]'");
	$t = $r -> GetRowAssoc(false);
	while(list($k,$v) = each($t)) $t[$k] = stripslashes($v);
	$smarty -> assign("t",$t);
	if(file_exists("files/avatars/".$_SESSION['USER_IDU'].".jpg")) $smarty -> assign("avatar", "files/avatars/".$_SESSION['USER_IDU'].".jpg");
	$PAGE = $smarty -> fetch("useredit.tpl");

}
?>