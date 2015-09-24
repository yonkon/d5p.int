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

$smarty -> assign("PAGETITLE","<h2>".$lang_ar['a_faq']." : <a href=\"admin.php?p=admin_faq&act=list\">".$lang_ar['a_faqlist']."</a><!-- : <a title='".$alang_ar['anews_catwindow']."' href='javascript:void(null)' onClick=\"divwin=dhtmlwindow.open('NCBox', 'inline', '', '".$alang_ar['anews_catwindow']."', 'width=750px,height=550px,left=50px,top=90px,resize=1,scrolling=1'); getdata('','get','?p=".$p."&act=CategoryWindow','NCBox_inner'); return false; \">".$lang_ar['anews_catwindow']."</a>--></h2>");
$smarty -> assign("modSet", "faq");

$q_state = array(
	'n'=>'<span style="color:red;">'.$lang_ar['a_faq_new'].'</span>',
	'o'=>'<span style="color:blue;">'.$lang_ar['a_faq_freeze'].'</span>',
	'y'=>'<span style="color:green;">'.$lang_ar['a_faq_show'].'</span>'
);
	$fl = isset($_SESSION['fl']) ? $_SESSION['fl'] : GetLangField();

//---------------------------------------------------------------
//--------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="update"){
	reset($fl);
	$val = array();
	while(list($k,$v)=each($fl)){
		$val[] = " q_quest_".$k." = '".mysql_real_escape_string(stripslashes($_REQUEST['q_quest_'.$k]))."', q_reply_".$k." = '".mysql_real_escape_string(stripslashes($_REQUEST['q_reply_'.$k]))."' ";
	}
	$q_st = isset($_REQUEST['q_state']) ? 'y' : 'o';
	$r = $db -> Execute("UPDATE ".$_conf['prefix']."faq SET
	q_state='".$q_st."',
	q_date1='".time()."',
	q_group='',
	".implode(", ", $val)."
	WHERE q_id='".$_REQUEST['q_id']."'
	");
	echo msg_box($lang_ar['a_faq_ok1']);
	$_REQUEST['act'] = "list";
}
//------------ВИДАЛЕННЯ ВИЮРАНОЇ НОВИНИ----------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delit"){
	$q = "DELETE FROM `".$_conf['prefix']."faq` WHERE `q_id`='".$_REQUEST['q_id']."'";
	$r = $db -> Execute($q);
	echo msg_box($lang_ar['a_faq_ok2']);
	$_REQUEST['act']="list";
}

//-----------РЕДАГУВАННЯ ВИБРАНОЇ НОВИНИ------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit_form"){
	reset($fl);
		$q = "SELECT * FROM ".$_conf['prefix']."faq WHERE q_id='".$_REQUEST['q_id']."'";
		$r = $db -> Execute($q);
	 	$t = $r -> GetRowAssoc(false);
	echo "<h4>".$lang_ar['edit']."</h4>";

	echo '<form action="admin.php" method="post" enctype="multipart/form-data" id="EQF">
	<span>'.$lang_ar['a_faq_adddate'].':</span> '.date("d.m.Y H:i",$t['q_date']).'<br /><br />';
	if($t['q_date1']!=0) echo '<span>'.$lang_ar['a_faq_datereply'].':</span> '.date("d.m.Y H:i",$t['q_date1']).'<br /><br />';
	$qshow = $t['q_state']=="y" ? ' checked="checked" ' : '';
	echo '<br /><input type="checkbox" id="q_state" name="q_state" value="y"'.$qshow.' /> '.$lang_ar['a_faq_switch'].'<br /><br />';
	
	initializeEditor($_conf['faq_editor']);

	echo '<br /><div id="tabs">';
	echo '<ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
		echo '<li><a href="#tabs-'.$i.'">'.strtoupper($k).'</a></li>';
		$i++;
	}
	echo '</ul>';
	reset($fl); $i=1;
	while(list($k,$v)=each($fl)){
	
		echo '<div id="tabs-'.$i.'">';

		echo '<span>'.$lang_ar['a_faq_question'].':</span><br>
		<textarea name="q_quest_'.$k.'" id="q_quest_'.$k.'" style="width:600px;height:50px;">'.stripslashes($t['q_quest_'.$k]).'</textarea><br /><br />
		<span>'.$lang_ar['a_faq_answer'].':</span><br>';
		$cfield = 'q_reply_'.$k;
		if($_conf['faq_editor'] == "no" || $_conf['faq_editor'] == "") $t['q_reply_'.$k] = htmlspecialchars($t['q_reply_'.$k]);
		if($_conf['faq_editor'] == "fck"){
			addFCKToField($cfield, $t['q_reply_'.$k], 'Default', '900', '600');
		}elseif($_conf['faq_editor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$t['q_reply_'.$k].'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['faq_editor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$t['q_reply_'.$k].'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$t['q_reply_'.$k].'</textarea><br />';
		}

		echo '</div>';

		$i++;
	}

	echo '</div>';

	echo "<br />
	<input type=hidden name=p value='".$p."'>
	<input type=hidden name=act value='update'>
	<input type=hidden name='q_id' id='q_id' value='".$t['q_id']."'>
	<input type=submit value=\"".$alang_ar['save']."\" style='width:200px;' />
	</form>";

	$HEADER .= '
	<script type="text/javascript" src="'.$_conf['www_patch'].'/js/jquery/ui/jquery.ui.tabs.js"></script>
	<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	</script>
	';
}
//-----------------------------------------
if(!isset($_REQUEST['act']) || $_REQUEST['act']=="list"){
	$interval = 30;
	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];
	$qn1="SELECT * FROM ".$_conf['prefix']."faq   ORDER BY q_date DESC";
	echo "<h1>".$lang_ar['a_faq']."</h1>";
	$qn = $qn1." LIMIT $start,$interval";

	$ms1 = $db->Execute($qn1);
	$ms = $db->Execute($qn);
	$all=$ms1->RecordCount(); // всего тем

	$list_page=Paging($all,$interval,$start,"admin.php?p=admin_faq&act=list&start=%start1%","");
	echo "<br />".$list_page;
	echo '<table border="0" cellspacing="0" cellpadding="0" class="selrow">';
	echo '<tr><th>ID</th><th>'.$lang_ar['a_faq_state'].'</th><th>'.$lang_ar['a_faq_issue'].'</th><th>'.$lang_ar['a_faq_question'].'</th><th>'.$lang_ar['a_faq_reply'].'</th><th>'.$lang_ar['a_faq_answer'].'</th><th>&nbsp;</th></tr>';
	while (!$ms->EOF) { 
		$t = $ms->GetRowAssoc(false);
		$q_date1 = $t['q_date1']==0 ? '' : date("d.m.Y H:i",$t['q_date1']);
		echo '<tr>
	    <td><a href="admin.php?p=admin_faq&act=edit_form&q_id='.$t['q_id'].'" title="'.$lang_ar['edit'].'">'.$t['q_id'].'</a></td>
	    <td><small>'.$q_state[$t['q_state']].'</small></td>
	    <td><small>'.date("d.m.Y H:i",$t['q_date']).'</small></td>
		<td>'.stripslashes($t['q_quest_'.$_SESSION['admin_lang']]).'</td>
	    <td><small>'.$q_date1.'</small></td>
		<td>'.substr(stripslashes($t['q_reply_'.$_SESSION['admin_lang']]),0,100).'...</td>
		<td><a href="admin.php?p=admin_faq&act=delit&q_id='.$t['q_id'].'">'.$lang_ar['delete'].'</a></td>
	    </tr>';
		$ms->MoveNext();
	}
	echo '</table>';
}

?>
