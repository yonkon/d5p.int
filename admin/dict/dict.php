<?php
if((isset($_REQUEST['act']) && !isset($_SERVER['HTTP_REFERER'])) || !defined('SHIFTCMS')){
	exit;
}

$smarty -> assign("PAGETITLE","<h2>Справочники</h2>");

if(!isset($_REQUEST['act'])){
	echo "<div class='block'>";
	echo "<a href='javascript:void(null)' onclick=\"getdata('','post','?p=dict&act=base&type=brand','WorkArea'); document.getElementById('EditArea').innerHTML='';\">Brand</a>";
	//echo " | <a href='javascript:void(null)' onclick=\"getdata('','post','?p=dict&act=base&type=pay_supp','WorkArea'); document.getElementById('EditArea').innerHTML='';\">Способы оплаты поставщику</a>";
	echo " | <a href='javascript:void(null)' onclick=\"getdata('','post','?p=dict&act=base&type=pay_client','WorkArea'); document.getElementById('EditArea').innerHTML='';\">Способы оплаты клиентом</a>";
	//echo " | <a href='javascript:void(null)' onclick=\"getdata('','post','?p=dict&act=base&type=delivery_supp','WorkArea'); document.getElementById('EditArea').innerHTML='';\">Доставка от поставщика</a>";
	echo " | <a href='javascript:void(null)' onclick=\"getdata('','post','?p=dict&act=base&type=delivery_client','WorkArea'); document.getElementById('EditArea').innerHTML='';\">Доставка клиенту</a>";
	//echo " | <a href='javascript:void(null)' onclick=\"getdata('','post','?p=dict&act=base&type=delivery_city','WorkArea'); document.getElementById('EditArea').innerHTML='';\">Города</a>";

    echo "</div>
	<table border='0'><tr>
	<td>
		<div id='WorkArea'></div>
		<br /><br />
		<div id='EditArea'></div>
	</td>
	<td>
		<div id='SecondArea'></div>
	</td>
	</tr></table>
	";
}


if(isset($_REQUEST['act']) && $_REQUEST['act']=="base"){
	$type = $_REQUEST['type'];
	$fl = GetLangField();
	if($type == "brand") $title = "Brand";
	if($type == "pay_supp") $title = "Способы оплаты поставщику";
	if($type == "pay_client") $title = "Способы оплаты клиентом";
	if($type == "delivery_supp") $title = "Доставка от поставщика";
	if($type == "delivery_client") $title = "Доставка клиенту";
	if($type == "delivery_city") $title = "Города";

	echo "<h3>$title</h3>";
	echo "<form action='javascript:void(null)' enctype='multipart/form-data' id='AddBaseForm' method='post' class='blockf'>
	<input type='hidden' name='p' id='p' value='dict' />
	<input type='hidden' name='act' id='act' value='AddBaseItem' />
	<input type='hidden' name='type' id='type' value='".$type."' />
	<strong>".$lang_ar['add'].":</strong><br />";
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<th>'.strtoupper($v1).' <img src="'.$_conf['tpl_dir'].'flags/'.$v1.'.gif" /></th>';
	}
	echo '</tr>';
	echo '<tr>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<td><input type="text" name="'.$k1.'" id="'.$k1.'" value="" style="width:200px;" /></td>';
	}
	echo '</tr>';
	echo '</table>';
	echo "
	<input type='button' value='".$lang_ar['add']."' onclick=\"doLoad('AddBaseForm','SubWorkArea')\" />
	</form><br /><br />";
	echo OutBaseForm($type);
}
/**
*
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="AddBaseItem"){

	$type = $_REQUEST['type'];
	if(trim($_REQUEST[$_conf['def_lang']])==''){
		echo msg_box("Введите текст!");
	}else{
		$fl = GetLangField(); $fq = array(); $dq = array();
		reset($fl);
		while(list($k1, $v1)=each($fl)){	
			$fq[$k1] = $k1;
			$dq[$k1] = "'".mysql_real_escape_string(stripslashes($_REQUEST[$k1]))."'";
		}
		$q = "INSERT INTO ".$_conf['prefix']."dict_".$type." (".implode(",",$fq).") 
		VALUE (".implode(",",$dq).")";
		$r = $db -> Execute($q);
		echo msg_box("Новая запись добавлена в справочник!");
	}
	echo OutBaseForm($type);
}
/**
*
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="DelBaseItem"){
	$type = $_REQUEST['type'];
		$q = "DELETE FROM ".$_conf['prefix']."dict_".$type." WHERE id='".$_REQUEST['id']."'";
		$r = $db -> Execute($q);
		echo msg_box("Запись удалена из справочника!");
	echo OutBaseForm($type);
}
/**
*
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="EditBaseItem"){
	$type = $_REQUEST['type'];
		$q = "SELECT * FROM ".$_conf['prefix']."dict_".$type." WHERE id='".$_REQUEST['id']."'";
		$r = $db -> Execute($q);
		$t = $r -> GetRowAssoc(false);
		$fl = GetLangField();
	echo "<form action='javascript:void(null)' enctype='multipart/form-data' id='UpdateBaseForm' method='post' class='blockf'>
	<input type='hidden' name='p' id='p' value='dict' />
	<input type='hidden' name='act' id='act' value='UpdateBaseItem' />
	<input type='hidden' name='type' id='type' value='".$type."' />
	<input type='hidden' name='id' id='id' value='".$t['id']."' />
	<strong>Изменить:</strong><br />";
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<th>'.strtoupper($v1).' <img src="'.$_conf['tpl_dir'].'flags/'.$v1.'.gif" /></th>';
	}
	echo '</tr>';
	echo '<tr>';
	reset($fl);
	while(list($k1, $v1)=each($fl)){		 
		echo '<td><input type="text" name="'.$k1.'" id="'.$k1.'" value="'.htmlspecialchars(stripslashes($t[$k1])).'" style="width:200px;" /></td>';
	}
	echo '</tr>';
	echo '</table>';

	echo "<input type='button' value='".$lang_ar['save']."' onclick=\"doLoad('UpdateBaseForm','SubWorkArea')\" />
	</form>";
}
/**
*
*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="UpdateBaseItem"){
	$type = $_REQUEST['type'];
	if(trim($_REQUEST[$_conf['def_lang']])==''){
		echo msg_box("Введите текст!");
	}else{
		$fl = GetLangField(); $dq = array();
		reset($fl);
		while(list($k1, $v1)=each($fl)){	
			$dq[] = $k1."='".mysql_real_escape_string(stripslashes($_REQUEST[$k1]))."'";
		}
		$q = "UPDATE ".$_conf['prefix']."dict_".$type." SET ".implode(",",$dq)." WHERE id='".$_REQUEST['id']."'";
		$r = $db -> Execute($q);
		echo msg_box("Запись обновлена!");
	}
	echo OutBaseForm($type);
}


/* *************************************** */
function outBaseForm($type){
	global $db, $_conf, $lang_ar;
	$opt_list = GetBaseDictList($type);
	echo "<div id='SubWorkArea'>
	<form action='javascript:void(null)' enctype='multipart/form-data' id='AddBaseForm' method='post' class='blockf'>
	<strong>Выбрать и ...</strong><br />
	<select name='id' id='id' style='width:200px;'>
	$opt_list
	</select>
	<input type='hidden' name='act' id='act' value='AddBaseItem' />
	<input type='button' value='".$lang_ar['edit']."' onclick=\"getdata('', 'post', '?p=dict&act=EditBaseItem&type=$type&id=' + document.getElementById('id').value, 'EditArea')\" /> <strong>или</strong> 
	<input type='button' value='".$lang_ar['delete']."' onclick=\"getdata('', 'post', '?p=dict&act=DelBaseItem&type=$type&id=' + document.getElementById('id').value, 'SubWorkArea')\" />
	</form>
	</div>";

}
/* *************************************** */
function GetBaseDictList($type){
	global $db, $_conf;
	$opt_list = "";
	$q = "SELECT * FROM ".$_conf['prefix']."dict_".$type." ORDER BY ".$_conf['def_lang'];
	//echo $q; exit;
	$r = $db -> Execute($q);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$opt_list .= "<option value='".$t['id']."'>".stripslashes($t[$_conf['def_lang']])."</option>";
		$r -> MoveNext();
	}
	return $opt_list;
}
?>