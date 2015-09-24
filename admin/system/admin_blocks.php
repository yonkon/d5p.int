<?php
/**
 * Управление выводом блоков на страницах сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.01
 * 04.12.2010 - добавлена возможность выбора редактора или его отключения
 */
if(!defined("SHIFTCMS")) exit;

$smarty -> assign("PAGETITLE","<h2><a href='admin.php?p=".$p."'>".$alang_ar['abl_title']."</a> : <a href='admin.php?p=".$p."&act=addForm'>".$alang_ar['abl_add_title']."</a></h2>");
$bed_array = array('no'=>'не использовать','ck'=>'ckeditor','fck'=>'FCKeditor', 'earea'=>'EditArea');

//================Форма редактирвоания блока==========================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="save"){
	$er = 0;
	if(trim($_REQUEST['block_name'])==""){
		echo msg_box($lang_ar['asys_bempty']);
		$er = 1;
	}
	if($er == 0){
		$fl = GetLangField();
		reset($fl); $keys = $vals = '';
		while(list($k1, $v1)=each($fl)){		 
			$vals .= ", content_".$v1."='".mysql_real_escape_string(stripslashes($_REQUEST['content_'.$v1]))."'"; 
		}
		$q = "UPDATE ".$_conf['prefix']."blocks SET
		block_name='".mysql_real_escape_string(stripslashes($_REQUEST['block_name']))."',
		block_file='".mysql_real_escape_string(stripslashes($_REQUEST['block_file']))."',
		block_description='".mysql_real_escape_string(stripslashes($_REQUEST['block_description']))."',
		btype='".mysql_real_escape_string(stripslashes($_REQUEST['psource']))."',
		beditor='".mysql_real_escape_string(stripslashes($_REQUEST['beditor']))."'
		".$vals." WHERE block_id='".(int)$_REQUEST['block_id']."'";
		$ms = $db->Execute($q);
		//echo $q;
	}
	if($er == 1){
		$_REQUEST['act'] = "edit";
	}else{
		add_to_log($q,"fortrans");
		echo msg_box($alang_ar['abl_added']);
		unset($_REQUEST['act']);
	}
}

//==============РЕДАКТИРОВАНИЕ ИНФОРМАЦИИ О СТРАНИЦЕ============================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit"){
	$rs = $db->Execute("SELECT * FROM ".$_conf['prefix']."blocks WHERE block_id='".$_REQUEST['block_id']."'");
	if($rs->RecordCount()!=0){
		$t = $rs -> GetRowAssoc(false);
		$fl = GetLangField();
		$ps1 = $ps2 = $ps3 = ''; $psf = $psc = "none";
		if($t['btype']=="file"){
			$ps1 = ' checked="checked"';
			$psf = "block";
		}
		if($t['btype']=="combi"){
			$ps3 = ' checked="checked"';
			$psf = $psc = "block";
		}
		if($t['btype']=="base"){
			$ps2 = ' checked="checked"';
			$psc = "block";
		}
		$bed = create_select($bed_array, $t['beditor'], "beditor", "");
		$editor = $t['beditor'];
		
	echo "<div class='block'>
	<form action='admin.php?p=".$p."&act=save&block_id=".$t['block_id']."' method='post'>

	<div id='addblockform'>
	<strong>".$alang_ar['abl_code']."</strong>:<br /><input type='text' name='block_name' id='block_name' value='".htmlspecialchars(stripslashes($t['block_name']))."' size='50' /> <br />
	<strong>".$alang_ar['abl_desc']."</strong>:<br /><input type='text' name='block_description' id='block_description' value='".htmlspecialchars(stripslashes($t['block_description']))."' size='100' /><br /><br />
	<strong>Редактор:</strong> ".$bed."<br /><br />

	<strong>".$lang_ar['asys_ptype'].":</strong><br />
	<input type='radio' name='psource' id='ps1' value='file' onclick='SwitchPField(this)'".$ps1." /> ".$lang_ar['asys_ps1']."<br />
		<div id='PSF' style='display:".$psf.";'>
		<strong>".$alang_ar['abl_file']."</strong>:<br /><input type='text' name='block_file' id='block_file' value='".htmlspecialchars(stripslashes($t['block_file']))."' size='50' />
		</div>
	<input type='radio' name='psource' id='ps3' value='combi' onclick='SwitchPField(this)'".$ps3." /> ".$lang_ar['asys_ps3']."<br />
	<input type='radio' name='psource' id='ps2' value='base' onclick='SwitchPField(this)'".$ps2." /> ".$lang_ar['asys_ps2']."<br />";

	echo '<br /><div id="tabs"><ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';

	initializeEditor($editor);

	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
	
		echo '<div id="tabs-'.$i.'">';

		echo "<div id='PSC_".$k."' class='tinyarea' style='display:".$psc.";'>
		<strong>".$alang_ar['ainf_content']."</strong><br />";
		$cfield = 'content_'.$k;

		if($editor == "no" || $editor == "") $t[$cfield] = htmlspecialchars(stripslashes($t[$cfield]));
		else $t[$cfield] = stripslashes($t[$cfield]);

		if($editor == "fck"){
			addFCKToField($cfield, $t[$cfield], 'Default', '700', '300');
		}elseif($editor == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$t[$cfield].'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '400');
		}elseif($editor == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$t[$cfield].'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$t[$cfield].'</textarea><br />';
		}
		echo '</div>';
		echo '</div>';

		$i++;
	}

	echo '</div>';
	$HEADER .= '
	<script type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
	';
	echo "<input type='submit' value='".$lang_ar['save']."' style='width:200px;' />
	</div>

	</form></div>";
	}
}
//================ДОБАВЛЕНИЕ НОВОЙ СТРАНИЦЫ==========================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="add"){
	$er = 0;
	if(trim($_REQUEST['block_name'])==""){
		echo msg_box($lang_ar['asys_bempty']);
		$er = 1;
	}
	if($er == 0){
		$fl = GetLangField();
		reset($fl); $keys = $vals = '';
		while(list($k1, $v1)=each($fl)){		 
			$keys .= ',content_'.$v1;
			$vals .= ", '".mysql_real_escape_string(stripslashes($_REQUEST['content_'.$v1]))."'"; 
		}
		$q = "INSERT INTO ".$_conf['prefix']."blocks(block_name,block_file,block_description,btype,beditor".$keys.") VALUES	('".mysql_real_escape_string(stripslashes($_REQUEST['block_name']))."','".mysql_real_escape_string(stripslashes($_REQUEST['block_file']))."','".mysql_real_escape_string(stripslashes($_REQUEST['block_description']))."','".mysql_real_escape_string(stripslashes($_REQUEST['psource']))."','".mysql_real_escape_string(stripslashes($_REQUEST['beditor']))."'".$vals.")";
		$ms = $db->Execute($q);
		//echo $q;
	}
	if($er == 1){
		$_REQUEST['act'] = "addForm";
	}else{
		add_to_log($q,"fortrans");
		echo msg_box($alang_ar['abl_added']);
		unset($_REQUEST['act']);
	}
}
/**
* Форма добавления блока
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="addForm"){
	$fl = GetLangField();
	$bed = create_select($bed_array, "no", "beditor", "");
	echo "<div class='block'>
	<form action='admin.php?p=".$p."&act=add' method='post'>
	<table border='0' cellspacing='0'>
	<tr><td colspan='6'>
	<div id='addblockform'>
	<strong>".$alang_ar['abl_code'].":</strong><br /><input type='text' name='block_name' id='block_name' value='' size='50' /> <br />
	<strong>".$alang_ar['abl_desc'].":</strong><br /><input type='text' name='block_description' id='block_description' value='' size='100' /><br /><br />
	
	<strong>Редактор:</strong> ".$bed."<br /><br />

	<strong>".$lang_ar['asys_ptype'].":</strong><br />
	<input type='radio' name='psource' id='ps1' value='file' onclick='SwitchPField(this)' /> ".$lang_ar['asys_ps1']."<br />
		<div id='PSF' style='display:none;'>
		<strong>".$alang_ar['abl_file']."</strong>:<br /><input type='text' name='block_file' id='block_file' value='' size='50' />
		</div>
	<input type='radio' name='psource' id='ps3' value='combi' onclick='SwitchPField(this)' /> ".$lang_ar['asys_ps3']."<br />
	<input type='radio' name='psource' id='ps2' value='base' checked='checked' onclick='SwitchPField(this)' /> ".$lang_ar['asys_ps2']."<br />";

	echo '<br /><div id="tabs"><ul>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<li><a href="#tabs-'.$i.'" rel="formtab'.$i.'">'.strtoupper($k).'</a></li>';
			$i++;
		}
	echo '</ul>';

		initializeEditor("ck");

	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
	
		echo '<div id="tabs-'.$i.'" class="tabcontent">';

		echo "<div id='PSC_".$k."' class='tinyarea' style='display:block;'>
		<strong>".$alang_ar['ainf_content']."</strong><br />";
		$cfield = 'content_'.$k;
		
		echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
		addCKToField($cfield);

		echo '</div></div>';

		$i++;
	}

	echo '</div>';
	$HEADER .= '
	<script type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
	';
	echo "<input type='submit' value='".$alang_ar['abl_addbut']."' style='width:200px;' />
	</div>
	</td>
	</tr></table>
	</form></div>";
}
//===============УДАЛЕНИЕ СТРАНИЦЫ================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delete"){
	$br = $_REQUEST['block_name'];
	$q = "update ".$_conf['prefix']."page set page_blocks=REPLACE(page_blocks,',$br',''), page_blocks=REPLACE(page_blocks,'$br,','')";
	$r = $db -> Execute($q);
		$q="DELETE FROM ".$_conf['prefix']."blocks WHERE block_id='$_REQUEST[block_id]'";
		$ms = $db->Execute($q);
	add_to_log($q,"fortrans");
	echo msg_box($alang_ar['abl_deleted']);
	unset($_REQUEST['act']);
}
//--------------ВЫВОД СПИСКА СТРАНИЦ И ФОРМЫ ДОБАВЛЕНИЯ СТРАНИЦЫ-----------
if(!isset($_REQUEST['act'])){
	echo "<table border='0' width='100%' cellspacing='0' class='selrow'>";
	echo "<tr bgcolor='#eeeeee'>
	<th>".$alang_ar['abl_name']."</th>
	<th>".$alang_ar['abl_file']."</th>
	<th>".$alang_ar['abl_desc']."</th>
	<th>".$alang_ar['abl_plist']."</th>
	<th>&nbsp;</th>
	</tr>";

$ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."blocks ORDER BY block_name");
while (!$ms->EOF) { 
	$tmp=$ms->GetRowAssoc();
	echo "<tr>
	<td><a href='admin.php?p=$p&act=edit&block_id=".$tmp['BLOCK_ID']."'><strong>".stripslashes($tmp['BLOCK_NAME'])."</strong></a></td>
	<td>".$tmp['BLOCK_FILE']."</td>
	<td>".$tmp['BLOCK_DESCRIPTION']."</td>
	<td><a title='".$alang_ar['abl_set']."' href='#' onClick=\"divwin=dhtmlwindow.open('PageListBox', 'inline', '', '".$alang_ar['abl_set']."', 'width=600px,height=500px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=admin_server&act=SetPageListForBlock&block_id=$tmp[BLOCK_ID]&block_name=$tmp[BLOCK_NAME]','PageListBox_inner'); return false; \">Настроить</a></td>
	<td><a href='$_SERVER[PHP_SELF]?p=$p&act=delete&block_id=$tmp[BLOCK_ID]&block_name=$tmp[BLOCK_NAME]' onclick=\"if(!confirm('".$alang_ar['abl_delblock1']."')||!confirm('".$alang_ar['abl_delblock2']."')) return false\">".$alang_ar['abl_del']."</a></td>
	</tr>";
	$ms->MoveNext(); 
}
echo "</table>";
}

$HEADER .= <<<EOT
	<script type="text/javascript">
		function SwitchPField(obj){
			if(obj.id=='ps1' && obj.checked==true){
				document.getElementById('PSF').style.display = 'block';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'none';
				}	
			}
			if(obj.id=='ps3' && obj.checked==true){
				document.getElementById('PSF').style.display = 'block';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'block';
				}	
			}
			if(obj.id=='ps2' && obj.checked==true){
				document.getElementById('PSF').style.display = 'none';
				var ob = getElementsByClass("tinyarea",null,'div');
				for(i=0;i<ob.length;i++){
					document.getElementById(ob[i].id).style.display = 'block';
				}	
			}
		}	
    </script>
EOT;

?>
