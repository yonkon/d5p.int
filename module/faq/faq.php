<?php
/**
 * Вывод новостей сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012 
 * @link http://shiftcms.net
 * @version 1.04.05
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['act']) && $_REQUEST['act']=="addQ" && $_conf['faq_addquest']=="y"){
	$js = array(); $js['msg'] = ''; $js['state'] = 'OK';
		if($_conf['faq_uname']=="y" && trim(stripslashes($_REQUEST['q_name']))==""){
			$js['msg'] .= msg_box($lang_ar['s_faq_er1']); $js['state'] = 'ERROR';
		}
		if($_conf['faq_uemail']=="y" && trim(stripslashes($_REQUEST['q_email']))==""){
			$js['msg'] .= msg_box($lang_ar['s_faq_er2']); $js['state'] = 'ERROR';
		}
		if($_SESSION['check_code']!=$_REQUEST['check_code']){
			$js['msg'] .= msg_box($lang_ar['s_faq_er3']); $js['state'] = 'ERROR';
		}
		if($js['state']=="OK"){
			$q_name = $_conf['faq_uname']=="y" ? mysql_real_escape_string(stripslashes($_REQUEST['q_name'])) : "";
			$q_email = $_conf['faq_uemail']=="y" ? mysql_real_escape_string(stripslashes($_REQUEST['q_email'])) : "";
			$r = $db -> Execute("INSERT INTO ".$_conf['prefix']."faq SET
			q_state='n',
			q_date='".time()."',
			q_group='',
			q_name='".$q_name."',
			q_email='".$q_email."',
			q_quest_".$_SESSION['lang']."='".mysql_real_escape_string(strip_tags(stripslashes($_REQUEST['q_quest'])))."'
			");
			$js['msg'] = '<h2>'.$lang_ar['s_faq_ok1'].'</h2>';
		}
	$GLOBALS['_RESULT'] = $js;
}


if(!isset($_REQUEST['act'])){

if(isset($_REQUEST['q_id']) && is_numeric($_REQUEST['q_id']) && $_REQUEST['q_id']>0){
	$faq = array();
	$ms = $db->Execute("SELECT * FROM ".$_conf['prefix']."faq
	WHERE q_id='".mysql_real_escape_string(stripslashes($_REQUEST['q_id']))."'");
	if($ms->RecordCount()!=0){ // всего тем
		$t = $ms->GetRowAssoc(false);
		$faq = array(
			'q_id'=>$t['q_id'],
			'q_date'=>$t['q_date'],
			'q_date1'=>$t['q_date1'],
			'q_quest'=>stripslashes($t['q_quest_'.$_SESSION['lang']]),
			'q_reply'=>stripslashes($t['q_reply_'.$_SESSION['lang']])
		);
		$smarty -> assign("act","full");
		$smarty -> assign("faq",$faq);
	}else{
		$smarty->assign("faqnotfound",$lang_ar['newsnotfound']);
	}


}else{

	$id = 0;
	$faq = array();
	$interval = $_conf['faq_count'];
	if(!isset($_REQUEST['start']) || $_REQUEST['start']<0 || !is_numeric($_REQUEST['start'])) $start=0;
	else $start = $_REQUEST['start'];
	
	if(isset($_REQUEST['sph']) && trim($_REQUEST['sph'])!=""){
		$q = "select SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."faq 
		WHERE MATCH(q_quest_".$_SESSION['lang'].",q_reply_".$_SESSION['lang'].") AGAINST ('".mysql_real_escape_string(stripslashes($_REQUEST['sph']))."'  IN BOOLEAN MODE)
		AND q_state='y' 
		ORDER BY q_date DESC 
		LIMIT ".$start.", ".$interval;
		$sph = htmlspecialchars(stripslashes($_REQUEST['sph']));
	}else{
		$q = "select SQL_CALC_FOUND_ROWS * FROM ".$_conf['prefix']."faq 
		WHERE q_state='y' 
		ORDER BY q_date DESC 
		LIMIT ".$start.", ".$interval;
		$sph = '';
	}

	$ms = $db -> Execute($q);

	$r1 = $db -> Execute("select found_rows()");
	$t1 = $r1 -> GetRowAssoc(false);
	$all = $t1['found_rows()'];

	if($sph=='') $list_page=GetPaging($all,$interval,$start,"index.php?p=faq&start=%start1%");
	else $list_page=GetPaging($all,$interval,$start,"index.php?p=faq&start=%start1%&sph=".$sph);

	while (!$ms->EOF) { 
		$t = $ms->GetRowAssoc(false);
		$faq[]=array(
			'q_id'=>$t['q_id'],
			'q_date'=>$t['q_date'],
			'q_date1'=>$t['q_date1'],
			'q_quest'=>stripslashes($t['q_quest_'.$_SESSION['lang']]),
			'q_reply'=>stripslashes($t['q_reply_'.$_SESSION['lang']])
		);
		$ms -> MoveNext(); 
	}
	$smarty -> assign("paging",$list_page);
	$smarty -> assign("listpage",$smarty -> fetch("db:paging.tpl"));
	$smarty -> assign("act","list");
	$smarty -> assign("faq",$faq);
}

$smarty->assign("sph", isset($_REQUEST['sph']) ? htmlspecialchars(stripslashes($_REQUEST['sph'])) : "");
$PAGE = $smarty->fetch("faq/faq.tpl");

if($_conf['faq_addquest']=="y"){
$HEADER .= '<script type="text/javascript">
$(document).ready(function(){
	$(".faq_title").click(function(){
		SwitchShow("FQ"+this.id);
		$(this).toggleClass("faq_opened");
	});
});
function sendQuestion(){
	document.getElementById("FQL").style.display = "block";
	document.getElementById("FQL").innerHTML = \'<img src="/js/img/loader.gif" />\';
    JsHttpRequest.query(
        "loader.php?p=faq&act=addQ",
        {
             "form": document.getElementById("QForm")
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result["state"] == "ERROR"){
						document.getElementById("FQL").innerHTML = result["msg"];
					}else{
						document.getElementById("FQL").innerHTML = "";
						document.getElementById("QFA").innerHTML = result["msg"];
					}
                }
        },
        true  // do not disable caching
    );
}
</script>';
}

}//if not set act

?>