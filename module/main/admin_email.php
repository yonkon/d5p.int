<?php
/**
 * Рассылка сообщений пользователям сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011 
 * @link http://shiftcms.net
 * @version 1.01.02
 */

if(!defined("SHIFTCMS")) exit;

if($_SERVER['PHP_SELF']=="/admin.php"){
	$smarty -> assign("PAGETITLE","<h2>".$lang_ar['nsa_title']."</h2>");
	echo "
	|&nbsp;<a href=\"admin.php?p=".$p."&act=list\">".$lang_ar['nsa_list']."</a>&nbsp;|&nbsp;
	<a href=\"admin.php?p=".$p."&act=create\">".$lang_ar['nsa_create']."</a>&nbsp;|&nbsp;
	<a href=\"admin.php?p=".$p."&act=signedList\">".$lang_ar['nsa_users']."</a>&nbsp;|&nbsp;
	<hr>";
}
$query_array = array(
	'all_user'=>"SELECT * FROM ".$_conf['prefix']."users WHERE newssign='0'",
	'all_from_group'=>"SELECT * FROM ".$_conf['prefix']."users WHERE newssign='0' AND group_code='request_group_code'",
	'all_signed'=>"SELECT * FROM ".$_conf['prefix']."news_signed",
);


if(!isset($_REQUEST['act'])) $_REQUEST['act'] = "list";

//---------------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="email"){
	@set_time_limit(0);
   $q="SELECT * FROM ".$_conf['prefix']."newsmsg WHERE idmsg='".(int)$_REQUEST['idmsg']."'";
   $r = $db -> Execute($q);
   $tmsg = $r -> GetRowAssoc(false);
   $mes_theme = stripslashes($tmsg['mes_theme']);
   $attch = array();
	if(stripslashes($tmsg['attachment'])!=""){
		$attch = explode("|",stripslashes($tmsg['attachment']));
	}
   $q="SELECT * FROM ".$_conf['prefix']."newsletter WHERE idmsg='".(int)$_REQUEST['idmsg']."' AND state='forsend'";
   $rs = $db -> Execute($q);
	$i=0;
	require_once('./include/swift/swift_required.php');
	$transport = Swift_SmtpTransport::newInstance();
	$mailer = Swift_Mailer::newInstance($transport);
	$mout = array();
	preg_match_all("|(src=\")(.*?)(\")|", stripslashes($tmsg['message']), $mout);
	$cts=time();
	while (!$rs->EOF) { 
		$t = $rs->GetRowAssoc();
		if(filter_var(trim($t['EMAIL']), FILTER_VALIDATE_EMAIL)){

		$message = stripslashes($tmsg['message']);
			$send = Swift_Message::newInstance()
				->setSubject($mes_theme)
				->setFrom(array($_conf['sup_email'] => $_conf['site_name']))
				->setTo(array(trim($t['EMAIL'])))
			;
			if(!empty($attch)){
				reset($attch);
				while(list($k,$v)=each($attch)){
					if(file_exists($v)) $send->attach(Swift_Attachment::fromPath($v));
				}
			}
			if(!empty($mout[2])){
				reset($mout[2]);
				while(list($k,$v)=each($mout[2])){
					$message = str_replace($v,$send->embed(Swift_Image::fromPath($v)),$message);
				}
			}
			$send->setBody(
				'<html>' .
				'<head></head>' .
				'<body>'. $message .'</body>' .
				'</html>',
				'text/html',
				''.$_conf['encoding'].''
			);
			if($result = $mailer->send($send)){
			   $r1 = $db -> Execute("UPDATE ".$_conf['prefix']."newsletter SET state='sended' WHERE idsn='".$t['IDSN']."'");
			   $i++;
			}
		}else{
			   $r1 = $db -> Execute("UPDATE ".$_conf['prefix']."newsletter SET state='sended' WHERE idsn='".$t['IDSN']."'");
			   $i++;
		}
		   $bt=time();
		   $bc=$bt-$cts;
		   if($bc>=25) break; /* длительность рассылки 25 секунд, если рассылка не окончена, надо повторить. */
		   $rs -> MoveNext();
	}
	$rc = time()-$cts;
	echo msg_box(sprintf($lang_ar['nsa_sended'],$rc,$i));
	$_REQUEST['act']="list";
}
//---------------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delit"){
   $q="DELETE FROM ".$_conf['prefix']."newsletter WHERE idmsg='".(int)$_REQUEST['idmsg']."'";
   $r = $db -> Execute($q);
   $q="DELETE FROM ".$_conf['prefix']."newsmsg WHERE idmsg='".(int)$_REQUEST['idmsg']."'";
   $r = $db -> Execute($q);
   echo msg_box($lang_ar['nsa_deleted']);
   $_REQUEST['act']="list";
}
//------------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="list"){
   echo "<h2>".$lang_ar['nsa_list']."</h2>";

   $q="SELECT *,
   (SELECT count(*) FROM ".$_conf['prefix']."newsletter WHERE ".$_conf['prefix']."newsletter.idmsg=".$_conf['prefix']."newsmsg.idmsg) as allmsg,
   (SELECT count(*) FROM ".$_conf['prefix']."newsletter WHERE ".$_conf['prefix']."newsletter.idmsg=".$_conf['prefix']."newsmsg.idmsg AND ".$_conf['prefix']."newsletter.state='sended') as allsended
   FROM ".$_conf['prefix']."newsmsg
   ORDER BY dcreate DESC";
   $r = $db -> Execute($q);
  echo "<table border=0 cellspacing=0 cellpadding=0 class='selrow'><tr>
	  <th>".$lang_ar['nsa_number']."</th><th>".$lang_ar['nsa_thema']."</th><th>".$lang_ar['nsa_all']."</th><th>".$lang_ar['nsa_sended1']."</th><th>".$lang_ar['nsa_created']."</th><th>".$lang_ar['edit']."</th><th>".$lang_ar['nsa_send']."</th><th>".$lang_ar['nsa_copy']."</th><th>".$lang_ar['nsa_del']."</th>
  </tr>";
  $i=0;
  while(!$r -> EOF){
  	$tmp = $r -> GetRowAssoc(false);
	$i++;
    echo "<tr bgcolor=#EEF7F5>
    <td><a href='admin.php?p=".$p."&act=list&subact=view&idmsg=".$tmp['idmsg']."'>".$i."</a></td>
    <td><a href='admin.php?p=".$p."&act=list&subact=view&idmsg=".$tmp['idmsg']."'>".$tmp['mes_theme']."</a></td>
    <td>".$tmp['allmsg']."</td>
    <td>".$tmp['allsended']."</td>
    <td>".date("d.m.Y H:i",$tmp['dcreate'])."</td>
    <td><a href=\"admin.php?p=".$p."&act=editmsg&idmsg=".$tmp['idmsg']."\">".$lang_ar['edit']."</a></td>
    <td><a href=\"admin.php?p=".$p."&act=email&idmsg=".$tmp['idmsg']."\">".$lang_ar['nsa_send']."</a></td>
    <td align='center'><a href=\"admin.php?p=".$p."&act=recreate&idmsg=".$tmp['idmsg']."\">Создать копию</a></td>
    <td><a href=\"admin.php?p=".$p."&act=delit&idmsg=".$tmp['idmsg']."\">".$lang_ar['nsa_del']."</a></td>
    </tr>";
	$r -> MoveNext();
  }
  echo "</table>";
  if(isset($_REQUEST['subact'])&&$_REQUEST['subact']=="view"){
    $q="SELECT * FROM ".$_conf['prefix']."newsmsg WHERE idmsg='".(int)$_REQUEST['idmsg']."'";
	$r = $db -> Execute($q);
    $tmp = $r -> GetRowAssoc(false);
     echo "<hr /><b>".$lang_ar['nsa_created'].":</b> ".date("d.m.Y H:i",$tmp['dcreate'])."<br />
         <b>".$lang_ar['nsa_thema'].":</b> <b>".stripslashes($tmp['mes_theme'])."<br /><br />
         <b>".$lang_ar['nsa_text'].":</b><br />";
         if($tmp['format']=='text') echo "<div style='border:solid 1px #120C61;background:#F4F3FE;padding:5px;'>".nl2br(stripslashes($tmp['message']))."</div>";
         if($tmp['format']=='html') echo "<div style='border:solid 1px #120C61;background:#F4F3FE;padding:5px;'>".stripslashes($tmp['message'])."</div>";
  }
}

/**
* Редагування повыдомлення
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delMsgFile"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."newsmsg where idmsg='".(int)$_REQUEST['idmsg']."'");
	$t = $r -> GetRowAssoc(false);
	$at = explode("|",stripslashes($t['attachment']));
	$at1 = array();
	$df = stripslashes($_REQUEST['file']);
	while(list($k,$v)=each($at)){
		if($df!=trim($v) && trim($v)!=""){
			$at1[] = trim($v);
		}
	}
	$attach = implode("|",$at1);
	$r = $db -> Execute("update ".$_conf['prefix']."newsmsg set attachment='".$attach."' where idmsg='".(int)$_REQUEST['idmsg']."'");
	@unlink($df);
	echo msg_box("Файл удален!");
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="editmsg"){

   echo "<h2>".$lang_ar['edit']."</h2>";
   $r = $db -> Execute("select * from ".$_conf['prefix']."newsmsg where idmsg='".(int)$_REQUEST['idmsg']."'");
   $t = $r -> GetRowAssoc(false);
	
   echo "<form action='admin.php?p=".$p."&act=updMsg&idmsg=".(int)$_REQUEST['idmsg']."' method='post' enctype='multipart/form-data'>
   ".$lang_ar['nsa_thema'].":<br>
   <input type='text' name='mes_theme' id='mes_theme' size='100' maxlength='250' value=\"".htmlspecialchars(stripslashes($t['mes_theme']))."\" /><br>
   ".$lang_ar['nsa_addfile'].":<br />
   <input type='file' class='uploadinputbutton' name='attach[]' id='attach[]' onchange=\"add_file('attach', 1);\" /><br />
   <span id=\"attach_1\"><input type=\"button\" value=\"Добавить другой\" onclick=\"add_file('attach', 1);\" /></span><br /><br />";
   //str_replace("|","<br />",$t['attachment'])."<br />";
   if($t['attachment']!=""){
	   $at = explode("|",stripslashes($t['attachment']));
		$i = 0;
	   while(list($k,$v)=each($at)){
		   if(trim($v)!=""){
			   $fz = get_filesize(filesize($v));
		   echo '<div id="f'.$i.'"><a href="'.$v.'" target="_blank">'.$v.'</a>
		   - '.$fz.' - (<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=delMsgFile&idmsg='.$t['idmsg'].'&file='.$v.'\',\'ActionRes\'); delelem(\'f'.$i.'\');"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" alt="Delete" /></a>)</div>';
		   $i++;
		   }
	   }
   }
   echo "<br /><p><strong>".$lang_ar['nsa_text'].":</strong></p><br />";
		/*   
		initializeTiny();
		echo '<textarea name="message" id="message" rows="30" cols="120">'.stripslashes($t['message']).'</textarea><br />';
		addTinyToField("message");
		*/
		/*
		initializeFCK();
		addFCKToField("message", stripslashes($t['message']), 'Default', '700', '600');
		*/
		echo '<textarea name="message" id="message" rows="30" cols="120">'.stripslashes($t['message']).'</textarea><br />';
		initializeCK();
		addCKToField("message", 'Default', '900', '500');

   echo "<br /><input type='submit' value='".$lang_ar['save']." >>' />
   </form>";

}
//------------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="create"){
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_group WHERE group_code!='guest' ORDER BY group_name");
	$gl = "<select name='group_code' id='group_code'>";
	while(!$r -> EOF){
		$t = ClearSleshes($r -> GetRowAssoc());
		$gl.="<option value='".$t['GROUP_CODE']."'>".$t['GROUP_NAME']."</option>";
		$r -> MoveNext();
	}
	$gl.="</select>";
   echo "<h2>".$lang_ar['mes_step1']."</h2><br />";
   echo "<form method=post action=".$_SERVER['PHP_SELF']."?p=".$p."&act=create1>";

   echo "<input type='hidden' name='format' id='format' value='html' />
   <input type='hidden' name='method' id='method' value='' />
   <b>".$lang_ar['mes_seluser']."</b><br><br>

   <div style='border:solid 1px #cccccc;background:#eeeeee;padding:2px;'>".$lang_ar['nsa_sendtoreg'].":
   <input type=submit name=all_user value=\"".$lang_ar['nsa_next']." >>\" onclick=\"document.getElementById('method').value='all_user'\" /></div><br>

   <div style='border:solid 1px #cccccc;background:#eeeeee;padding:2px;'>".$lang_ar['mes_sendtosign'].":
   <input type=submit name='all_signed' value=\"".$lang_ar['nsa_next']." >>\" onclick=\"document.getElementById('method').value='all_signed'\" /></div><br>

   <div style='border:solid 1px #cccccc;background:#eeeeee;padding:2px;'>".$lang_ar['mes_sendtogroup'].":</b> $gl 
   <input type=submit name='all_from_group' value=\"".$lang_ar['nsa_next']." >>\"  onclick=\"document.getElementById('method').value='all_from_group'\" /></div><br>

   </form>";
}
//--------------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="create1"){
   echo "<h2>".$lang_ar['nsa_step2']."</h2>";
   /*
echo "<pre>";   
print_r($_REQUEST);
echo "</pre>";
	*/
   if(isset($_REQUEST['method']) && ($_REQUEST['method']=="all_user" || $_REQUEST['method']=="all_signed")){
      $q = $query_array[$_REQUEST['method']];
   }

   if(isset($_REQUEST['method']) && $_REQUEST['method']=="all_from_group"){
	  $q = str_replace('request_group_code', $_REQUEST['group_code'], $query_array[$_REQUEST['method']]);
   }
	
//   echo $q;
	$rs = $db -> Execute($q);
   $sall = $rs -> RecordCount();
//   echo $q;
   echo "<br><font color=blue><b>".sprintf($lang_ar['nsa_found'],$sall)."</b></font><br><br>";
   echo "<form action='".$_SERVER['PHP_SELF']."?p=$p&act=create2&format=".$_REQUEST['format']."' method='post' enctype='multipart/form-data'>
   ".$lang_ar['nsa_thema'].":<br>
   <input type='text' name='mes_theme' id='mes_theme' size='100' maxlength='250' /><br>
   ".$lang_ar['nsa_addfile'].":<br />
   <input type='file' class='uploadinputbutton' name='attach[]' id='attach[]' onchange=\"add_file('attach', 1);\" /><br />
   <span id=\"attach_1\"><input type=\"button\" value=\"Добавить другой\" onclick=\"add_file('attach', 1);\" /></span><br />
   ".$lang_ar['nsa_text'].":<br />
   ";
/*
<input type="file" class="uploadinputbutton" maxsize="2097152" name="file[]" onchange="add_file('file', 1);" /><br />
<span id="file_1"><input type="button" value="Додати інший" onclick="add_file('file', 1);" /></span><br />
*/
		$url = "?p=unsubscribe";
		$url1 = '<a href="?p=unsubscribe">отписаться</a>';
       $txt = stripslashes("\n\n---------------------------------------\n".sprintf($lang_ar['nsa_msgend1'],$_conf['site_name'],$url,$_conf['www_patch']));
       $html = stripslashes("<br><br>---------------------------------------<br />".sprintf($lang_ar['nsa_msgend2'],$_conf['site_name'],$url1, '<a href="'.$_conf['www_patch'].'">'.$_conf['www_patch'].'</a>'));

   if($_REQUEST['format']=='text'){
      echo "<textarea name=message cols=80 rows=15>".$txt."</textarea><br>";
   }
   if($_REQUEST['format']=='html'){
	   /*
		initializeTiny();
		echo '<textarea name="message" id="message" rows="30" cols="120"></textarea><br />';
		addTinyToField("message");
		*/
		echo '<textarea name="message" id="message" rows="30" cols="120">'.$html.'</textarea><br />';
		initializeCK();
		addCKToField("message", 'Default', '900', '500');
		
   }
   echo "<br /><input type='hidden' name='q' id='q' value=\"".$q."\" />";
   echo "<input type='submit' value='".$lang_ar['nsa_create']." >>' />
   </form>";

}
//---------------------------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="create2"){
		$attachment = array();
		include "include/uploader.php";
		$upl = new uploader;
		$farr = $upl -> ConvertFileArray("attach");
		$upl -> rewrite = 1;
			$sbd = substr(time(),0,3);
			$dir = "tmp/".$sbd;
			if(!is_dir($dir)) $upl -> MakeDir($dir);
			$dir = "tmp/".$sbd."/".time();
			if(!is_dir($dir)) $upl -> MakeDir($dir);
		while(list($key,$val) = each($farr)){
			$filename = $dir."/".$val['name'];
			$upl -> fname = $filename;
			$res = $upl -> SaveFile($val);
			if($res == 1){
				$attachment[] = $filename;
				echo $lang_ar['nsa_fileadded'].": ".$filename." (".$val['size']." байт)<br />";
			}else{
				if(trim($val['name'])!="") echo $res."<br />";
			}
		}

	   if($_conf['url_type'] == 1) $message = rewrite_url($_REQUEST['message'],$_conf);
	   $message = rewrite_img_url($message,$_conf);
	   
	   $r = $db -> Execute("insert into ".$_conf['prefix']."newsmsg(mes_theme,message,format,attachment,dcreate)values('".mysql_real_escape_string(stripslashes($_REQUEST['mes_theme']))."','".mysql_real_escape_string(stripslashes($message))."','".mysql_real_escape_string(stripslashes($_REQUEST['format']))."','".mysql_real_escape_string(stripslashes(implode("|",$attachment)))."','".time()."')");
	   $idmsg = $db -> Insert_ID();
	   $q = stripslashes($_REQUEST['q']);
	   $ms = $db -> Execute($q);
	   $sall = $ms -> RecordCount();
       $cd=time();
		while (!$ms->EOF) { 
			$tmp = $ms -> GetRowAssoc();
	       $qi="INSERT INTO ".$_conf['prefix']."newsletter(email,datec,state,idmsg)VALUE
	       ('".$tmp['EMAIL']."','".$cd."','forsend','".$idmsg."')";
		   $rs = $db -> Execute($qi);
		   $ms -> MoveNext();
	   }
   echo "<br><font color=blue>".sprintf($lang_ar['nsa_maked'],$sall)."</font><br><br>
   ".sprintf($lang_ar['nsa_sendmsg'],$idmsg).".<br /><br />
   ".$lang_ar['nsa_sendmsglater']."<br /><br />";
}

/**
* Збереження змін у відредагованому повідомленні
*/
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="updMsg"){
		$r = $db -> Execute("select * from ".$_conf['prefix']."newsmsg 
		WHERE idmsg='".(int)$_REQUEST['idmsg']."'");
		$t = $r -> GetRowAssoc(false);
		
		$attachment = array(); $attch = '';
		include "include/uploader.php";
		$upl = new uploader;
		$farr = $upl -> ConvertFileArray("attach");
		$upl -> rewrite = 1;
			$sbd = substr(time(),0,3);
			$dir = "tmp/".$sbd;
			if(!is_dir($dir)) $upl -> MakeDir($dir);
			$dir = "tmp/".$sbd."/".time();
			if(!is_dir($dir)) $upl -> MakeDir($dir);
		while(list($key,$val) = each($farr)){
			$filename = $dir."/".$val['name'];
			$upl -> fname = $filename;
			$res = $upl -> SaveFile($val);
			if($res == 1){
				$attachment[] = $filename;
				echo $lang_ar['nsa_fileadded'].": ".$filename." (".$val['size']." байт)<br />";
			}else{
				if(trim($val['name'])!="") echo $res."<br />";
			}
		}
		if(trim($t['attachment'])!="") $attch = trim($t['attachment'])."|".implode("|",$attachment);
		else $attch = implode("|",$attachment);
		
	   if($_conf['url_type'] == 1) $message = rewrite_url(stripslashes($_REQUEST['message']),$_conf);
	   $message = rewrite_img_url($message,$_conf);

	   $r = $db -> Execute("update ".$_conf['prefix']."newsmsg set
	   mes_theme='".mysql_real_escape_string(stripslashes($_REQUEST['mes_theme']))."',
	   message='".mysql_real_escape_string($message)."',
	   attachment='".mysql_real_escape_string(stripslashes($attch))."'
	   WHERE idmsg='".(int)$_REQUEST['idmsg']."'
	   ");
	   $idmsg = $db -> Insert_ID();

   echo "<br><font color=blue>".$lang_ar['nsa_updated']."</font><br /><br />
   ".sprintf($lang_ar['nsa_sendmsg'],(int)$_REQUEST['idmsg']).".<br /><br />
   ".$lang_ar['nsa_sendmsglater']."<br /><br />";
}
/**
* Створення дублікату існуючої розсилки
*/
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="recreate"){
	$ndatec = time();
	$r1 = $db -> Execute("select * from ".$_conf['prefix']."newsmsg where idmsg='".(int)$_REQUEST['idmsg']."'");
	$t1 = $r1 -> GetRowAssoc(false);
	   $r = $db -> Execute("insert into ".$_conf['prefix']."newsmsg(mes_theme,message,format,attachment,dcreate)values('".mysql_real_escape_string(stripslashes($t1['mes_theme']))."','".mysql_real_escape_string(stripslashes($t1['message']))."','".mysql_real_escape_string(stripslashes($t1['format']))."','".mysql_real_escape_string(stripslashes($t1['attachment']))."','".$ndatec."')");
	   $idmsg = $db -> Insert_ID();
	
	$r = $db -> Execute("select email from ".$_conf['prefix']."newsletter where idmsg='".(int)$_REQUEST['idmsg']."'");
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$ri = $db -> Execute("insert into ".$_conf['prefix']."newsletter (email, datec, state, idmsg)values('".mysql_real_escape_string(stripslashes($t['email']))."','".$ndatec."','forsend','".$idmsg."')");
		$r -> MoveNext();
	}
   echo "<br><font color=blue>".sprintf($lang_ar['nsa_maked'],$r -> RecordCount())."</font><br><br>
   ".sprintf($lang_ar['nsa_sendmsg'],$idmsg).".<br /><br />
   ".$lang_ar['nsa_sendmsglater']."<br /><br />";
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="DelSignedItem"){
		$r = $db->Execute("DELETE FROM ".$_conf['prefix']."news_signed WHERE id='".(int)$_REQUEST['id']."'");
		echo msg_box($lang_ar['nsa_userdelfromlist']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="signedList"){
   echo "<h2>".$lang_ar['nsa_listusers']."</h2>";
		$interval=50;
		if(!isset($_REQUEST['start'])) $start=0;
		else $start=$_REQUEST['start'];
   		$and = 0; $qad = '';
		$sname = $semail = '';
   if(isset($_REQUEST['subact']) && $_REQUEST['subact']=="search"){
   		$sname = trim($_REQUEST['sname'])!="" ? mysql_real_escape_string(stripslashes($_REQUEST['sname'])) : "";
   		$semail = trim($_REQUEST['semail'])!="" ? mysql_real_escape_string(stripslashes($_REQUEST['semail'])) : "";
		if($sname!=""){
			if($and==0) $qad .= " WHERE name LIKE '%".$sname."%'";
			else  $qad .= " name LIKE '%".$sname."%'";
		}
		if($semail!=""){
			if($and==0) $qad .= " WHERE email LIKE '%".$semail."%'";
			else  $qad .= " AND email LIKE '%".$semail."%'";
		}
   }
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."news_signed ".$qad." order by time DESC LIMIT ".$start.", ".$interval);
		$r1 = $db -> Execute("SELECT count(*) FROM ".$_conf['prefix']."news_signed ".$qad." order by time DESC");
	$t1 = $r1->GetRowAssoc(false);
	$list_page = Paging($t1['count(*)'],$interval,$start,"admin.php?p=".$p."&act=signedList&start=%start1%","");
	echo '<div class="block">
	<form method="post" action="admin.php?p='.$p.'&act=signedList&subact=search" enctype="multipart/form-data">
	'.$lang_ar['nsa_username'].': <input type="text" name="sname" id="sname" value="'.htmlspecialchars($sname).'" size="20" />&nbsp;&nbsp;
	E-mail: <input type="text" name="semail" id="semail" value="'.htmlspecialchars($semail).'" size="20" />
	<input type="submit" value="'.$lang_ar['nsa_find'].'" />
	</form>
	</div>';
	echo $list_page;
   echo '<table class="selrow" cellspacing="0">
   <tr>
   <th width="200">'.$lang_ar['nsa_username'].'</th><th width="250">E-mail</th><th>'.$lang_ar['nsa_datesign'].'</th><th>'.$lang_ar['nsa_del'].'</th>
   </tr>';
   while(!$r -> EOF){
   	$t = $r -> GetRowAssoc(false);
	   echo '
	   <tr id="TR'.$t['id'].'">
	   <td><span id="n'.$t['id'].'"><span onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=LoadField&id='.$t['id'].'&field=name&val='.stripslashes($t['name']).'\',\'n'.$t['id'].'\');">'.stripslashes($t['name']).'</span></span></td>
	   <td><span id="e'.$t['id'].'"><span onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=LoadField&id='.$t['id'].'&field=email&val='.stripslashes($t['email']).'\',\'e'.$t['id'].'\');">'.stripslashes($t['email']).'</span></span></td>
	   <td>'.date("d.m.Y H:i",$t['time']).'</td>
	   <td><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=DelSignedItem&id='.$t['id'].'\',\'ActionRes\');delelem(\'TR'.$t['id'].'\');"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" width="16" height="16" alt="Delete" /></a></td>
	   </tr>';
	$r -> MoveNext();
   }
   echo '</table>';
	echo $list_page;
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="LoadField"){
	parse_str($_REQUEST['q'],$data);
	if($data['field']=="email") $sid = "e";
	if($data['field']=="name") $sid = "n";
	echo '
	<input type="text" name="val'.$data['id'].'" id="val'.$data['id'].'" style="width:190px" value="'.stripslashes($data['val']).'" onblur="getdata(\'\',\'post\',\'?p='.$p.'&act=LoadVal&id='.$data['id'].'&field='.$data['field'].'&val=\'+this.value,\''.$sid.$data['id'].'\')" /><script type="text/javascript">jQuery(document).ready(function(){
jQuery(\'#val'.$data['id'].'\').focus();})</script>
	';
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="LoadVal"){
	parse_str($_REQUEST['q'],$data);
	if($data['field']=="email") $sid = "e";
	if($data['field']=="name") $sid = "n";
	$r = $db -> Execute("update ".$_conf['prefix']."news_signed set ".$data['field']."='".mysql_real_escape_string(stripslashes($data['val']))."' where id='".$data['id']."'");
	echo '
	<span onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=LoadField&id='.$data['id'].'&field='.$data['field'].'&val='.stripslashes($data['val']).'\',\''.$sid.$data['id'].'\')">'.stripslashes($data['val']).'</span>
	';
}

?>
