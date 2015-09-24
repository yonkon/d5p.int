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

$smarty -> assign("PAGETITLE","<h2><a href=\"admin.php?p=admin_akcii&act=list\">Акции</a> : <a href=\"admin.php?p=admin_akcii&act=add_form\">Добавить</a></h2>");
$smarty -> assign("modSet", "akcii");

//---------------------------------------------------------------
$dir = $_conf['upldir']."/akcii";
$fl = GetLangField();
if(!is_dir($dir)){
	include("include/uploader.php");
	$upl = new uploader;
	$upl -> MakeDir($dir);
}
//----------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="add_akcia"){
	$er = 0;
	if(trim($_REQUEST['title_'.$_SESSION['admin_lang']])==""){
		echo msg_box("Ошибка! Введите заглавие!");
		$er = 1;
	   $_REQUEST['act']="add_form";
	}
	if($er==0){
    $da = strtotime($_REQUEST['date']);
	reset($fl);
	$vals = array();
	while(list($k,$v)=each($fl)){
		$vals[] = " title_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['title_'.$k]))."', 
		anons_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['anons_'.$k]))."',
		text_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['text_'.$k]))."' ";
	}
		$q = "INSERT INTO ".$_conf['prefix']."akcii SET
		date='".$da."',
		".implode(",",$vals)."
		";
		$r = $db -> Execute($q);
		$id = $db -> Insert_ID();
		if($_FILES['aphoto']['name']!=""){
			include "include/imager.php";
			$img = new imager;
			$img -> crop = array("");
			$img -> whatcrop = array("");
			$img -> desttype = array("thumb");
			$width = array($_conf['athumb_w']);
			$height = array($_conf['athumb_h']);
			$name = array($dir."/".$_FILES['aphoto']['name']);
			$img -> width = $width;
			$img -> height = $height;
			$img -> fname = $name;
			$img -> sign = array('');
			$res = $img -> ResizeImage($_FILES['aphoto']);
			if($res == 1){
				$r = $db -> Execute("update ".$_conf['prefix']."akcii SET
				aphoto='".mysql_real_escape_string(stripslashes($name[0]))."' WHERE id='".$id."'");
				echo msg_box("Фото к анонсу успешно загружено!");
			}else{
				echo msg_box($res);
			}
		}
		echo msg_box("Новая акция добавлена в базу данных!");
	   $_REQUEST['act']="list";
	}
}
//--------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="upd_akcia"){
	$er = 0;
	if(trim($_REQUEST['title_'.$_SESSION['admin_lang']])==""){
		echo msg_box("Ошибка! Введите заглавие!");
		$er = 1;
	   $_REQUEST['act']="add_form";
	}
	if($er==0){
    $da = strtotime($_REQUEST['date']);
	reset($fl);
	$vals = array();
	while(list($k,$v)=each($fl)){
		$vals[] = " title_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['title_'.$k]))."', 
		anons_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['anons_'.$k]))."',
		text_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['text_'.$k]))."' ";
	}
		$q = "UPDATE ".$_conf['prefix']."akcii SET
		date='".$da."',
		".implode(",",$vals)."
		WHERE id='".$_REQUEST['id']."'";
		$r = $db -> Execute($q);
		$id = $_REQUEST['id'];
		if($_FILES['aphoto']['name']!=""){
			include "include/imager.php";
			$img = new imager;
			$img -> crop = array("");
			$img -> whatcrop = array("");
			$img -> desttype = array("thumb");
			$width = array($_conf['athumb_w']);
			$height = array($_conf['athumb_h']);
			$name = array($dir."/".$_FILES['aphoto']['name']);
			$img -> width = $width;
			$img -> height = $height;
			$img -> fname = $name;
			$img -> sign = array('');
			$res = $img -> ResizeImage($_FILES['aphoto']);
			if($res == 1){
				$r = $db -> Execute("update ".$_conf['prefix']."akcii SET
				aphoto='".mysql_real_escape_string(stripslashes($name[0]))."' WHERE id='".$id."'");
				echo msg_box("Фото к анонсу успешно загружено!");
			}else{
				echo msg_box($res);
			}
		}
		echo msg_box("Информация о акции успешно обновлена!");
	   $_REQUEST['act']="list";
	}
}
//------------ВИДАЛЕННЯ ВИЮРАНОЇ НОВИНИ----------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delit"){
	   $q = "SELECT * FROM `".$_conf['prefix']."akcii` WHERE `id`='".$_REQUEST['id']."'";
	   $r = $db -> Execute($q);
	   $t = $r -> GetRowAssoc(false);
	   if($t['aphoto']!=""){
		   @unlink(stripslashes($t['aphoto']));
	   }
	   $q = "DELETE FROM `".$_conf['prefix']."akcii` WHERE `id`='".$_REQUEST['id']."'";
	   $r = $db -> Execute($q);

	echo msg_box("Информация о акции удалена из базы данных!");
	   $_REQUEST['act']="list";
}
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delPH"){
	   $q = "SELECT * FROM `".$_conf['prefix']."akcii` WHERE `id`='".$_REQUEST['id']."'";
	   $r = $db -> Execute($q);
	   $t = $r -> GetRowAssoc(false);
	   if($t['aphoto']!=""){
		   @unlink(stripslashes($t['aphoto']));
	   }
	echo msg_box("Фото удалено!");
}

/* ************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="add_form"){
	echo "<h2>Добавить акцию</h2><br />";
	echo "<form action='$_SERVER[PHP_SELF]' method='post' enctype='multipart/form-data' id='addAF'>
	<span>Дата:</span> <input type='text' id='date' name='date' value='".date("d.m.Y H:i",time())."' size='20' class='datetextbox' readonly='readonly' /><br /><br />";
	echo '<span>Фото:</span> <input type="file" name="aphoto" id="aphoto" /><br /><br />';
	initializeEditor($_conf['neditor']);
	
	echo '<div id="tabs">';
	echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			//echo '<li><a href="javascript:void(null)" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';

		echo "<span>Заглавие:</span><br />
		<input type='text' name='title_".$k."' id='title_".$k."' size='75' maxlenght='250' value='' /><br />
		<span>Анонс:</span><br />
		<textarea name='anons_".$k."' id='anons_".$k."' style='width:400px;height:70px;'></textarea><br />
		<span>Полное описание</span><br />";
		$cfield = 'text_'.$k.'';
		if($_conf['neditor'] == "fck"){
			addFCKToField($cfield, '', 'Default', '900', '600');
		}elseif($_conf['neditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['neditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
		}
		echo '</div>';

		$i++;
	}

	echo '</div>';
	echo "<br />
	<input type='hidden' name='p' value='admin_akcii' />
	<input type='hidden' name='act' value='add_akcia' />
	<input type='submit' value='".$lang_ar['add']."' style='width:200px;' />
	</form>";

	$HEADER .= '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/ui.datetimepicker.js"></script>
	<link rel="stylesheet" href="'.$_conf['www_patch'].'/js/jquery/themes/green/dark.datetimepicker.css" type="text/css">
	<script type="text/javascript">
	$(function() {
		$("#date").datetimepicker({
			dateFormat: "dd.mm.yy",
			timeFormat: "hh:ii"
		});
	});
	</script>
	';
}
//-----------РЕДАГУВАННЯ ВИБРАНОЇ НОВИНИ------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit_form"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."akcii where id='".$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
	
	echo "<h2>Редактировать акцию</h2><br />";
	echo "<form action='$_SERVER[PHP_SELF]' method='post' enctype='multipart/form-data' id='editAF'>
	<span>Дата:</span> <input type='text' id='date' name='date' value='".date("d.m.Y H:i",$t['date'])."' size='20' class='datetextbox' readonly='readonly' /><br /><br />";
	echo '<span>Фото:</span> <input type="file" name="aphoto" id="aphoto" />';
	if(trim($t['aphoto'])!="" && file_exists($t['aphoto'])){
		echo '<br /><span id="APH"><img src="'.stripslashes($t['aphoto']).'" /></span><br />
		<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=admin_akcii&act=delPH&id='.$t['id'].'\',\'APH\')"><small>Удалить фото</small></a>';
	}
	echo '<br /><br />';
	initializeEditor($_conf['neditor']);
	
	echo '<div id="tabs">';
	echo '<ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			//echo '<li><a href="javascript:void(null)" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';

		echo "<span>Заглавие:</span><br />
		<input type='text' name='title_".$k."' id='title_".$k."' size='75' maxlenght='250' value='".htmlspecialchars(stripslashes($t['title_'.$k]))."' /><br />
		<span>Анонс:</span><br />
		<textarea name='anons_".$k."' id='anons_".$k."' style='width:400px;height:70px;'>".stripslashes($t['anons_'.$k])."</textarea><br />
		<span>Полное описание</span><br />";
		$cfield = 'text_'.$k.'';
		$val = stripslashes($t['text_'.$k]);
		if($_conf['neditor'] == "fck"){
			addFCKToField($cfield, $val, 'Default', '900', '600');
		}elseif($_conf['neditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$val.'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['neditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$val.'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$val.'</textarea><br />';
		}
		echo '</div>';

		$i++;
	}

	echo '</div>';
	echo "<br />
	<input type='hidden' name='p' value='admin_akcii' />
	<input type='hidden' name='act' value='upd_akcia' />
	<input type='hidden' name='id' value='".$t['id']."' />
	<input type='submit' value='".$lang_ar['save']."' style='width:200px;' />
	</form>";

	$HEADER .= '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/ui.datetimepicker.js"></script>
	<link rel="stylesheet" href="'.$_conf['www_patch'].'/js/jquery/themes/green/dark.datetimepicker.css" type="text/css">
	<script type="text/javascript">
	$(function() {
		$("#date").datetimepicker({
			dateFormat: "dd.mm.yy",
			timeFormat: "hh:ii"
		});
	});
	</script>
	';
}
//-----------------------------------------
if(!isset($_REQUEST['act']) || $_REQUEST['act']=="list"){
	$interval = 30;
	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];
   $qn1="SELECT * FROM ".$_conf['prefix']."akcii ORDER BY date DESC";
	echo "<h1>Акции</h1>";
	$qn=$qn1." LIMIT $start,$interval";

	$ms1 = $db->Execute($qn1);
	$ms = $db->Execute($qn);
	$all=$ms1->RecordCount(); // всего тем

	$list_page=Paging($all,$interval,$start,"admin.php?p=admin_akcii&act=list&start=%start1%","");
	echo "<br />".$list_page;
	echo '<table border="0" cellspacing="0" cellpadding="0" class="selrow">';
	echo '<tr><th>ID</th><th>Дата</th><th>Заглавие</th><th>Удалить</th></tr>';
	while (!$ms->EOF) { 
		$tmpn = $ms->GetRowAssoc();
		echo '<tr>
	    <td><a href="admin.php?p=admin_akcii&act=edit_form&id='.$tmpn['ID'].'" title="Редактировать">'.$tmpn['ID'].'</a></td>
	    <td><small>'.date("d.m.Y H:i",$tmpn['DATE']).'</small></td>
		<td><a href="admin.php?p=admin_akcii&act=edit_form&id='.$tmpn['ID'].'" title="Редактировать">'.stripslashes($tmpn['TITLE_'.strtoupper($_SESSION['admin_lang'])]).'</a></td>
		<td><a href="admin.php?p=admin_akcii&act=delit&id='.$tmpn['ID'].'">'.$lang_ar['delete'].'</a></td>
	    </tr>';
		$ms->MoveNext();
	}
	echo '</table>';
}

?>
