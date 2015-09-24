<?php
/**
 * Управление группами пользователей на сайте
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01.01
 * 05.05.2010 - добавлена возможность создавать новую группу на основании существующей - копировать настройки
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2>".$alang_ar['ag_title']."</h2>");

//==============РЕДАКТИРОВАНИЕ ИНФОРМАЦИИ О СТРАНИЦЕ============================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit"){
	$rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."user_group WHERE group_id='".$_REQUEST['group_id']."'");
	if($rs->RecordCount()!=0){
		$tmp=$rs->GetRowAssoc();
		if($tmp['GROUP_ACCESS']=="y") $ga = "checked='checked'";
		else $ga = '';
		echo "<div class='block'>
		<table border='0' cellspacing='1'>
       <tr>
		<td>
		<h3>".$alang_ar['edit']."</h3>
		<form action='' method='post'>
		<table border='0'>
	<tr><td>".$alang_ar['ag_code'].":</td><td><input type='text' name='group_code' id='group_code' value='".$tmp['GROUP_CODE']."' size='50' readonly='readonly' /></td></tr>
	<tr><td>".$alang_ar['ag_name'].":</td><td><input type='text' name='group_name' value='".$tmp['GROUP_NAME']."' size='50' /></td></tr>
	<tr><td>".$alang_ar['ag_priority'].":</td><td><input type='text' name='group_priority' id='group_priority' value='".$tmp['GROUP_PRIORITY']."' size='10' /></td></tr>
	<tr><td>&nbsp;</td><td><input type='checkbox' name='group_access' value='y' $ga /> ".$alang_ar['ag_access']."</td></tr> 
	<tr><td>&nbsp;</td><td>
		<input type='hidden' name='act' value='save' /><input type='hidden' name='p' value='$p' />
		<input type='hidden' name='group_id' value='".$_REQUEST['group_id']."' />
		<input type='submit' value='".$alang_ar['edit']."' /></td></tr>
		</table>
		</form>
		</td>
		</tr>
		</table></div>";
	}
 unset($_REQUEST['act']);
}
//================ОБНОВЛЕНИ ИНФОРМАЦИИ О СТРАНИЦЕ=====================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save"){
		if(isset($_REQUEST['group_access'])) $ga = $_REQUEST['group_access'];
		else $ga = 'n';
	$q="UPDATE `".$_conf['prefix']."user_group` SET
	`group_name`='".$_REQUEST['group_name']."',	`group_access`='".$ga."', `group_priority`='".mysql_real_escape_string(stripslashes($_REQUEST['group_priority']))."' WHERE `group_id`='".$_REQUEST['group_id']."'";
	$ms = $db->Execute($q);
	add_to_log($q,"fortrans");
	echo msg_box($alang_ar['saved']);
	unset($_REQUEST['act']);
}
//================ДОБАВЛЕНИЕ НОВОЙ ГРУППЫ==========================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="add"){
	$er = 0;
	if(trim($_REQUEST['group_code'])==""){
		echo msg_box($alang_ar['ag_er1']); $er = 1;
	}
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_group WHERE group_code='".mysql_real_escape_string(stripslashes($_REQUEST['group_code']))."'");
	if($r -> RecordCount() > 0){
		echo msg_box($alang_ar['ag_er2']); $er = 1;
	}
	if($er == 0){
		if(isset($_REQUEST['group_access'])) $ga = $_REQUEST['group_access'];
		else $ga = 'n';
		$q="INSERT INTO ".$_conf['prefix']."user_group(group_id,group_code,group_name,group_access,group_priority) VALUES
		('','".$_REQUEST['group_code']."','".$_REQUEST['group_name']."','".$ga."','".mysql_real_escape_string(stripslashes($_REQUEST['group_priority']))."')";
		$ms = $db->Execute($q);
			if($_REQUEST['ex_group_code']!="0") CopyGroupSettings($_REQUEST['ex_group_code'], $_REQUEST['group_code']);
		echo msg_box($alang_ar['ag_created']);
	}
	unset($_REQUEST['act']);
}
//===============УДАЛЕНИЕ СТРАНИЦЫ================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delete"){
	$q = "update ".$_conf['prefix']."users set group_code='guest' where group_code='".$_REQUEST['group_code']."'";
	$r = $db -> Execute($q);
	$gr = $_REQUEST['group_code'];
	$q = "update ".$_conf['prefix']."page set pgroups=REPLACE(pgroups,',".$gr."',''), pgroups=REPLACE(pgroups,'".$gr.",','')";
	$r = $db -> Execute($q);
	$q = "update ".$_conf['prefix']."admin_menu set punkt_groups=REPLACE(punkt_groups,',".$gr."',''), punkt_groups=REPLACE(punkt_groups,'".$gr.",','')";
	$r = $db -> Execute($q);
		$q="DELETE FROM ".$_conf['prefix']."user_group WHERE group_id='".$_REQUEST['group_id']."'";
		$ms = $db->Execute($q);
	add_to_log($q,"fortrans");
	echo msg_box($alang_ar['ag_deleted']);
	unset($_REQUEST['act']);
}
//--------------ВЫВОД СПИСКА СТРАНИЦ И ФОРМЫ ДОБАВЛЕНИЯ СТРАНИЦЫ-----------
if(!isset($_REQUEST['act'])){

$group_list = '<select name="ex_group_code" id="ex_group_code" style="width:200px;"><option value="0">'.$alang_ar['ag_blank'].'</option>';
$r = $db->Execute("SELECT * FROM ".$_conf['prefix']."user_group ORDER BY group_code");
while (!$r->EOF) { 
	$t = $r -> GetRowAssoc(false);
	$group_list .= '<option value="'.$t['group_code'].'">'.stripslashes($t['group_name']).'</option>';
	$r -> MoveNext();
}
$group_list .= '</select>';

	echo "<div class='block'>
	<form action='admin.php' method='post'><table border='0' cellspacing='0'>
	<tr><td colspan='2'><h3>".$alang_ar['ag_add']."</h3></td></tr>
	<tr><td><strong>".$alang_ar['ag_code'].":</strong></td>
	<td><input type='text' name='group_code' value='' size='50' /> </td></tr>
	<tr><td><strong>".$alang_ar['ag_name'].":</strong></td><td><input type='text' name='group_name' value='' size='50' /></td></tr>
	<tr><td><strong>".$alang_ar['ag_priority'].":</strong></td><td><input type='text' name='group_priority' id='group_priority' value='' size='10' /></td></tr>
	<tr><td>&nbsp;</td><td><input type='checkbox' name='group_access' value='y' /> ".$alang_ar['ag_access']."</td> </tr>
	<tr><td><strong>".$alang_ar['ag_example'].":</strong></td><td>".$group_list."</td></tr>
	<tr><td colspan='2'><input type='hidden' name='act' value='add' /><input type='hidden' name='p' value='".$p."' />
	<input type='submit' value='".$alang_ar['save']."' /></td></tr>
	</table></form>
	</div>";
	echo "<table border='0' width='100%' cellspacing='0' class='selrow'>";
	echo "<tr bgcolor='#eeeeee'>
	<th>".$alang_ar['ag_group']."</th>
	<th>".$alang_ar['ag_users']."</th>
	<th>".$alang_ar['ag_name']."</th>
	<th>".$alang_ar['ag_priority']."</th>
	<th>".$alang_ar['ag_menu']."</th>
	<th>".$alang_ar['ag_access1']."</th>
	<th>&nbsp;</th>
	</tr>";

$ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."user_group ORDER BY group_code");
while (!$ms->EOF) { 
	$tmp=$ms->GetRowAssoc();
	$r = $db -> CacheExecute("select count(idu) from ".$_conf['prefix']."users where group_code='".$tmp['GROUP_CODE']."'");
	$t = $r -> GetRowAssoc();
	if($tmp['GROUP_ACCESS']=="y"){
		$ga = $alang_ar['ag_access'];
		$set_menu="<a title='".$alang_ar['ag_setmenu']."' href='#' onClick=\"divwin=dhtmlwindow.open('MenuBox', 'inline', '', '".$alang_ar['ag_setmenu']."', 'width=450px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=admin_server&act=SetMenuForm&group_id=".$tmp['GROUP_ID']."&group_code=".$tmp['GROUP_CODE']."','MenuBox_inner'); return false; \">".$alang_ar['ag_setmenu']."</a>";
	}else{
		$ga = "";
		$set_menu="";
	}
	echo "<tr>
	<td><a href='admin.php?p=".$p."&act=edit&group_id=".$tmp['GROUP_ID']."'><strong>".$tmp['GROUP_CODE']."</strong></a></td>
	<td><a href='".$_SERVER['PHP_SELF']."?p=admin_users&s_group_code=".$tmp['GROUP_CODE']."'>".$t['COUNT(IDU)']."</a></td>
	<td>".$tmp['GROUP_NAME']."</td>
	<td>".$tmp['GROUP_PRIORITY']."</td>
	<td>".$set_menu."</td>
	<td><a title='".$alang_ar['ag_setaccess']."' href='#' onClick=\"divwin=dhtmlwindow.open('AccessBox', 'inline', '', '".$alang_ar['ag_setaccess']."', 'width=600px,height=500px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=admin_server&act=SetAccessForm&group_id=".$tmp['GROUP_ID']."&group_code=".$tmp['GROUP_CODE']."','AccessBox_inner'); return false; \">".$alang_ar['ag_setaccess']."</a></td>
	<td>";
	if($tmp['GROUP_SYS']!='y') echo "<a href='".$_SERVER['PHP_SELF']."?p=".$p."&act=delete&group_id=".$tmp['GROUP_ID']."&group_code=".$tmp['GROUP_CODE']."' onclick=\"if(!confirm('".$alang_ar['ag_del1']."')||!confirm('".$alang_ar['ag_del2']."')) return false\">".$alang_ar['delete']."</a>";
	else echo "";
	echo "</td>
	</tr>";
	$ms->MoveNext(); 
}
echo "</table>";
}

?>
