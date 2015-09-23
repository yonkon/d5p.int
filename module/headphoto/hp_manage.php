<?php
/**
 * Управление новостями сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.01.02
 */

$smarty -> assign("PAGETITLE","<h2><a href=\"admin.php?p=hp_manage\">Фото для шапки сайта</a></h2>");

$smarty -> assign("modSet", "headphoto");
global $CMS;
if(!isset($CMS['structure'])) loadSiteStructure();
$dir = $_conf['upldir'].'/'.$_conf['hp_path'];

//---------------------------------------------------------------
$dirs="";
if(isset($_REQUEST['act']) && $_REQUEST['act']=="updPH"){
			$pname = isset($_REQUEST['pname']) ? implode(",",$_REQUEST['pname']) : '';
			$r = $db -> Execute("update ".$_conf['prefix']."headphoto set 
			pages='".mysql_real_escape_string($pname)."'
			where id='".$_REQUEST['id']."'");
			echo msg_box("Настройки страниц обновлены!");
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="setPH"){
	$par = $CMS['structure'];
	$r = $db -> Execute("select * from ".$_conf['prefix']."headphoto where id='".$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
	$ph = explode(",",stripslashes($t['pages']));
	echo '
	<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="SHPF" style="margin-left:20px;">
	<strong>Выберите страницы:</strong><br />
	<div style="height:320px; width:400px; overflow:auto; padding:3px; border:dotted 1px #ccc;">';
	while(list($k,$v)=each($par)){
		$chk = in_array($v['pname'],$ph) ? ' checked="cchecked" ' : '';
		if($v['menushow1']=="y" || $v['menushow2']=="y" || $v['menushow3']=="y") echo '<input type="checkbox" name="pname[]" id="pname[]" value="'.$v['pname'].'"'.$chk.' /> '.$v['linkname'].'<br />';
		if(is_array($v['sub'])){
			while(list($k1,$v1)=each($v['sub'])){
				$chk1 = in_array($v1['pname'],$ph) ? ' checked="cchecked" ' : '';
				if($v1['menushow1']=="y" || $v1['menushow2']=="y" || $v1['menushow3']=="y") echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="pname[]" id="pname[]" value="'.$v1['pname'].'"'.$chk1.' /> '.$v1['linkname'].'<br />';
			}
		}

	}
	echo '</div>
	<input type="hidden" name="p" id="p" value="hp_manage" />
	<input type="hidden" name="act" id="act" value="updPH" />
	<input type="hidden" name="id" id="id" value="'.$_REQUEST['id'].'" />
	<input type="button" value="'.$lang_ar['save'].'" onclick="doLoad(\'SHPF\',\'ActionRes\')" />
	</form>
	</div>
	';
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="delPH"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."headphoto where id='".$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
	$img = $dir.'/'.stripslashes($t['file']);
	@unlink($img);
	$r = $db -> Execute("delete from ".$_conf['prefix']."headphoto where id='".$_REQUEST['id']."'");
	echo msg_box("Изображение удалено!");
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="uplPH"){
	if($_FILES['photo']['name']!=""){
		include("include/uploader.php");
		$upl = new uploader;
		if(!is_dir($dir)) $upl->MakeDir($dir);
		$fname = $dir.'/'.$_FILES['photo']['name'];
		$upl -> fname = $fname;
		$res = $upl -> SaveFile($_FILES['photo']);
		if($res == 1){
			$pname = isset($_REQUEST['pname']) ? implode(",",$_REQUEST['pname']) : '';
			$r = $db -> Execute("insert into ".$_conf['prefix']."headphoto set 
			file='".mysql_real_escape_string(stripslashes($_FILES['photo']['name']))."',
			pages='".mysql_real_escape_string($pname)."'");
		}else{
			echo msg_box($res);
		}
	}else{
		echo msg_box("Ошибка! Выберите файл!");
	}
	$_REQUEST['act'] = "list";
}

//-----------------------------------------
if(!isset($_REQUEST['act']) || $_REQUEST['act']=="list"){
	$par = $CMS['structure'];
	echo '
	<div class="block">
	<form method="post" action="admin.php?p=hp_manage&act=uplPH" enctype="multipart/form-data" id="HPF">
	<table border="0"><tr>
	<td valign="top">
	<strong>Выбрать фото:</strong><br />
	700x251<br />
	<input type="file" name="photo" id="photo" />
	</td>
	<td width="50">&nbsp;</td>
	<td valign="top">
	<strong>Выберите страницы:</strong><br />
	<div style="height:200px; width:400px; overflow:auto; padding:3px; border:dotted 1px #ccc; background:#fff;">';
	while(list($k,$v)=each($par)){
		if($v['menushow1']=="y" || $v['menushow2']=="y" || $v['menushow3']=="y") echo '<input type="checkbox" name="pname[]" id="pname[]" value="'.$v['pname'].'" /> '.$v['linkname'].'<br />';
		if(is_array($v['sub'])){
			while(list($k1,$v1)=each($v['sub'])){
				if($v1['menushow1']=="y" || $v1['menushow2']=="y" || $v1['menushow3']=="y") echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="pname[]" id="pname[]" value="'.$v1['pname'].'" /> '.$v1['linkname'].'<br />';
			}
		}

	}
	echo '</div></td>
	</tr></table>
	<input type="submit" value="'.$lang_ar['save'].'" />
	</form>
	</div>
	';
	
	$r = $db -> Execute("select * from ".$_conf['prefix']."headphoto");
	if($r -> RecordCOunt()>0){
		echo '<table border="0" cellspacing="0" class="selrow">';
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			$img = $dir.'/'.stripslashes($t['file']);
			$imgtag = file_exists($img) ? '<img src="'.$img.'" width="150" />' : '';
			echo '<tr id="tr'.$t['id'].'">
			<td>'.$imgtag.'</td>
			<td>'.stripslashes($t['file']).'</td>
			<td><a href="javascript:void(null)" onclick="hpwin=dhtmlwindow.open(\'HPBox\', \'inline\', \'\', \'Настройка страниц\', \'width=450px,height=400px,left=150px,top=120px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=hp_manage&act=setPH&id='.$t['id'].'\',\'HPBox_inner\'); return false; ">'.str_replace(',','<br />',stripslashes($t['pages'])).'</a></td>
			<td><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=hp_manage&act=delPH&id='.$t['id'].'\',\'ActionRes\');delelem(\'tr'.$t['id'].'\')" /><img src="'.$_conf['www_patch'].'/'.$_conf['admin_tpl_dir'].'img/delit.png" alt="'.$lang_ar['delete'].'" /></a></td>
			</tr>';
			$r -> MoveNext();
		}
		echo '</table>';
	}
}

?>
