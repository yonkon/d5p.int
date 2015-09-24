<?php
/**
* Рассылка уведомлений запланированных в календаре
* @package ShiftCMS
* @subpackage ORDER
* @version 1.00 10.05.2009
* @author Volodymyr Demchuk
* @link http://shiftcms.net
*/


$mail_send_after = 10; // Час первой почтовой рассылки
$mail_send_after1 = 20; // Час второй почтовой рассылки
$sms_send_after = 10; // час смс-рассылки

$h = date("G",time());
$tm = time();
$send_mail = 0;
$send_sms = 0;
	/**
	*  Рассылка почтовых сообщений
	*/
	$q = "SELECT * FROM ".$_conf['prefix']."calendar WHERE alert_mail='y' AND ".time()." BETWEEN starttime AND instime";
	$r = $db -> Execute($q);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		if(($t['am_last']==0 && $h==$mail_send_after) || ($t['am_last']==0 && $h==$mail_send_after1) 
		|| (($tm-$t['am_last']) > 4000 && $h==$mail_send_after) || (($tm-$t['am_last']) > 4000 && $h==$mail_send_after1)) {
			$ui = GetUserName($t['idu']);
			SendEmail($_conf['sysidu'], $_conf['sup_email'], $_conf['site_name'], $t['idu'], $ui['EMAIL'], stripslashes($ui['FIO']), stripslashes($t['rtitle']), "Дата события: ".date("d.m.Y H:i",$t['instime'])."<br />".stripslashes($t['record']));
			$ru = $db -> Execute("UPDATE ".$_conf['prefix']."calendar SET am_last='".time()."' WHERE idc='$t[idc]'");
			$send_mail++;
		}
		$r -> MoveNext();
	}

	/**
	*  Рассылка СМС сообщений
	*/
	/*
	$q = "SELECT * FROM ".$_conf['prefix']."calendar WHERE alert_sms='y' AND ".time()." BETWEEN starttime AND instime";
	$r = $db -> Execute($q);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		if(($t['as_last']==0 && $h==$sms_send_after) || (($tm-$t['as_last']) > 4000 && $h==$sms_send_after)) {
			$ui = GetUserName($t['idu']);
			SendEmail($_conf['sysidu'], $_conf['sup_email'], $_conf['site_name'], $t['idu'], $ui['EMAIL'], stripslashes($ui['FIO']), stripslashes($t['rtitle']), stripslashes($t['record']));
			$ru = $db -> Execute("UPDATE ".$_conf['prefix']."calendar SET as_last='".time()."' WHERE idc='$t[idc]'");
			$send_sms++;
		}
		$r -> MoveNext();
	}
	*/

echo "Всего отправлено напоминаний: $send_mail на почту и $send_sms СМС.\n";
$PAGE = '';
?>