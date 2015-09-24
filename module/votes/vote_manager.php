<?php
/**
 * Управление опросами на сайте
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010 
 * @link http://shiftcms.net
 * @version 1.00.01	11.02.2010
 */
if(!defined("SHIFTCMS")) exit;

$links = ' | <a href="admin.php?p='.$p.'&act=VoteList"><strong>'.$lang_ar['vote_list'].'</strong></a> | ';
$links .= '<a href="admin.php?p='.$p.'&act=AddVoteForm"><strong>'.$lang_ar['vote_create'].'</strong></a> | ';
$smarty -> assign("PAGETITLE","<h2 style='display:inline'>".$lang_ar['vote_pagetitle'].":</h2> ".$links);

//================================================================
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="VoteDelit"){
		$q="delete from ".$_conf['prefix']."poll
		WHERE id='".$_REQUEST['id']."'";
		$r = $db -> Execute($q);
		echo msg_box($lang_ar['vote_msg1']);
   unset($_REQUEST['act']);
}


//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="SaveNewVote"){
	$fl = GetLangField();
	//echo "<pre>";
	//print_r($_REQUEST);
	//echo "</pre>";

	$type = $_REQUEST['votetype']=='r' ? 'r' : 'c';
	$show = isset($_REQUEST['voteshow']) ? 'y' : 'n';
	$single = isset($_REQUEST['votesingle']) ? 'y' : 'n';
	$com = isset($_REQUEST['votecom']) ? 'y' : 'n';
	$field = $data = array();
	reset($fl);
	while(list($k,$v)=each($fl)){
		$field[] = 'name_'.$k.', '.'desc_'.$k.', '.'quest_'.$k;
		$data[] = "'".mysql_real_escape_string(stripslashes($_REQUEST['name_'.$k]))."', ".
		"'".mysql_real_escape_string(stripslashes($_REQUEST['desc_'.$k]))."', ".
		"'".mysql_real_escape_string(stripslashes(serialize($_REQUEST['quest_'.$k])))."' "; 
	}
	   $q="insert into ".$_conf['prefix']."poll
	   (votetype, votesingle, voteshow, datecreated, enablecom, ".implode(",", $field).") VALUES (
	   '".$type."', 
	   '".$single."', 
	   '".$show."', 
	   '".time()."', 
	   '".$com."', 
	   ".implode(",", $data)."
	   )";
	   //echo $q;
		$r = $db -> Execute($q);
		echo msg_box($lang_ar['vote_msg2']);
	unset($_REQUEST['act']);
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="AddVoteForm"){
	$fl = GetLangField();

	echo "<h2>".$lang_ar['vote_create']."</h2>
	<form action='admin.php?p=".$p."&act=SaveNewVote' method='post'>
	<input type='checkbox' name='voteshow' id='voteshow' value='y' /> ".$lang_ar['vote_switch']."<br />
	<input type='checkbox' name='votesingle' id='votesingle' value='y' checked='checked' /> ".$lang_ar['vote_single']."<br />
	<input type='checkbox' name='votecom' id='votecom' value='y' checked='checked' /> ".$lang_ar['vote_com']."<br />
	<input type='radio' name='votetype' id='votetype_r' value='r' checked='checked' /> ".$lang_ar['vote_type_r']."
	&nbsp;&nbsp;
	<input type='radio' name='votetype' id='votetype_c' value='c' /> ".$lang_ar['vote_type_c']."<br /><br />
	<strong>".$lang_ar['vote_field'].":</strong><br />";
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr><th>№</th>';
	reset($fl); 
	$t_field = '<tr><th>'.$lang_ar['vote_name'].'</th>';
	$d_field = '<tr><th>'.$lang_ar['vote_desc'].'</th>';
	while(list($k1, $v1)=each($fl)){		 
		echo '<th>'.strtoupper($v1).' <img src="'.$_conf['tpl_dir'].'flags/'.$v1.'.gif" /></th>';
		$t_field .= '<td><input type="text" name="name_'.$k1.'" id="name_'.$k1.'" size="70" maxlenght="150" value="" /></td>';
		$d_field .= '<td><textarea name="desc_'.$k1.'" id="desc_'.$k1.'" style="width:370px;height:70px;"></textarea></td>';
	}
	echo '</tr>';
	$t_field .= '</tr>';
	$d_field .= '</tr>';
	echo $t_field.$d_field;
	for($j=1; $j<=15; $j++){
		echo '<tr><th>'.$j.'</th>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<td><input type="text" name="quest_'.$k.'['.$j.']" id="quest_'.$k.'['.$j.']" size="70" maxlenght="150" value="" /></td>';
			$i++;
		}
		echo '</tr>';
	}
	echo '</table>';

	echo "<br />
	<input type=submit value=\"".$alang_ar['save']."\">
	</form>";
}

//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="UpdateVote"){
	$fl = GetLangField();
	//echo "<pre>";
	//print_r($_REQUEST);
	//echo "</pre>";
	$type = $_REQUEST['votetype']=='r' ? 'r' : 'c';
	$show = isset($_REQUEST['voteshow']) ? 'y' : 'n';
	$single = isset($_REQUEST['votesingle']) ? 'y' : 'n';
	$com = isset($_REQUEST['votecom']) ? 'y' : 'n';
	$field = $data = array();
	reset($fl);
	while(list($k,$v)=each($fl)){
		$field[] = "name_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['name_'.$k]))."', 
		desc_".$k."='".mysql_real_escape_string(stripslashes($_REQUEST['desc_'.$k]))."', 
		quest_".$k."='".mysql_real_escape_string(stripslashes(serialize($_REQUEST['quest_'.$k])))."'";
	}
	   $q="update ".$_conf['prefix']."poll set
	   votetype='".$type."', 
	   votesingle='".$single."', 
	   voteshow='".$show."', 
	   enablecom='".$com."', 
	   ".implode(",", $field)."
	   WHERE id='".$_REQUEST['id']."'";
	   //echo $q;
		$r = $db -> Execute($q);
		echo msg_box($lang_ar['vote_msg3']);
	unset($_REQUEST['act']);
}
//---------------------------------------------------------------
if(isset($_REQUEST['act'])&&$_REQUEST['act']=="VoteEditForm"){
	$fl = GetLangField();
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."poll WHERE id='".(int)$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
	
	$show = $t['voteshow']=='y' ? 'checked="checked"' : '';
	$single = $t['votesingle']=='y' ? 'checked="checked"' : '';
	$com = $t['enablecom']=='y' ? 'checked="checked"' : '';
	$type_r = $t['votetype']=='r' ? 'checked="checked"' : '';
	$type_c = $t['votetype']=='c' ? 'checked="checked"' : '';

	echo "<h2>".$lang_ar['vote_edit']."</h2>
	<form action='admin.php?p=".$p."&act=UpdateVote&id=".(int)$_REQUEST['id']."' method='post'>
	<input type='checkbox' name='voteshow' id='voteshow' value='y' ".$show." /> ".$lang_ar['vote_switch']."<br />
	<input type='checkbox' name='votesingle' id='votesingle' value='y' ".$single." /> ".$lang_ar['vote_single']."<br />
	<input type='checkbox' name='votecom' id='votecom' value='y' ".$com." /> ".$lang_ar['vote_com']."<br />
	<input type='radio' name='votetype' id='votetype_r' value='r' ".$type_r." /> ".$lang_ar['vote_type_r']."&nbsp;&nbsp;
	<input type='radio' name='votetype' id='votetype_c' value='c' ".$type_c." /> ".$lang_ar['vote_type_c']."<br /><br />
	<strong>".$lang_ar['vote_field'].":</strong><br />";
	echo '<table border="0" cellspacing="0" class="selrow">';
	echo '<tr><th>№</th>';
	reset($fl); 
	$t_field = '<tr><th>'.$lang_ar['vote_name'].'</th>';
	$d_field = '<tr><th>'.$lang_ar['vote_desc'].'</th>';
	while(list($k1, $v1)=each($fl)){		 
		echo '<th>'.strtoupper($v1).' <img src="'.$_conf['tpl_dir'].'flags/'.$v1.'.gif" /></th>';
		$t_field .= '<td><input type="text" name="name_'.$k1.'" id="name_'.$k1.'" size="70" maxlenght="150" value="'.htmlspecialchars(stripslashes($t['name_'.$k1])).'" /></td>';
		$d_field .= '<td><textarea name="desc_'.$k1.'" id="desc_'.$k1.'" style="width:370px;height:70px;">'.htmlspecialchars(stripslashes($t['desc_'.$k1])).'</textarea></td>';
		$quest[$k1] = unserialize(stripslashes($t['quest_'.$k1]));
	}
	echo '</tr>';
	$t_field .= '</tr>';
	$d_field .= '</tr>';
	echo $t_field.$d_field;
	for($j=1; $j<=15; $j++){
		echo '<tr><th>'.$j.'</th>';
		reset($fl); $i=1;
		while(list($k,$v)=each($fl)){
			echo '<td><input type="text" name="quest_'.$k.'['.$j.']" id="quest_'.$k.'['.$j.']" size="70" maxlenght="150" value="'.htmlspecialchars($quest[$k][$j]).'" /></td>';
			$i++;
		}
		echo '</tr>';
	}
	echo '</table>';

	echo "<br />
	<input type=submit value=\"".$alang_ar['save']."\">
	</form>";

	/* out vote results */
	$data = array();
	$allvotes = 0; $maxwidth = 480; 
	$vot = unserialize(stripslashes($t['voteres']));
	if($vot=="") $vot = array();
	while(list($k,$v)=each($vot)){
		$allvotes = $allvotes + $v;
	}
	$quest = unserialize(stripslashes($t['quest_'.$_SESSION['lang']]));
	$graf = array();
	while(list($k,$v)=each($quest)){
		if(trim($v)!=""){
			$graf[$k]['quest'] = $v;
			$graf[$k]['number'] = $k;
			if(isset($vot[$k])) $graf[$k]['votes'] = $vot[$k];
			else $graf[$k]['votes'] = 0;
			$graf[$k]['procent'] = $allvotes==0 ? 0 : round($graf[$k]['votes']*100/$allvotes, 0);
			$graf[$k]['width'] = $allvotes==0 ? 0 : round($graf[$k]['votes']*$maxwidth/$allvotes, 0);
			if($graf[$k]['votes'] == 0) $graf[$k]['width'] = 1;
		}
	}
	reset($graf);
	echo '<br /><h3>'.$lang_ar['vote_result'].'</h3>';
	echo '<table border="0" cellspacing="0" cellpadding="0" class="VoteResTab">';
	while(list($k,$v)=each($graf)){
		echo '<tr>
			<td class="vote_pr" style="width:50px">'.$v['number'].'</td>
        	<td class="vote_pr" style="width:50px">'.$v['procent'].'% ('.$v['votes'].')</td>
        	<td class="vote_quest">'.$v['quest'].'<br /><div style="width:'.$v['width'].'px;" class="vote_gr vote_color'.$v['number'].'"></div></td>
            </tr>
		';
	}	
	echo '</table>';
	echo '<br /><h3>'.$lang_ar['vote_comlist'].'</h3>';
	$usercom = str_replace("||", "<br />", stripslashes($t['usercom']));
	$usercom = str_replace("|", " | ", $usercom);
	echo $usercom;

/*
    	<table border="0" cellspacing="0" cellpadding="0" class="VoteResTab">
		{foreach from=$data.graf key=key item=item}
        	<tr>
        	<td class="vote_pr">{$item.procent}%</td>
        	<td class="vote_quest">{$item.quest}<br /><div style="width:{$item.width}px;" class="vote_gr vote_color{$item.number}"></div></td>
            </tr>
		{/foreach}
        </table>
*/
}

//---------------------------------------------------------------
if(!isset($_REQUEST['act']) || $_REQUEST['act']=="VoteList"){

	echo "<br /><h2>".$lang_ar['vote_list']."</h2>
	<table border='0' cellspacing='2' class='selrow' id='VoteListTab'>";
     echo "<tr>
	 <th>ID</th>
	 <th>".$lang_ar['vote_name']."</th>
	 <th>".$lang_ar['vote_dcreated']."</th>
	 <th>".$lang_ar['vote_count']."</th>
	 <th>".$lang_ar['vote_switch1']."</th>
	 <th>".$lang_ar['delete']."</th>
	 </tr>";
	$q="SELECT * FROM ".$_conf['prefix']."poll ORDER BY datecreated";
	$r = $db -> Execute($q);
	while(!$r -> EOF){
		$t = $r -> GetRowAssoc(false);
		$show = $t['voteshow']=="y" ? '<font color="green">'.$lang_ar['vote_switch2'].'</font>' : '<font color="red">'.$lang_ar['vote_switch3'].'</font>';
		echo '<tr>
		 <td>'.$t['id'].'</td>
		 <td><a href="admin.php?p='.$p.'&act=VoteEditForm&id='.$t['id'].'">'.stripslashes($t['name_'.$_conf['def_admin_lang']]).'</a></td>
		 <td>'.date("d.m.Y", $t['datecreated']).'</td>
		 <td>'.$t['countvote'].'</td>
		 <td>'.$show.'</td>
		 <td><a href="admin.php?p='.$p.'&act=VoteDelit&id='.$t['id'].'"><img src="'.$_conf['tpl_dir'].'adm_img/delit.png" width="16" height="16" alt="'.$lang_ar['vote_delete'].'" /></a></td>
		</tr>';
		$r -> MoveNext();
	}
	echo "</table>";
}

?>
