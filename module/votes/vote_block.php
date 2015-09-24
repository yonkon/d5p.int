<?php
/**
 * Блок для вывода опросов и их результатов
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2010 
 * @link http://shiftcms.net
 * @version 1.00	12.02.2010
 */
if(!isset($_REQUEST['vote_act'])){
	$vote_block = '';

	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."poll WHERE voteshow='y' ORDER BY rand() LIMIT 0,1");
	if($r -> RecordCount() > 0){
		$smarty -> assign("showvote", "showvote");
		$t = $r -> GetRowAssoc(false);
		$id = $t['id']; $cookie = "vote_".$id;
		$name = stripslashes($t['name_'.$_SESSION['lang']]);
			$smarty -> assign("vote_name", $name);
		$desc = stripslashes($t['desc_'.$_SESSION['lang']]);
			$smarty -> assign("vote_desc", $desc);
		if(isset($_COOKIE[$cookie]) && $t['votesingle']=="y") {
			$data = GetVoteResult($t);
			$smarty -> assign("data", $data);
			$smarty -> assign("show", "result");
			$smarty -> assign("head", "show");
			$vote_block = $smarty->fetch("votes/vote_block.tpl");
		}else{
			$data = GetVoteForm($t);
			$smarty -> assign("data", $data);
			$smarty -> assign("head", "show");
			$smarty -> assign("show", "form");
			$vote_block = $smarty->fetch("votes/vote_block.tpl");
		}
	}
} // not set vote_act

if(isset($_REQUEST['vote_act']) && $_REQUEST['vote_act']=="ParseVoteData"){
	$er = 0; $msg = ''; $res['state'] = "ERROR";
	$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."poll WHERE id='".$_REQUEST['id']."'");
	$t = $r -> GetRowAssoc(false);
	
	if(!isset($_REQUEST['quest'])){
		$er = 1; $res['msg'] .= $lang_ar['vote_er1'].'\n';
	}
	if($er == 0){
		$countvote = $t['countvote']+1;
		if(isset($_REQUEST['usercom']) && trim($_REQUEST['usercom'])!=""){
			$usercom = mysql_real_escape_string(stripslashes($t['usercom'])."||".date("d.m.Y H:i",time())."|".stripslashes($_REQUEST['usercom']));
			$setusercom = "usercom='".$usercom."', ";
		}else{
			$setusercom = "";
		}
		$vot = unserialize(stripslashes($t['voteres']));
		while(list($k,$v)=each($_REQUEST['quest'])){
			if(isset($vot[$v])) $vot[$v]++;
			else $vot[$v] = 1;
		}
		$voteres = serialize($vot);
			$q = "UPDATE ".$_conf['prefix']."poll SET 
			voteres = '".$voteres."', ".$setusercom." countvote='".$countvote."'
			WHERE id='".$_REQUEST['id']."'";
			$r = $db -> Execute($q);
				$id = $t['id']; $cookie = "vote_".$id;
			if($t['votesingle']=='y'){
				setcookie($cookie, $t['id'], time()+86400*365);
			}else{
				if(isset($_COOKIE[$id])) setcookie($cookie, $t['id'], time());
			}
		$r = $db -> Execute("SELECT * FROM ".$_conf['prefix']."poll WHERE id='".$_REQUEST['id']."'");
		$t = $r -> GetRowAssoc(false);
			$data = GetVoteResult($t);
			$smarty -> assign("data", $data);
			$smarty -> assign("head", "hide");
			$smarty -> assign("show", "result");
			$smarty -> assign("showvote", "showvote");
			$vote_block = $smarty->fetch("votes/vote_block.tpl");
		$res['state'] = "OK";
		$res['msg'] = $vote_block;
	}
	$GLOBALS['_RESULT'] = $res;
}


function GetVoteForm($t){
	$data=array();
	$items=0;
	$data['id'] = $t['id'];
	$data['quest'] = unserialize(stripslashes($t['quest_'.$_SESSION['lang']]));
	$data['type'] = $t['votetype'];
	$data['com'] = $t['enablecom'];

	return $data;
}


function GetVoteResult($t){
	$data = array();
	$allvotes = 0; $maxwidth = 180;
	$vot = unserialize(stripslashes($t['voteres']));
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
			$graf[$k]['procent'] = round($graf[$k]['votes']*100/$allvotes, 0);
			$graf[$k]['width'] = round($graf[$k]['votes']*$maxwidth/$allvotes, 0);
			if($graf[$k]['votes'] == 0) $graf[$k]['width'] = 1;
		}
	}
	$data['graf'] = $graf;
	
	return $data;
}
?>