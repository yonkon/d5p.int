<?php
/**
 * Скрипт для управления меню внутри системы управления
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00 14.11.2009
 * 14.11.2009 - переделаны функции SecList, OutList таким образом, что они используют только один запрос к базе
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=admin_menu'>".$alang_ar['amn_title']."</a></h2>");

$fl = GetLangField();
//==============РЕДАКТИРОВАНИЕ ИНФОРМАЦИИ О СТРАНИЦЕ============================
		$gr = $db->Execute("SELECT * FROM ".$_conf['prefix']."user_group ORDER BY group_code");
		$glist=array();
		while (!$gr->EOF) { 
			$gt=$gr->GetRowAssoc(false);
			$gc = $gt['group_code'];
			$glist[$gc] = $gt['group_name'];
			$gr->MoveNext(); 
		}

if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit"){
	$rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."admin_menu WHERE mid='$_REQUEST[mid]'");
	if($rs->RecordCount()!=0){
		$tmp=$rs->GetRowAssoc();
		$gvalue=explode(",",$tmp['PUNKT_GROUPS']);
		$g_check = create_check($glist,$gvalue,"punkt_groups","");
		  $q="SELECT * FROM ".$_conf['prefix']."admin_menu ORDER BY punkt_order";
		  $r = $db -> Execute($q);
		  $all = $r -> GetAll();
		
		$pparent_list = "<select name='punkt_parent' id='punkt_parent'><option value=''>".$alang_ar['amn_newsection']."</option>".SecList($all,0,0,$tmp['PUNKT_PARENT'], '')."</select>";
		
		echo "<div class='block'>
		<table border='0' cellspacing='1'>
       <tr>
		<td colspan='4'>
		<h3>".$alang_ar['edit']."</h3>
		<form action='' method='post'>";
		echo '<table border="0" cellspacing="0" class="selrow">';
		echo '<tr><th>&nbsp;</th>';
			reset($fl);
			while(list($k1, $v1)=each($fl)){		 
				echo '<th>'.strtoupper($v1).' <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v1.'.gif" /></th>';
			}
		echo '</tr>';
		
			reset($fl);
		echo '<tr><td>'.$alang_ar['amn_name'].':</td>';
			while(list($k1, $v1)=each($fl)){		 
				echo "<td><input type='text' name='punkt_name_".$k1."' value='".$tmp['PUNKT_NAME_'.strtoupper($k1).'']."' size='50' /></td>";
			}
		echo '</tr></table>';
		$ico = $_conf['www_patch'].'/'.$_conf['admin_tpl_dir'].'img/menu/'.stripslashes($tmp['PUNKT_ICO']);
		$ico_img = ' &nbsp; <img src="'.$ico.'" />';
		echo $alang_ar['amn_link'].": <input type='text' name='punkt_link' value='$tmp[PUNKT_LINK]' size='50' />
		".$alang_ar['amn_icon'].": <input type='text' name='punkt_ico' value='".$tmp['PUNKT_ICO']."' size='20' />".$ico_img."<br />
		".$alang_ar['amn_order'].": <input type='text' name='punkt_order' value='$tmp[PUNKT_ORDER]' size='5' /> 
		".$alang_ar['amn_parent'].": $pparent_list<br />
		<strong>".$alang_ar['amn_group'].":</strong><br />
		$g_check<br />
		<input type='hidden' name='act' value='save' /><input type='hidden' name='p' value='$p' />
		<input type='hidden' name='mid' value='$_REQUEST[mid]' />
		<input type='submit' value='".$alang_ar['save']."' />
		</form>
		</td>
		</tr>
		</table></div>";
	}
 unset($_REQUEST['act']);
}
//================ОБНОВЛЕНИ ИНФОРМАЦИИ О СТРАНИЦЕ=====================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save"){
		if(trim($_REQUEST['punkt_parent'])!=''){
			$pparent=$_REQUEST['punkt_parent'];
		}else{
			$pparent='0';
		}
	$pgroups = isset($_REQUEST['punkt_groups']) ? implode(",",$_REQUEST['punkt_groups']) : '';
		reset($fl); $vals = '';
		while(list($k1, $v1)=each($fl)){		 
			$vals .= ", `punkt_name_".$k1."`='".mysql_real_escape_string(stripslashes($_REQUEST['punkt_name_'.$k1]))."'";
		}
	$q="UPDATE `".$_conf['prefix']."admin_menu` SET
	`punkt_parent`='$pparent', `punkt_order`='".$_REQUEST['punkt_order']."',
	`punkt_link`='".mysql_real_escape_string(stripslashes($_REQUEST['punkt_link']))."',
	punkt_groups='$pgroups',
	punkt_ico='".mysql_real_escape_string(stripslashes($_REQUEST['punkt_ico']))."'
	".$vals." WHERE `mid`='$_REQUEST[mid]'";
	$ms = $db->Execute($q);
	add_to_log($q,"fortrans");
	echo msg_box($alang_ar['saved']);
	unset($_REQUEST['act']);
}
//================ДОБАВЛЕНИЕ НОВОЙ СТРАНИЦЫ==========================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="add"){
		if(trim($_REQUEST['punkt_parent'])!=''){
			$pparent = $_REQUEST['punkt_parent'];
		}else{
			$pparent = '0';
		}
		$pgroups = implode(",",$_REQUEST['punkt_groups']);
		reset($fl); $keys = $vals = '';
		while(list($k1, $v1)=each($fl)){		 
			$keys .= ', punkt_name_'.$k1;
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['punkt_name_'.$k1]))."'";
		}
		$q="INSERT INTO ".$_conf['prefix']."admin_menu(mid,punkt_parent,punkt_order,punkt_link,punkt_groups,punkt_ico".$keys.")
		VALUES('','$pparent','$_REQUEST[punkt_order]',
		'$_REQUEST[punkt_link]','$pgroups',
		'".mysql_real_escape_string(stripslashes($_REQUEST['punkt_ico']))."'
		".$vals.")";
		$ms = $db->Execute($q);
	add_to_log($q,"fortrans");
		echo msg_box($alang_ar['saved']);
	unset($_REQUEST['act']);
}
//===============УДАЛЕНИЕ СТРАНИЦЫ================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delete"){
	if($_REQUEST['type']=="0"){
		$q="DELETE FROM ".$_conf['prefix']."admin_menu WHERE mid='".$_REQUEST['mid']."' OR punkt_parent='".$_REQUEST['mid']."'";
		$ms = $db->Execute($q);
	}else{
		$q="DELETE FROM ".$_conf['prefix']."admin_menu WHERE mid='".$_REQUEST['mid']."'";
		$ms = $db->Execute($q);
	}
	add_to_log($q,"fortrans");
	echo msg_box($alang_ar['amn_deleted']);
	unset($_REQUEST['act']);
}

//--------------ВЫВОД СПИСКА СТРАНИЦ И ФОРМЫ ДОБАВЛЕНИЯ СТРАНИЦЫ-----------
if(!isset($_REQUEST['act'])){
		  $q="SELECT * FROM ".$_conf['prefix']."admin_menu ORDER BY punkt_order";
		  $r = $db -> Execute($q);
		  $all = $r -> GetAll();

		$gvalue=array();
		$g_check = create_check($glist,$gvalue,"punkt_groups","");
	$pparent_list = "<select name='punkt_parent' id='punkt_parent'><option value=''>".$alang_ar['amn_newsection']."</option>".SecList($all, 0, 0, '', '')."</select>";

	echo "<div class='block'>
	<form action='' method='post'>
	<tr>
	<td colspan='5'>
	<strong><a href='javascript:void(null)' onclick=\"SwitchShow('addmenuform');\">Добавить пункт меню</a></strong>
	<div id='addmenuform' style='display:none'>";
		echo '<table border="0" cellspacing="0" class="selrow">';
		echo '<tr><th>&nbsp;</th>';
			reset($fl);
			while(list($k1, $v1)=each($fl)){		 
				echo '<th>'.strtoupper($v1).' <img src="'.$_conf['admin_tpl_dir'].'flags/'.$v1.'.gif" /></th>';
			}
		echo '</tr>';
		
			reset($fl);
		echo '<tr><td>'.$alang_ar['amn_name'].':</td>';
			while(list($k1, $v1)=each($fl)){		 
				echo "<td><input type='text' name='punkt_name_".$k1."' value=\"\" size='50' /></td>";
			}
		echo '</tr></table>';
	echo $alang_ar['amn_link'].": <input type='text' name='punkt_link' value='' size='50' />
	".$alang_ar['amn_icon'].": <input type='text' name='punkt_ico' value='' size='20' /><br />
	".$alang_ar['amn_order'].": <input type='text' name='punkt_order' value='' size='5' /> 
	".$alang_ar['amn_parent'].": $pparent_list<br />
	<strong>".$alang_ar['amn_group'].":</strong><br />
	$g_check<br />
	<input type='hidden' name='act' value='add' /><input type='hidden' name='p' value='$p' />
	<input type='submit' value='".$alang_ar['save']."' />
	</div>
	</td>
	</tr></table></form></div>";

	echo "<div style='padding-left:20px;'><table border='0' width='100%' cellspacing='0' class='selrow' id='PageListTab'>";
	echo "<thead><tr>
	<th>".$alang_ar['amn_name']."</th>
	<th>".$alang_ar['amn_order']."</th>
	<th>".$alang_ar['amn_link']."</th>
	<th>".$alang_ar['amn_group']."</th>
	<th>&nbsp;</th>
	</tr></thead><tbody>";

echo OutList($all, 0, 0);

echo "</tbody></table>";
}


/* *********************************************************************** */
/* **************************************************************** */
function SecList($all, $punkt_parent, $level, $curmid, $sel){
	global $db, $_conf;
  reset($all);
  $fill = str_repeat("-", $level*3);
  while(list($k,$v)=each($all)){
  	if($v['punkt_parent']==$punkt_parent){
      if($curmid==$v['mid']) $sel.="<option  class='tbg".$level."' value='".$v['mid']."' selected='selected'> ".$fill." ".$v['punkt_name_'.$_conf['def_admin_lang']]."</option>";
      else $sel.="<option  class='tbg".$level."' value='".$v['mid']."'> ".$fill." ".$v['punkt_name_'.$_SESSION['admin_lang']]."</option>";
	  $sel = SecList($all,$v['mid'], $level+1, $curmid, $sel);
	}
  }
	return $sel;		
}
/* ************************************************************** */
function OutList($all,$punkt_parent, $level, $node=null){
	global $db, $_conf, $p;
	$tab = '';
	$fill = str_repeat("&nbsp;", $level*6);
	reset($all);
  while(list($k,$v)=each($all)){
  if($v['punkt_parent']==$punkt_parent){
	$treetab = 'id="ex0-node-'.$v['punkt_parent']."-".$v['mid'].'" class="child-of-ex0-node-'.$node.'"';
		$ico = $_conf['www_patch'].'/'.$_conf['admin_tpl_dir'].'img/menu/'.stripslashes($v['punkt_ico']);
		$ico_img = ' &nbsp; <img src="'.$ico.'" />';
     echo "<tr ".$treetab.">
	 <td>".$fill." ".$ico_img." <a href='".$_SERVER['PHP_SELF']."?p=".$p."&act=edit&mid=".$v['mid']."'><strong>".stripslashes($v['punkt_name_'.$_SESSION['admin_lang']])."</strong></a></td>
	 <td>".$fill." ".$v['punkt_order']."</td>
	 <td>".$v['punkt_link']."</td>
	 <td>".$v['punkt_groups']."</td>
	 <td><a href='".$_SERVER['PHP_SELF']."?p=".$p."&act=delete&type=0&mid=".$v['mid']."' onclick=\"if(!confirm('Удалить пункт меню?')||!confirm('Вы точно уверены? После удаления восстановить раздел будет невозможно!')) return false\"><img src='".$_conf['admin_tpl_dir']."img/delit.png' width='16' height='16' alt='Удалить' border='0' /></a></td>
	 </tr>";
	 $tab .= OutList($all,$v['mid'], $level+1, $v['punkt_parent']."-".$v['mid']);
  }
  }
  return $tab;		
}

$HEADER .= <<<EOT
	<link href="$_conf[www_patch]/$_conf[admin_tpl_dir]css/jquery.acts_as_tree_table.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="$_conf[www_patch]/js/jquery/external/jquery.acts_as_tree_table.js"></script> 
	<script type="text/javascript">
		$(document).ready(function(){
			$("#PageListTab").acts_as_tree_table({
				default_state: 'expanded',
				indent: 20
			});
		} ); 
	</script>
EOT;
?>
