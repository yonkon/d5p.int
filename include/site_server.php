<?php
/**
 * Набор действий используемых в различных частях сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.01
 */
if((isset($_REQUEST['act']) && !isset($_SERVER['HTTP_REFERER'])) || !defined('SHIFTCMS')){
	add_to_log("From IP: ".get_ip()."<BR />SERVER<br />".print_r($_SERVER,1)."<br />REQUEST:".print_r($_REQUEST,1)."<br />SESSION".print_r($_SESSION,1),"hc");
	exit;
}

/* добавление/редактирование пользователя пользователя */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "AddOrEditUser" && isset($_SESSION['USER_IDU'])){
		if(!isset($_SESSION['USER_IDU'])) { exit;}
		if(isset($_REQUEST['idu'])) echo EditUserForm($_REQUEST['idu']);
		else echo EditUserForm();
}

/* сохранение данных пользователя */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "SaveUserInfo" && isset($_SESSION['USER_IDU'])){
	if(!isset($_SESSION['USER_IDU'])) { exit;}
	$res = CheckUserData();
	if($res == "OK") {
		SaveUserData();
		$smarty->assign("info_message", "Данные успешно сохранены!");
		echo $smarty->fetch("messeg.tpl");
		/*
		echo "<script type='text/javascript'>
		document.getElementById('UserFormArea').innerHTML='';
		</script>";
		*/
	}else{
		echo $res;
	}
}


/* вывод истории пользователя */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "ShowUserHistory" && isset($_SESSION['USER_IDU'])){
	if(!isset($_SESSION['USER_IDU'])) { exit;}
	include "admin/system/loghistory.php";
}


/* получение и вівод новіх собітий для пользователя */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "Informer"){
	if(!isset($_SESSION['USER_IDU'])) { exit;}
	$info = Informer();
	if(trim($info)!=""){
	echo "<div id='somediv' style='display:none;'>{$info}</div>
			<a href='#' onClick=\"divwin=dhtmlwindow.open('divbox', 'div', 'somediv', 'Информер', 
            'width=450px,height=400px,left=50px,top=50px,resize=1,scrolling=1'); return false;\" style='padding:0px;margin:0px;'><img src='".$_conf['admin_tpl_dir']."img/alert.gif' width='16' height='16' alt='Информер' style='border:0px;vertical-align:middle;' /></a>";
	}else{
		echo "";
	}
}

/* Сохранение личной информации клиентом */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "SaveClientSetting"){
	if(!isset($_SESSION['USER_IDU'])) { exit;}
	$data = SecureRequest($_REQUEST);
	$er = 0; $er_msg = "";
	if(trim($data['fio'])=="" || trim($data['email'])=="" || trim($data['login'])==""){
		$er = 1; $er_msg = "Пожалуйста, заполните все объязательные поля обозначенные *";
	}
	if(trim($data['password'])!=trim($data['password1']) && (trim($data['password'])!="" && trim($data['password1'])!="")){
		$er = 1; $er_msg = "Повторно введенный пароль не соответствует первому!";
	}
	$r = $db -> Execute("select * from ".$_SESSION['conf']['prefix']."users where email='$data[email]' AND idu!='$_SESSION[USER_IDU]'");
	if($r -> RecordCount() > 0){
		$er = 1; $er_msg = "E-mail $data[email] уже зарегистрирвоан на сайте!";
	}
	$r = $db -> Execute("select * from ".$_SESSION['conf']['prefix']."users where login='$data[login]' AND idu!='$_SESSION[USER_IDU]'");
	if($r -> RecordCount() > 0){
		$er = 1; $er_msg = "Логин $data[login] уже зарегистрирвоан на сайте!";
	}
	if($er==1){
		$smarty->assign("info_message",$er_msg);
		echo $smarty->fetch("messeg.tpl");
	}else{
		if(trim($data['password'])!=""){
		$q="update ".$_SESSION['conf']['prefix']."users set email='$data[email]', login='$data[login]', password='$data[password]' where idu='$data[idu]'";
		}else{
		$q="update ".$_SESSION['conf']['prefix']."users set email='$data[email]', login='$data[login]' where idu='$data[idu]'";
		}
		$r = $db -> Execute($q);
		$q = "update ".$_SESSION['conf']['prefix']."users_add set fio='$data[fio]', phone='$data[phone]', icq='$data[icq]', 
		rekvisite='$data[rekvisite]' where idu='$_SESSION[USER_IDU]'";
		$r = $db -> Execute($q);
		$smarty->assign("info_message","Данные успешно сохранены!");
		echo $smarty->fetch("messeg.tpl");
	}
}

/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "UploadUserPhoto" && isset($_SESSION['USER_IDU'])){
	$js['state'] = "OK";
	$js['msg'] = '';//print_r($_REQUEST,1).print_r($_FILES,1);
	$out = "";
	$fl = GetLangField();
	$pid = time();
	$photo_type = stripslashes($_REQUEST['photo_type']);
	$type_id = stripslashes($_REQUEST['type_id']);
	include("include/uploader.php");
	$upl = new uploader;
	$dir1 = $_conf['upldir'].'/'.$photo_type;
	if(!is_dir($dir1)) $upl -> MakeDir($dir1);
	$dir = $_conf['upldir'].'/'.$photo_type.'/'.$type_id;
	if(!is_dir($dir)) $upl -> MakeDir($dir);
	
	include("include/imager.php");
	$img = new imager;
	$width = array($_conf['pgal_thumb_w'], $_conf['pgal_w'], 10000);
	$height = array($_conf['pgal_thumb_h'], $_conf['pgal_h'], 10000);
	$name = array($dir.'/'.$pid."_s.jpg", $dir.'/'.$pid.".jpg", $dir.'/'.$pid."_orig.jpg");
	$img -> width = $width;
	$img -> height = $height;
	$img -> fname = $name;
	$img -> desttype = array("thumb","photo","original");
	$img -> crop = array("yes","","");
	$img -> whatcrop = array("center","","");
	$res = $img -> ResizeImage($_FILES['file']);
	if($res == 1){
		reset($fl); $vals = '';
		while(list($k,$v)=each($fl)) $vals .= ",photosign_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['photosign']))."'";
		$q="INSERT INTO ".$_conf['prefix']."page_gal SET photo_id='".$pid."', photo_type='".mysql_real_escape_string($photo_type)."', type_id='".mysql_real_escape_string($type_id)."', photo_group='".mysql_real_escape_string($_REQUEST['photo_group'])."'".$vals." ";
		$rs = $db -> Execute($q);
		$js['msg'] = '<font color="green">Фото успешно загружено на сервер!</font>';
		$js['thumb'] = $dir.'/'.$pid."_s.jpg";
		$js['thumb_w'] = $_conf['pgal_thumb_w'];
		$js['bigphoto'] = $dir.'/'.$pid.".jpg";
		$js['photo_id'] = $pid;
		$js['photo_group'] = stripslashes($_REQUEST['photo_group']);
		$js['psign'] = stripslashes($_REQUEST['photosign_'.$_SESSION['lang']]);
	}else{
		$js['state'] = "ERROR";
		$js['msg'] = '<font color="green">'.$res.'</font>';
	}
	$GLOBALS['_RESULT'] = $js;
}
/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "DeleteUserPhoto" && isset($_SESSION['USER_IDU'])){
	echo DelPagePhoto($_REQUEST['photo_id']);
}


/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "UploadUserVideo" && isset($_SESSION['USER_IDU'])){
	$js['state'] = "OK";
	$js['msg'] = '';
	$out = ""; $er = 0;
	if(trim($_REQUEST['video_code'])==""){
		$er = 1;
		$js['state'] = "ERROR"; $js['msg'] = '<font color="red">Ошибка! Пожалуйста, введите код для вставки видео</font>';
	}
	if($er==0){
		$fl = GetLangField();
		$vid = time();
		$video_type = stripslashes($_REQUEST['video_type']);
		$type_id = stripslashes($_REQUEST['type_id']);
		reset($fl); $vals = '';
		while(list($k,$v)=each($fl)) $vals .= ",vsign_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['vsign_'.$k]))."'";
		$q="INSERT INTO ".$_conf['prefix']."page_video SET video_id='".$vid."',video_type='".mysql_real_escape_string($video_type)."', type_id='".mysql_real_escape_string($type_id)."', video_group='".mysql_real_escape_string($_REQUEST['video_group'])."', video_code='".mysql_real_escape_string(stripslashes($_REQUEST['video_code']))."'".$vals." ";
		$rs = $db -> Execute($q);
		$js['msg'] = '<font color="green">Видео успешно добавлено!</font>';
		$js['video_id'] = $vid;
		$js['video_group'] = stripslashes($_REQUEST['video_group']);
		$js['vsign'] = stripslashes($_REQUEST['vsign']);
	}
	$GLOBALS['_RESULT'] = $js;
}
/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "UploadUserVideo1" && isset($_SESSION['USER_IDU'])){
	$js['state'] = "OK";
	$js['msg'] = '';//print_r($_REQUEST,1).print_r($_FILES,1);
	$out = "";
	$fl = GetLangField();
	$vid = $_REQUEST['video_id'];
	$video_type = stripslashes($_REQUEST['video_type']);
	$type_id = stripslashes($_REQUEST['type_id']);
		reset($fl); $vals = '';
		while(list($k,$v)=each($fl)) $vals .= ",vsign_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['vsign_'.$k]))."'";
		$q="UPDATE ".$_conf['prefix']."page_video SET video_group='".mysql_real_escape_string($_REQUEST['video_group'])."', video_code='".mysql_real_escape_string(stripslashes($_REQUEST['video_code']))."'".$vals." where video_id='".$vid."'";
		$rs = $db -> Execute($q);
		$js['msg'] = '<font color="green">Запись обновлена!</font>';
		$js['video_id'] = $vid;
		$js['video_group'] = stripslashes($_REQUEST['video_group']);
		$js['vsign'] = stripslashes($_REQUEST['vsign']);
	$GLOBALS['_RESULT'] = $js;
}
/* ************************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "DeleteUserVideo" && isset($_SESSION['USER_IDU'])){
	echo DelPageVideo($_REQUEST['video_id']);
}

if(isset($_REQUEST['act']) && $_REQUEST['act'] == "EditUserVideo" && isset($_SESSION['USER_IDU'])){
	$r = $db -> Execute("select * from ".$_conf['prefix']."page_video where video_id='".mysql_real_escape_string(stripslashes($_REQUEST['video_id']))."'");
	if($r -> RecordCount() > 0){
		$t = $r -> GetRowAssoc(false);
		$fl = GetLangField();
		echo '<div style="padding:2px; border:solid 1px #ccc; background:#eee;" id="EDA'.$t['video_id'].'">
	<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="PageVideoForm'.$t['video_id'].'">
	<input type="hidden" name="video_type" value="'.$t['video_type'].'" id="video_type" />
	<input type="hidden" name="type_id" value="'.$t['type_id'].'" id="type_id" />
	<input type="hidden" name="video_id" value="'.$t['video_id'].'" id="video_id" />
	<strong>Код вставки видео:</strong><br />
	<textarea name="video_code" id="video_code" style="width:400px;height:100px;">'.stripslashes($t['video_code']).'</textarea><br />
	<strong>Подпись к видео:</strong><br />';
		reset($fl);
		while(list($k,$v)=each($fl)){
		echo '<input type="text" name="vsign_'.$v.'" id="vsign_'.$v.'" style="width:200px;" value="'.htmlspecialchars(stripslashes($t['vsign_'.$v])).'" maxlength="255" /> <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v.'.gif" /> '.strtoupper($v).'<br />';
		}
	echo '<strong>Порядковый номер видео:</strong> <input type="text" name="video_group" id="video_group" value="'.$t['video_group'].'" size="3" /> <small>число от 1 до 99</small><br />
	<br /><input type="button" value="Сохранить" onclick="doLoadUserPageVideo1(\'PageVideoForm'.$t['video_id'].'\',\'VideoMsg\',\'EDV'.$t['video_id'].'\')" /> &nbsp;&nbsp; <input type="button" value="Отмена" onclick="document.getElementById(\'EDV'.$t['video_id'].'\').innerHTML=\'\';" />
	</form><br />
		</div>';
	}
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="toCompare"){
	$res = array();
	$res['state'] = "OK";
	$res['msg'] = "";
	$id = (int)$_REQUEST['id'];
	$cat = (int)$_REQUEST['cat'];
	$ch = $_REQUEST['checked']==1 ? 'add' : 'remove';
	if(!isset($_SESSION['compareitems'])) $_SESSION['compareitems'] = array();
	reset($_SESSION['compareitems']);
	while(list($k,$v)=each($_SESSION['compareitems'])){
		if($v['cat']!=$cat){
			$res['state'] = "ERROR";
			$res['msg'] = "Вы можете сравнивать между собой товары только из одного раздела!";
		}
	}
	if($res['state']=="OK"){
		if($ch=='remove'){
			reset($_SESSION['compareitems']);
			while(list($k,$v)=each($_SESSION['compareitems'])){
				if($k==$id){
					unset($_SESSION['compareitems'][$k]);
				}
			}
			$res['msg'] = "Товар удален из списка сравнения!";
		}
		if($ch=='add'){
			$r = $db -> Execute("select * from ".$_conf['prefix']."catalog where id='".$id."'");
			$t = $r -> GetRowAssoc(false);
			$_SESSION['compareitems'][$id] = array(
				'id'=>$id,
				'cat'=>$cat,
				'name'=>stripslashes($t['name_'.$_SESSION['lang']])
			);
			$res['msg'] = "Товар добавлен в список сравнения!";
		}
		reset($_SESSION['compareitems']); $out = '';
		while(list($k,$v)=each($_SESSION['compareitems'])){
			$out .= '<span id="CI_'.$k.'" class="compitem">'.$v['name'].' <small>(<a href="javascript:void(null)" onclick="toCompare('.$k.', '.$v['cat'].', 0)">Удалить</a>)</span></small>';
		}
		$res['out'] = $out;
	}

	$GLOBALS['_RESULT'] = $res;
}
?>