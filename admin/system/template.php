<?php
/**
 * Управление шаблонами находящимися в базе данных
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.02 12.07.2009
 * 04.12.2010 - подключен новый редактор дл яподсветки синтаксиса кода.
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['tmpl_title']."</a> : <a href='admin.php?p=".$p."&act=add_form'>".$alang_ar['tmpl_create']."</a></h2>");

//================================================================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delete"){
   $q="delete from ".$_conf['prefix']."template WHERE tpl_id='".$_REQUEST['tpl_id']."'";
   $r = $db -> Execute($q);
		echo msg_box($alang_ar['tmpl_del']);
   unset($_REQUEST['act']);
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save_page"){
	$er = 0;
	if(trim($_REQUEST['tpl_group'])==""){
		echo msg_box($lang_ar['tmpl_er1']); $er = 1;
	}
	if(trim($_REQUEST['tpl_name'])==""){
		echo msg_box($lang_ar['tmpl_er2']); $er = 1;
	}
	if(trim($_REQUEST['tpl_description'])==""){
		echo msg_box($lang_ar['tmpl_er3']); $er = 1;
	}
	if($er==0){
	   $q="insert into ".$_conf['prefix']."template 
	   (tpl_name, tpl_source, tpl_time, tpl_description, tpl_group)
	   VALUES
	   ('".mysql_real_escape_string(stripslashes($_REQUEST['tpl_name']))."',
	   '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_source']))."',
	   '".time()."',
	   '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_description']))."',
	   '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_group']))."')";
	   
		$r = $db -> Execute($q);
		echo msg_box($alang_ar['saved']);
		unset($_REQUEST['act']);
	}else{
		$_REQUEST['act'] = "add_form";
	}
}
//---------------------------------------------------------------
if(isset($_REQUEST['act']) && $_REQUEST['act']=="add_form"){
	$tpl_group = isset($_REQUEST['tpl_group']) ? htmlspecialchars(stripslashes($_REQUEST['tpl_group'])) : '';
	$tpl_name = isset($_REQUEST['tpl_name']) ? htmlspecialchars(stripslashes($_REQUEST['tpl_name'])) : '';
	$tpl_description = isset($_REQUEST['tpl_group']) ? htmlspecialchars(stripslashes($_REQUEST['tpl_description'])) : '';
	$tpl_source = isset($_REQUEST['tpl_group']) ? stripslashes($_REQUEST['tpl_source']) : '';
	echo "<h2>".$alang_ar['tmpl_create']."</h2>
	<form action='admin.php?p=".$p."&act=save_page' method='post' enctype='multipart/form-data' id='addTF'>
	".$alang_ar['tmpl_group'].":<br />
	<input type='text' name='tpl_group'  id='tpl_group' size='50' maxlenght='50' value=\"".$tpl_group."\" /><br />
	".$alang_ar['tmpl_name'].":<br />
	<input type='text' name='tpl_name' id='tpl_name' size='50' maxlenght='50' value=\"".$tpl_name."\" /><br />
	".$alang_ar['tmpl_desc'].":<br />
	<textarea name='tpl_description' id='tpl_description' style='width:800px;height:50px;'>".$tpl_description."</textarea><br>
	".$alang_ar['tmpl'].":<br />
	<textarea name=\"tpl_source\" id=\"tpl_source\" style=\"width:800px;height:600px;\">".$tpl_source."</textarea><br />
	<input type=submit value=' - ".$alang_ar['save']." - ' />
	</form>
	<div id='addTFRes'></div>";
	initializeEditor("earea");
	addEditAreaToField("tpl_source");
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="update"){
	$er = 0;
	/*
	echo '<pre>';
	print_r($_REQUEST);
	echo '</pre>';
	*/
	if(trim($_REQUEST['tpl_group'])==""){
		echo msg_box($lang_ar['tmpl_er1']); $er = 1;
	}
	if(trim($_REQUEST['tpl_name'])==""){
		echo msg_box($lang_ar['tmpl_er2']); $er = 1;
	}
	if(trim($_REQUEST['tpl_description'])==""){
		echo msg_box($lang_ar['tmpl_er3']); $er = 1;
	}
	if($er==0){
	   $q="update ".$_conf['prefix']."template SET 
	   tpl_name = '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_name']))."',
	   tpl_source = '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_source']))."',
	   tpl_time = '".time()."',
	   tpl_description = '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_description']))."',
	   tpl_group = '".mysql_real_escape_string(stripslashes($_REQUEST['tpl_group']))."'
	   WHERE tpl_id='".$_REQUEST['tpl_id']."'";
	   $r = $db -> Execute($q);
		echo msg_box($alang_ar['saved']);
	}
	
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit"){
	$q="SELECT * FROM ".$_conf['prefix']."template WHERE tpl_id='".(int)$_REQUEST['tpl_id']."'";
	$r = $db -> Execute($q);
	$t = $r -> GetRowAssoc(false);
	$ro = $_SESSION['USER_GROUP']=="super" ? "" : ' readonly="readonly"';
	echo "<h2>".$alang_ar['tmpl_edit']."</h2>
	<!--<form action='admin.php?p=".$p."&act=update&tpl_id=".$t['tpl_id']."' method=post>-->
	<form action='javascript:void(null)' method='post' id='TMPLForm' enctype='multipart/form-data'>
	<input type='hidden' name='p' id='p' value='".$p."' />
	<input type='hidden' name='act' id='act' value='update' />
	<input type='hidden' name='tpl_id' id='tpl_id' value='".$t['tpl_id']."' />
	
	".$alang_ar['tmpl_group'].":<br />
	<input type='text' name='tpl_group' size='50' maxlenght='50' value='".htmlspecialchars(stripslashes($t['tpl_group']))."'".$ro." /><br />
	".$alang_ar['tmpl_name'].":<br />
	<input type='text' name='tpl_name' size='50' maxlenght='50' value='".htmlspecialchars(stripslashes($t['tpl_name']))."'".$ro." /><br />
	".$alang_ar['tmpl_desc'].":<br />
	<textarea name='tpl_description' style='width:800px;height:50px;'".$ro.">".htmlspecialchars(stripslashes($t['tpl_description']))."</textarea><br>
	".$alang_ar['tmpl'].":<br />
	<textarea name=\"tpl_source\" id=\"tpl_source\" style=\"width:800px;height:600px;\">".stripslashes($t['tpl_source'])."</textarea><br />
	<!--<input type=\"submit\" value=' - ".$alang_ar['save']." - ' />-->
	<input type=\"button\" value=' - ".$alang_ar['save']." - ' onclick=\"$('#tpl_source').val(editAreaLoader.getValue('tpl_source'));doLoad('TMPLForm','sRes')\" /><span id='sRes'></div>
	</form>";
	initializeEditor("earea");
	addEditAreaToField("tpl_source");
}
//---------------------------------------------------------------
if(!isset($_REQUEST['act'])||$_REQUEST['act']=="main"){
	$gar = array();
	$q="SELECT tpl_group FROM ".$_conf['prefix']."template Group BY tpl_group ORDER BY tpl_group";
	$r = $db -> Execute($q);
	while(!$r->EOF){
		$t = $r -> GEtRowAssoc();
		$gar[] = $t['TPL_GROUP'];
		$r -> MoveNext();
	}
	echo "<h2>".$alang_ar['tmpl_list']."</h2>";
	echo "<table border='0' cellspacing='2' class='selrow'>";
	echo "<tr>
	 <th>".$alang_ar['edit']."</th>
	 <th>".$alang_ar['tmpl_name']."</th>
	 <th>".$alang_ar['tmpl_desc']."</th>";
	if($_SESSION['USER_GROUP']=="super") echo "<th>".$alang_ar['delete']."</th>";
	 echo "</tr>";
	reset($gar);
	while(list($k,$v)=each($gar)){
		$r = $db -> Execute("SELECT tpl_id,tpl_name,tpl_description FROM ".$_conf['prefix']."template WHERE tpl_group='$v' ORDER BY tpl_name");
		echo "<tr bgcolor='#FFEAD5'><th colspan='4'>$v</th></tr>";
		while(!$r->EOF){
			$t = $r -> GetRowAssoc(false);
			echo "<tr bgcolor='#eeeeee'>
			<td><a href='admin.php?p=".$p."&act=edit&tpl_id=".$t['tpl_id']."'><img src='$_conf[admin_tpl_dir]img/edit.png' width='16' height='16' border='0' alt='".$alang_ar['tmpl_edit']."' /></a></td>
			<td>$t[tpl_name]</td>
			<td>".stripslashes($t['tpl_description'])."</td>";
			if($_SESSION['USER_GROUP']=="super") echo "<td><a href='admin.php?p=".$p."&act=delete&tpl_id=".$t['tpl_id']."' onclick=\"if(!confirm('".$alang_ar['tmpl_del1']."')||!confirm('".$alang_ar['tmpl_del2']."')) return false\"><img src='".$_conf['admin_tpl_dir']."img/delit.png' width='16' height='16' alt='".$alang_ar['delete']."' border='0' /></a></td>";
			echo "</tr>";
			$r -> MoveNext();
		}
	}
	 echo "</table>";
}


?>
