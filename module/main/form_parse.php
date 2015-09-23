<?php
/**
 * Обработка данных из форм созданных конструктором
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2012
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

if(isset($_REQUEST['act']) && $_REQUEST['act']=="parseData"){
	
	$js = array();
	$js['state'] = "OK";
	$js['msg'] = '';
	$data = '<table border="1">';
	
	$r = $db -> Execute("select * from ".$_conf['prefix']."form where idf='".$_REQUEST['idf']."'");
	$t = $r -> GetRowAssoc(false);
	$rf = $db -> Execute("select * from ".$_conf['prefix']."form_field where idf='".$_REQUEST['idf']."' order by f_order");
	while(!$rf->EOF){
		$tf = $rf -> GetRowAssoc(false);
		$val = '';
		$f_name = $tf['f_name'];
		$f_list = array();
		if($tf['f_list']!=""){
			$fl = explode(",",$tf['f_list']);
			while(list($k,$v)=each($fl)){
				$fl1 = explode(":",$v);
				$f_list[] = array('key'=>$fl1[0],'val'=>stripslashes($fl1[1]));
			}
			reset($f_list);
		}
		if($tf['f_type']=="text" || $tf['f_type']=="textarea"){
			$val = stripslashes($_REQUEST[$f_name]);
			if(trim($val)=="" && $tf['f_req']=="y"){
				$js['state'] = "ERROR";
				$js['msg'] .= stripslashes($tf['f_req_alert'])."\n";
			}
		}
		if($tf['f_type']=="select"){
			$val = stripslashes($_REQUEST[$f_name]);
			if((trim($val)=="0" || trim($val)=="") && $tf['f_req']=="y"){
				$js['state'] = "ERROR";
				$js['msg'] .= stripslashes($tf['f_req_alert'])."\n";
			}
			while(list($k,$v)=each($f_list)){if($v['key']==$val) $val = $v['val'];}
		}
		if($tf['f_type']=="radio"){
			if(!isset($_REQUEST[$f_name]) && $tf['f_req']=="y"){
					$js['state'] = "ERROR";
					$js['msg'] .= stripslashes($tf['f_req_alert'])."\n";
			}else{
				$val = stripslashes($_REQUEST[$f_name]);
				while(list($k,$v)=each($f_list)){if($v['key']==$val) $val = $v['val'];}
			}
		}
		if($tf['f_type']=="checkbox"){
			if(!isset($_REQUEST[$f_name]) && $tf['f_req']=="y"){
					$js['state'] = "ERROR";
					$js['msg'] .= stripslashes($tf['f_req_alert'])."\n";
			}else{
				while(list($k1,$v1)=each($_REQUEST[$f_name])){
					while(list($k,$v)=each($f_list)){
						if($v['key']==$v1) $val .= $v['val'].'<br />';
					}
					reset($f_list);
				}
			}
		}
		$data .= '<tr><td>'.stripslashes($tf['f_label']).'</td><td>'.stripslashes($val).'</td></tr>';
		$rf->MoveNext();
	}
	$data .= '</table>';
	
	if($t['f_send']=="y" && $js['state'] == "OK"){
		$msg = '<p>'.$lang_ar['af_newmsg'].': '.stripslashes($t['name']).'</p>
		<p>'.$lang_ar['af_datecomp'].': '.date("d.m.Y H:i",time()).'</p>'.$data.'<p><a href="'.$_conf['www_patch'].'">'.$_conf['www_patch'].'</a></p>';
		SendEmail(0, stripslashes($t['f_email']), stripslashes($_conf['site_name']), 0, $_conf['sup_email'], $_conf['site_name'], $_conf['site_name']." - ".$lang_ar['af_newmsg'].": ".stripslashes($t['name']), $msg);
	}
	if($t['f_save']=="y" && $js['state'] == "OK"){
		$r = $db -> Execute("insert into ".$_conf['prefix']."form_data set
		idf='".$t['idf']."',
		fdate='".time()."',
		fmsg='".mysql_real_escape_string(stripslashes($data))."'
		");
	}
	
	if($js['state'] == "OK") $js['msg'] = '<div class="msg">'.stripslashes($t['f_msg']).'</div>';
	//$js['msg'] .= print_r($_REQUEST,1);
	//$js['msg'] .= $data;
	$GLOBALS['_RESULT'] = $js;
	
}else{
	
	$PAGE = '';
	
}
?>