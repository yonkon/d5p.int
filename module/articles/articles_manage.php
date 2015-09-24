<?php
/**
 * Управление статьями сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010 
 * @link http://shiftcms.net
 * @version 1.00
 */

$smarty -> assign("modSet", "articles");

$smarty -> assign("PAGETITLE","<h2><a href=\"admin.php?p=".$p."\">".$lang_ar['art_title']."</a> : <a href=\"admin.php?p=".$p."&act=add_form\">".$lang_ar['add']."</a></h2>");

//----------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="addReview"){
	if(trim($_REQUEST['r_title'])==""){
		echo msg_box($lang_ar['art_er1']);
	}else{
		$q = "insert into ".$_conf['prefix']."articles set 
		r_dadd='".time()."',
		r_wadd='".$_SESSION['USER_IDU']."',
		r_source='".mysql_real_escape_string($_REQUEST['r_source'])."',
		r_title='".mysql_real_escape_string($_REQUEST['r_title'])."',
		r_avtor='".mysql_real_escape_string($_REQUEST['r_avtor'])."',
		r_abstract='".mysql_real_escape_string($_REQUEST['r_abstract'])."',
		r_content='".mysql_real_escape_string($_REQUEST['r_content'])."'
		";
		$r = $db -> Execute($q);
		echo msg_box($lang_ar['art_ok1']);
	}
	unset($_REQUEST['act']);
}

/* ************************************************************ */
if(isset($_REQUEST['act']) && $_REQUEST['act']=="add_form"){
	echo "<h2>".$lang_ar['art_add']."</h2><br />";
	initializeEditor($_conf['arteditor']);
	echo '<div id="tabs">';
	echo '<form method="post" id="aRF" enctype="multipart/form-data" action="admin.php?p='.$p.'&act=addReview">';
		echo "
		<span><strong>".$lang_ar['art_tit'].":*</strong></span><br />
		<input type='text' name='r_title' id='r_title' style='width:700px;' maxlenght='255' value='' /><br />
		<span><strong>".$lang_ar['art_avtor'].":</strong></span><br />
		<input type='text' name='r_avtor' id='r_avtor' style='width:400px;' maxlenght='255' value='' /><br />
		<span><strong>".$lang_ar['art_anons'].":</strong></span><br />
		<textarea name='r_abstract' id='r_abstract' style='width:700px;height:80px;'></textarea><br />
		<span><strong>".$lang_ar['art_txt'].":*</strong></span><br />";
		$cfield = 'r_content';
		if($_conf['arteditor'] == "tiny"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addTinyToField($cfield);
		}elseif($_conf['arteditor'] == "fck"){
			addFCKToField($cfield, '', 'Default', '900', '600');
		}elseif($_conf['arteditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['arteditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120"></textarea><br />';
		}
		
		echo '<span><strong>'.$lang_ar['art_src'].':</strong></span><br />
		<input type="text" name="r_source" id="r_source" style="width:400px;" maxlenght="255" value="" /><br />';
		echo "<br /><input type='submit' value='".$lang_ar['add']."' style='width:200px;' />
		</form>";
	echo '</div><br />';

	
}
//--------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="updReview"){
	if(trim($_REQUEST['r_title'])==""){
		echo msg_box($lang_ar['art_er1']);
	}else{
		$q = "update ".$_conf['prefix']."articles set 
		r_dedit='".time()."',
		r_wedit='".$_SESSION['USER_IDU']."',
		r_source='".mysql_real_escape_string($_REQUEST['r_source'])."',
		r_title='".mysql_real_escape_string($_REQUEST['r_title'])."',
		r_avtor='".mysql_real_escape_string($_REQUEST['r_avtor'])."',
		r_abstract='".mysql_real_escape_string($_REQUEST['r_abstract'])."',
		r_content='".mysql_real_escape_string($_REQUEST['r_content'])."'
		where r_id='".$_REQUEST['r_id']."'";
		$r = $db -> Execute($q);
		echo msg_box($lang_ar['art_ok2']);
	}
	unset($_REQUEST['act']);
}
//------------ВИДАЛЕННЯ ВИЮРАНОЇ НОВИНИ----------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="delReview"){
	$q = "DELETE FROM `".$_conf['prefix']."articles` WHERE `r_id`='".$_REQUEST['r_id']."'";
	$r = $db -> Execute($q);
	echo msg_box($lang_ar['art_ok3']);
	unset($_REQUEST['act']);
}
//-----------РЕДАГУВАННЯ ВИБРАНОЇ НОВИНИ------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="edit_form"){
	$r = $db -> Execute("select * from ".$_conf['prefix']."articles where r_id='".$_REQUEST['r_id']."'");
	$t = $r -> GetRowAssoc(false);
	initializeEditor($_conf['arteditor']);

	echo "<h2>".$lang_ar['art_edit']."</h2>";
	echo "<form action='admin.php?p=".$p."&act=updReview&r_id=".$t['r_id']."' method='post' enctype='multipart/form-data'>";
	echo '<div id="tabs">';
		echo "<span><strong>Заглавие:*</strong></span><br>
		<input type='text' name='r_title' id='r_title' style='width:700px;' maxlenght='255' value='".htmlspecialchars(stripslashes($t['r_title']))."' /><br>
		<span><strong>Автор:</strong></span><br />
		<input type='text' name='r_avtor' id='r_avtor' style='width:400px;' maxlenght='255' value='".htmlspecialchars(stripslashes($t['r_avtor']))."' /><br />
		<span><strong>Анонс:</strong></span><br />
		<textarea name='r_abstract' id='r_abstract' style='width:700px;height:80px;'>".htmlspecialchars(stripslashes($t['r_abstract']))."</textarea><br />
		<span><strong>Текст обзора (статьи):*</strong></span><br>";
		$cfield = 'r_content';
		if($_conf['arteditor'] == "no" || $_conf['arteditor'] == "") $cdata = htmlspecialchars(stripslashes($t[$cfield]));
		else $cdata = stripslashes($t[$cfield]);
		if($_conf['arteditor'] == "tiny"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$cdata.'</textarea><br />';
			addTinyToField($cfield);
		}elseif($_conf['arteditor'] == "fck"){
			addFCKToField($cfield, $cdata, 'Default', '900', '600');
		}elseif($_conf['arteditor'] == "ck"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$cdata.'</textarea><br />';
			addCKToField($cfield, 'Default', '900', '600');
		}elseif($_conf['arteditor'] == "earea"){
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$cdata.'</textarea><br />';
			addEditAreaToField($cfield);
		}else{
			echo '<textarea name="'.$cfield.'" id="'.$cfield.'" rows="30" cols="120">'.$cdata.'</textarea><br />';
		}
		echo '<span><strong>'.$lang_ar['art_src'].':</strong></span><br />
		<input type="text" name="r_source" id="r_source" style="width:400px;" maxlenght="255" value="'.htmlspecialchars(stripslashes($t['r_source'])).'" /><br />';
	echo '</div>';

	echo "<br />
	<input type=submit value=\"".$alang_ar['save']."\" style='width:200px;' />
	</form>";
}
//-----------------------------------------
if(!isset($_REQUEST['act'])){
	$interval = 50;
	if(!isset($_REQUEST['start'])) $start=0;
	else $start=$_REQUEST['start'];
	$q="SELECT SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."articles ORDER BY r_dadd DESC LIMIT ".$start.", ".$interval;
	$r = $db -> Execute($q);
	$r1 = $db -> Execute("select found_rows()");
	$t1 = $r1 -> GetRowAssoc(false);
	$all = $t1['found_rows()'];
	echo "<h1>".$lang_ar['art_title']."</h1>";
	$list_page=Paging($all,$interval,$start,"admin.php?p=".$p."&start=%start1%","");
	echo "<br />".$list_page;
	echo '<table border="0" cellspacing="0" cellpadding="0" class="selrow">';
	echo '<tr><th>ID</th><th>'.$lang_ar['art_date'].'</th><th>'.$lang_ar['art_avtor'].'</th><th>'.$lang_ar['art_tit'].'</th><th>'.$lang_ar['delete'].'</th></tr>';
	while(!$r->EOF) { 
		$t = $r -> GetRowAssoc(false);
		echo '<tr>
	    <td><a href="admin.php?p='.$p.'&act=edit_form&r_id='.$t['r_id'].'" title="'.$lang_ar['edit'].'">'.$t['r_id'].'</a></td>
	    <td><small>'.date("d.m.Y H:i",$t['r_dadd']).'</small></td>
		<td>'.stripslashes($t['r_avtor']).'</td>
		<td><a href="admin.php?p='.$p.'&act=edit_form&r_id='.$t['r_id'].'" title="'.$lang_ar['edit'].'">'.stripslashes($t['r_title']).'</a></td>
		<td><a href="admin.php?p='.$p.'&act=delReview&r_id='.$t['r_id'].'">'.$lang_ar['delete'].'</a></td>
	    </tr>';
		$r->MoveNext();
	}
	echo '</table>';
}




?>
