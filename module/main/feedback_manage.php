<?php
/**
 * Просмотр и управление сообщениями из формы обратной связи
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01 06.07.2009
 */
if(!defined("SHIFTCMS")) exit;
$smarty -> assign("PAGETITLE","<h2>".$lang_ar['fba_title']."</h2>");

if(isset($_REQUEST['act']) && $_REQUEST['act']=="SendReply"){
   global $_conf, $lang;
	if(trim($_REQUEST['email'])=="" || trim($_REQUEST['text'])=="" || trim($_REQUEST['thema'])==""){
		echo msg_box("Не указан э-мейл получателя, тема сообщения или текст сообщения!");
	}else{
		SendEmail(0, $_conf['sup_email'], $_conf['site_name'], 0, stripslashes($_REQUEST['email']), stripslashes($_REQUEST['name']), stripslashes($_REQUEST['thema']), nl2br(stripslashes($_REQUEST['text'])));
		echo msg_box("Сообщение успешно отправлено!");
	}
		unset($_REQUEST['act']);
}
if(isset($_REQUEST['act']) && $_REQUEST['act']=="WriteReply"){
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."feedback WHERE id='$_REQUEST[id]'");
	$t = $r -> GetRowAssoc(false);
	echo "<form method='post' action='admin.php?p=feedback_manage&act=SendReply' id='WriteReplyForm' enctype='multipart/form-data'>";
	echo "<h3>Написать ответ</h3>";
	echo "<strong>E-mail:</strong><br /><input type='text' name='email' id='email' style='width:400px;' value='".htmlspecialchars(stripslashes($t['email']))."' /><br /><input type='hidden' name='name' id='name' value='".htmlspecialchars(stripslashes($t['name']))."' />";
	echo "<strong>Тема сообщения:</strong><br /><input type='text' style='width:400px;' name='thema' id='thema' value='RE: ".htmlspecialchars(stripslashes($t['company']))."' /><br />";
	echo "<strong>Текст сообщения:</strong><br /><textarea name='text' id='text' style='width:400px;height:200px;'>\n\n-----------------------------------------\n".htmlspecialchars(stripslashes($t['ftext']))."</textarea><br /><br />";
	echo "<input type='submit' value='Отправить' />";
	echo "<input type='button' value='Отмена' onclick=\"document.getElementById('ReplyForm_".$_REQUEST['id']."').innerHTML='';\" />";
	echo "</form>";
	//print_r($t);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="deleteorder"){
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."feedback WHERE id='$_REQUEST[id]'");
	echo msg_box($lang_ar['fba_del']);
	unset($_REQUEST['act']);
}

/* ***************************************************************************** */
if(!isset($_REQUEST['act'])){
	if(isset($_REQUEST['start'])) $_SESSION['start'] = $_REQUEST['start'];
	if(isset($_SESSION['start'])) $start = $_SESSION['start'];
	else $start = 0;
	$interval = 30;

		$q="SELECT * FROM ".$_conf['prefix']."feedback ORDER BY date desc LIMIT $start, $interval";
		$q1="SELECT count(*) FROM ".$_conf['prefix']."feedback ORDER BY date desc";
	
		$r1 = $db->Execute($q1);
		$t1 = $r1 -> GetRowAssoc(false);
		$all = $t1['count(*)'];
		$list_page=Paging($all,$interval,$start,"admin.php?p=$p&start=%start1%","");

		$r = $db->Execute($q);

		if($r -> RecordCount() > 0){
	echo "<strong>Всего $all</strong>";
	echo $list_page;
	echo "<table border='0' cellspacing='0' class='selrow' width='100%'>
	<th>".$lang_ar['fba_date']."</th><th>".$lang_ar['fba_company']."</th><th>".$lang_ar['fba_who']."</th><th>".$lang_ar['fba_phone']."</th><th>".$lang_ar['fb_msgemail']."</th><th>".$lang_ar['fba_msg']."</th><th>".$lang_ar['delete']."</th></tr>";
	while (!$r -> EOF) { 
		$t = $r -> GetRowAssoc(false);
		$bg = '';
		if($t['state']=="new"){
			$bg="style='background:#FFFF66'";
			$ru = $db -> Execute("UPDATE ".$_conf['prefix']."feedback SET state='read' WHERE id='$t[id]'");
		}
		$id = $t['id'];
	    echo "<tr $bg>";
		echo "
		<td>".date("d.m.Y H:i", $t['date'])."</td>
		<td>".stripslashes($t['company'])."</td>
		<td>".stripslashes($t['name'])."</td>
		<td>".stripslashes($t['phone'])."</td>
		<td>".stripslashes($t['email'])."<br /><a href='javascript:void(null)' onclick=\"getdata('','post','?p=".$p."&id=".$t['id']."&act=WriteReply','ReplyForm_".$t['id']."')\">Написать ответ</a></td>
		<td>".stripslashes($t['ftext'])."<div id='ReplyForm_".$t['id']."'></div></td>
		<td align='center' style='border-right:solid 1px #cccccc;'><a href='admin.php?p=".$p."&act=deleteorder&id=".$t['id']."' onclick=\"if(!confirm('".$lang_ar['fba_del_hint']."')) return false\"><img src='$_conf[admin_tpl_dir]img/delit.png' width='16' height='16' alt='".$alang_ar['delete']."' border='0' /></a></td>";
    	echo "</tr>";
		$r->MoveNext();
	}
	echo "</table>";
	echo $list_page;

		}else{
			echo "<strong>".$lang_ar['fba_msg1']."</strong>";
		}
}
?>