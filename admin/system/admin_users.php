<?php
/**
 * Управление пользователями сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.03
 */
if(!defined("SHIFTCMS")) exit;

//require('./include/lang/admin/'.$_SESSION['admin_lang'].'.php'); 

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['au_title']."</a></h2>");
$smarty -> assign("modSet", "users");

echo "<img src='".$_conf['admin_tpl_dir']."img/worker_icon.gif' alt='".$alang_ar['au_loghistory']."' width='16' height='16' /> &nbsp; <a title='".$alang_ar['au_adduser']."' href='javascript:void(null)' onClick=\"divwin=dhtmlwindow.open('UserEditBox', 'inline', '', '".$alang_ar['au_adduser']."', 'width=450px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=site_server&act=AddOrEditUser','UserEditBox_inner'); return false; \"><strong>".$alang_ar['au_adduser']."</strong></a><br><br>";

$ustate = array('checked'=>'проверенные','new'=>'новые'/*,'blocked'=>'заблокированные'*/);

/* сохранение данных пользователя */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "SaveUserInfo"){
	$res = CheckUserData();
	if($res == "OK") {
		SaveUserData();
		echo msg_box($alang_ar['au_saved']);
	}else{
		echo $res;
	}
	unset($_REQUEST['act']);
}


//=================УДАЛЕНИЕ АДМИНА ИЗ БД====================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delit"){
		DeleteUser($_REQUEST['idu']);
		echo msg_box($alang_ar['au_userdeleted']);
		unset($_REQUEST['act']);
}

/* ============= Переменные для поиска ================== */
isset($_REQUEST['s_login']) ? $s_login = $_REQUEST['s_login'] : $s_login = "";
isset($_REQUEST['s_email']) ? $s_email = $_REQUEST['s_email'] : $s_email = "";
isset($_REQUEST['s_group_code']) ? $s_group_code = $_REQUEST['s_group_code'] : $s_group_code = "";
isset($_REQUEST['s_idu']) ? $s_idu = $_REQUEST['s_idu'] : $s_idu = "";
isset($_REQUEST['s_fio']) ? $s_fio = $_REQUEST['s_fio'] : $s_fio = "";
isset($_REQUEST['s_state']) ? $s_state = $_REQUEST['s_state'] : $s_state = "";

	$state_list = create_select($ustate, $s_state, "s_state", " style='width:150px;' ");

	$r = $db -> Execute("select group_code,group_name from ".$_conf['prefix']."user_group WHERE group_priority<='".$_SESSION['GROUP_PRIORITY']."' AND group_code!='guest' order by group_code");
	$glist = array();
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$gc = $t['group_code'];
		$glist[$gc] = $t['group_name'];
		$r -> MoveNext();
	}
	$group_list = create_select($glist, $s_group_code, "s_group_code", " style='width:150px;' ");

/* ===== Форма поиска ============= */
echo "<div class='block'>
<form action='".$_SERVER['PHP_SELF']."?p=admin_users' method='post'>
<table border='0' cellspacing='5'>
<tr>
	<td>".$alang_ar['au_login'].":<br /><input type='text' name='s_login' value=\"".$s_login."\" size='15' /></td>
	<td>".$alang_ar['au_email'].":<br /><input type='text' name='s_email' value=\"".$s_email."\" size='15' /></td>
	<td>".$alang_ar['au_group'].":<br />".$group_list."</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>".$alang_ar['au_fio'].":<br /><input type='text' name='s_fio' value=\"".$s_fio."\" size='15' /></td>
	<td>IDU:<br /><input type='text' name='s_idu' value='".$s_idu."' size='15' /></td>
	<td>Состояние:<br />".$state_list."</td>
	<td valign='bottom'><input type='submit' value='".$alang_ar['au_search']."' /></td>
</tr>
</table>
</form>
</div>";
/* ================СПИСОК АДМИНОВ САЙТА=================== */
if(!isset($_REQUEST['act'])){
	$interval=50;
	if(isset($_REQUEST['start'])) $_SESSION['user_start'] = $_REQUEST['start'];
	
	if(!isset($_SESSION['user_start'])) $start=0;
	else $start = $_SESSION['user_start'];
	$add_par = "";
	$where = 0;
$q="SELECT SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."users 
	LEFT JOIN ".$_conf['prefix']."users_add USING (idu) 
	LEFT JOIN ".$_conf['prefix']."user_group USING (group_code) 
	WHERE (group_priority<='".$_SESSION['GROUP_PRIORITY']."' OR idu='".$_SESSION['USER_IDU']."')
";
if(trim($s_login)!=""){
	$q.=" AND login='".$s_login."' ";
	$add_par.="&s_login=".$s_login;
}
if(trim($s_email)!=""){
	$q.=" AND email='".$s_email."' ";
	$add_par.="&s_email=".$s_email;
}
if(trim($s_group_code)!=""){
	$q.=" AND group_code='".$s_group_code."' ";
	$add_par.="&s_group_code=".$s_group_code;
}
if(trim($s_state)!=""){
	$q.=" AND state='".$s_state."' ";
	$add_par.="&s_state=".$s_state;
}
if(trim($s_idu)!=""){
	$q.=" AND idu='".$s_idu."' ";
	$add_par.="&s_idu=".$s_idu;
}
if(trim($s_fio)!=""){
	$q.=" AND fio LIKE '%".$s_fio."%' ";
	$add_par.="&s_fio=".$s_fio;
}
$q1 = $q." LIMIT ".$start.", ".$interval;
$r = $db -> Execute($q);

$r1 = $db -> Execute("select found_rows()");
$t1 = $r1 -> GetRowAssoc(false);
$all = $t1['found_rows()'];

	$list_page=Paging($all,$interval,$start,"admin.php?p=admin_users&start=%start1%".$add_par,"");
	echo "<br />".$list_page;

echo "<strong>".sprintf($alang_ar['au_msg1'], $all)."</strong>";
echo "<table border='0' cellspacing='0' class='selrow' width='100%'>
<tr><th>IDU</th><th>&nbsp;</th><th>on-line</th><th>".$alang_ar['au_login']."</th><th>".$alang_ar['au_fio']."</th><th>".$alang_ar['au_group']."</th><th>".$alang_ar['au_email']."</th><th>ICQ</th><th>".$alang_ar['au_dreg']."</th><th>".$alang_ar['au_dlast']."</th><th>".$alang_ar['delete']."</th></tr>";
$i=1;
	while (!$r -> EOF) { 
		$tmp = $r -> GetRowAssoc();
	   if($tmp['STATE'] == "new"){
		   $rsu = $db -> Execute("update ".$_conf['prefix']."users set state='checked' where idu='".$tmp['IDU']."'");
	   }
		if(WorkerIsOnline($tmp['IDU'])==1) $online="<img src='".$_conf['admin_tpl_dir']."img/online.gif' width='16' height='16' alt='On-line' />";
		else $online="<img src='".$_conf['admin_tpl_dir']."img/offline.gif' width='16' height='16' alt='' />";
    echo "<tr>
            <td><b>".$tmp['IDU']."</b></td>
            <td><a title='".$alang_ar['au_loghistory']."' href='javascript:void(null)' onClick=\"divwin=dhtmlwindow.open('UserHistoryBox', 'inline', '', '".$alang_ar['au_loghistory']."', 'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=site_server&act=ShowUserHistory&idu=".$tmp['IDU']."','UserHistoryBox_inner'); return false; \"><img src='".$_conf['admin_tpl_dir']."img/clock.gif' alt='".$alang_ar['au_loghistory']."' width='16' height='16' /></a></td>
            <td align='center'>".$online."</td>
            <td><a title='".$alang_ar['au_uedit']."' href='#' onClick=\"divwin=dhtmlwindow.open('UserEditBox', 'inline', '', '".$alang_ar['au_uedit']."', 'width=450px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=site_server&act=AddOrEditUser&idu=".$tmp['IDU']."','UserEditBox_inner'); return false; \"><strong>".$tmp['LOGIN']."</strong></a></td>
			<td>".stripslashes($tmp['FIO'])."</td>
            <td>".$tmp['GROUP_CODE']."</td>
            <td><b>".$tmp['EMAIL']."</b> ".MailToUser($tmp['IDU'])."</td>
			<td>".$tmp['ICQ']." <img src='http://status.icq.com/online.gif?icq=".$tmp['ICQ']."&amp;img=27' /></td>
            <td><small>".date("d.m.Y H:i",$tmp['DREG'])."</small></td>
            <td><small>".date("d.m.Y H:i",$tmp['DACC'])."</small></td>
            <td><a href=\"admin.php?p=".$_REQUEST['p']."&idu=".$tmp['IDU']."&act=delit\" onclick=\"if(!confirm('".$alang_ar['au_msg2']."')||!confirm('".$alang_ar['au_msg3']."')) return false\"><img src='".$_conf['admin_tpl_dir']."img/delit.png' /></a></td>
            </tr>";
		$r -> MoveNext(); 
		$i++;
	}
echo "</table>";
	echo "<br />".$list_page;

}
?>
