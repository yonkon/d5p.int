<?php
/**
 * Скрипт авторизации пользователей системы
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.01.04
 */
ob_start();
session_start();
define('SHIFTCMS',true);
include('./include/config/set.inc.php'); 

include('./include/adodb/adodb.inc.php'); 
include('./include/main_function.php');

    $db = ADONewConnection("mysql"); 
    $db -> debug = false; 
    $db -> Connect($host, $user, $pass, $base); 
    
    $rs = $db -> Execute('SET NAMES '.$_conf['encoding_db']);
    
if(!isset($_SESSION['try_login'])) $_SESSION['try_login'] = 0;
else $_SESSION['try_login']++;

load_conf_var();

$check=0;
$ip1 = $_SERVER['REMOTE_ADDR'];
$ip_ar = explode(".",$ip1);
$ip_ar[3] = "*";
$ip2 = implode(".",$ip_ar);

if(isset($_POST['login'])){
   $rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."users WHERE login='".mysql_real_escape_string($_POST['login'])."'");
	  $tmp = $rs -> GetRowAssoc();//fields; 
	  $allow = 0;
		if(trim($tmp['ALLOWED_IP']) != ""){
	  		$allowed_ip = explode(",",$tmp['ALLOWED_IP']);
			if(!in_array($ip1, $allowed_ip) && !in_array($ip2, $allowed_ip)) $allow = 1;
		}
	  
	if($rs -> RecordCount() == 0) {
		$check = 3;
	}else if($_SESSION['try_login'] > 5) {
		$check = 5;
	}else if($allow == 1){
		$check = 9;
	}else{
		if($tmp['PASSWORD'] != $_POST['password']) $check = 2;
		else if($tmp['BLOCK_ACC'] == 1) $check = 4;
		else $check = 1;
	}
}
if($check==1) {
	$rg = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_group WHERE group_code='".$tmp['GROUP_CODE']."'");
	$tg = $rg -> GetRowAssoc();

	if(isset($_POST['authperiod']) && $_POST['authperiod']=="yes"){
		$stime = time()+3600*24*365;
	}else{
		$stime = time()+12*3600;
	}
	  $strong = md5($tmp['PASSWORD']."-".$tmp['LOGIN']."-".$tmp['IDU']);
	
      setcookie("AUTHPERIOD","yes",$stime);
      setcookie("strong", $strong, $stime);
      setcookie("USER_IDU", $tmp['IDU'], $stime);
      setcookie("USER_D", $_SERVER['HTTP_HOST'], $stime);

      $_SESSION['strong'] = $strong;
      $_SESSION['USER_IDU'] = $tmp['IDU'];
      $_SESSION['USER_D'] = $_SERVER['HTTP_HOST'];
      $_SESSION['USER_LOGIN'] = $tmp['LOGIN'];
      $_SESSION['USER_EMAIL'] = $tmp['EMAIL'];
      $_SESSION['USER_GROUP'] = $tmp['GROUP_CODE'];
      $_SESSION['GROUP_ACCESS'] = $tg['GROUP_ACCESS'];
      $_SESSION['GROUP_PRIORITY'] = $tg['GROUP_PRIORITY'];
      $_SESSION['USER_LAST_ACCES'] = $tmp['DACC'];
	  $tm = time();
      $_SESSION['TIME_ACC'] = $tm;
      $_SESSION['conf'] = $_conf;
      $rs = $db->Execute("UPDATE `".$_conf['prefix']."users` SET `dacc`='".time()."',`ip`='".$_SERVER['REMOTE_ADDR']."', `time_acc`='".$tm."',`ip_acc`='".$_SERVER['REMOTE_ADDR']."' WHERE `idu`='".$tmp['IDU']."'");
      $rs = $db->Execute("INSERT INTO `".$_conf['prefix']."enterlog` (id,idu,action,date,ip) VALUES ('', 
	  '".$tmp['IDU']."', 'Вход в систему с формы входа', '".time()."', '".$_SERVER['REMOTE_ADDR']."')");

	if($tg['GROUP_ACCESS']=='y'){
		$gopage="admin.php";
	}else{
		if(isset($_SESSION['curpage'])) $gopage = $_SESSION['curpage'];
		else $gopage = $_conf['www_patch']."/cabinet/";
	}
	header("Location:".$gopage);
}else{
		$rurl[2] = '?p=enter&er='.$check;
		$ru = $_conf['url_type'] == 1 ? _rewrite_url($rurl,false) : $rurl[2];
		header("Location:".$ru);
	//}
}

$db -> Close();
ob_end_flush();
exit;

?>