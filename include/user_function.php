<?php
/**
 * Набор функций для работы с записями пользователей системы
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.02
 */
if(!defined("SHIFTCMS")) exit;

/* формирует ссылку на вывод информации о пользователе */
function MakeUserInfoLink($idu,$text){
	global $_conf, $alang_ar;
	$link = "<a title='Статистика пользователя' href='#' onClick=\"divwin=dhtmlwindow.open('UserStatBox', 'inline', '', 'Статистика пользователя', 'width=400px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=site_server&act=OutUserStat&idu=$idu','UserStatBox_inner'); return false; \">$text</a>";
	return $link;
}


/* формирует ссылку для вывода формы написания письма */
function MailToUser($idu){
	global $_conf;
	$link = "<a title='Написать письмо' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('WriteFormBox', 'inline', '', 'Написать письмо', 'width=800px,height=500px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=outlook&type=new&mailact=WriteForm&toidu=".$idu."','WriteFormBox_inner'); return false; \"><img src='$_conf[admin_tpl_dir]img/mail_icon1.gif' width='16' height='16' alt='Написать письмо' style='vertical-align:middle;' /></a>";
	return $link;
}

/* форма добавления/редактирования пользователя */
function EditUserForm($idu = null){
	global $db, $_conf, $alang_ar;
	$out = '';
	if($idu == null){
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."users LEFT JOIN ".$_conf['prefix']."users_add USING(idu) LIMIT 1");
		$ui = $r -> GetRowAssoc();//GetUserName(1);
		while(list($key,$val)=each($ui)) $ui[$key] = '';
		$login_field = "";
		$acttype = "insert";
	}else{
		$ui = GetUserName($idu);
		$login_field = "readonly='readonly' style='background:#cccccc;'";
		$acttype = "update";
		if($_SESSION['GROUP_PRIORITY']<$ui['GROUP_PRIORITY'] && $_SESSION['USER_IDU']!=$idu){
			exit;
		}
	}

	$r = $db -> Execute("select group_code, group_name from ".$_conf['prefix']."user_group where group_priority<='".$_SESSION['GROUP_PRIORITY']."' AND group_code!='guest' order by group_code");
	$glist = array();
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$gc = $t['group_code'];
		$glist[$gc] = $t['group_name'];
		$r -> MoveNext();
	}
	if(isset($_REQUEST['type']) && $_REQUEST['type']=="own"){
		$rfr = "readonly='readonly' style='background:#cccccc;'";
		$group_list = GetGroupName($ui['GROUP_CODE'])."<input type='hidden' name='group_code' value='$ui[GROUP_CODE]' />";
	}else{
		$rfr = "";
		$group_list = create_select($glist, $ui['GROUP_CODE'], "group_code", "style='width:270px;'");
	}
		$ui['ALLOWED_IP'] = trim(str_replace("&nbsp;","",$ui['ALLOWED_IP']));
	if(isset($_REQUEST['ret'])) $pp = "user_info";
	else $pp = "admin_users";
	
	$ns = $ui['NEWSSIGN']==0 ? ' checked="checked" ' : '';

    $out.="<div id='UserFormArea'>
	<form action='javascript:void(null)' id='EditUserFormArea' method='post' enctype='multipart/form-data'>
	<!--<form action='admin.php?p=$pp' id='EditUserFormArea' method='post' enctype='multipart/form-data'>-->
	<h3>Редактирование данных пользователя $ui[LOGIN]</h3><br />
            <input type='hidden' name='p' value='site_server' />
            <input type='hidden' name='idu' value='$ui[IDU]' />
            <input type='hidden' name='act' value='SaveUserInfo' />
            <input type='hidden' name='acttype' value='$acttype' />
	<table border='0' class='selrow' cellspacing='0'>
	<tr><td>Логин:</td><td><input type='text' name='login' value='$ui[LOGIN]' size='15' $login_field /></td></tr>
	<tr><td>E-mail:</td><td><input type='text' name='email' value='$ui[EMAIL]' size='45' /></td></tr>
	<tr><td>Пароль:</td><td><input type='text' name='password' value='$ui[PASSWORD]' size='15' /></td></tr>
	<tr><td>Группа:</td><td>$group_list</td></tr>
	<tr><td>ФИО:</td><td><input type='text' name='fio' value='$ui[FIO]' size='50' /></td></tr>
	<tr><td>Город:</td><td><input type='text' name='city' value='$ui[CITY]' size='25' /></td></tr>
	<tr><td>Адрес:</td><td><textarea name='contact' style='width:300px;height:50px;'>$ui[CONTACT]</textarea></td></tr>
	<tr><td>ICQ:</td><td><input type='text' name='icq' value='$ui[ICQ]' size='15' /></td></tr>
	<tr><td>Телефон:</td><td><input type='text' name='phone' value='$ui[PHONE]' size='15' /></td></tr>
	<tr><td>Мобильный:</td><td><input type='text' name='mphone' value='$ui[MPHONE]' size='15' /></td></tr>
</td></tr>
	<tr><td>Подписаться на новости сайта:</td><td><input type='checkbox' name='newssign' id='newssign' value='0'".$ns." /></td></tr>
</td></tr>
	<tr><td>Разрешить вход с IP:</td><td><input type='text' name='allowed_ip' id='allowed_ip' value='$ui[ALLOWED_IP]' size='45' maxlenght='150' /><br /><small>Можно воодить несколько IP разделенных запьятой.<br />Напр.: 194.44.198.33,194.44.196.*</small></td></tr>
</td></tr>
	<tr><td colspan='2' align='center'>
	<input type='submit' value='Сохранить' onclick=\"doLoad('EditUserFormArea','EditUserRes')\" />
	<!--<input type='submit' value='Сохранить' />-->
	</td></tr>
	</table>
    </form></div>
	<div id='EditUserRes'></div>";
	return $out;
}

/* Проверка данных пользователя на правльность ввода */
function CheckUserData(){
	global $db, $_conf, $smarty, $alang_ar;
	$error = "";
	if(trim($_REQUEST['email']) == ""){
		$smarty->assign("info_message","Ошибка! Укажите электронный адрес пользователя!");
		$error.= $smarty->fetch("db:messeg.tpl");
	}
	if(trim($_REQUEST['login']) == ""){
		$smarty->assign("info_message","Ошибка! Укажите логин пользователя!");
		$error.= $smarty->fetch("db:messeg.tpl");
	}
	if(trim($_REQUEST['password']) == ""){
		$smarty->assign("info_message","Ошибка! Укажите пароль пользователя!");
		$error.= $smarty->fetch("db:messeg.tpl");
	}
	if(trim($_REQUEST['group_code']) == "" || trim($_REQUEST['group_code']) == "0"){
		$smarty->assign("info_message","Ошибка! Укажите группу пользователя!");
		$error.= $smarty->fetch("db:messeg.tpl");
	}
	if($_REQUEST['acttype'] == "insert") $r = $db -> Execute("select * from ".$_conf['prefix']."users where login='$_REQUEST[login]'");
	if($_REQUEST['acttype'] == "update") $r = $db -> Execute("select * from ".$_conf['prefix']."users where login='$_REQUEST[login]' and idu != '$_REQUEST[idu]'");
	if($r -> RecordCount() > 0){
		$smarty->assign("info_message","Ошибка! Указанный логин пользователя уже существует в базе данных!");
		$error.= $smarty->fetch("db:messeg.tpl");
	}
	if($error == "") return "OK";
	else return $error;
}

/* сохранение пользователя */
function SaveUserData(){
	global $db, $_conf, $smarty, $alang_ar;
	$_REQUEST['allowed_ip'] = str_replace("&nbsp;","",$_REQUEST['allowed_ip']);
	$ns = isset($_REQUEST['newssign']) ? 0 : 1;
	if($_REQUEST['acttype'] == "insert"){
		$q = "insert into ".$_conf['prefix']."users set
		`email`='".mysql_real_escape_string(stripslashes($_REQUEST['email']))."', 
		`login`='".mysql_real_escape_string(stripslashes($_REQUEST['login']))."', 
		`password`='".mysql_real_escape_string(stripslashes($_REQUEST['password']))."',
		`dreg`='".time()."', 
		`dacc`='".time()."',
		`group_code`='".mysql_real_escape_string(stripslashes($_REQUEST['group_code']))."', 
		`allowed_ip`='".mysql_real_escape_string(stripslashes($_REQUEST['allowed_ip']))."',
		`newssign`='".$ns."',
		`state`='checked'
		";
		$r = $db -> Execute($q);
		$idu = $db -> Insert_ID();
		$q1 = "insert into ".$_conf['prefix']."users_add set
		`idu`=".$idu.",
		`fio`='".mysql_real_escape_string(stripslashes($_REQUEST['fio']))."', 
		`contact`='".mysql_real_escape_string(stripslashes($_REQUEST['contact']))."', 
		`city`='".mysql_real_escape_string(stripslashes($_REQUEST['city']))."',
		`icq`='".mysql_real_escape_string(stripslashes($_REQUEST['icq']))."', 
		`phone`='".mysql_real_escape_string(stripslashes($_REQUEST['phone']))."', 
		`mphone`='".mysql_real_escape_string(stripslashes($_REQUEST['mphone']))."'
		";
		$r = $db -> Execute($q1);
		//MakeDefUserSet($idu);
		return $idu;
	}
	if($_REQUEST['acttype'] == "update"){
		$q = "update `".$_conf['prefix']."users` set 
		`email`='".mysql_real_escape_string(stripslashes($_REQUEST['email']))."', 
		`password`='".mysql_real_escape_string(stripslashes($_REQUEST['password']))."',
		`group_code`='".mysql_real_escape_string(stripslashes($_REQUEST['group_code']))."', 
		`allowed_ip`='".mysql_real_escape_string(stripslashes($_REQUEST['allowed_ip']))."',
		`newssign`='".$ns."'
		where `idu`='".mysql_real_escape_string(stripslashes($_REQUEST['idu']))."'";
		$r = $db -> Execute($q);
		$q1 = "update `".$_conf['prefix']."users_add` set 
		`fio`='".mysql_real_escape_string(stripslashes($_REQUEST['fio']))."', 
		`contact`='".mysql_real_escape_string(stripslashes($_REQUEST['contact']))."', 
		`city`='".mysql_real_escape_string(stripslashes($_REQUEST['city']))."',
		`icq`='".mysql_real_escape_string(stripslashes($_REQUEST['icq']))."', 
		`phone`='".mysql_real_escape_string(stripslashes($_REQUEST['phone']))."', 
		`mphone`='".mysql_real_escape_string(stripslashes($_REQUEST['mphone']))."'
		where idu='".mysql_real_escape_string(stripslashes($_REQUEST['idu']))."'";
		$r = $db -> Execute($q1);
	}
}
function prepareLogin($login){
	global $_conf, $db;
		$r = $db -> Execute("select login from ".$_conf['prefix']."users where login='".mysql_real_escape_string($login)."'");
		$i = 1;
	while($r->RecordCount()!=0){
		$login = $login.$i;
		$r = $db -> Execute("select login from ".$_conf['prefix']."users where login='".mysql_real_escape_string($login)."'");
		$i++;
	}
	return $login;
}

/* удаление пользователя */
function DeleteUser($idu){
	global $db, $_conf, $smarty;
	$r = $db -> Execute("delete from ".$_conf['prefix']."users_add where idu='$idu'");
	$r = $db -> Execute("delete from ".$_conf['prefix']."enterlog where idu='$idu'");
	$r = $db -> Execute("delete from ".$_conf['prefix']."users where idu='$idu'");
}

/* получить имя группы по ее коду */
function GetGroupName($gc){
	global $db, $_conf;
	$r = $db -> Execute("select * from ".$_conf['prefix']."user_group where group_code='$gc'");
	$t = $r -> GetRowAssoc();
	return $t['GROUP_NAME'];

}


/* аутентификация пользователей, которые при входе указали "Запомнить" и истек срок сессии */
function authenticate($idu){	
	global $db, $_conf, $alang_ar;
if(isset($_COOKIE['AUTHPERIOD']) && $_COOKIE['AUTHPERIOD']=="yes" && !isset($_SESSION['USER_IDU']) && isset($_COOKIE['USER_IDU']) && $_COOKIE['USER_D']==$_SERVER['HTTP_HOST']){
	//echo "authenticate";
    $q = "SELECT * FROM `".$_conf['prefix']."users` WHERE `idu`='".$idu."'";
	$res = $db -> Execute($q);
    $all= $res -> RecordCount();
    if($all!=0){
	$tmp = $res -> GetRowAssoc();
		$strong = md5($tmp['PASSWORD']."-".$tmp['LOGIN']."-".$tmp['IDU']);
		if($strong != $_COOKIE['strong']) { header("location:logout.php"); exit; }
		$rg = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_group WHERE group_code='".$tmp['GROUP_CODE']."'");
		$tg = $rg -> GetRowAssoc();
      $_SESSION['strong'] = $strong;
      $_SESSION['USER_IDU'] = $tmp['IDU'];
      $_SESSION['USER_D'] = $_SERVER['HTTP_HOST'];
      $_SESSION['USER_LOGIN'] = $tmp['LOGIN'];
      $_SESSION['USER_EMAIL'] = $tmp['EMAIL'];
      $_SESSION['USER_GROUP'] = $tmp['GROUP_CODE'];
      $_SESSION['GROUP_ACCESS'] = $tg['GROUP_ACCESS'];
      $_SESSION['GROUP_PRIORITY'] = $tg['GROUP_PRIORITY'];
      $_SESSION['USER_LAST_ACCES'] = $tmp['DACC'];
	  $tm = time();
     $_SESSION['TIME_ACC'] = $tm;
     $_SESSION['conf'] = $_conf;
      $rs = $db->Execute("UPDATE `".$_conf['prefix']."users` SET `dacc`='".time()."',`ip`='".$_SERVER['REMOTE_ADDR']."', `time_acc`='".$tm."',`ip_acc`='".$_SERVER['REMOTE_ADDR']."' WHERE `idu`='".$tmp['IDU']."'");
      $rs = $db->Execute("INSERT INTO `".$_conf['prefix']."enterlog` (`id`,`idu`,`action`,`date`,`ip`) VALUES ('', 
	  '".$tmp['IDU']."', 'Автоматическое продолжение сессии', '".time()."', '".$_SERVER['REMOTE_ADDR']."')");
  }else{
  	header("location:logout.php");
	exit;
  }
}
  return true;
}

/* аутентификация пользователей, которые при входе указали "Запомнить" и истек срок сессии */
function authorize($idu){	
	global $db, $_conf, $alang_ar;
    $q="SELECT * FROM ".$_conf['prefix']."users WHERE idu='$idu'";
	$res = $db -> CacheExecute($q);
    $all= $res -> RecordCount();
    if($all!=0){
		$tmp = $res -> GetRowAssoc();
		$stime=time()+3600*24*365;
		$strong = md5($tmp['PASSWORD']."-".$tmp['LOGIN']."-".$tmp['IDU']);
		$rg = $db -> CacheExecute("SELECT * FROM ".$_conf['prefix']."user_group WHERE group_code='$tmp[GROUP_CODE]'");
		$tg = $rg -> GetRowAssoc();
      $_SESSION['USER_IDU']=$tmp['IDU'];
      $_SESSION['USER_D'] = $_SERVER['HTTP_HOST'];
      $_SESSION['USER_LOGIN']=$tmp['LOGIN'];
      $_SESSION['USER_EMAIL']=$tmp['EMAIL'];
      $_SESSION['USER_GROUP']=$tmp['GROUP_CODE'];
      $_SESSION['USER_LAST_ACCES']=$tmp['DACC'];
	  $_SESSION['GROUP_ACCESS']=$tg['GROUP_ACCESS'];
      setcookie("AUTHPERIOD","yes",$stime);
      setcookie("strong",$strong,$stime);
      setcookie("USER_IDU",$tmp['IDU'],$stime);
      setcookie("USER_D",$_SERVER['HTTP_HOST'],$stime);
	  $tm=time();
     $_SESSION['TIME_ACC']=$tm;
     $_SESSION['conf']=$_conf;
      $rs = $db->Execute("UPDATE `".$_conf['prefix']."users` SET `dacc`='".time()."',`ip`='$_SERVER[REMOTE_ADDR]', `time_acc`='".$tm."',`ip_acc`='$_SERVER[REMOTE_ADDR]' WHERE `idu`='$tmp[IDU]'");
      $rs = $db->Execute("INSERT INTO `".$_conf['prefix']."enterlog` (id,idu,action,date,ip) VALUES ('', 
	  '$tmp[IDU]', 'Автоматическое продолжение сессии', '".time()."', '$_SERVER[REMOTE_ADDR]')");
  }else{
  	header("location:logout.php");
	exit;
  }
  return true;
}

function flyMenu(){
	global $_conf, $db;
	$out = '';
	$q = "SELECT mid, punkt_parent, punkt_order, punkt_link, punkt_ico,
	punkt_name_".$_SESSION['admin_lang']." as punkt_name
	FROM ".$_conf['prefix']."admin_menu
	WHERE FIND_IN_SET('".$_SESSION['USER_GROUP']."', punkt_groups)
	ORDER BY punkt_parent, punkt_order";
	$r = $db -> Execute($q);
	$ar = $r -> GetArray();
	//echo '<pre>';
	//print_r($ar);
	//echo '</pre>';
	$menu = getFlyMenu($ar, 0, 0);
	$out = buildFlyMenu($menu);
	//echo '<pre>';
	//print_r($menu);
	//echo '</pre>';

	return $out;
}
function buildFlyMenu($menu){
	global $_conf;
	reset($menu); $out = '';
	while(list($k,$v)=each($menu)){
		$ico = $_conf['admin_tpl_dir'].'img/menu/'.stripslashes($v['punkt_ico']);
		if(file_exists($ico)&&!is_dir($ico)) $ico_img = ' &nbsp; <img src="'.$ico.'" />';
		else $ico_img = '';
		if($v['level']==0){
			$out .= '<li class="top"><a href="'.$v['punkt_link'].'" ';
			if($v['submenu']!='') $out .= 'id="M'.$v['mid'].'" ';
			$out .= 'class="top_link"><span class="down">'.$ico_img.' '.$v['punkt_name'].'</span></a>';
			if($v['submenu']!='') $out .= '<ul class="sub">'.buildFlyMenu($v['submenu']).'</ul>';
			$out .= '</li>';
		}elseif($v['level']==1){
			if($v['submenu']!=''){
				$out .= '<li><a href="'.$v['punkt_link'].'" class="fly"><span class="ico">'.$ico_img.'</span>'.$v['punkt_name'].'</a>';
				$out .= '<ul>'.buildFlyMenu($v['submenu']).'</ul>';
			}else{
				$out .= '<li><a href="'.$v['punkt_link'].'"><span class="ico">'.$ico_img.'</span>'.$v['punkt_name'].'</a>';
			}
			$out .= '</li>';
		}else{
			if($v['submenu']!=''){
				$out .= '<li><a href="'.$v['punkt_link'].'" class="fly"><span class="ico">'.$ico_img.'</span>'.$v['punkt_name'].'</a>';
				$out .= '<ul>'.buildFlyMenu($v['submenu']).'</ul>';
			}else{
				$out .= '<li><a href="'.$v['punkt_link'].'"><span class="ico">'.$ico_img.'</span>'.$v['punkt_name'].'</a>';
			}
			$out .= '</li>';
		}
	}
	return $out;
}

function getFlyMenu($ar, $parent, $level){
	reset($ar); $menu = array();
	while(list($k,$v)=each($ar)){
		if($v['punkt_parent']==$parent){
			$menu[$v['mid']] = array(
				'mid'=>$v['mid'],
				'level'=>$level,
				'punkt_order'=>$v['punkt_order'],	
				'punkt_link'=>stripslashes($v['punkt_link']),
				'punkt_ico'=>stripslashes($v['punkt_ico']),
				'punkt_name'=>stripslashes($v['punkt_name']),
				'submenu'=>getFlyMenu($ar, $v['mid'], $level+1)
			);
			unset($ar[$k]);
		}
	}
	if(count($menu)>0) return $menu;
	else return '';
}
/* create menu function */
function initializeMenu() {
	global $db, $_conf;
  $q = "SELECT distinct t1.*, if(t2.mid IS NOT NULL, 1, 0) hassub 
  FROM ".$_conf['prefix']."admin_menu t1 
  LEFT JOIN ".$_conf['prefix']."admin_menu t2 ON (t1.mid=t2.punkt_parent) 
  WHERE FIND_IN_SET('".$_SESSION['USER_GROUP']."', t1.punkt_groups) OR FIND_IN_SET('".$_SESSION['USER_GROUP']."', t2.punkt_groups)
  ORDER BY t1.punkt_parent,t1.punkt_order";
  $menu = $db -> Execute($q);
  $menuCreated = array();
  $t = "var menuMgr = new NlsMenuManager(\"mgr1\");\n";
  //$t .= "menuMgr.defaultEffect = \"randomdissolve\";\n";
  $t .= "menuMgr.icPath=\"img/\"\n";

	while(!$menu -> EOF){
		$row = $menu -> GetRowAssoc(false);
    	$prId=$row["punkt_parent"];
    if (!isset($menuCreated[$prId])) {
      if ($prId==0) {
        $t .= "var mn" . $prId . " = menuMgr.createMenubar(\"mn" . $prId . "\");\n";
  		$t .= "mn" . $prId . ".stlprf=\"horz_\";\n";
  		$t .= "mn" . $prId . ".orient = \"H\";\n";
  		$t .= "mn" . $prId . ".showIcon = false;\n";
  		$t .= "mn" . $prId . ".showSubIcon=false;\n";
	  	$t .= "mn" . $prId . ".dropShadow(\"none\");\n";
      } else {
        $t .= "var mn" . $prId . " = menuMgr.createMenu(\"mn" . $prId . "\");\n";
		  $t .= "mn" . $prId . ".showIcon=true;\n";
		  $t .= "mn" . $prId . ".dropShadow(\"bottomright\", \"5px\");\n";
     	  $t .= "mn" . $prId . ".showIcon=true;\n";
     	  $t .= "mn" . $prId . ".absWidth=\"250px\";\n";
      }
      $menuCreated[$prId]=$prId;
    }
	    $t .= "mn" . $prId . ".addItem(\"" . $row['mid'] . "\", " .
    	  "\"" . $row['punkt_name_'.$_SESSION['admin_lang']] . "\", \"" . $row['punkt_link'] . "\");\n";
    if ($row["hassub"]==1) {
      $t .= "mn" . $prId . ".addSubmenu(\"" . $row['mid'] . "\",\"" . "mn" . $row['mid'] . "\");\n";
    }
	$menu -> MoveNext();
  }
  return $t;
}

function displayMenu() {
  $t = "menuMgr.renderMenus();\n";
  $t .= "menuMgr.renderMenubar();\n";
  return $t;
}

function CopyGroupSettings($fromgroup, $togroup){
	global $_conf, $db;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."admin_menu");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$pg = explode(",", $t['punkt_groups']);
		if(in_array($fromgroup, $pg)){
			$punkt_groups = $t['punkt_groups'].",".$togroup;
			$ru = $db -> Execute("UPDATE ".$_conf['prefix']."admin_menu SET punkt_groups='".$punkt_groups."' WHERE mid='".$t['mid']."'");
		}
		$r -> MoveNext();
	}

	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."page");
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$pg = explode(",", $t['pgroups']);
		if(in_array($fromgroup, $pg)){
			$pgroups = $t['pgroups'].",".$togroup;
			$ru = $db -> Execute("UPDATE ".$_conf['prefix']."page SET pgroups='".$pgroups."' WHERE pname='".$t['pname']."'");
		}
		$r -> MoveNext();
	}
	return true;
}



function GetMailAccount($idu, $email){
	global $_conf,$db,$smarty;
	$rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account WHERE idu='$idu' AND email='".mysql_real_escape_string($email)."'");
  if($rs->RecordCount()!=0){
  	$out=array();
	$tmp = $rs -> GetRowAssoc(false);
  	while(list($key,$val)=each($tmp)){
		$out[$key]=stripslashes($val);
	}
	return $out;
  }else{
	return false;
  }
}
function GetMailAccountById($idma){
	global $db, $_conf;
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."user_mail_account WHERE idma='".$idma."'");
	$t = $r -> GetRowAssoc(false);
	while(list($k,$v)=each($t)){
		$t[$k] = stripslashes($v);
	}
	return $t;
}

function CheckRegData(){
	global $db, $smarty, $_conf, $lang_ar;
	$res = array();
	$res['state'] = "OK";
	$res['errormsg'] = "";
	if(trim($_REQUEST['fio'])=="" || trim($_REQUEST['pass'])=="" || trim($_REQUEST['login'])=="" || trim($_REQUEST['email'])==""){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er3']."\n";
	}
	if($_REQUEST['pass']!=$_REQUEST['pass1']){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er4']."\n";
	}

	if($_REQUEST['check_code']!=$_SESSION['check_code'] && (isset($_REQUEST['chk_yes']) && $_REQUEST['chk_yes']!='y')){
		$res['state'] = "ERROR";
		$res['errormsg'] .= $lang_ar['reg_er5']."\n";
	}
	$r = $db -> Execute("SELECT login FROM ".$_conf['prefix']."users WHERE login='".mysql_real_escape_string($_REQUEST['login'])."'");
	if($r -> RecordCount() != 0){
		$res['state'] = "ERROR";
		$res['errormsg'] .= sprintf($lang_ar['reg_er6'], stripslashes($_REQUEST['login']))."\n";
	}
	$e = $db -> Execute("SELECT email FROM ".$_conf['prefix']."users WHERE email='".mysql_real_escape_string($_REQUEST['email'])."'");
	if($e -> RecordCount() != 0){
		$res['state'] = "ERROR";
		$res['errormsg'] .= sprintf($lang_ar['reg_er7'], stripslashes($_REQUEST['email']))."\n";
	}
	return $res;	
}


function SaveRegData(){
	global $db, $smarty, $_conf, $lang_ar;
	$res = array();
	$newssign = isset($_REQUEST['newssign']) ? '0' : '1';
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."users (email, login, password, dreg, dacc, ip, group_code, newssign, state) VALUES
		('".mysql_real_escape_string($_REQUEST['email'])."', 
		'".mysql_real_escape_string($_REQUEST['login'])."', '".mysql_real_escape_string($_REQUEST['pass'])."', 
		'".time()."','".time()."', '".$_SERVER['REMOTE_ADDR']."', 'client', '".$newssign."', 'new')");
		$idu = $db -> Insert_ID();
		$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."users_add (idu, fio, contact, phone, mphone) VALUES
		('".$idu."', 
		'".mysql_real_escape_string($_REQUEST['fio'])."', 
		'".mysql_real_escape_string($_REQUEST['contact'])."',
		'".mysql_real_escape_string($_REQUEST['phone'])."', 
		'".mysql_real_escape_string($_REQUEST['mphone'])."'
		)");

		if(isset($_FILES['avatar']) && $_FILES['avatar']['name']!=""){
			include "include/uploader.php";
			$upl = new uploader;
			if(!is_dir("files/avatars")) $upl -> MakeDir("files/avatars");
			
			include "include/imager.php";
			$img = new imager;
				$img -> crop = array("");
				$img -> whatcrop = array("");
				$img -> desttype = array("thumb");
				$width = array($_conf['avatar_w']);
				$height = array($_conf['avatar_w']);
				$name = array("files/avatars/".$idu.".jpg");
				$img -> width = $width;
				$img -> height = $height;
				$img -> fname = $name;
				$ares = $img -> ResizeImage($_FILES['avatar']);
				if($ares != 1){
					$res['successmsg'] .= $ares."\n";
				}
		}
		$res['successmsg'] .= "<strong>".$lang_ar['reg_success']."</strong>";
		$res['idu'] = $idu;
	return $res;
}

/* форма добавления/редактирования пользователя */
function UserCard($idu){
	global $db, $_conf, $alang_ar;
	$out = '';
	
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."users LEFT JOIN ".$_conf['prefix']."users_add USING(idu) WHERE idu='".$idu."'");
	if($r -> RecordCount()==0){
		$out .= 'Ошибка! Вы не выбрали пользователя или такого пользователя не существует!';
	}else{
		$t = $r -> GetRowAssoc(false);
		$rg = $db -> Execute("select group_code,group_name from ".$_conf['prefix']."user_group WHERE group_code='".$t['group_code']."'");
		$tg = $rg -> GetRowAssoc(false);
		if($t['suppl']!='0'){
			$rsuppl = $db -> Execute("select * from ".$_conf['prefix']."suppliers where ids='".$t['suppl']."'");
			$tsuppl = $rsuppl -> GetRowAssoc(false);
			$supplinfo = '<br /><font style="color:blue;font-weight:bold;">Контактное лицо от поставщика '.stripslashes($tsuppl['s_name']).'</font><br />';
		}else $supplinfo = '';
	
	    $out.='<div id="UserFormArea">
		'.$supplinfo.'
		<h3>Информация пользователя '.stripslashes($t['login']).'</h3><br />
		<table border="0" class="selrow" cellspacing="0">
		<tr><td><strong>E-mail:</strong></td><td>'.stripslashes($t['email']).'</td></tr>
		<tr><td><strong>Группа:</strong></td><td>'.stripslashes($tg['group_name']).'</td></tr>
		<tr><td><strong>Фамилия:</strong></td><td>'.stripslashes($t['sname']).'</td></tr>
		<tr><td><strong>Имя:</strong></td><td>'.stripslashes($t['fname']).'</td></tr>
		<tr><td>Отчество:</td><td>'.stripslashes($t['mname']).'</td></tr>
		<tr><td>Город:</td><td>'.stripslashes($t['city']).'</td></tr>
		<tr><td>Адрес:</td><td>'.stripslashes($t['contact']).'</td></tr>
		<tr><td>Факс:</td><td>'.stripslashes($t['fax']).'</td></tr>
		<tr><td>Телефон:</td><td>'.stripslashes($t['phone']).'</td></tr>
		<tr><td>Мобильный:</td><td>'.stripslashes($t['mphone']).'</td></tr>
		<tr><td></td><td></td></tr>';
		if($t['organisation']!="") $out .= '<tr><td>Организация:</td><td>'.stripslashes($t['organisation']).'</td></tr>';
		if($t['firmadres']!="") $out .= '<tr><td>Юридический адрес:</td><td>'.stripslashes($t['firmadres']).'</td></tr>';
		if($t['svnomer']!="") $out .= '<tr><td>Номер свидетельства:</td><td>'.stripslashes($t['svnomer']).'</td></tr>';
		if($t['pdvnomer']!="") $out .= '<tr><td>Номер плательщика НДС:</td><td>'.stripslashes($t['pdvnomer']).'</td></tr>';
		$out .= '</table>
	    </div>';
	}
	return $out;
}

/* формирует ссылку для вывода формы написания письма */
function MailToEmail($email, $name){
	global $_conf;
	$link = "<a title='Написать письмо' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('WriteFormBox', 'inline', '', 'Написать письмо', 'width=800px,height=500px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=outlook&type=new&mailact=WriteForm&toemail=".stripslashes($email)."&tofio=".stripslashes($name)."','WriteFormBox_inner'); return false; \"><img src='$_conf[admin_tpl_dir]img/mail_icon1.gif' width='16' height='16' alt='Написать письмо' style='vertical-align:middle;' /></a>";
	return $link;
}

/* Полная информация о пользователе по его ИД возвращается в виде массива */
function GetUserName($idu){
	global $_conf,$db,$smarty;
	$rs = $db -> Execute("SELECT * FROM ".$_conf['prefix']."users 
	LEFT JOIN ".$_conf['prefix']."users_add USING (idu) 
	LEFT JOIN ".$_conf['prefix']."user_group USING (group_code) 
	WHERE ".$_conf['prefix']."users.idu='".$idu."'");
  if($rs->RecordCount()!=0){
  	$out=array();
	$tmp = $rs -> GetRowAssoc();
  	while(list($key,$val)=each($tmp)){
		if($val=='') $val='';
		$out[$key]=stripslashes($val);
		$out[strtolower($key)]=stripslashes($val);
	}
		return $out;
  }else{
  		return "";
  }
}

/* пРоверка на наличие новых сообщений */
function Informer(){
	global $_conf,$db,$smarty;
	if(!function_exists("Super_Informer")) include("include/alerts.php");
	$allmsg = Super_Informer();
	return $allmsg;
}

function VisitersCount(){
	$visiters=0;
	$interval = 60*1;
	if(file_exists("tmp/count.txt")){
		$data = file("tmp/count.txt");
		$sid = session_id();
		$tm = time();
		$uexists = 0;
		$str="";
		while(list($key,$val)=each($data)){
			$d = explode(":",trim($val));
			if($d[0]==$sid || $d[2]==$_SERVER['REMOTE_ADDR']){
				$uexists = 1;
				$str.=$d[0].":".$tm.":".$_SERVER['REMOTE_ADDR']."\n";
				$visiters++;
			}else{
				$dif = $tm - $d[1];
				if($dif < $interval){
					$str.=$d[0].":".$d[1].":".$d[2]."\n";
					$visiters++;
				}
			}
		}
			if($uexists==0){
				$str.=$sid.":".$tm.":".$_SERVER['REMOTE_ADDR'];
				$visiters++;
			}
		$fp = fopen("tmp/count.txt","w");
		fwrite($fp,trim($str));
		fclose($fp);
	}else{
		$visiters = 1;
		$str = session_id().":".time().":".$_SERVER['REMOTE_ADDR']."\n";
		$fp = fopen("tmp/count.txt","w");
		fwrite($fp,$str);
		fclose($fp);
	}
	
	return $visiters;
}

function WorkerCount(){
	$visiters=0;
	$interval = 60*1;
	if(file_exists("tmp/workercount.txt")){
		$data = file("tmp/workercount.txt");
		$tm = time();
		$uexists = 0;
		$str="";
		while(list($key,$val)=each($data)){ /*обрабатываем данные из файла*/
			$d = explode(":",trim($val)); /*каждую строук отдельно*/
			if(isset($_SESSION['USER_IDU']) && trim($d[1])==trim($_SESSION['USER_IDU'])){/*если такая сессия есть в файле, то обновляем дату*/
				$uexists = 1;
				$str.=$tm.":".$d[1].":".$_SERVER['REMOTE_ADDR']."\n";
				$visiters++;
			}else{/* иначе вставляем в файл новую запись */
				$dif = $tm - $d[0];
				if($dif < $interval){
					$str.=$d[0].":".$d[1].":".$d[2]."\n";
					$visiters++;
				}
			}
		}
			if(isset($_SESSION['USER_IDU']) && $uexists==0){
				$str.=$tm.":".$_SESSION['USER_IDU'].":".$_SERVER['REMOTE_ADDR'];
				$visiters++;
			}
		$fp = fopen("tmp/workercount.txt","w");
		if (flock($fp, LOCK_EX)) { // выполнить эксплюзивное запирание
		    fwrite($fp,trim($str));
		    flock($fp, LOCK_UN); // отпираем файл
		}
		fclose($fp);
	}else{
		$visiters = 1;
		$str = time().":".$_SESSION['USER_IDU'].":".$_SERVER['REMOTE_ADDR']."\n";
		$fp = fopen("tmp/workercount.txt","w");
		if (flock($fp, LOCK_EX)) { // выполнить эксплюзивное запирание
		    fwrite($fp,trim($str));
		    flock($fp, LOCK_UN); // отпираем файл
		}
		fclose($fp);
	}
	VisitersCount();
	return $visiters;
}

function WorkerIsOnline($idu){
	$online=0;
	if(file_exists("tmp/workercount.txt")){
		$data = file("tmp/workercount.txt");
		while(list($key,$val)=each($data)){
			$d = explode(":",trim($val));
			if(trim($d[1])==trim($idu)){
				$online = 1;
			}
		}
	}
	return $online;
}

function GetOnlineWorker(){
	$online = 0;
	if(file_exists("tmp/workercount.txt")){
		$data = file("tmp/workercount.txt");
		$online = count($data);
	}
		return $online;
}
function GetListOnlineWorker(){
	global $_conf, $db;
	$online = 0;
	if(file_exists("tmp/workercount.txt")){
		$data = file("tmp/workercount.txt");
	}
	return $data;
}

?>