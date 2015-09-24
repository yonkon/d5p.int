<?php
/**
 * Вывод информации о событиях для различных групп пользователей
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

	$allmsg = Super_Informer($_SESSION['USER_GROUP']);
	/*
	if($_SESSION['USER_GROUP']=="super" || $_SESSION['USER_GROUP']=="administrator") $allmsg = Super_Informer($_SESSION['USER_GROUP']);
	if($_SESSION['USER_GROUP']=="manager") $allmsg = Super_Informer();
	*/


function Super_Informer(){
	global $_conf,$db,$smarty;
	$allmsg="";

	/* проверяем на наличие новых сообщений в гостевой книге */
	/*
	$r = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."guestbook WHERE  g_state='new'");
	$t = $r -> GetRowAssoc(false);
	if($t['count(*)'] > 0) $allmsg .= "У вас есть новые сообщения (".$t['count(*)'].") в <a href='admin.php?p=admin_guestbook'>гостевой книге</a>!<br />";
	*/
	/**
	* Проверка событий из календаря для всех групп пользователей
	*/
	$q = "SELECT * FROM ".$_conf['prefix']."calendar WHERE idu='$_SESSION[USER_IDU]' AND alert_informer='y' AND ".time()." BETWEEN starttime AND instime";
	$r = $db -> Execute($q);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$qs = "&act=LoadAlert&calendarOutType=DAY&day=".date("j",$t['instime'])."&week=".date("w",$t['instime'])."&month=".date("n",$t['instime'])."&year=".date("Y",$t['instime']);
		$allmsg .= "<a title='Календарь' href='javascript:void(null)' onClick=\"calwin=dhtmlwindow.open('CalendarBox', 'inline', '', 'Календарь', 'width=790px, height=580px, left=50px, top=70px, resize=1, scrolling=1'); calwin.moveTo('middle', 'middle'); getdata('', 'get', '?p=calendar".$qs."', 'CalendarBox_inner'); return false; \">".stripslashes($t['rtitle'])."</a><br />";
		$r -> MoveNext();
	}
	/**
	* Проверка новых сообщений из формы обратной связи
	*/
	$q = "SELECT count(*) FROM ".$_conf['prefix']."feedback WHERE state='new'";
	$r = $db -> Execute($q);
	$t = $r -> GetRowAssoc(false);
	if($t['count(*)'] > 0) $allmsg .= "<a title='Календарь' href='admin.php?p=feedback_manage' >Новые сообщения из формы обратной связи (".$t['count(*)'].")</a><br />";
	
	/**
	* Проверка на наличие новых зарегистрированных пользователей
	*/
	$q = "SELECT count(*) FROM ".$_conf['prefix']."users WHERE state='new'";
	$r = $db -> Execute($q);
	$t = $r -> GetRowAssoc(false);
	if($t['count(*)'] > 0) $allmsg .= "<a title='Новые пользователи' href='".$_SERVER['PHP_SELF']."?p=admin_users&s_state=new' >На сайте зарегистрировались новые пользователи (".$t['count(*)'].")</a><br />";

	$mod = getInstalledModules();
	while(list($k,$v)=each($mod)){
		$mod_func = '_alert'.$k;
		if(function_exists($mod_func)){
			$allmsg .= call_user_func($mod_func);
		}
		
	}

	return $allmsg;
}


?>