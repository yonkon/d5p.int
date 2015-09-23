<?php
$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=admin_guestbook'>Гостевая книга</a></h2>");
$smarty -> assign("modSet", "guestbook");

if(isset($_REQUEST['act']) && $_REQUEST['act'] == "delete"){
		$r = $db -> Execute("DELETE FROM ".$_conf['prefix']."guestbook WHERE g_id='$_REQUEST[g_id]'");
		echo msg_box("Сообщение удалено из гостевой книги!");
		unset($_REQUEST['act']);
}


if(isset($_REQUEST['act']) && $_REQUEST['act'] == "ChangeShow"){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."guestbook WHERE g_id='$_REQUEST[g_id]'");
		$t = $r -> GetRowAssoc(false);
		if($t['g_show'] == "y"){
			$r = $db -> Execute("UPDATE ".$_conf['prefix']."guestbook SET g_show='n' WHERE g_id='$_REQUEST[g_id]'");
			$s_link = "<font color='red'>Показ отключен</font>";
		}else{
			$r = $db -> Execute("UPDATE ".$_conf['prefix']."guestbook SET g_show='y' WHERE g_id='$_REQUEST[g_id]'");
			$s_link = "<font color='green'>Показывается</font>";
		}
		echo "<span id='G_".$_REQUEST['g_id']."'><a href='javascript:void(null)' onclick=\"getdata('','get','?p=$p&act=ChangeShow&g_id=".$t['g_id']."','G_".$_REQUEST['g_id']."')\">$s_link</a></span> ";
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="update"){
	if(trim($_REQUEST['g_who'])=="" || trim($_REQUEST['g_text'])==""){
		echo msg_box("Пожалуйста, заполните объязательные поля, отмеченные звездочкой!");
		$_REQUEST['act'] = "edit";
	}else{
		$r = $db -> Execute("UPDATE ".$_conf['prefix']."guestbook SET
		g_who = '".mysql_real_escape_string($_REQUEST['g_who'])."',
		g_email = '".mysql_real_escape_string($_REQUEST['g_email'])."',
		g_text = '".mysql_real_escape_string($_REQUEST['g_text'])."'
		WHERE g_id='$_REQUEST[g_id]'");
		echo msg_box($alang_ar['saved']);
		unset($_REQUEST['act']);
	}
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="edit"){
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."guestbook where g_id='$_REQUEST[g_id]'");
	$t = $r -> GetRowAssoc(false);
	echo '
		<form action="admin.php?p='.$p.'&act=update" method="post" enctype="multipart/form-data" id="GuestbookForm">
		<table border="0">
		<tr><td align="right">&nbsp;</td><td>
		<h3>Редактировать отзыв</h3><br /></td></tr>
		<tr><td align="right">Дата:</td><td>
		'.date("d.m.Y H:i",$t['g_date']).'</td></tr>
		<tr><td align="right"><label for="g_who">Имя<span>*</span></label></td><td>
		<input type="text" name="g_who" id="g_who" value="'.htmlspecialchars(stripslashes($t['g_who'])).'" size="30" /></td></tr>
		<tr><td align="right"><label for="g_email">E-mail</label></td><td>
		<input type="text" name="g_email" id="g_email" value="'.htmlspecialchars(stripslashes($t['g_email'])).'" size="50" /></td></tr>
		<tr><td align="right"><label for="g_text">Текст сообщения<span>*</span></label></td><td>
		<textarea name="g_text" id="g_text" style="width:500px; height:200px;">'.htmlspecialchars(stripslashes($t['g_text'])).'</textarea></td></tr>
		<tr><td>&nbsp;</td><td>
		<input type="hidden" name="g_id" id="g_id" value="'.$_REQUEST['g_id'].'" />
		<input type="submit" id="SendRecord" value="'.$alang_ar['save'].'" class="gbut" /></td></tr>
		</table>
		</form>
	';
}


if(!isset($_REQUEST['act'])){
$interval=20;
if(!isset($_REQUEST['start'])) $start=0;
else $start=$_REQUEST['start'];
   $qn1="SELECT count(*) FROM ".$_conf['prefix']."guestbook";
   $qn="SELECT * FROM ".$_conf['prefix']."guestbook ORDER BY g_date DESC LIMIT $start,$interval";

	$ms1 = $db->Execute($qn1);
	$r1 = $ms1 -> GetRowAssoc(false);
	$all = $r1['count(*)'];

	$ms = $db->Execute($qn);

	$lp = GetPaging($all,$interval,$start,"admin.php?p=admin_guestbook&start=%start1%");
		$smarty -> assign("paging",$lp);
		$listpage = $smarty -> fetch("db:paging.tpl");

	echo "<p>".$listpage."</p>";
	echo "<table border='0' cellspacing='0' class='selrow'>";
	echo "<tr><th>&nbsp;</th><th>Дата</th><th>Автор</th><th>E-mail</th><th>Текст</th><th>Включить/выключить</th><th>Удалить</th></tr>";
	while (!$ms->EOF) { 
		$tmpm=$ms->GetRowAssoc(false);
		if($tmpm['g_state'] == "new") $r = $db -> Execute("UPDATE ".$_conf['prefix']."guestbook SET g_state='read' WHERE g_id='$tmpm[g_id]'");
		$show = $tmpm['g_show']=="y" ? "<font color='green'>Показывается</font>" : "<font color='red'>Показ отключен</font>";
		echo "<tr>
		<td align='center'><a href='admin.php?p=".$p."&act=edit&g_id=".$tmpm['g_id']."'><img src='".$_conf['admin_tpl_dir']."img/edit.png' width='16' height='16' border='0' alt='Редактировать информацию' /></a></td>
		<td>".date("d.m.Y H:i", $tmpm['g_date'])."</td>
		<td>".htmlspecialchars(stripslashes($tmpm['g_who']))."</td>
		<td>".htmlspecialchars(stripslashes($tmpm['g_email']))."</td>
		<td>".nl2br(htmlspecialchars(stripslashes($tmpm['g_text'])))."</td>
		<td><span id='G_".$tmpm['g_id']."'>
		<a href='javascript:void(null)' onclick=\"getdata('','get','?p=$p&act=ChangeShow&g_id=".$tmpm['g_id']."', 'G_".$tmpm['g_id']."')\">$show</a>
		</span></td>
	<td><a href='admin.php?p=".$p."&act=delete&g_id=".$tmpm['g_id']."&start=".$start."' onclick=\"if(!confirm('Удалить сообщение? Вы уверены?')) return false\"><img src='".$_conf['admin_tpl_dir']."img/delit.png' width='16' height='16' alt='Удалить' border='0' /></a></td>
		</tr>";
		$ms->MoveNext(); 
	}
	echo "</table>";
	echo "<p>".$listpage."</p>";
}

?>