<?php
/**
 * Управление разделами форума из системы управления
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	12.10.2009
 */
if(!defined("SHIFTCMS")) exit;
$smarty -> assign("modSet", "forum");

//include("module/forum/forum_function.php");
	$fl = GetLangField();


$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['forum_a_title']."</a></h2>");
if(!isset($_REQUEST['parent_idf'])) $_REQUEST['parent_idf'] = '0';

reset($fl);
while(list($k1, $v1)=each($fl)){
	if(!isset($_REQUEST['fname_'.$k1])) $_REQUEST['fname_'.$k1] = '';
	if(!isset($_REQUEST['fdesc_'.$k1])) $_REQUEST['fdesc_'.$k1] = '';
}
if(!isset($_REQUEST['forder'])) $_REQUEST['forder'] = '';
/**
* Delete forum dection
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delete"){	
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum WHERE idf=".$_REQUEST['idf']." OR parent_idf=".$_REQUEST['idf']);
		while(!$r -> EOF){
			$t = $r -> GetRowAssoc(false);
			DeleteSection($t['idf']);
			$r -> MoveNext();
		}
		echo msg_box($alang_ar['forum_a_deleted']);
}

/**
* Create forum section
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="create"){	
//echo '<pre>'.print_r($_REQUEST,1).'</pre>';

	if(trim($_REQUEST['fname_'.$_conf['def_lang']])==""){
		echo msg_box($alang_ar['forum_a_er1']);
	}else{
		reset($fl); $keys = array(); $vals = array();
		while(list($k1, $v1)=each($fl)){
			$keys[] = ' fname_'.$k1.', fdesc_'.$k1;
			$vals[] = " '".mysql_real_escape_string(stripslashes($_REQUEST['fname_'.$k1]))."', '".mysql_real_escape_string(stripslashes($_REQUEST['fdesc_'.$k1]))."'"; 
		}
		if(isset($_REQUEST['idu']) && $_REQUEST['ftype']!="o"){
			$fuser = implode(",",$_REQUEST['idu']);
		}else $fuser = '';
		$q = "INSERT INTO ".$_conf['prefix']."forum (parent_idf, forder, ftype, fuser,".implode(",",$keys).")VALUES(
		'".mysql_real_escape_string(stripslashes($_REQUEST['parent_idf']))."',
		'".mysql_real_escape_string(stripslashes($_REQUEST['forder']))."', 
		'".mysql_real_escape_string(stripslashes($_REQUEST['ftype']))."',
		'".$fuser."',
		".implode(",",$vals).")";
		if($_REQUEST['parent_idf']!="0" && isset($_REQUEST['idu'])){
			$rp = $db -> Execute("select * from ".$_conf['prefix']."forum where idf=".$_REQUEST['parent_idf']);
			$tp = $rp -> GetRowAssoc(false);
			if($tp['fuser']!="") $tp_fuser = prepareUserForMainSection($tp['fuser'],$_REQUEST['idu']);
			else $tp_fuser = $fuser;
			$rpu = $db -> Execute("update ".$_conf['prefix']."forum set fuser='".$tp_fuser."' where idf=".$_REQUEST['parent_idf']);
		}
		//echo $q;
		$ri = $db -> Execute($q);
		echo msg_box($alang_ar['forum_a_ok1']);
	}

}
/**
* Update forum section
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="update"){	
	if(trim($_REQUEST['fname_'.$_conf['def_lang']])==""){
		echo msg_box("Укажите название раздела!");
	}else{
		reset($fl); $vals = array();
		while(list($k1, $v1)=each($fl)){
			$vals[] = "fname_".$k1."='".mysql_real_escape_string(stripslashes($_REQUEST['fname_'.$k1]))."', fdesc_".$k1."='".mysql_real_escape_string(stripslashes($_REQUEST['fdesc_'.$k1]))."'"; 
		}

		if(isset($_REQUEST['idu']) && $_REQUEST['ftype']!="o"){
			$fuser = implode(",",$_REQUEST['idu']);
		}else $fuser = '';
		$q = "UPDATE ".$_conf['prefix']."forum SET
		parent_idf='".stripslashes($_REQUEST['parent_idf'])."',
		forder='".stripslashes($_REQUEST['forder'])."',
		ftype='".stripslashes($_REQUEST['ftype'])."',
		fuser='".$fuser."',
		".implode(",",$vals)."
		WHERE idf=".$_REQUEST['idf'];
		//echo $q;
		if($_REQUEST['parent_idf']!="0" && isset($_REQUEST['idu'])){
			$rp = $db -> Execute("select * from ".$_conf['prefix']."forum where idf=".$_REQUEST['parent_idf']);
			$tp = $rp -> GetRowAssoc(false);
			if($tp['fuser']!="") $tp_fuser = prepareUserForMainSection($tp['fuser'],$_REQUEST['idu']);
			else $tp_fuser = $fuser;
			$rpu = $db -> Execute("update ".$_conf['prefix']."forum set 
			fuser='".$tp_fuser."' where idf=".$_REQUEST['parent_idf']);
		}
		$ri = $db -> Execute($q);
		echo msg_box($alang_ar['forum_a_ok2']);
	}
}

/**
* List forum section and add/edit section form
*/
  $q = "SELECT *,
  (select count(*) from ".$_conf['prefix']."forum_theme WHERE ".$_conf['prefix']."forum_theme.idf=".$_conf['prefix']."forum.idf) as ctheme,
  (select count(*) from ".$_conf['prefix']."forum_msg WHERE ".$_conf['prefix']."forum_msg.idf=".$_conf['prefix']."forum.idf) as cmsg
   FROM ".$_conf['prefix']."forum ORDER BY forder ASC";
  $r = $db -> Execute($q);
  $fs = $r -> GetAll();
  $newfs = array();
  $j = array();
  while(list($k, $v)=each($fs)){
  	if($v['parent_idf'] == 0){
		$newfs[$v['idf']][0] = $v;
	}else{
		if(isset($j[$v['parent_idf']])) $ind = $j[$v['parent_idf']];
		else $ind = $j[$v['parent_idf']] = 1;
		$newfs[$v['parent_idf']][$ind] = $v;
		$j[$v['parent_idf']] = $j[$v['parent_idf']] + 1;
	}
  }

	//echo "<pre>";
	//print_r($newfs);
	//echo "</pre>";
reset($newfs); $table = ""; 
$select = "<select name='parent_idf' id='parent_idf'><option value='0'> - ".$alang_ar['forum_a_firstsec']." - </option>";
$table .= "<table class='selrow'>";
		$table .= "<tr>
		<th>".$alang_ar['edit']."</th>
		<th>".$alang_ar['forum_a_order']."</th>
		<th>".$alang_ar['forum_a_section']."</th>
		<th>".$alang_ar['forum_a_themes']."</th>
		<th>".$alang_ar['forum_a_msgs']."</th>
		<th>".$alang_ar['delete']."</th>
		</tr>";
while(list($k,$v)=each($newfs)){
	asort($v);
	while(list($k1,$v1)=each($v)){
		if($k1==0){
			if($v1['idf']==$_REQUEST['parent_idf']) $select .= "<option value='".$v1['idf']."' selected='selected'>".$v1['fname_'.$_conf['def_lang']]."</option>";
			else $select .= "<option value='".$v1['idf']."'>".$v1['fname_'.$_conf['def_lang']]."</option>";
		}
		$row = $k1==0 ? "<tr class='high'>" : "<tr>";
		$table .= $row;
		$ident = $v1['parent_idf']==0 ? '' : ' style="padding-left:30px;"';
		$table .= "<td><a href='admin.php?p=".$p."&act=edit&idf=".$v1['idf']."&parent_idf=".$v1['parent_idf']."'><img src='".$_conf['admin_tpl_dir']."img/edit.png' width='16' height='16' border='0' alt='".$alang_ar['edit']."' /></a></td>
		<td>".stripslashes($v1['forder'])."</td>
		<td".$ident."><strong>".stripslashes($v1['fname_'.$_conf['def_lang']])."</strong><br /><small>".stripslashes($v1['fdesc_'.$_conf['def_lang']])."</small></td>
		<td>".stripslashes($v1['ctheme'])."</td>
		<td>".stripslashes($v1['cmsg'])."</td>
		<td><a href='admin.php?p=".$p."&act=delete&idf=".$v1['idf']."' onclick=\"if(!confirm('".$alang_ar['ainf_msg4']."')||!confirm('".$alang_ar['ainf_msg5']."')) return false\"><img src='".$_conf['admin_tpl_dir']."img/delit.png' width='16' height='16' alt='".$alang_ar['delete']."' border='0' /></a></td>";
		$table .= "</tr>";
	}
}
$table .= "</table>"; $select .= "</select>";
/**
* edit section form
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="edit"){
	$re = $db -> Execute("SELECT * FROM ".$_conf['prefix']."forum WHERE idf='".$_REQUEST['idf']."'");
	$te = $re -> GetRowAssoc(false);
	echo "<div class='blockf' style='padding:5px;'>";
	echo "<h3>".$alang_ar['forum_a_editsec']."</h3>";
	echo "<form method='post' action='admin.php' enctype='multipart/form-data'>";
	echo "<input type='hidden' name='p' id='p' value='forum_manage' />";
	echo "<input type='hidden' name='act' id='act' value='update' />";
	echo "<input type='hidden' name='idf' id='idf' value='".$_REQUEST['idf']."' />";
	echo $alang_ar['forum_a_selsec'].":<br />".$select."<br />";
	echo "<strong>".$alang_ar['forum_a_order'].":</strong> <input type='text' name='forder' id='forder' value='".stripslashes($te['forder'])."' size='10' /><br />";
	
	$chk_o = $chk_c = $chk_s = '';
	if($te['ftype']=="o") { $chk_o = ' checked="checked" '; $disp = 'none';}
	if($te['ftype']=="c") { $chk_c = ' checked="checked" '; $disp = 'block';}
	if($te['ftype']=="s") { $chk_s = ' checked="checked" '; $disp = 'block';}
		$fuser_str = '';
	if($te['fuser']!=""){
		$fu = explode(",",$te['fuser']);
		while(list($k,$v)=each($fu)){
			$ui = GetUserName($v);
			$fuser_str .= '<span id="su'.$v.'"><input type="hidden" name="idu['.$v.']" id="idu['.$v.']" value="'.$v.'" /><strong>'.stripslashes($ui['FIO']).'</strong> (login: '.stripslashes($ui['LOGIN']).', idu: '.$v.') (<a href="javascript:void(null)" onclick="delelem(\'su'.$v.'\')">Видалити</a>)<br /></span>';
		}
	}
	echo '<strong>'.$lang_ar['forum_ftype'].':</strong><br />
<input type="radio" name="ftype" id="ftype1" value="o" '.$chk_o.' onclick="document.getElementById(\'selUser\').style.display=\'none\'" /> '.$lang_ar['forum_ftype_o'].'<br />
<input type="radio" name="ftype" id="ftype2" value="c" '.$chk_c.' onclick="document.getElementById(\'selUser\').style.display=\'block\'" /> '.$lang_ar['forum_ftype_c'].'<br />
<input type="radio" name="ftype" id="ftype3" value="s" '.$chk_s.' onclick="document.getElementById(\'selUser\').style.display=\'block\'" /> '.$lang_ar['forum_ftype_s'].'<br />';
echo '<div id="selUser" class="block" style="display:'.$disp.';">
'.$lang_ar['forum_ftype_sel'].': 
<input type="text" name="sText" id="sText" value="" size="30" onkeyup="if(this.value.length>1) getdata(\'\',\'post\',\'?p=forum_action&act=SearchUsers&sText=\'+this.value,\'searchResArea\');" /><br />
<div id="searchResArea"></div>
<div id="selUsers" class="blockf"><strong>'.$lang_ar['forum_ftype_selected'].'</strong><br />'.$fuser_str.'</div>
</div><br />';
	
	echo '<div id="tabs">';
		echo '<ul>';
		reset($fl); $i=1; 
		while(list($k,$v)=each($fl)){echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';	$i++;}
		echo '</ul>';
		reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';
		echo $alang_ar['forum_a_secname'].":<br /><input type='text' name='fname_".$k."' id='fname_".$k."' value='".htmlspecialchars(stripslashes($te['fname_'.$k]))."' size='70' /><br />";	
		echo $alang_ar['forum_a_secdesc'].":<br /><textarea name='fdesc_".$k."' id='fdesc_".$k."' style='width:400px;height:60px;' />".htmlspecialchars(stripslashes($te['fdesc_'.$k]))."</textarea><br />";
		
		echo '</div>';

		$i++;
	}
	echo '</div>';
	echo '
	<script type="text/javascript">
		var ft=new ddtabcontent("formtabs")
		ft.setpersist(true)
		ft.setselectedClassTarget("link")
		ft.init()
	</script>
	';
	echo "<input type='submit' value='".$alang_ar['save']."' />";
	echo "</form><br />";
	echo "</div>";
	$HEADER = '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	';

/**
* create section form
*/
} else {

	echo '<a href="javascript:void(null)" style="padding:5px;" onclick="SwitchShow(\'ASA\')"><strong>'.$alang_ar['forum_a_seccreate'].'</strong></a>';
	echo "<div class='blockf' style='padding:5px; display:none;' id='ASA'>";
	
	echo "<h3>".$alang_ar['forum_a_seccreate']."</h3>";
	
echo "<form method='post' action='admin.php' enctype='multipart/form-data'>";
echo "<input type='hidden' name='p' id='p' value='forum_manage' />";
echo "<input type='hidden' name='act' id='act' value='create' />";
echo $alang_ar['forum_a_selsec'].":<br />".$select."<br />";
echo "<strong>".$alang_ar['forum_a_order'].":</strong> <input type='text' name='forder' id='forder' value='".htmlspecialchars(stripslashes($_REQUEST['forder']))."' size='10' /><br />";

echo '<strong>'.$lang_ar['forum_ftype'].':</strong><br />
<input type="radio" name="ftype" id="ftype1" value="o" checked="checked" onclick="document.getElementById(\'selUser\').style.display=\'none\'" /> '.$lang_ar['forum_ftype_o'].'<br />
<input type="radio" name="ftype" id="ftype2" value="c" onclick="document.getElementById(\'selUser\').style.display=\'block\'" /> '.$lang_ar['forum_ftype_c'].'<br />
<input type="radio" name="ftype" id="ftype3" value="s" onclick="document.getElementById(\'selUser\').style.display=\'block\'" /> '.$lang_ar['forum_ftype_s'].'<br />';
echo '<div id="selUser" class="block" style="display:none;">
'.$lang_ar['forum_ftype_sel'].': 
<input type="text" name="sText" id="sText" value="" size="30" onkeyup="if(this.value.length>1) getdata(\'\',\'post\',\'?p=forum_action&act=SearchUsers&sText=\'+this.value,\'searchResArea\');" /><br />
<div id="searchResArea"></div>
<div id="selUsers" class="blockf"><strong>'.$lang_ar['forum_ftype_selected'].'</strong><br /></div>
</div><br />';

	echo '<div id="tabs">';
		echo '<ul>';
		reset($fl); $i=1; 
		while(list($k,$v)=each($fl)){echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';	$i++;}
		echo '</ul>';
		reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<div id="tabs-'.$i.'">';
		echo $alang_ar['forum_a_secname'].":<br /><input type='text' name='fname_".$k."' id='fname_".$k."' value='".htmlspecialchars(stripslashes($_REQUEST['fname_'.$k]))."' size='70' /><br />";	
		echo $alang_ar['forum_a_secdesc'].":<br /><textarea name='fdesc_".$k."' id='fdesc_".$k."' style='width:400px;height:60px;' />".htmlspecialchars(stripslashes($_REQUEST['fdesc_'.$k]))."</textarea><br />";		
		echo '</div>';
		$i++;
	}
	echo '</div>';
	echo "<input type='submit' value='".$alang_ar['save']."' />";
	echo "</form><br />";
	echo "</div>";
	$HEADER = '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#tabs").tabs();
	});
	</script>
	';
}

	echo "<p>".$alang_ar['forum_a_alert']."</p>";
	echo $table;

$HEADER .= '<script type="text/javascript" src="'.$_conf['www_patch'].'/'.$_conf['tpl_dir'].'forum/forum.js"></script>';
?>