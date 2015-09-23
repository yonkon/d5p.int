<?php
/**
* Почтовый клиент для работы с почтой внутри системы
* @package ShiftCMS
* @version 1.00.01 10.06.2009
* @author Volodymyr Demchuk
* @link http://shiftcms.net
*/
if(!defined('SHIFTCMS')) HackingAttempt();

if(isset($_REQUEST['ido']) && trim($_REQUEST['ido'])!="") { define("ido", (int)$_REQUEST['ido']); $_REQUEST['filter_ido'] = ido; }
else define("ido", "");


if(isset($_REQUEST['idma']) && trim($_REQUEST['idma'])!="") define("idma", (int)$_REQUEST['idma']);
else{
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account WHERE email='".stripslashes($_SESSION['USER_EMAIL'])."'");
	if($r -> RecordCount() == 0){
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."user_mail_account(idu, email)VALUES('".$_SESSION['USER_IDU']."', '".mysql_real_escape_string(stripslashes($_SESSION['USER_EMAIL']))."')");
		$idma = $db -> Insert_ID();
		define("idma", $idma);
	}else{
		$t = $r -> GetRowAssoc(false);
		define("idma", $t['idma']);
	}
}

$baseAccount = GetMailAccount($_SESSION['USER_IDU'], $_SESSION['USER_EMAIL']);
$r = $db -> Execute("UPDATE ".$_conf['prefix']."user_mail SET account='".$baseAccount['idma']."' WHERE idu='".$_SESSION['USER_IDU']."' AND account=0");

$toidu = isset($_REQUEST['toidu']) ? $_REQUEST['toidu'] : null;
$idm = isset($_REQUEST['idm']) ? $_REQUEST['idm'] : null;

if(isset($_REQUEST['mailact1'])) $_REQUEST['mailact']=="--";

if(!isset($_REQUEST['mailact']) || $_REQUEST['mailact']=="main") 
	echo LoadMainWindow();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="LoadMailList") 
	echo LoadMailList($_REQUEST['folder'], $_REQUEST['outpage'], idma);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="LoadMessageForRead") 
	echo LoadMessageForRead($_REQUEST['idm']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="LoadOnlyMessageForRead") 
	echo LoadOnlyMessageForRead($_REQUEST['idm']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="DeleteMessage") 
	echo DeleteMessage($_REQUEST['idm']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="EmptyTrash") 
	echo EmptyTrash();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="FullDeleteMessage") 
	echo FullDeleteMessage($_REQUEST['idm']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="WriteForm") 
	echo WriteForm($_REQUEST['type'],$idm, $toidu);
if(isset($_REQUEST['mailact1']) && $_REQUEST['mailact1']=="UploadAttachment") 
	echo UploadAttachment();
if(isset($_REQUEST['mailact1']) && $_REQUEST['mailact1']=="DelTmpAttach") 
	echo DelTmpAttach();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="SendMsg")
	echo SendMsg();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="UserSettings")
	echo UserSettings();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="SaveUSet")
	echo SaveUSet();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="SaveUSet1")
	echo SaveUSet1();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="SearchInContact")
	echo LoadContactList();
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="CheckNewMail") 
	echo CheckNewMail($_REQUEST['idma']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="DeleteMailAccount") 
	echo DeleteMailAccount($_REQUEST['del_idma']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="LoadUserContact") 
	echo LoadUserContact($_REQUEST['idu']);
if(isset($_REQUEST['mailact']) && $_REQUEST['mailact']=="UpdateMessageCount") 
	echo UpdateMessageCount($_REQUEST['idma']);




/**
* Main window functions
*/
function LoadMainWindow(){
	global $db, $_conf, $smarty;
	$qido = ido == "-" ? "" : " AND ido='".ido."' ";
	$out = '<input type="hidden" name="CURRENT_IDMA" id="CURRENT_IDMA" value="'.idma.'" />';
	$out .= "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
	$out .= "<tr><td colspan='2'>
		<div class='block' id='OPanel2'>
		<table border='0' cellspacing='0' cellpadding='2' width='100%'><tr>
		
		<td width='26'><a title='Написать письмо' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('WriteFormBox', 'inline', '', 'Написать письмо', 'width=800px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=outlook&type=new&mailact=WriteForm&ido=".ido."&idma=".idma."&idm=null','WriteFormBox_inner'); return false; \"><img src='$_conf[admin_tpl_dir]outlook/new_icon.gif' width='19' height='19' alt='Написать письмо' /></a></td>

		<td width='26'><a title='Удалить выбранные сообщения' href='javascript:void(null)' onClick=\"DeleteSelectedMessages();\"><img src='$_conf[admin_tpl_dir]outlook/delete_big_icon.gif' width='15' height='19' alt='Удалить выбранные сообщения' /></a></td>


		<td width='26'><a title='Ответить на выбранное сообщение' href='javascript:void(null)' onClick=\"ReplyForward('reply','".idma."');\"><img src='$_conf[admin_tpl_dir]outlook/reply_big_icon.gif' width='25' height='19' alt='Ответить на выбранное сообщение' /></a></td>

		<td width='26'><a title='Переслать выбранное сообщение' href='javascript:void(null)' onClick=\"ReplyForward('forward','".idma."');\"><img src='$_conf[admin_tpl_dir]outlook/forward_big_icon.gif' width='25' height='19' alt='Переслать выбранное сообщение' /></a></td>
		
		<td width='26'><a title='Настройка аккаунта' href='javascript:void(null)' onClick=\"getdata('','post','?p=outlook&mailact=UserSettings','OMailList');\"><img src='$_conf[admin_tpl_dir]outlook/setting_icon.gif' width='19' height='19' alt='Переслать выбранное сообщение' /></a></td>
		
		<td align='right'><div id='OMSGBlock' style='text-align:right;'></div></td>
		</tr></table>
		</div>
		</td></tr>";
	$out .= "<tr>
	<td rowspan='2' width='160' id='OFolderTd' valign='top'>
	<div id='OFolder'>
	<div class='block'>
	<strong>фильтровать по:</strong> <br />
	E-mail:<br /><input type='text' name='filter_email' id='filter_email' class='filter' value='' style='width:100px;' onkeyup=\"LoadIdoMessages(this.value);\" /><br />
	ФИО:<br /><input type='text' name='filter_fio' id='filter_fio' class='filter' value='' style='width:100px;' onkeyup=\"LoadIdoMessages(this.value);\" /><br />
	Вложения:<br />
	<input type='radio' name='filter_attach' id='filter_attach[1]' value='1' class='filter' checked='checked' /> все 
	<input type='radio' name='filter_attach' id='filter_attach[2]' value='2' class='filter' /> есть 
	<input type='radio' name='filter_attach' id='filter_attach[3]' value='3' class='filter' /> нет<br />
	<!--№ заказа: <input type='text' name='filter_ido' id='filter_ido' class='filter' value='".ido."' style='width:40px;' onkeyup=\"LoadIdoMessages(this.value);\" /> -->
	<center><input type='image' src='".$_conf['admin_tpl_dir']."outlook/applay_icon.gif' style='width:15px;height:15px;border:none;' onclick=\"ApplayFilter()\" /></center>
	</div>
	<br />";
	
	$rac = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account WHERE idu='".$_SESSION['USER_IDU']."'");
	while(!$rac -> EOF){
		$tac = $rac -> GetRowAssoc(false);
		$out .= "<h4>".stripslashes($tac['email'])."</h4>";
		$cm = CountMessages($tac['idma']);

	$out .= "<a href='javascript:void(null)' onClick=\"LoadMailList('allmail', 'page', '".$tac['idma']."');\">
	<img src='$_conf[admin_tpl_dir]outlook/ready_icon.gif' width='15' height='13' alt='Вся почта' /> Вся почта (<span id='ACount_".$tac['idma']."'>".$cm['all']."</span>)</a>
	
	<a href='javascript:void(null)' onClick=\"LoadMailList('inbox', 'page', '".$tac['idma']."');\" style='float:left;'>
	<img src='$_conf[admin_tpl_dir]outlook/inbox_icon.gif' width='15' height='13' alt='Входящие' /> Входящие (<span id='ICount_".$tac['idma']."'>".$cm['inb']."</span>)(<span id='NCount_".$tac['idma']."'><strong>".$cm['new']."</strong></span>)</a> 
	<a href='javascript:void(null)' onclick=\"CheckNewMail('".$tac['idma']."')\" style='float:left;clear:right;' title='Проверить почту'><img src='".$_conf['admin_tpl_dir']."outlook/check_icon.gif' width='15' height='15' alt='Проверить почту' /></a>
	
	<a href='javascript:void(null)' onClick=\"LoadMailList('outbox', 'page', '".$tac['idma']."');\" style='clear:left;'>
	<img src='$_conf[admin_tpl_dir]outlook/sent_icon.gif' width='15' height='13' alt='Отправленные' /> Отправленные (<span id='SCount_".$tac['idma']."'>".$cm['out']."</span>)</a>
	
	<a href='javascript:void(null)' onClick=\"LoadMailList('trash', 'page', '".$tac['idma']."');\" style='float:left;'>
	<img src='$_conf[admin_tpl_dir]outlook/trash_icon.gif' width='15' height='13' alt='Корзина' /> Корзина (<span id='TCount_".$tac['idma']."'>".$cm['trash']."</span>)</a> 
	
	<a href='javascript:void(null)' onClick=\"EmptyTrash(".$tac['idma'].")\" style='float:left;' title=\"Очистить корзину\"><img src='$_conf[admin_tpl_dir]outlook/del_icon.gif' width='14' height='14' alt='Очистить корзину' /></a><br /><br />";
		$rac -> MoveNext();
	}//while accounts
	$out .= "</div>
	</td><td valign='top'>
		<div id='OMailList'>".LoadMailList('allmail','page', idma)."</div>
	</td></tr>
	<!--<tr><td><div id='OMessageArea'></div></td></tr>-->";
	$out .= "</table><div id='debug2'></div>";
	
	return $out;
}// end load main outlook window

/**
* Load list of messages
*/
function LoadMailList($folder, $outpage, $idma){
	global $db, $_conf, $smarty;
	$out = ""; $qido = "";
	//$out .= print_r($_REQUEST,1);
	if(isset($_REQUEST['filter_ido']) && trim($_REQUEST['filter_ido'])!="") $qido .= " AND ido='".(int)$_REQUEST['filter_ido']."' ";
	if(isset($_REQUEST['filter_email']) && trim($_REQUEST['filter_email'])!="") $qido .= " AND (from_email LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_email']))."%' OR to_email LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_email']))."%')";
	if(isset($_REQUEST['filter_fio']) && trim($_REQUEST['filter_fio'])!="") $qido .= " AND (from_name LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_fio']))."%' OR to_name LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_fio']))."%')";
	if(isset($_REQUEST['filter_attach']) && trim($_REQUEST['filter_attach'])=="2") $qido .= " AND (SELECT count(*) FROM ".$_conf['prefix']."user_mail_attach WHERE ".$_conf['prefix']."user_mail.idm = ".$_conf['prefix']."user_mail_attach.idm) > 0 ";
	if(isset($_REQUEST['filter_attach']) && trim($_REQUEST['filter_attach'])=="3") $qido .= " AND (SELECT count(*) FROM ".$_conf['prefix']."user_mail_attach WHERE ".$_conf['prefix']."user_mail.idm = ".$_conf['prefix']."user_mail_attach.idm) = 0 ";
	
	$interval = 60;
	$acc = GetMailAccountById($idma);
	$uemail = "<font color=blue>".$acc['email']."</font>: ";
	$mstart = isset($_REQUEST['mstart']) ? $_REQUEST['mstart'] : 0;
	$q = " FROM ".$_conf['prefix']."user_mail WHERE  idu='".$_SESSION['USER_IDU']."' AND account='".$idma."' ".$qido;
	if($folder=="allmail") $q .= "AND (folder='inbox' OR folder='outbox') ";
	if($folder=="inbox") $q .= "AND folder='inbox' ";
	if($folder=="outbox") $q .= "AND folder='outbox' ";
	if($folder=="trash") $q .= "AND folder='trash' ";
	$q .= " ORDER BY mdate DESC ";
	$q_page = "SELECT count(*) ".$q;
	$q_list = "SELECT *, (SELECT count(*) FROM ".$_conf['prefix']."user_mail_attach WHERE ".$_conf['prefix']."user_mail.idm = ".$_conf['prefix']."user_mail_attach.idm) as attach ".$q." LIMIT $mstart, $interval";
	$r_page = $db -> Execute($q_page);
	$r_list = $db -> Execute($q_list);
	$t_page = $r_page -> GetRowAssoc(false);
	$all = $t_page['count(*)'];
	//echo $q;
	if($outpage=="page"){
		$plist = Paging($all, $interval, $mstart, "javascript:void(null)","onClick=\"getdata('','post','?p=outlook&mailact=LoadMailList&folder=$folder&outpage=page&mstart=%start1%&ido=".ido."&idma=".$idma."','OMailListSimple');\"");
		if($folder=="inbox") $fold = "<strong>".$uemail."Входящие. </strong><input type='hidden' name='CurFolder' id='CurFolder' value='inbox' />";
		if($folder=="outbox") $fold = "<strong>".$uemail."Отправленные. </strong><input type='hidden' name='CurFolder' id='CurFolder' value='outbox' />";
		if($folder=="allmail") $fold = "<strong>".$uemail."Входящие и отправленные. </strong><input type='hidden' name='CurFolder' id='CurFolder' value='allmail' />";
		if($folder=="trash") $fold = "<strong>".$uemail."Корзина. </strong><input type='hidden' name='CurFolder' id='CurFolder' value='trash' />";
		$tpl = "<div id='OMailPageList'>$fold &nbsp;&nbsp; $plist</div>";
	}
	$mt = $tpl."<table border='0' cellspacing='1' cellpadding='1' width='100%' class='Mtab' id='MailTab'>";
	$mt .= "<thead><tr><th><input type='checkbox' name='chAll' value='chAll' id='chAll' onclick=\"CheckAllMsg('CHM',this)\" /></th><th>От</th><th>К</th><th>Тема</th><th>Дата</th><th>&nbsp;</th><th>Удалить</th></tr></thead></tbody>";
	while(!$r_list -> EOF){
		$t = $r_list -> GetRowAssoc(false);
		//$baseclass = $t['mstate']=="new" ? "OrowB" : "Orow1";
		$style = $t['mstate']=="new" ? "font-weight:bold;" : "font-weight:normal;";
		if(trim($t['to_name'])=="") $t['to_name'] = stripslashes($t['to_email']);
		if(trim($t['from_name'])=="") $t['from_name'] = stripslashes($t['from_email']);
		
		$openmsg = " onclick=\"ReadMessage('$t[idm]'); document.getElementById('tr".$t['idm']."').style.fontWeight = 'normal'; \" style='cursor:pointer;'";
		$mt .= "<tr id='tr".$t['idm']."' bgcolor='#ffffff' class='Omainbody' style='$style'
		onmouseover=\"this.className=document.getElementById('ch".$t['idm']."').checked ? 'Omainhighsel' : 'Omainhigh'\" 
		onmouseout=\"this.className=document.getElementById('ch".$t['idm']."').checked ? 'Omainsel' : 'Orow1 Omainbody'\">
		<td><input type='checkbox' name='ch' value='".$t['idm']."' id='ch".$t['idm']."' class='CHM' 
		onclick=\"document.getElementById('tr".$t['idm']."').className = this.checked ? 'Omainhighsel' : 'Omainhigh';\" /></td>
		<td $openmsg>".stripslashes($t['from_name'])."</td>
		<td $openmsg>".stripslashes($t['to_name'])."</td>
		<td $openmsg>".stripslashes($t['subject'])."<br /><font style='color:#999999;'><small>".substr(strip_tags(stripslashes($t['message'])),0,200)."...</small></font></td>
		<td $openmsg><span class='sdate'>".date("d.m.Y H:i", $t['mdate'])."</span></td>";
		if($t['attach'] > 0) $mt .= "<td $openmsg><img src='$_conf[admin_tpl_dir]outlook/attach_icon.gif' width='14' height='13' alt='Аттачмент ($t[attach])' /></td>";
		else $mt .= "<td $openmsg>&nbsp;</td>";
		if($t['folder']=="trash") $mt .= "<td><a href='javascript:void(null)' onClick=\"DeleteMessage('FullDeleteMessage','$t[idm]', '".$idma."');\" title='Удалить сообщение'><img src='$_conf[admin_tpl_dir]img/delit.png' width='16' height='16' alt='Удалить сообщение' /></a></td>";
		else $mt .= "<td><a href='javascript:void(null)' onClick=\"DeleteMessage('DeleteMessage','$t[idm]', '".$idma."');\" title='Отправить в  корзину'><img src='$_conf[admin_tpl_dir]outlook/trash_icon.gif' width='15' height='13' alt='Отправить в  корзину' /></a></td>";
		$mt .= "</tr>";
		//?p=outlook&ido=".ido."&mailact=".$mailact."&idm=".$t['idm']."
		$r_list -> MoveNext();
	}
	$mt .= "</tbody></table>";
	$out .= "<div id='OMailListSimple'>$mt</div>";
	return $out;
}


/**
* Вывод письма для чтения
*/
function LoadMessageForRead($idm){
	global $db, $_conf, $smarty;
	
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail WHERE idm='$idm'");
	if($r -> RecordCount() == 0) return "Письмо не найдено!";
	$t = $r -> GetRowAssoc(false);
		if($t['folder']=="trash"){
			$delmailact = "FullDeleteMessage";
			$delimg = "<img src='$_conf[admin_tpl_dir]img/delit.png' width='15' height='19' alt='Удалить сообщение' /></a>";
		}else{
			$delmailact = "DeleteMessage";
			$delimg = "<img src='$_conf[admin_tpl_dir]outlook/delete_big_icon.gif' width='15' height='19' alt='Отправить в  корзину' /></a>";
		}
	$out = "<div class='block' id='OPanel2'>
		<table border='0' cellspacing='0' cellpadding='2' width='100%'><tr>

		<td width='26'><a title='Ответить на сообщение' href='javascript:void(null)' onClick=\"replywin=dhtmlwindow.open('WriteFormBox', 'inline', '', 'Ответить на сообщение', 'width=800px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); replywin.moveTo('middle','middle'); getdata('','get','?p=outlook&type=reply&mailact=WriteForm&ido=".ido."&idm=".$idm."','WriteFormBox_inner'); setfocus('replywin'); return false; \"><img src='$_conf[admin_tpl_dir]outlook/reply_big_icon.gif' width='25' height='19' alt='Ответить на сообщение' /></a></td>

		<td width='26'><a title='Переслать сообщение' href='javascript:void(null)' onClick=\"forwin=dhtmlwindow.open('WriteFormBox', 'inline', '', 'Переслать сообщение', 'width=800px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); forwin.moveTo('middle','middle'); getdata('','get','?p=outlook&type=forward&mailact=WriteForm&ido=".ido."&idm=".$idm."','WriteFormBox_inner'); setfocus('forwin'); return false; \"><img src='$_conf[admin_tpl_dir]outlook/forward_big_icon.gif' width='25' height='19' alt='Переслать сообщение' /></a></td>

		<td width='26'><a title='Удалить сообщение' href='javascript:void(null)' onClick=\"DeleteMessage('".$delmailact."','".$idm."', '".idma."'); rwin.close(); \">".$delimg."</a></td>

		<td align='right'><div id='OMSGBlock1' style='text-align:right;'></div></td>
		
		</tr></table>
		</div>";

	$head .= "<table border='0' width='100%'><tr><td valign='top'>";
	$out .= "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
		$attach = array(); $attach_str = '';
		$ra = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
		if($ra -> RecordCount() > 0){
			while(!$ra -> EOF){
				$ta = $ra -> GetRowAssoc(false);
				$fz = get_filesize(filesize(stripslashes($ta['fpath'])));
				$attach[] = '<a href="?p=getfile&ida='.$ta['ida'].'&type=afile">'.stripslashes($ta['fname']).'</a> <small>('.$fz.')</small>';
				$ra -> MoveNext();
			}
			$attach_str = "<br />".implode(" | ",$attach);
		}
	if($t['mstate']=="new"){
		$rus = $db -> Execute("UPDATE ".$_conf['prefix']."user_mail SET mstate='read' WHERE idm='$idm'");
	}
	$head .= "<span style='font-size:14px;font-weight:bold;'>".stripslashes($t['subject'])."</span> от ".date("d.m.Y H:i", $t['mdate'])."<br />";
	$head .= "От <strong>".stripslashes($t['from_name'])." &lt;".stripslashes($t['from_email'])."&gt;</strong> ";
	$head .= "к <strong>".stripslashes($t['to_name'])." &lt;".stripslashes($t['to_email'])."&gt;</strong>";
	$head .= $attach_str;
	$head .= "</td></tr></table>";
	
	$out .= "<tr><td><div class='blockw' style='height:50px;'>$head</div></td></tr>";
	$out .= "<tr><td><iframe frameborder='0' width='100%' height='400' src='admin.php?p=outlook&mailact=LoadOnlyMessageForRead&idm=$idm'></iframe></td></tr>";
	$out .= "</table>";
	
	return $out;
}

/**
* Вывод текста сообщения в ифрейм для чтения
*/
function LoadOnlyMessageForRead($idm){
	global $db, $_conf, $smarty;
	$out = "";
	$r = $db -> Execute("SELECT message FROM ".$_conf['prefix']."user_mail WHERE idm='$idm'");
	if($r -> RecordCount() == 0) return "Письмо не найдено!";
	$t = $r -> GetRowAssoc(false);
	$out .= stripslashes($t['message']);
	return $out;
}

/**
* Удаление сообщения - перенос в корзину
*/
function DeleteMessage($idm){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("UPDATE ".$_conf['prefix']."user_mail SET folder='trash' WHERE idm='$idm'");
	$res['msg'] = "Сообщение отправлено в корзину!";
	$res['countmsg'] = CountMessages(idma);
	$GLOBALS['_RESULT'] = $res;
}
/**
* Удаление сообщения
*/
function FullDeleteMessage($idm){
	global $db, $_conf, $smarty;
	$ra = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
		if($ra -> RecordCount() > 0){
			require_once("include/uploader.php");
			$upl = new uploader;
			while(!$ra -> EOF){
				$ta = $ra -> GetRowAssoc(false);
				$upl -> DeleteFile(stripslashes($ta['fpath']));
				$pp = pathinfo($ta['fpath']);
				@rmdir($pp['dirname']);
				$ra -> MoveNext();
			}
			unset($upl);
		}
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
	$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail WHERE idm='$idm'");
	$res['msg'] = "Сообщение удалено!";
	$res['countmsg'] = CountMessages(idma);
	$GLOBALS['_RESULT'] = $res;
}
/**
* Полная очистка корзины
*/
function EmptyTrash(){
	global $db, $_conf, $smarty;
	$idms = '';
	$ra = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail WHERE idu='".$_SESSION['USER_IDU']."' AND account='".idma."' AND folder='trash'");
		if($ra -> RecordCount() > 0){
			while(!$ra -> EOF){
				$ta = $ra -> GetRowAssoc(false);
				$idm = $ta['idm'];
					$rat = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
					if($rat -> RecordCount() > 0){
						require_once("include/uploader.php");
						$upl = new uploader;
						while(!$rat -> EOF){
							$tat = $rat -> GetRowAssoc(false);
								$upl -> DeleteFile(stripslashes($tat['fpath']));
								$pp = pathinfo($tat['fpath']);
								@rmdir($pp['dirname']);
							$rat -> MoveNext();
						}
						unset($upl);
					}
					$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
					$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail WHERE idm='$idm'");
				$ra -> MoveNext();
			}
		}
	$res['msg'] = "Корзина очищена!";
	$res['countmsg'] = CountMessages(idma);
	$GLOBALS['_RESULT'] = $res;
}

/**
* Удаление почтового аккаунта и всех писем из него
*/
function DeleteMailAccount($del_idma){
	global $db, $_conf, $smarty;
	$idms = '';
	$del_mail = GetMailAccountById($del_idma);
	$ra = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail WHERE account='".$del_idma."' AND idu='".$_SESSION['USER_IDU']."'");
		if($ra -> RecordCount() > 0){
			while(!$ra -> EOF){
				$ta = $ra -> GetRowAssoc(false);
				$idm = $ta['idm'];
					$rat = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
					if($rat -> RecordCount() > 0){
						require_once("include/uploader.php");
						$upl = new uploader;
						while(!$rat -> EOF){
							$tat = $rat -> GetRowAssoc(false);
								$upl -> DeleteFile(stripslashes($tat['fpath']));
								$pp = pathinfo($tat['fpath']);
								@rmdir($pp['dirname']);
							$rat -> MoveNext();
						}
						unset($upl);
					}
					$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail_attach WHERE idm='$idm'");
					$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail WHERE idm='$idm'");
				$ra -> MoveNext();
			}
		}
		$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."user_mail_account WHERE idma='".$del_idma."'");
	echo msg_box("Почтовый аккаунт ".$del_mail['email']." и все письма из этого аккаунта удалены!<br />Для отображения изменений обновите страницу или перейдите <a href='admin.php?p=usermail'>по этой ссылке</a>");
}
/**
* Генерация и вывод формы написания письма
* @param string $type = (new, reply, forward)
*/
function WriteForm($type="new", $idm = null, $toidu = null){
	global $db, $_conf, $smarty;
	$out = ""; $attach_str = "";
	$subject = ""; $message = ""; $to = ""; $add_to_email = "";
	$write_from_idma = 0;
		$fi = GetUserName($_SESSION['USER_IDU']);
		if(stripslashes(trim($fi['FIO']))=="") $fi['FIO'] = $fi['EMAIL'];
		$from_idu = $_SESSION['USER_IDU'];
		$pe = explode("@",$fi['EMAIL']);
		
		//$from = str_replace('"','',imap_rfc822_write_address($pe[0], $pe[1], stripslashes($fi['FIO'])));
			//$mail_ui = GetMailAccount($_SESSION['USER_IDU'], stripslashes($fi['EMAIL']));
				//if($mail_ui == false) $sign = '';
				//else $sign = nl2br(stripslashes($mail_ui['sign']));

	if($type == "reply"){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail WHERE idm='".$idm."'");
		$t = $r -> GetRowAssoc(false);
		$write_from_idma = $t['account'];
			$subject = "Re: ".stripslashes($t['subject']);
			$message = stripslashes($t['message']);
		if($t['from_email'] != $fi['EMAIL']){
			$ti['FIO'] = stripslashes($t['from_name']);
			$to_idu = $t['from_idu'];
			$pe = explode("@",$t['from_email']);
			$to = str_replace('"','',imap_rfc822_write_address($pe[0], $pe[1], stripslashes($ti['FIO'])));
		}
		if($t['from_email'] == $fi['EMAIL']){
			$ti['FIO'] = stripslashes($t['to_name']);
			$to_idu = $t['to_idu'];
			$pe = explode("@",$t['to_email']);
			$to = str_replace('"','',imap_rfc822_write_address($pe[0], $pe[1], stripslashes($ti['FIO'])));
		}
	}else if($type == "forward"){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail WHERE idm='".$idm."'");
		$t = $r -> GetRowAssoc(false);
		$write_from_idma = $t['account'];
			$subject = "Fwd: ".stripslashes($t['subject']);
			$message = stripslashes($t['message']);
			$rfwd = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='".$idm."'");
			if($rfwd -> RecordCount() > 0){
				if(!class_exists("uploader")){
					require_once("include/uploader.php");
				}
				$up = new uploader;
				$up -> rewrite = 1;
				if(!is_dir("tmp/atch")) $up -> MakeDir("tmp/atch");
				while(!$rfwd->EOF){
					$tfwd = $rfwd -> GetRowAssoc(false);
					$path = stripslashes($tfwd['fpath']);
					$ppa = pathinfo($path);
					$upres = $up -> MoveFile($path, "tmp/atch/".$ppa['basename']);
					if($upres == 1){
						$id = 'T'.time();
						$attach_str .= '<span id="'.$id.'" style="border:solid 1px #666666;padding:2px;"> '.$ppa['basename'].' ('.get_filesize(filesize("tmp/atch/".$ppa['basename'])).') (<a href="javascript:void(null)" onclick="DelTmpAttach(\'WFMsg\',\''.$ppa['basename'].'\',\''.$id.'\');"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" width="12" height="12" alt="Удалить" /></a>)<input type="hidden" name="attfile[]" id="attfile[]" value="'.$ppa['basename'].'" /> </span>';
					}
					$rfwd -> MoveNext();
				}
			}
	}else{
		$subject = "";
		if($toidu != null){
			$ti = GetUserName($toidu);
			if(stripslashes(trim($ti['FIO']))=="") $ti['FIO'] = $ti['EMAIL'];
			$to_idu = $toidu;
			$te = explode("@",$ti['EMAIL']);
			$to = str_replace('"','',imap_rfc822_write_address($te[0], $te[1], stripslashes($ti['FIO'])));
		}else{
			$to = ""; $to_idu = ""; 
		}
		$from = '';
	}

	$rac = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account WHERE idu='".$_SESSION['USER_IDU']."'");
	$idma_array = ''; $si = 0; $from_option = ''; $find_account = 0;
	while(!$rac->EOF){
		$tac = $rac -> GetRowAssoc(false);
			$pe = explode("@",$tac['email']);
			$from_sel = str_replace('"','',imap_rfc822_write_address($pe[0], $pe[1], stripslashes($fi['FIO'])));
			if($write_from_idma==$tac['idma']){
				$from_option .= '<option value="'.$from_sel.'" selected="selected">'.$fi['FIO'].' &lt;'.$tac['email'].'&gt;</option>';
				$_REQUEST['idma'] = $tac['idma'];
				$sign = nl2br(stripslashes($tac['sign']));
				$find_account = 1;
			}else $from_option .= '<option value="'.$from_sel.'">'.$fi['FIO'].' &lt;'.$tac['email'].'&gt;</option>';
		$idma_array .= 'if(this.selectedIndex=='.$si.') document.getElementById(\'idma\').value='.$tac['idma'].'; ';
		$si++;
		$rac -> MoveNext();
	}
	$from_select = '<select name="from" id="from" style="width:500px;padding:2px;" onchange="'.$idma_array.'">'.$from_option.'</select>';
	
	if($find_account == 0){
		$mail_ui = GetMailAccount($_SESSION['USER_IDU'], $_SESSION['USER_EMAIL']);
		$sign = nl2br(stripslashes($mail_ui['sign']));
		$_REQUEST['idma'] = $mail_ui['idma'];
	}
	
	if($type == "reply"){
		$message = "<br />".$sign."<br /><br />---------------------------------------------------<br />".$message;
	}elseif($type=="forward"){
		$message = $message."<br />".$sign;
	}else{
		$message = "<br />".$sign;
	}
	
	if($to_idu != ""){
		$add_to_email = "Все адреса: &bull; ";
	$rac = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account LEFT JOIN ".$_conf['prefix']."users_add USING(idu) WHERE idu=".$to_idu." ORDER BY idma");	
	while(!$rac -> EOF){
		$tac = $rac -> GetRowAssoc(false);
		$add_to_email .= '<a href="javascript:void(null)" onclick="document.getElementById(\'to\').value=\''.stripslashes($tac['fio']).' &lt;'.stripslashes($tac['email']).'&gt;\'; document.getElementById(\'to_idu\').value=\''.stripslashes($to_idu).'\';">'.stripslashes($tac['email']).'</a> &bull; ';
		$rac -> MoveNext();
	}
	}
	$out .= '<table width="100%" border="0"><tr><td width="200">&nbsp;</td>';
	$out .= '<td><div id="WFMsg"></div></td></tr>';
	$out .= '<tr><td width="200" valign="top"><img src="'.$_conf['admin_tpl_dir'].'outlook/adresbook_icon.gif" width="14" height="14" alt="Контакты" /> <strong>Контакты</strong><br />
	<small>Поиск по ФИО, логину, e-mail:</small><br />
	<input type="text" name="cfilter" id="cfilter" value="" style="width:170px;" onkeyup="SearchInContact(this.value)" /><br />
	<div style="height:450px; width:190px; overflow-y:scroll;" id="ContactArea">'.LoadContactList().'</div></td>';
	$out .= '<td valign="top" style="border-left:solid 1px #cccccc; padding-left:4px;">';
	$out .= '<div id="MainFormMsg"><form method="post" action="javascript:void(null)" id="WFF" enctype="multipart/form-data">';
	$out .= '<input type="hidden" name="ido" id="ido" value="'.ido.'" />';
	$out .= '<input type="hidden" name="idma" id="idma" value="'.$_REQUEST['idma'].'" />';
	$out .= '<input type="hidden" name="idm" id="idm" value="'.$idm.'" />';
	$out .= '<input type="hidden" name="p" id="p" value="outlook" />';
	$out .= '<input type="hidden" name="type" id="type" value="'.$type.'" />';
	$out .= '<input type="hidden" name="mailact" id="mailact" value="SendMsg" />';
	$out .= '<div id="AllUserMail">'.$add_to_email.'</div>';
	$out .= '<input type="button" value="К:" style="width:50px; text-align:right;" /><input type="text" name="to" id="to" value="'.$to.'" style="width:500px;padding:2px;" /><input type="hidden" name="to_idu" id="to_idu" value="'.$to_idu.'" /><br />';
	$out .= '<input type="button" value="От:" style="width:50px; text-align:right;" />'.$from_select.'<!--<input type="text" name="from" id="from" value="'.$from.'" style="width:500px;padding:2px;" />--><input type="hidden" name="from_idu" id="from_idu" value="'.$from_idu.'" /><br />';
	$out .= '<input type="button" value="Тема:" style="width:50px; text-align:right;" /><input type="text" name="subject" id="subject" value="'.$subject.'" style="width:500px;padding:2px;" /><br />';
	
	$out .= '<div class="block" style="width:550px;"><table border="0"><tr>';
	$out .= '<td><input type="file" style="background:#e3efff;" name="attach" id="attach" onchange="if(this.value!=\'\') UpLoadAttach(\'WFF\',\'WFMsg\');" /></td>';
	$out .= '<td><div id="AFiles">'.$attach_str.'</div></td>';
	$out .= '</tr></table></div><br />';
		include("./include/FCKeditor/fckeditor.php") ;
		$oFCKeditor = new FCKeditor('message') ;
		$oFCKeditor -> ToolbarSet = 'Mail' ;
		$sBasePath = "./include/FCKeditor/" ;
		$oFCKeditor -> Width  = '560';
		$oFCKeditor -> Height = '320';
		$oFCKeditor -> BasePath	= $sBasePath ;
		$oFCKeditor -> Value = $message;
		$MAILTEXT = $oFCKeditor -> Create() ;
	$out .= $MAILTEXT.'<br />';
	$out .= '<table border="0"><tr><td><input type="button" name="Send" id="Send" value=" -= ОТПРАВИТЬ =- " onclick="SendMessage(\'WFF\',\'WFMsg\', document.getElementById(\'idma\').value)" /></td><td><div id="WFM"></div></td></tr></table>';
	$out .= '</form></div>';
	$out .= '</td></tr></table><div id="debug2"></div>';
	return $out;
}

/**
* Функция загрузки аттачмента и временного хранения
*/
function UploadAttachment(){
	global $_conf;
	if(!class_exists("uploader")){
		require_once("include/uploader.php");
	}
	$up = new uploader;
	$up -> rewrite = 1;
	if(!is_dir("tmp/atch")) $up -> MakeDir("tmp/atch");
	$upres = $up -> MoveFile($_FILES['attach']['tmp_name'], "tmp/atch/".$_FILES['attach']['name']);
	if($upres == 1){
		$id = 'T'.time();
		$str = '<span id="'.$id.'" style="border:solid 1px #666666;padding:2px;"> '.$_FILES['attach']['name'].' ('.get_filesize($_FILES['attach']['size']).') (<a href="javascript:void(null)" onclick="DelTmpAttach(\'WFMsg\',\''.$_FILES['attach']['name'].'\',\''.$id.'\');"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" width="12" height="12" alt="Удалить" /></a>)<input type="hidden" name="attfile[]" id="attfile[]" value="'.$_FILES['attach']['name'].'" /> </span>';
		$res['successmsg'] = "Файл ".$_FILES['attach']['name']." успешно загружен на сервер!";
		$res['fileinfo'] = $str;
		$GLOBALS['_RESULT'] = $res;
	}else{
		$GLOBALS['_RESULT'] = $upres;
	}
}
/**
* Удаление временного аттачмента
*/
function DelTmpAttach(){
	@unlink("tmp/atch/".$_REQUEST['file']);
	$res['res'] = "OK";
	$res['successmsg'] = "Файл удален!";
	$GLOBALS['_RESULT'] = $res;
}

/**
* Функция отправки сообщения
*/
function SendMsg(){
	global $_conf, $db, $smarty;
	$attach = array(); $er = 0; $res = array();
	$ar = imap_rfc822_parse_adrlist($_REQUEST['from'], "");
	$from_ar = get_object_vars($ar[0]);
	$from_email = $from_ar['mailbox']."@".$from_ar['host'];
	$from_name = $from_ar['personal'];

	$ar1 = imap_rfc822_parse_adrlist($_REQUEST['to'], "");
	$to_ar = get_object_vars($ar1[0]);
	$to_email = $to_ar['mailbox']."@".$to_ar['host'];
	$to_name = $to_ar['personal'];

	if(trim($_REQUEST['to'])==""){$er = 1; $res['state']="ERROR"; $res['msg']="Вы не указали получателя сообщения! Выберите контакт из списка контактов или введите э-мейл вручную!"; }
	if(trim($_REQUEST['subject'])==""){$er = 1; $res['state']="ERROR"; $res['msg']="Пожалуйста, укажите тему письма!"; }
	if(trim($_REQUEST['message'])==""){$er = 1; $res['state']="ERROR"; $res['msg']="Вы пытаетесь отправить пустое сообщение! Введите текст сообщения!"; }
	if($er == 0){
		if(isset($_REQUEST['attfile'])){
			while(list($k,$v)=each($_REQUEST['attfile'])){
				$path = "tmp/atch/".stripslashes($v);
				$attach[$path] = stripslashes($v);
			}
		}
		/*
		if($type == "forward"){
			$rfwd = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_attach WHERE idm='".$_REQUEST['idm']."'");
			if($rfwd -> RecordCount() > 0){
				while(!$rfwd->EOF){
					$tfwd = $rfwd -> GetRowAssoc(false);
					$path = stripslashes($tfwd['fpath']);
					$ppa = pathinfo($path);
					$attach[$path] = $ppa['basename'];
					$rfwd -> MoveNext();
				}
			}
		}
		*/
		$sres = SendEmail($_REQUEST['from_idu'], $from_email, $from_name, $_REQUEST['to_idu'], $to_email, $to_name, stripslashes($_REQUEST['subject']), stripslashes($_REQUEST['message']), $_REQUEST['idma'], ido, '', $attach);
		if($sres == 1){$er = 0; $res['state']="OK"; $res['msg']="Сообщение успешно отправлено!"; }
		else{$er = 1; $res['state']="ERROR"; $res['msg']=$sres; }
		$res['countmsg'] =  CountMessages($_REQUEST['idma']);
		$res['sendMail'] = "sendMail";
	}
	//print_r($res);
	//print_r($_REQUEST);
	$GLOBALS['_RESULT'] = $res;
}
/**
* Main window functions
*/
function CountMessages($idma){
	global $db, $_conf, $smarty;
	/*$qido = ido == "-" ? "" : " AND ido='".ido."' ";*/
	$qido = '';
	if(isset($_REQUEST['filter_ido']) && trim($_REQUEST['filter_ido'])!="") $qido .= " AND ido='".(int)$_REQUEST['filter_ido']."' ";
	if(isset($_REQUEST['filter_email']) && trim($_REQUEST['filter_email'])!="") $qido .= " AND (from_email LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_email']))."%' OR to_email LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_email']))."%')";
	if(isset($_REQUEST['filter_fio']) && trim($_REQUEST['filter_fio'])!="") $qido .= " AND (from_name LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_fio']))."%' OR to_name LIKE '%".mysql_real_escape_string(stripslashes($_REQUEST['filter_fio']))."%')";
	if(isset($_REQUEST['filter_attach']) && trim($_REQUEST['filter_attach'])=="2") $qido .= " AND (SELECT count(*) FROM ".$_conf['prefix']."user_mail_attach WHERE ".$_conf['prefix']."user_mail.idm = ".$_conf['prefix']."user_mail_attach.idm) > 0 ";
	if(isset($_REQUEST['filter_attach']) && trim($_REQUEST['filter_attach'])=="3") $qido .= " AND (SELECT count(*) FROM ".$_conf['prefix']."user_mail_attach WHERE ".$_conf['prefix']."user_mail.idm = ".$_conf['prefix']."user_mail_attach.idm) = 0 ";
	
	$r_all = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."user_mail WHERE idu='".$_SESSION['USER_IDU']."' AND account='".$idma."' AND  (folder='inbox' OR folder='outbox')".$qido);
	$t_all = $r_all -> GetRowAssoc(false);
	$r_in = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."user_mail WHERE idu='".$_SESSION['USER_IDU']."' AND account='".$idma."' AND folder='inbox'".$qido);
	$t_in = $r_in -> GetRowAssoc(false);
	$r_new = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."user_mail WHERE idu='".$_SESSION['USER_IDU']."' AND account='".$idma."' AND folder='inbox' AND mstate='new'".$qido);
	$t_new = $r_new -> GetRowAssoc(false);
	$r_out = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."user_mail WHERE idu='".$_SESSION['USER_IDU']."' AND account='".$idma."' AND folder='outbox'".$qido);
	$t_out = $r_out -> GetRowAssoc(false);
	$r_trash = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."user_mail WHERE idu='".$_SESSION['USER_IDU']."' AND account='".$idma."' AND folder='trash'".$qido);
	$t_trash = $r_trash -> GetRowAssoc(false);
	$msgcount = array(
		'all'=>$t_all['count(*)'],
		'inb'=>$t_in['count(*)'],
		'new'=>$t_new['count(*)'],
		'out'=>$t_out['count(*)'],
		'trash'=>$t_trash['count(*)'],
	);
	return $msgcount;
}

/**
* Main window functions
*/
function UpdateMessageCount($idma){
	$res['countmsg'] = CountMessages(idma);
	$GLOBALS['_RESULT'] = $res;
}
/**
*  Функция вывода списка доступных контактов для пользователя
*/
function LoadContactList(){
	global $_conf, $db, $smarty;
	$out = "";
	$str = isset($_REQUEST['str']) ? stripslashes($_REQUEST['str']) : null;
	$out .= Group_Contact("super", $str);
	$out .= Group_Contact("administrator", $str);
	$out .= Group_Contact("manager", $str);
	$out .= Group_Contact("client", $str);
	$res['msg'] = $out;
	if(isset($str)) $GLOBALS['_RESULT'] = $res;
	else return $out;
}
function Group_Contact($group, $str){
	global $_conf, $db, $smarty;
	if($group=="super" || $group=="administrator") $out = "<strong>Администраторы</strong><br />";
	if($group=="manager") $out = "<strong>Менеджеры</strong><br />";
	if($group=="client") $out = "<strong>Клиенты</strong><br />";
	if($str!=null && $str!="") $sf = " AND (".$_conf['prefix']."users_add.fio LIKE '%".mysql_real_escape_string($str)."%' OR ".$_conf['prefix']."users.email LIKE '%".mysql_real_escape_string($str)."%' OR ".$_conf['prefix']."users.login LIKE '%".mysql_real_escape_string($str)."%') ";
	else $sf = "";
	$q = "SELECT * FROM ".$_conf['prefix']."users LEFT JOIN ".$_conf['prefix']."users_add USING(idu) 
	WHERE group_code='".$group."' AND email!='' AND email!='&nbsp;' $sf ";
	$q .= "ORDER BY fio, email";
	$r = $db -> Execute($q);
	if($r -> RecordCount() != 0){
		while(!$r -> EOF){
			$t = $r -> GetRowAssoc(false);
			//$out .= '<a href="javascript:void(null)" onclick="document.getElementById(\'to\').value=\''.stripslashes($t['fio']).' &lt;'.stripslashes($t['email']).'&gt;\'; document.getElementById(\'to_idu\').value=\''.stripslashes($t['idu']).'\'; LoadUserContact(\''.$t['idu'].'\');">'.stripslashes($t['fio']).' &lt;'.stripslashes($t['email']).'&gt;</a><br />';
			$out .= '<a href="javascript:void(null)" onclick="document.getElementById(\'to\').value=\''.stripslashes($t['fio']).' &lt;'.stripslashes($t['email']).'&gt;\'; document.getElementById(\'to_idu\').value=\''.stripslashes($t['idu']).'\'; LoadUserContact(\''.$t['idu'].'\');">'.stripslashes($t['fio']).'</a><br />';
			//$out .= '<a href="javascript:void(null)" onclick="LoadUserContact(\''.$t['idu'].'\')">'.stripslashes($t['fio']).' &lt;'.stripslashes($t['email']).'&gt;</a><br />';
			$r -> MoveNext();
		}
	}
	return $out;
}
/**
* Вибір і завантаженні всіх адрес користувача
*/
function LoadUserContact($idu){
	global $db, $_conf;
	$option = "Все адреса: &bull; ";
	$rac = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account LEFT JOIN ".$_conf['prefix']."users_add USING(idu) WHERE idu=".$idu." ORDER BY idma");	
	while(!$rac -> EOF){
		$tac = $rac -> GetRowAssoc(false);
		$option .= '<a href="javascript:void(null)" onclick="document.getElementById(\'to\').value=\''.stripslashes($tac['fio']).' &lt;'.stripslashes($tac['email']).'&gt;\'; document.getElementById(\'to_idu\').value=\''.stripslashes($idu).'\';">'.stripslashes($tac['email']).'</a> &bull; ';
		$rac -> MoveNext();
	}
	$res['mails'] = $option;
	$GLOBALS['_RESULT'] = $res;
}
/**
* Основная страница настроек аккаунта пользователем
*/
function UserSettings(){
	global $db, $_conf;
	$option = "";
	$opt = array(
		'imap'=>'IMAP',
		'notls'=>'IMAP (no TLS)',
		'ssl'=>'IMAP SSL',
		'ssl/novalidate-cert'=>'IMAP SSL (self signed)',
		'pop3'=>'POP3',
		'pop3/notls'=>'POP3 (no TLS)',
		'pop3/ssl'=>'POP3 SSL',
		'pop3/ssl/novalidate-cert'=>'POP3 SSL (self signed)'
	);

	$mail_ui = GetMailAccount($_SESSION['USER_IDU'], $_SESSION['USER_EMAIL']);
	
	$sel_idma = isset($_REQUEST['set_idma']) ? $_REQUEST['set_idma'] : $mail_ui['idma'];
	$rac = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account WHERE idu=".$_SESSION['USER_IDU']." ORDER BY idma");	
	$acc_string = ' &nbsp;&nbsp; &bull; &nbsp;&nbsp;';
	while(!$rac -> EOF){
		$tac = $rac -> GetRowAssoc(false);
		if($tac['idma']==$sel_idma){
			$acc_string .= '<strong>'.stripslashes($tac['email']).'</strong> &nbsp;&nbsp; &bull; &nbsp;&nbsp;';
			$mail_ui = GetMailAccountById($tac['idma']);
		}else $acc_string .= '<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=outlook&mailact=UserSettings&set_idma='.$tac['idma'].'\',\'OMailList\')">'.stripslashes($tac['email']).'</a> &nbsp;&nbsp; &bull; &nbsp;&nbsp;';
		$rac -> MoveNext();
	}
	$acc_string .= '<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=outlook&mailact=UserSettings&set_idma=-1\',\'OMailList\')" title="Добавить новый почтовый аккаунт"><img src="'.$_conf['admin_tpl_dir'].'outlook/addaccount_icon.gif" width="21" height="18" style="vertical-align:middle;" alt="Добавить новый почтовый аккаунт" /></a> &nbsp;&nbsp; &bull; &nbsp;&nbsp;';
	reset($opt);
	while(list($k,$v)=each($opt)){
		if($k == $mail_ui['mailtls']) $option .= '<option value="'.$k.'" selected="selected">'.$v.'</option>';
		$option .= '<option value="'.$k.'">'.$v.'</option>';
	}
	if(isset($_REQUEST['set_idma']) && $_REQUEST['set_idma']==-1){
		while(list($k,$v)=each($mail_ui)){
			$mail_ui[$k] = '';
		}
	}

	$out = '<div id="SetArea">';
	
	$out .= '<div style="padding:5px; border:dashed 1px green;">'.$acc_string.'</div>';
	
	$out .= '<div style="padding:5px;">';
	$out .= '<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="USetForm">';
	$out .= '<input type="hidden" name="idma" id="idma" value="'.$mail_ui['idma'].'" />';

	if(isset($_REQUEST['set_idma']) && $_REQUEST['set_idma']==-1){
		$out .= '<h3>Добавить новый почтовый аккаунт</h3><p><small>Вы можете указать только адрес электронной почты, а остальные поля оставить пустыми. Если вы желаете принимать почту из указанного почтового адреса, тогда заполните все поля.</small></p>';
		$out .= '<strong>E-mail (адрес электронной почты):</strong><br />';
		$out .= '<input type="text" name="email" id="email" value="'.$mail_ui['email'].'" style="width:300px;" /><br />';
	}else{
		$out .= '<h3>'.$mail_ui['email'].'</h3>';
		$out .= '<input type="hidden" name="email" id="email" value="'.$mail_ui['email'].'" />';
	}
/*	
	$out .= '<strong>Логин:</strong><br />';
	$out .= '<input type="text" name="login" id="login" value="'.$mail_ui['login'].'" style="width:300px;" /><br />';
	$out .= '<strong>Пароль:</strong><br />';
	$out .= '<input type="password" name="password" id="password" value="'.$mail_ui['password'].'" style="width:300px;" /><br />';
	$out .= '<strong>Сервер:</strong><br />';
	$out .= '<input type="text" name="server" id="server" value="'.$mail_ui['server'].'" style="width:300px;" /><br />';
	$out .= '<input type="text" name="port" id="port" value="'.$mail_ui['port'].'" style="width:50px;" />';
	$out .= '<select name="mailtls" id="mailtls" onchange="updateLoginPort()" style="width:250px;">'.$option.'</select><br />';
*/	
	$out .= '<div id="msgarea"></div>';
	$out .= '<input type="button" name="SaveUSet" value="Сохранить" onclick="SaveUserSet(\'USetForm\',\'msgarea\')" />';
	$out .= '</form>';
	$out .= '</div>';
	if(!isset($_REQUEST['set_idma']) || $_REQUEST['set_idma']!=-1){
	$out .= '<div style="padding:5px;">';
	$out .= '<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="USetForm1">';
	$out .= '<h3>Подпись в конце сообщения:</h3>';
	$out .= '<input type="hidden" name="idma1" id="idma1" value="'.$mail_ui['idma'].'" />';
	$out .= '<input type="hidden" name="email1" id="email1" value="'.$mail_ui['email'].'" />';
	$out .= '<textarea name="sign" id="sign" style="width:300px; height:150px;">'.$mail_ui['sign'].'</textarea><br />';
	$out .= '<div id="msgarea1"></div>';
	$out .= '<input type="button" name="SaveUSet1" value="Сохранить" onclick="SaveUserSet1(\'USetForm1\',\'msgarea1\')" />';
	$out .= '</form>';
	$out .= '</div>';
	}
	$out .= '</div>';
	if((!isset($_REQUEST['set_idma']) || $_REQUEST['set_idma']!=-1) && $mail_ui['email']!=$_SESSION['USER_EMAIL']){
		$out .= '<br /><br /><div class="block">';
		$out .= '<strong>Если вы хотите удалить почтовый аккаунт - нажмите ссылку ниже. Удалять можно только дополнительные почтовые ящики.<br />ВНИМАНИЕ! Во время удаления почтового аккаунта будут удалены все письма из этого аккаунта!</strong><br /><br /><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=outlook&mailact=DeleteMailAccount&del_idma='.$mail_ui['idma'].'\',\'OMailList\')">Удалить аккаунт '.$mail_ui['email'].'</a>';
		$out .= '</div>';
	}
	return $out;
}
/**
*
*/
function SaveUSet(){
	global $db, $_conf;
	$er = 0; $er1 = 0; $res = array();
	$res['msg'] = ''; $remote = 'n';
	if(trim($_REQUEST['email'])==""){
		$res['msg'] .= "<p class='mailerror'>Пожалуйста, укажите адрес электронной почты!</p>";
		$er = 1;
	}
	
	if(trim($_REQUEST['login'])=="" || trim($_REQUEST['mailtls'])=="" || trim($_REQUEST['password'])=="" ||
	trim($_REQUEST['server'])=="" || trim($_REQUEST['port'])==""){
		//$res['msg'] .= "<p class='mailerror'>Если желаете принимать почту с вашего почтового аккаунта, заполните все объязательные поля! Иначе укажите только адрес электронной почты, а остальные поля оставьте пустыми.</p>";
		$er1 = 1;
	}
	
	if($er==0 && $er1==0){
		if(!$mbox = imap_open("{".stripslashes($_REQUEST['server']).":".stripslashes($_REQUEST['port'])."/".stripslashes($_REQUEST['mailtls'])."}INBOX", $_REQUEST['login'], $_REQUEST['password'])){
			$res['msg'] .= "<p class='mailerror'>Не удалось установить соединение с сервером: ". imap_last_error()."<br />Проверьте введенные данные. Возможно в качестве логина нужно использовать полный адрес e-mail.</p>";
			$er = 1;
		}else{ $res['msg'] .= "<p class='mailok'>Соединение с почтовым сервером установлено!</p>"; $remote = 'y'; }
	}
	if($er == 0){
		$mail_ui = GetMailAccount($_SESSION['USER_IDU'], stripslashes($_REQUEST['email']));
		if($mail_ui == false){ //insert
			$ri = $db -> Execute("INSERT INTO ".$_conf['prefix']."user_mail_account (idu, email, server, port, mailtls, login, password, remote) VALUES(
			'".$_SESSION['USER_IDU']."', '".mysql_real_escape_string(stripslashes($_REQUEST['email']))."', '".mysql_real_escape_string(stripslashes($_REQUEST['server']))."', '".mysql_real_escape_string(stripslashes($_REQUEST['port']))."', '".mysql_real_escape_string(stripslashes($_REQUEST['mailtls']))."', '".mysql_real_escape_string(stripslashes($_REQUEST['login']))."', '".mysql_real_escape_string(stripslashes($_REQUEST['password']))."', '".$remote."')");
			$res['msg'] .= "<p class='mailok'>Новый почтовый аккаунт добавлен в базу данных!<br />Обновите страницу, чтобы применить изменения (нажмите клавишу F5 или иконку на панели броузера 'Обновить страницу')</p>";
		}else{//update
			$ri = $db -> Execute("UPDATE ".$_conf['prefix']."user_mail_account SET server='".mysql_real_escape_string(stripslashes($_REQUEST['server']))."', port='".mysql_real_escape_string(stripslashes($_REQUEST['port']))."', mailtls='".mysql_real_escape_string(stripslashes($_REQUEST['mailtls']))."', login='".mysql_real_escape_string(stripslashes($_REQUEST['login']))."', password='".mysql_real_escape_string(stripslashes($_REQUEST['password']))."', remote='".$remote."'
			WHERE idu='".$_SESSION['USER_IDU']."' AND email='".mysql_real_escape_string(stripslashes($_REQUEST['email']))."'");
			$res['msg'] .= "<p class='mailok'>Данные почтового аккаунта обновлены!</p>";
		}
	}
	//$res['msg'] .= print_r($_REQUEST,1);
	$GLOBALS['_RESULT'] = $res;
}

/**
*
*/
function SaveUSet1(){
	global $db, $_conf;
	$er = 0; $res = array();
	if(trim($_REQUEST['sign'])==""){
		$res['msg'] = "<p class='mailerror'>Пожалуйста, введите текст подписи!</p>";
		$er = 1;
	}else if(trim($_REQUEST['email1'])==""){
		$res['msg'] .= "<p class='mailerror'>Пожалуйста, сначала введите адрес электронной почты в форме выше и сохраните его!</p>";
		$er = 1;
	}else{
		$ui = GetUserName($_SESSION['USER_IDU']);
		$mail_ui = GetMailAccount($_SESSION['USER_IDU'], $ui['EMAIL']);
		if($mail_ui == false){ //insert
			$q = "INSERT INTO ".$_conf['prefix']."user_mail_account (idu, email, sign) VALUES('".$_SESSION['USER_IDU']."', '".mysql_real_escape_string(stripslashes($_REQUEST['email1']))."', '".mysql_real_escape_string(stripslashes($_REQUEST['sign']))."')";
			$r = $db -> Execute($q);
			$res['msg'] = "<p class='mailok'>Подпись к письмам успешно добавлена!</p>";
		}else{//update
			$q = "UPDATE ".$_conf['prefix']."user_mail_account SET 
			sign = '".mysql_real_escape_string(stripslashes($_REQUEST['sign']))."'
			WHERE idu='".$_SESSION['USER_IDU']."' AND email='".mysql_real_escape_string(stripslashes($_REQUEST['email1']))."'";
			$r = $db -> Execute($q);
			
			$res['msg'] = "<p class='mailok'>Подпись к письмам успешно обновлена!</p>";
		}
	}
	$GLOBALS['_RESULT'] = $res;
}



/**
* Check for new mail for selected account
*/ 
function CheckNewMail($idma){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."user_mail WHERE account='".$idma."' AND idu='".$_SESSION['USER_IDU']."' AND folder='inbox' AND mstate='new'");
	$t = $r -> GetRowAssoc(false);
	if($t['count(*)']==0) $res['msg'] = "Нет новых сообщений!";
	else $res['msg'] = "У вас есть ".$t['count(*)']." непрочитанных сообщений!";
	$res['countmsg'] = CountMessages($idma);
	$GLOBALS['_RESULT'] = $res;
}
?>