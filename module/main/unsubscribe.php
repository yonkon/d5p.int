<?php
/**
 * Отписаться от рассылки 
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['news_unsubscribe'])){
   $q="SELECT * FROM ".$_conf['prefix']."users WHERE email='$_REQUEST[email]'";
   $r = $db -> Execute($q);
   if($r -> RecordCount() == 0){
		$q="SELECT * FROM ".$_conf['prefix']."news_signed WHERE email='$_REQUEST[email]'";
		$r = $db -> Execute($q);
		if($r -> RecordCount() == 0){
			$smarty->assign("info_message","Извините, но указанный Вами e-mail: $_REQUEST[email] не найден в базе данных!");
			$reply = $smarty->fetch("messeg.tpl");
			$smarty -> assign("replymsg", $reply);
			unset($_REQUEST['news_unsubscribe']);
		}else{
			$q="DELETE FROM ".$_conf['prefix']."news_signed WHERE email='$_REQUEST[email]'";
			$r = $db -> Execute($q);
			$smarty->assign("info_message","Ваш e-mail: $_REQUEST[email] удален из списков рассылки!");
			$reply = $smarty->fetch("messeg.tpl");
			$smarty -> assign("replymsg", $reply);
		}
   }else{
		$q="UPDATE ".$_conf['prefix']."users SET newssign='1' WHERE email='$_REQUEST[email]'";
		$r = $db -> Execute($q);
		$smarty->assign("info_message","Ваш e-mail: $_REQUEST[email] удален из списков рассылки!");
		$reply = $smarty->fetch("messeg.tpl");
		$smarty -> assign("replymsg", $reply);
   }

}

$PAGE = $smarty -> fetch("db:unsubscribe.tpl");
$TITLE = $CURPATCH = "Отписаться от рассылки";
?>
