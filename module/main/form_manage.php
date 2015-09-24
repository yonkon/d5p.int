<?php
/**
 * Создание форм, просмотр данных...
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012
 * @link http://shiftcms.net
 * @version 1.00 23.03.2012
 */
if(!defined("SHIFTCMS")) exit;

	$smarty -> assign("PAGETITLE","<h2><a href='".$_SERVER['PHP_SELF']."?p=".$p."'>".$lang_ar['af_title']."</a></h2>");

if(!isset($_REQUEST['act'])){
	
	$r = $db -> Execute("select * from ".$_conf['prefix']."form");
	$forms = '';
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		if($t['f_save']=="y") $dd = '&nbsp;-&nbsp; (<a href="admin.php?p='.$p.'&act=viewData&idf='.$t['idf'].'">'.$lang_ar['af_data'].'</a>)';
		else $dd = '';
		$delf = ' &nbsp; - &nbsp;<a href="javascript:void(null)" onclick="delForm(\''.$t['idf'].'\')" title="'.$lang_ar['delete'].'"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" /></a>';
		$forms .= '<span id="SAF'.$t['idf'].'"><a href="javascript:void(null)" onclick="openEditForm(\''.$t['idf'].'\')" id="AF'.$t['idf'].'">'.stripslashes($t['name']).'</a>'.$dd.$delf.'<br /></span>';
		$r -> MoveNext();
	}
	
	echo '<table border="0" cellspacing="10"><tr>
	<td valign="top" width="300">
		<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p='.$p.'&act=newForm\',\'WA\'); $(\'#WAF\').html(\'\'); $(\'#PREVIEW\').html(\'\');"><strong>'.$lang_ar['create_form'].'</strong></a><br /><br />
		<div id="FormList">'.$forms.'</div>
		<br />
		<div id="WA"></div>
	</td>
	<td valign="top" width="300">
		<div id="WAF"></div>
	</td>
	<td valign="top" width="300">
		<div id="PREVIEW"></div>
	</td>
	</tr></table>';

	$HEADER .= '<script type="text/javascript" src="'.$_conf['www_patch'].'/js/form.js"></script>';	
}
/* форма добавления новой формы */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="newForm"){
	echo '<div class="blockf">
	<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="NFF">
	<strong>'.$lang_ar['af_name'].'</strong><br />
	<input type="text" name="name" id="name" size="55" value="" /><br /><br />
	<input type="checkbox" name="f_save" id="f_save" value="y" /> <strong>'.$lang_ar['af_savedb'].'</strong><br /><br />
	<input type="checkbox" name="f_send" id="f_send" value="y" onclick="if(this.checked==true) ShowObject(\'feml\'); else HideObject(\'feml\');" /> <strong>'.$lang_ar['af_sendeml'].'</strong><br /><br />
	<span id="feml" style="display:none;">
		<strong>'.$lang_ar['f_email'].'</strong><br />
		<input type="text" name="f_email" id="f_email" size="35" value="" /><br /><br />
	</span>
	<strong>'.$lang_ar['af_succmsg'].'</strong><br />
	<textarea name="f_msg" id="f_msg" style="width:200px;height:50px;"></textarea><br /><br />
	<input type="submit" value="'.$lang_ar['save'].'" onclick="sendNewForm()" /> &nbsp; <span id="NFFLoad"></span>
	</form>
	</div>';
}
/* сохраняем новую форму */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="sendNewForm"){
	$js = array(); $js['state'] = "OK"; $js['msg'] = '';
	$f_save = isset($_REQUEST['f_save']) ? 'y' : 'n';
	$f_send = isset($_REQUEST['f_send']) ? 'y' : 'n';
	$f_email = $f_send=='y' ? mysql_real_escape_string(stripslashes($_REQUEST['f_email'])) : '';
	$r = $db -> Execute("insert into ".$_conf['prefix']."form set
	name='".mysql_real_escape_string(stripslashes($_REQUEST['name']))."',
	dadd='".time()."',
	uadd='".$_SESSION['USER_IDU']."',
	f_save='".$f_save."',
	f_send='".$f_send."',
	f_email='".$f_email."',
	f_msg='".mysql_real_escape_string(stripslashes($_REQUEST['f_msg']))."'
	");
	$idf = $db -> Insert_ID();
	$js['idf'] = $idf;
	$js['name'] = stripslashes($_REQUEST['name']);
	$GLOBALS['_RESULT'] = $js;
}
/*форма редактирования формы*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="editForm"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."form where idf='".$_REQUEST['idf']."'");
	$t = $r -> GetRowAssoc(false);
	$f_save = $t['f_save']=='y' ? ' checked="checked"' : '';
	$f_send = $t['f_send']=='y' ? ' checked="checked"' : '';
	$feml_displ = $t['f_send']=='y' ? 'block' : 'none';
	echo '<div class="blockf">
	<form method="post" action="javascript:void(null)" enctype="multipart/form-data" id="NFF">
	<input type="hidden" name="idf" id="idf" value="'.$t['idf'].'" />
	<strong>'.$lang_ar['af_name'].'</strong><br />
	<input type="text" name="name" id="name" size="55" value="'.htmlspecialchars(stripslashes($t['name'])).'" /><br /><br />
	<input type="checkbox" name="f_save" id="f_save" value="y"'.$f_save.' /> <strong>'.$lang_ar['af_savedb'].'</strong><br /><br />
	<input type="checkbox" name="f_send" id="f_send" value="y"'.$f_send.' onclick="if(this.checked==true) ShowObject(\'feml\'); else HideObject(\'feml\');" /> <strong>'.$lang_ar['af_sendeml'].'</strong><br /><br />
	<span id="feml" style="display:'.$feml_displ.';">
		<strong>'.$lang_ar['f_email'].'</strong><br />
		<input type="text" name="f_email" id="f_email" size="35" value="'.htmlspecialchars(stripslashes($t['f_email'])).'" /><br /><br />
	</span>
	<strong>'.$lang_ar['af_succmsg'].'</strong><br />
	<textarea name="f_msg" id="f_msg" style="width:200px;height:50px;">'.stripslashes($t['f_msg']).'</textarea><br /><br />
	<input type="submit" value="'.$lang_ar['save'].'" onclick="updForm()" /> &nbsp; <span id="NFFLoad"></span>
	</form>
	</div>';
}
/* обновляем существующую форму */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="updForm"){
	$js = array(); $js['state'] = "OK"; $js['msg'] = '';
	$f_save = isset($_REQUEST['f_save']) ? 'y' : 'n';
	$f_send = isset($_REQUEST['f_send']) ? 'y' : 'n';
	$f_email = $f_send=='y' ? mysql_real_escape_string(stripslashes($_REQUEST['f_email'])) : '';
	$r = $db -> Execute("update ".$_conf['prefix']."form set
	name='".mysql_real_escape_string(stripslashes($_REQUEST['name']))."',
	dedit='".time()."',
	uedit='".$_SESSION['USER_IDU']."',
	f_save='".$f_save."',
	f_send='".$f_send."',
	f_email='".$f_email."',
	f_msg='".mysql_real_escape_string(stripslashes($_REQUEST['f_msg']))."'
	WHERE idf='".$_REQUEST['idf']."'");
	$js['idf'] = $_REQUEST['idf'];
	$js['name'] = stripslashes($_REQUEST['name']);
	$GLOBALS['_RESULT'] = $js;
}
/*форма редактирования полей формы*/
if(isset($_REQUEST['act']) && $_REQUEST['act']=="editFieldForm"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."form_field where idf='".$_REQUEST['idf']."' order by f_order");
	$ff = '';
	while(!$r->EOF){
		$t = $r -> GetRowAssoc(false);
		$delf = ' &nbsp; - &nbsp;<a href="javascript:void(null)" onclick="delField(\''.$t['id'].'\')" title="Удалить поле"><img src="'.$_conf['admin_tpl_dir'].'img/delit.png" /></a>';
		$ff .= '<span id="SFF'.$t['id'].'"><a href="javascript:void(null)" onclick="loadFieldToEdit(\''.$t['id'].'\')" id="FF'.$t['id'].'">'.stripslashes($t['f_label']).'</a>'.$delf.'<br /></span>';
		$r -> MoveNext();
	}
	echo '<div class="blockf"><h3>'.$lang_ar['af_fieldlist'].':</h3><br /><div id="FieldList">'.$ff.'</div><br /><hr />
	<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=form_manage&act=previewForm&idf='.$_REQUEST['idf'].'\',\'PREVIEW\')"><strong>'.$lang_ar['af_preview'].'</strong></a><br />
	<a href="javascript:void(null)" onclick="openEditFieldForm(\''.$_REQUEST['idf'].'\')">'.$lang_ar['af_addfield'].'</a>
	</div>';
	echo '<div class="blockf">
	<form method="post" enctype="multipart/form-data" action="javascript:void(null)" id="FieldForm">
	<input type="hidden" name="idf" id="idf" value="'.$_REQUEST['idf'].'" />
	<input type="hidden" name="id" id="id" value="-1" />
	<h3>'.$lang_ar['af_ae_field'].'</h3><br />
	<strong>'.$lang_ar['af_f_order'].'</strong><br />
	<input type="text" name="f_order" id="f_order" size="8" /><br />
	<strong>'.$lang_ar['af_f_type'].'</strong><br />
	<select name="f_type" id="f_type" onchange="specType(this.value)">
		<option value="text">Text</option>
		<option value="textarea">Textarea</option>
		<option value="select">Select</option>
		<option value="radio">Radiobutton</option>
		<option value="checkbox">Checkbox</option>
	</select><br />
	<strong>'.$lang_ar['af_f_label'].'</strong><br />
	<small>'.$lang_ar['af_namehint'].'</small><br />
	<input type="text" name="f_name" id="f_name" size="20" maxlength="20" /><br />
	<strong>'.$lang_ar['af_fieldsign'].'</strong><br />
	<input type="text" name="f_label" id="f_label" size="30" /><br />
	<input type="checkbox" name="f_req" id="f_req" value="y" onclick="if(this.checked==true) ShowObject(\'frq\'); else HideObject(\'frq\');" /> <strong>'.$lang_ar['af_f_req'].'</strong><br />
	<span id="frq" style="display:none;"><strong>'.$lang_ar['af_f_reqalert'].'</strong><br />
	<input type="text" name="f_req_alert" id="f_req_alert" size="30" /><br /></span>
	<strong>'.$lang_ar['af_f_init_val'].'</strong><br />
	<input type="text" name="f_init_val" id="f_init_val" size="20" /><br />
	<span id="datalist" style="display:none;">
	<strong>'.$lang_ar['af_f_list'].'</strong><br />
	<small>'.$lang_ar['af_flisthint'].'Значения в виде пар: ключ:значение, разделенных запятой, напр.: key1:label1,key2:label2 ...</small><br />
	<textarea name="f_list" id="f_list" style="width:200px; height:50px;"></textarea><br />
	</span>
	<input type="button" value="'.$lang_ar['save'].'" onclick="saveField()" /> &nbsp; <span id="FLoad"></span>
	</form>
	</div>';
}
/* сохраняем поле формы */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="saveField"){
	$js = array(); $js['state']="OK";$js['msg']='';
	$f_req = isset($_REQUEST['f_req']) ? 'y' : 'n';
	if($_REQUEST['id']=="-1"){
		$r = $db -> Execute("insert into ".$_conf['prefix']."form_field set
		idf='".$_REQUEST['idf']."',
		f_order='".mysql_real_escape_string(stripslashes($_REQUEST['f_order']))."',
		f_type='".mysql_real_escape_string(stripslashes($_REQUEST['f_type']))."',
		f_name='".mysql_real_escape_string(stripslashes($_REQUEST['f_name']))."',
		f_req='".$f_req."',
		f_init_val='".mysql_real_escape_string(stripslashes($_REQUEST['f_init_val']))."',
		f_list='".mysql_real_escape_string(stripslashes($_REQUEST['f_list']))."',
		f_label='".mysql_real_escape_string(stripslashes($_REQUEST['f_label']))."',
		f_req_alert='".mysql_real_escape_string(stripslashes($_REQUEST['f_req_alert']))."'
		");
		$js['id'] = $db -> Insert_ID();
		$js['jsact'] = 'add';
	}else{
		$r = $db -> Execute("update ".$_conf['prefix']."form_field set
		idf='".$_REQUEST['idf']."',
		f_order='".mysql_real_escape_string(stripslashes($_REQUEST['f_order']))."',
		f_type='".mysql_real_escape_string(stripslashes($_REQUEST['f_type']))."',
		f_req='".$f_req."',
		f_init_val='".mysql_real_escape_string(stripslashes($_REQUEST['f_init_val']))."',
		f_list='".mysql_real_escape_string(stripslashes($_REQUEST['f_list']))."',
		f_label='".mysql_real_escape_string(stripslashes($_REQUEST['f_label']))."',
		f_req_alert='".mysql_real_escape_string(stripslashes($_REQUEST['f_req_alert']))."'
		where id='".$_REQUEST['id']."'
		");
		$js['id'] = $_REQUEST['id'];
		$js['jsact'] = 'upd';
	}
	$js['f_label'] = stripslashes($_REQUEST['f_label']);
	//$js['msg'] = print_r($_REQUEST,1);
	$GLOBALS['_RESULT'] = $js;
}
/* сохраняем поле формы */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="loadFieldToEdit"){
	$js = array(); $js['state']="OK";$js['msg']='';
	$r = $db -> Execute("select * from ".$_conf['prefix']."form_field where id='".$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
	while(list($k,$v)=each($t)) $t[$k] = stripslashes($v);
	$js['data'] = $t;
	$GLOBALS['_RESULT'] = $js;
}
/* Предварительный просмотр формы */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="previewForm"){
	echo '<div class="blockf">'.buildForm($_REQUEST['idf']).'</div>';
}

/* Просмотр данных введенных в форму */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="viewData"){
	if(isset($_REQUEST['start'])) $start = $_REQUEST['start'];
	else $start = 0;
	$interval = 20;

		$q="SELECT SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."form_data WHERE idf='".$_REQUEST['idf']."' ORDER BY fdate desc LIMIT ".$start.", ".$interval;
		$r = $db->Execute($q);
	
		$r1 = $db->Execute("select found_rows()");
		$t1 = $r1 -> GetRowAssoc(false);
		$all = $t1['found_rows()'];
		$list_page=Paging($all,$interval,$start,"admin.php?p=$p&act=viewData&idf=".$_REQUEST['idf']."&start=%start1%","");

		if($r -> RecordCount() > 0){
			echo "<strong>Всего $all записей</strong>";
			echo $list_page;
			echo "<table border='0' cellspacing='0' class='selrow' width='100%'>
			<th>".$lang_ar['fba_date']."</th><th>".$lang_ar['af_data']."</th><th>".$lang_ar['delete']."</th></tr>";
			while (!$r -> EOF) { 
				$t = $r -> GetRowAssoc(false);
			    echo "<tr id='FTR".$t['idd']."'>";
				echo "<td>".date("d.m.Y H:i", $t['fdate'])."</td>
				<td>".stripslashes($t['fmsg'])."</td>
				<td align='center' style='border-right:solid 1px #cccccc;'><a href='javascript:void(null)' onclick=\"getdata('','post','?p=form_manage&act=delData&idd=".$t['idd']."','ActionRes'); delelem('FTR".$t['idd']."')\"><img src='$_conf[admin_tpl_dir]img/delit.png' width='16' height='16' alt='".$alang_ar['delete']."' border='0' /></a></td>";
		    	echo "</tr>";
				$r->MoveNext();
			}
			echo "</table>";
			echo $list_page;
		}else{
			echo "<strong>".$lang_ar['fba_msg1']."</strong>";
		}
}
/* Удаление данных */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delData"){
	$r = $db -> Execute("delete from ".$_conf['prefix']."form_data where idd='".$_REQUEST['idd']."'");
	echo msg_box($lang_ar['af_recdel']);
}
/* Удаление формы */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delForm"){
	$js = array(); $js['state']="OK";$js['msg']='';
	$r = $db -> Execute("delete from ".$_conf['prefix']."form_data where idf='".$_REQUEST['idf']."'");
	$r = $db -> Execute("delete from ".$_conf['prefix']."form_field where idf='".$_REQUEST['idf']."'");
	$r = $db -> Execute("delete from ".$_conf['prefix']."form where idf='".$_REQUEST['idf']."'");
	$js['msg'] = $lang_ar['af_formdel'];
	$GLOBALS['_RESULT'] = $js;
}
/* Удаление поля формы */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="delField"){
	$js = array(); $js['state']="OK";$js['msg']='';
	$r = $db -> Execute("delete from ".$_conf['prefix']."form_field where id='".$_REQUEST['id']."'");
	$js['msg'] = $lang_ar['af_fielddel'];
	$GLOBALS['_RESULT'] = $js;
}
?>