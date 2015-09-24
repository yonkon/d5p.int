<?php
/**
 * Набор функций для модуля гостевой книги
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012
 * @link http://shiftcms.net
 * @version 1.03
 */
if(!defined("SHIFTCMS")) exit;

function _alertguestbook(){
	global $db, $CMS, $_conf;
	$out = '';
	/* проверяем на наличие новых сообщений в гостевой книге */
	$r = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."guestbook WHERE  g_state='new'");
	$t = $r -> GetRowAssoc(false);
	if($t['count(*)'] > 0) $out = "У вас есть новые сообщения (".$t['count(*)'].") в <a href='admin.php?p=admin_guestbook'>гостевой книге</a>!<br />";
	return $out;
}

?>