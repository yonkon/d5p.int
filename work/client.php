<?php

/**
* ���������� ����� ��� ������ ������-���������
* @package ShiftCMS
* @subpackage Remote
* @author Volodymyr Demchuk http://shiftcms.net
* @version 1.00 15.02.2011
*/
if(!defined('SHIFTCMS')){
	exit;
}

/**
* ������� ��� �������� ������� �� ��������� ������
* @param string $function ��� ���������� ������� �� ��������� �������
* @param array $data ������ ������ ������������ �� ��������� ������ � �������� ��������� ���������� �������
* @return array ������ ������ ������������ ��������� ��������. � ����������� �� ���������� ������� �������� ��������� ����� ������
*/
function SendRemoteRequest($function, $data){
	global $_conf, $PAGE;
	reset($data);
	if(!class_exists("nusoap_client")) {
		require_once(dirname(__FILE__).'/include/nusoap/nusoap.php');
	}
	$uchetclient = new nusoap_client(uchet_addr, uchetwsdl);
	$ucheterr = $uchetclient->getError();
	if ($ucheterr) {
	    $PAGE .= '<p><b>������ � ������������ ������:</b> ' . $ucheterr . '</p>';
	}
	if(isset($_SESSION['A_CABINET'])){
		$data['strong'] = $_SESSION['A_STRONG'];
		$data['idu'] = $_SESSION['A_USER_IDU'];
		$data['owner_idu'] = $_SESSION['A_CABINET'];
	}
	$data['sys_pass'] = md5($_conf['sys_pass']);
	$data['rhost'] = $_conf['rhost'];
//print_r($data);
	$uchetresult = $uchetclient -> call($function, $data);
	
	if ($uchetclient->fault) {
	    $PAGE .= '<p><b>����:</b><pre>';
	    $PAGE .= print_r($uchetresult,1);
	    $PAGE .= '</pre></p>';
	} else {
	    $ucheterr = $uchetclient -> getError();
	    if ($ucheterr) {
        	if(uchetdebug == true) RetDebugUchet($uchetclient);
	        $PAGE .= '<p><b>������:</b> ' . $ucheterr . '</p>';
	    } else {
        	if(uchetdebug == true) RetDebugUchet($uchetclient);
			return $uchetresult;
	    }
	}
}


/* ********************************************************************************************* */

function RetDebugUchet($client){
	echo '<h2>������</h2>';
	echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
	echo '<h2>�����</h2>';
	echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>'; 
	echo '<h2>�������</h2>';
	echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>'; 
}

/**
*
*/
function Authorize($data = ''){
	if($data==''){
		$_SESSION['A_CABSET'] = unserialize($_COOKIE['A_CABSET']);
		$_SESSION['A_STRONG'] = $_COOKIE['A_STRONG'];
		$_SESSION['A_USER_IDU'] = $_COOKIE['A_USER_IDU'];
		$_SESSION['A_USER_LOGIN'] = $_COOKIE['A_USER_LOGIN'];
		$_SESSION['A_USER_EMAIL'] = $_COOKIE['A_USER_EMAIL'];
		$_SESSION['A_USER_LAST_ACCES'] = $_COOKIE['A_USER_LAST_ACCES'];
		$_SESSION['A_USER_FIO'] = $_COOKIE['A_USER_FIO'];
		$_SESSION['A_CABINET'] = $_COOKIE['A_CABINET'];
	}else{
		if($data['authperiod']=="y") $stime=time()+3600*24*365;
		else $stime = time()+12*3600;
		$_SESSION['A_CABSET'] = $data['cabset'];
		$_SESSION['A_STRONG'] = $data['strong'];
		$_SESSION['A_USER_IDU'] = $data['idu'];
		$_SESSION['A_USER_LOGIN'] = $data['login'];
		$_SESSION['A_USER_EMAIL'] = $data['email'];
		$_SESSION['A_USER_LAST_ACCES'] = $data['last_access'];
		$_SESSION['A_USER_FIO'] = $data['fio'];
		$_SESSION['A_CABINET'] = $data['cabinet'];
		$_SESSION['A_SHOWPOPUPNEWS'] = true;
		setcookie("A_CABSET", serialize($data['cabset']), $stime);
		setcookie("A_STRONG", $data['strong'], $stime);
		setcookie("A_USER_IDU", $data['idu'], $stime);
		setcookie("A_USER_LOGIN", $data['login'], $stime);
		setcookie("A_USER_EMAIL", $data['email'], $stime);
		setcookie("A_USER_LAST_ACCESS", $data['last_access'], $stime);
		setcookie("A_USER_FIO", $data['fio'], $stime);
		setcookie("A_CABINET", $data['cabinet'], $stime);
	}
}

/* ======�������� �� �������� � ����������� �������============ */
function Paging($all,$interval,$start,$link,$add_parametr){
$list_page="";
if($all<=$interval) $list_page="";
if($all>$interval){
    $count_page=ceil($all/$interval);
	if($count_page<20){
		for($i=0;$i<$count_page;$i++){
			$page=$i+1;
			$start1=$interval*$i;
			$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
			if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
			else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
	}else{ /* ���� ������� ������ 20 - ������� ��������� ������� */
$cur_page_number=$start/$interval+1;

if(($cur_page_number<=8) || ($cur_page_number>$count_page-8)){
		for($i=0;$i<10;$i++){
				$page=$i+1;
				$start1=$interval*$i;
				$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
				if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
				else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
			$list_page.=" ... &nbsp;";
		for($i=$count_page-10;$i<$count_page;$i++){
			$page=$i+1;
			$start1=$interval*$i;
			$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
			if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
			else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
}else{
		$add_parametr1=str_replace("%start1%",0,$add_parametr);
		$list_page=$list_page."<a href=\"".str_replace("%start1%",0,$link)."\" ".$add_parametr1.">1</a>&nbsp;";
			$list_page.=" ... &nbsp;";
		for($i=$cur_page_number-8;$i<$cur_page_number+7;$i++){
			$page=$i+1;
			$start1=$interval*$i;
			$add_parametr1=str_replace("%start1%",$start1,$add_parametr);
			if($start==$start1) $list_page=$list_page."<span class=\"current\">$page</span>&nbsp;";
			else $list_page=$list_page."<a href=\"".str_replace("%start1%",$start1,$link)."\" ".$add_parametr1.">$page</a>&nbsp;";
		}
			$list_page.=" ... &nbsp;";
		$add_parametr1=str_replace("%start1%",$count_page*$interval,$add_parametr);
		$list_page=$list_page."<a href=\"".str_replace("%start1%",$count_page*$interval,$link)."\" ".$add_parametr1.">$count_page</a>&nbsp;";
}

	}
	 $ppr=$start-$interval;
	 $add_parametr1=str_replace("%start1%",$ppr,$add_parametr);
	 if($start>0) $prev="<a href=\"".str_replace("%start1%",$ppr,$link)."\" ".$add_parametr1.">����������</a>&nbsp;";
	 else $prev="";
	 $pnx=$start+$interval;
	 $add_parametr1=str_replace("%start1%",$pnx,$add_parametr);
	 if($pnx<$all)  $pnext="<a href=\"".str_replace("%start1%",$pnx,$link)."\" ".$add_parametr1.">���������</a>&nbsp;";
	 else $pnext="";
	 $list_page=$prev.$list_page.$pnext;
	 $list_page="<div class=\"navigation\">".$list_page."</div>";
}
return $list_page;
}

/**
* ����� �������������� ������ ������ �������
*/
function EditOwnData(){
	global $_conf;
	$out = '';
	$data = array();
	$res = SendRemoteRequest("GetOwnData", $data);
	
	if($res['status']['code']==0){
		
		$a_no = $res['data']['ui']['A_NEWORDER']=="1" ? "checked='checked'" : "";

		$birthday = $res['data']['ui']['BIRTHDAY'];
		if($birthday != '0000-00-00' && $birthday != '') {
			$birthday = explode('-',$birthday);
			$birthday = $birthday[2].'.'.$birthday[1].'.'.$birthday[0];
		} else $birthday = '';
		
    	$out.="<div id='UserFormArea'>
		<form method='post' action='javascript:void(null)' enctype='multipart/form-data' id='EditUserForm'>
			<input type='hidden' name='p' id='p' value='functions' />
			<input type='hidden' name='act' id='act' value='SaveOwnData' />
			<h3>�������������� ������ ������</h3><br />
			<table border='0'>
				<tr>
					<td valign='top'>
						<table border='0' class='selrow' cellspacing='0'>
							<tr><td>�����:</td><td><strong>".$res['data']['ui']['LOGIN']."</td></tr>
							<tr><td>E-mail:*</td><td><input type='text' name='email' id='email' value='".htmlspecialchars(stripslashes($res['data']['ui']['EMAIL']))."' style='width:270px;' /></td></tr>
							<tr><td>���:*</td><td><input type='text' name='fio' id='fio' value='".htmlspecialchars(stripslashes($res['data']['ui']['FIO']))."' style='width:270px;' /></td></tr>
							<tr><td>�����:</td><td><textarea name='contact' id='contact' style='width:270px;height:50px;'>".stripslashes($res['data']['ui']['CONTACT'])."</textarea></td></tr>
							<tr><td>ICQ:</td><td><input type='text' name='icq' id='icq' value='".htmlspecialchars(stripslashes($res['data']['ui']['ICQ']))."' style='width:270px;' /></td></tr>
							<tr><td>�������:</td><td><input type='text' name='phone' id='phone' value='".htmlspecialchars(stripslashes($res['data']['ui']['PHONE']))."' style='width:270px;' /></td></tr>
							<tr><td>���������:</td><td><input type='text' name='mphone' id='mphone' value='".htmlspecialchars(stripslashes($res['data']['ui']['MPHONE']))."' style='width:270px;' /></td></tr>
							<tr><td>���-�����:</td><td><input type='text' name='web' id='web' value='".htmlspecialchars(stripslashes($res['data']['ui']['WEB']))."' style='width:270px;' /></td></tr>
							<tr><td>������� Webmoney R-����:</td><td><input type='text' name='webmoney' id='webmoney' value='".htmlspecialchars(stripslashes($res['data']['ui']['WEBMONEY']))."' style='width:270px;' /></td></tr>
							<tr><td>������� ������.������:</td><td><input type='text' name='yandx' id='yandx' value='".htmlspecialchars(stripslashes($res['data']['ui']['YANDEX']))."' style='width:270px;' /></td></tr>
							<tr><td>�������������� ����������:</td><td><textarea name='addinfo' id='addinfo' style='width:270px;height:50px;'>".stripslashes($res['data']['ui']['ADDINFO'])."</textarea></td></tr>
							<tr><td>�������:</td><td>".stripslashes($res['data']['ui']['refererinfo'])."</td></tr>
							<tr><td colspan='2'><strong>������� ������:</strong></td></tr>
							<tr><td>����� ������:</td><td><input type='password' name='password' id='password' value='' style='width:270px;' /></td></tr>
							<tr><td>��������� ����� ������:</td><td><input type='password' name='password1' id='password1' value='' style='width:270px;' /></td></tr>
							<tr><td colspan='2'>&nbsp;</td></tr>
							<tr>
								<td>����� ����������</td>
								<td><input type='text' name='city' id='city' value='".htmlspecialchars(stripslashes($res['data']['ui']['CITY']))."' style='width:270px;' /></td>
							</tr>
							<tr>
								<td>���� ��������</td>
								<td><input type='text' name='birthday' id='birthday' class='datetextbox' value='".$birthday."' style='width:270px;' />
									<script type='text/javascript'>
										Calendar.setup({
											inputField : 'birthday',
											ifFormat : '%d.%m.%Y',
											showsTime : false
										});
									</script>
								</td>
							</tr>
							<tr>
								<td>������� �������� ���������</td>
								<td><textarea type='text' name='biography' id='biography' style='height:50px; width:270px;'>".htmlspecialchars(stripslashes($res['data']['ui']['BIOGRAPHY']))."</textarea></td>
							</tr>
							<tr>
								<td>� ������ ������� �������������</td>
								<td><textarea type='text' name='collab_firms' id='collab_firms' style='height:50px; width:270px;'>".htmlspecialchars(stripslashes($res['data']['ui']['COLLAB_FIRMS']))."</textarea></td>
							</tr>
							<tr>
								<td>�������������� ����� ��� �����</td>
								<td><input type='text' name='time_to_call' id='time_to_call' value='".htmlspecialchars(stripslashes($res['data']['ui']['TIME_TO_CALL']))."' style='width:270px;' /></td>
							</tr>
							<tr>
								<td>��� ����� ����������� ���������� �����</td>
								<td><input type='text' name='how_long_avtor' id='how_long_avtor' value='".htmlspecialchars(stripslashes($res['data']['ui']['HOW_LONG_AVTOR']))."' style='width:270px;' /></td>
							</tr>
							<tr>
								<td>��� � ��� ����� ����������</td>
								<td><input type='text' name='name_to_address' id='name_to_address' value='".htmlspecialchars(stripslashes($res['data']['ui']['NAME_TO_ADDRESS']))."' style='width:270px;' /></td>
							</tr>
							<tr>
								<td>������� ����� � ����� ������ ���������</td>
								<td><input type='text' name='count_of_works' id='count_of_works' value='".htmlspecialchars(stripslashes($res['data']['ui']['COUNT_OF_WORKS']))."' style='width:270px;' /></td>
							</tr>								
						</table>
					</td>
					<td width='20'>&nbsp;</td>
					<td valign='top'>
						<div id='avtorFields'><table border='0' cellspacing='0'>
							<tr>
								<td colspan='2'><strong>�������������:</strong><br /><div style='height:300px; width:300px; overflow:scroll;'>".$res['data']['course_ch']."</div><div id='ShowBox'>".$res['data']['SB_str']."</div><br /></td>
							</tr>						
						</table></div>
					</td>
				</tr>
				<tr><td colspan='3' align='center'><input type='checkbox' name='a_neworder' id='a_neworder' value='1' ".$a_no." /> �������� ��������� �� e-mail � ����� ������� �� ������</td></tr>
				<tr>
					<td colspan='3' align='center'>
					<input type='button' onclick=\"doLoad('EditUserForm','TTT','".$_conf['base_url']."')\" value='���������' />
					</td>
				</tr>
			</table>
	    </form>
		</div>
		<div id='TTT' style='text-align:center;color:red;'></div>";
		return $out;

	} else {
		
		return '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
		
	}
}

/**
* �������� � ���������� ������ ������ �������
*/
function SaveOwnData(){
	global $_conf;
	$out = '';
	if(trim($_REQUEST['email'])=="") return "������! ����������, ������� ��� e-mail!";
	if(trim($_REQUEST['fio'])=="") return "������! ����������, ������� ���� ���!";
	if(trim($_REQUEST['phone'])=="" && trim($_REQUEST['mphone'])=="") return "������! ����������, ������� ��� ������� ��� ���������!";
	if((trim($_REQUEST['password'])!="" || trim($_REQUEST['password1'])!="") && trim($_REQUEST['password'])!=trim($_REQUEST['password1'])) return "������! �������� ��������� ������ �� ��������� � ������!";
	
	$data = array();
	$data['pars']['email'] = stripslashes($_REQUEST['email']);
	$data['pars']['fio'] = stripslashes($_REQUEST['fio']);
	$data['pars']['contact'] = stripslashes($_REQUEST['contact']);
	$data['pars']['icq'] = stripslashes($_REQUEST['icq']);
	$data['pars']['phone'] = stripslashes($_REQUEST['phone']);
	$data['pars']['mphone'] = stripslashes($_REQUEST['mphone']);
	$data['pars']['web'] = stripslashes($_REQUEST['web']);
	$data['pars']['webmoney'] = stripslashes($_REQUEST['webmoney']);
	$data['pars']['yandex'] = stripslashes($_REQUEST['yandx']);
	$data['pars']['addinfo'] = stripslashes($_REQUEST['addinfo']);
	if($data['pars']['password']!="") $data['pars']['password'] = stripslashes($_REQUEST['password']);
	$data['pars']['a_special'] = $_REQUEST['a_special'];
	$data['pars']['a_neworder'] = isset($_REQUEST['a_neworder']) ? 1 : 0;
	$data['pars']['birthday'] = $_REQUEST['birthday'];
	$data['pars']['biography'] = $_REQUEST['biography'];
	$data['pars']['collab_firms'] = $_REQUEST['collab_firms'];
	$data['pars']['time_to_call'] = $_REQUEST['time_to_call'];
	$data['pars']['how_long_avtor'] = $_REQUEST['how_long_avtor'];
	$data['pars']['name_to_address'] = $_REQUEST['name_to_address'];
	$data['pars']['count_of_works'] = $_REQUEST['count_of_works'];
	$data['pars']['city'] = $_REQUEST['city'];
	$res = SendRemoteRequest("SaveOwnData", $data);
	if($res['status']['code']==0){
		return $res['status']['msg'];
	} else {
		return '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
	}

	return $out;
}

/**
* ����� ������ ������ �������
* @param $ido ����� ������
*/
function EstimateOrder($ido){
	global $_conf;
	$out = "";
	$data['ido'] = $ido;
	$res = SendRemoteRequest("GetOrderInfo", $data);
	if($res['status']['code']!=0){
		return '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
	}
	$oi = $res['data']['oi'];
	//if($_REQUEST['state']=="new")  $r = $db -> Execute("UPDATE ".$_conf['prefix']."order_estimate SET state='viewed' WHERE ido='".$ido."' AND idu='".$_SESSION['USER_IDU']."'");
	$out .= "<table border='0' cellspacing='10' width='830'><tr><td valign='top'>";
	$out .= OutOrderInfoSoap($oi);
	$out .= "</td><td valign='top'>";
	$out .= '<p>����������, ������� ���� �������, �� ������� �� ������ ��������� ��� ������. ��� ������� ������� ������.</p><br />';
	$out .= "<form method='post' action='".$_conf['base_url']."/?p=order_avtor_estimate&ido=".$ido."&act=Estimate&id=".$_REQUEST['id']."' id='EForm' enctype='multipart/form-data'>";
	$out .= "<input type='radio' name='type' id='type1' value='yes' checked='checked' onclick=\"HideObject('NoO'); ShowObject('YesO');\" /> ������� ����� &nbsp;&nbsp;&nbsp;&nbsp;";
	$out .= "<input type='radio' name='type' id='type2' value='no' onclick=\"HideObject('YesO'); ShowObject('NoO');\" /> ����������<br />";
	$out .= "<div id='YesO' style='display:block;' class='block'>";
	$out .= "<strong>���� ����:<span>*</span></strong><br /><input type='text' name='amount' id='amount' style='width:300px;' value='' /><br />";
	$out .= "<strong>���� ����������:<span>*</span></strong><br /><input type='text' name='srok' id='srok' class='datetextbox' style='width:300px;' value='' /><br />";
	$out .= "��� �����������:<br /><textarea name='messag1' id='messag1' style='width:300px;height:100px;'></textarea><br />";
	$out .= "</div>";
	$out .= "<div id='NoO' style='display:none;' class='block'>";
	$out .= "������� ������� ������:<br /><textarea name='messag' id='messag' style='width:300px;height:100px;'></textarea><br />";
	$out .= "</div>";
	$out .= "<input type='submit' value='���������' />";
	$out .= "</form>";
	$out .= "</td></tr>";
	$out .= "<tr><td colspan='2'><strong>����� � ������:</strong>";
	if(count($oi['files'])>0){
		$out .= '<table border="0" class="selrow">';
		while(list($k,$v)=each($oi['files'])){
			$out .= '<tr><td><a href="'.$_conf['base_url'].'?p=getfile&ido='.$ido.'&idf='.$v['idf'].'&type=ofile" target="_blank">'.$v['fname'].'</a></td><td><small>'.$v['fsize'].'</small></td><td>'.$v['fpart'].'</td><td><small>'.$v['fdate'].'</small></td><td>'.$v['fcom'].'</td><td>'.$v['fdel'].'</td></tr>';
		}
		$out .= '</table>';
	}
	$out .= "</td></tr>";
	$out .= "</table>";
	$out .= "<script type='text/javascript'>
 	Calendar.setup({
 		inputField : \"srok\",
		ifFormat : \"%d.%m.%Y\",
		showsTime : true
	});
	</script>
";
	return $out;
}


/**
* ����� ���������� �� ��������� ������
* @param $ido ����� ������
*/
function InfoEstimateOrder($ido){
	global $_conf;
	$out = "";
	$data['ido'] = $ido;
	$res = SendRemoteRequest("GetOrderInfo", $data);
	if($res['status']['code']!=0){
		return '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
	}
	$oi = $res['data']['oi'];
	//if($_REQUEST['state']=="new")  $r = $db -> Execute("UPDATE ".$_conf['prefix']."order_estimate SET state='viewed' WHERE ido='".$ido."' AND idu='".$_SESSION['USER_IDU']."'");
	$out .= "<table border='0' cellspacing='10' width='830'><tr><td valign='top'>";
	$out .= OutOrderInfoSoap($oi);
	$out .= "</td></tr>";
	$out .= "<tr><td><strong>����� � ������:</strong>";
	if(count($oi['files'])>0){
		$out .= '<table border="0" class="selrow">';
		while(list($k,$v)=each($oi['files'])){
			$out .= '<tr><td><a href="'.$_conf['base_url'].'?p=getfile&ido='.$ido.'&idf='.$v['idf'].'&type=ofile" target="_blank">'.$v['fname'].'</a></td><td><small>'.$v['fsize'].'</small></td><td>'.$v['fpart'].'</td><td><small>'.$v['fdate'].'</small></td><td>'.$v['fcom'].'</td><td>'.$v['fdel'].'</td></tr>';
		}
		$out .= '</table>';
	}
	$out .= "</td></tr>";
	$out .= "</table>";
	/* ����� � ����� �������� �� ������� */
	$plg = $res['data']['oi']['plagiat'];
	$out .= '<br /><h3>�������� �� ��������</h3>
	<div id="PlagiatList">
	<table border="0" cellspacing="0" class="selrow">';
	if(!empty($plg)){
	while(list($k,$v)=each($plg)){
		$out .= '<tr>
		<td><a href="'.$_conf['base_url'].'?p=getfile&sop='.$v['sop'].'&type=plg" target="_blank">'.$v['p_file'].'</a></td>
		<td>'.stripslashes($v['p_com']).'</td>
		<td><span class="sdate">'.date("d.m.Y H:i",$v['p_date']).'</span></td>
		<td>'.stripslashes($v['fio']).' ('.$v['login'].', idu: '.$v['idu'].')</td>
		</tr>';
	}
	}
	$out .= '</table></div>';

	return $out;
}

/**
* ����� ���������� �� ��������� ������
* @param $ido ����� ������
*/
function DelSingleFile($idf,$ido){
	global $_conf;
	$out = "";
	$data['pars']['idf'] = $idf;
	$data['pars']['ido'] = $ido;
	$res = SendRemoteRequest("DelSingleFileSoap", $data);
	if($res['status']['code']!=0){
		return '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
	}else{
		return $res['status']['msg'];
	}
}
/**
* ����� ���������� � ������
* @param array $oi ������ � ������
* @param string $level ������� �������
*/
function OutOrderInfoSoap($oi){
	global $_conf;
	$out = "<table border='0' cellspacing='0' class='selrow1' width='100%'>";
	$out .= "<tr><th width='200'>�</th><td>$oi[ido]</td></tr>";
	$out .= "<tr><th>����</th><td>".stripslashes($oi['o_thema'])."</td></tr>";
	$out .= "<tr><th>������� ������</th><td>".stripslashes($oi['course'])."</td></tr>";
	$out .= "<tr><th>��� ������</th><td>".stripslashes($oi['worktype'])."</td></tr>";
	$out .= "<tr><th>��� �������� ���������</th><td>".stripslashes($oi['shcooltype'])."</td></tr>";
	$out .= "<tr><th>������ � ����� ����</th><td>".stripslashes($oi['o_cc'])."</td></tr>";
	$out .= "<tr><th>�������� ����</th><td>".stripslashes($oi['o_vuz'])."</td></tr>";
	$out .= "<tr><th>����� ������</th><td>".stripslashes($oi['o_volume'])."</td></tr>";
	$out .= "<tr><th>����</th><td>".stripslashes($oi['name_gost'])."</td></tr>";
	$out .= "<tr><th>�����</th><td>".stripslashes($oi['o_font'])."</td></tr>";
	$out .= "<tr><th>��������</th><td>".stripslashes($oi['o_interval'])."</td></tr>";
	$out .= "<tr><th>�-�� ������������ ����������</th><td>".stripslashes($oi['o_listsource'])."</td></tr>";
	$out .= "<tr><th>�������������� ����������</th><td>".nl2br(stripslashes($oi['o_addinfo']))."</td></tr>";
	if($oi['o_state']=="estimate"){
		$out .= "<tr><th>���� ����������</th><td><span class='sdate'>".date("d.m.Y",$oi['o_client_srok']-1*24*3600)."</span></td></tr>";
	}
	if($oi['o_avtorcost']==0 || $oi['o_avtor']!=$_SESSION['A_USER_IDU']) $oi['o_avtorcost'] = "?";
	$out .= "<tr><th>����</th><td><span class='scena'>".$oi['o_avtorcost']."</span></td></tr>";
	if($oi['amountp']==0) $oi['amountp'] = '-';
	$out .= "<tr><th>�����</th><td><span class='scena'>".$oi['amountp']."</span></td></tr>";
	
	$out .= "<tr><th>��������</th><td>".$oi['manager']."</td></tr>";
	$out .= "<tr><th>�������������� ��������</th><td>".$oi['manager_isp']."</td></tr>";
	$out .= "</table>";
	
	return $out;
}

/* ������� ������� � ������ ������ */
function OutOrderPlanSoap($ido, $plan){
	$out = "";
	$out .= "<table border='0' cellspacing='0' class='selrow' width='100%' id='PlanTable'>";
	$out .= "<tr><th>����</th><th>���� �����</th><th>���������</th></tr>";
	$i = 0;
	while(list($k,$t)=each($plan)){
		if($t['state_file']=="n") $state_file = "�� ��������";
		elseif($t['state_file']=="b" && $t['twsrok']!=0){
			$state_file = "�� ���������. ���� ���������: ".date("d.m.Y",$t['twsrok'])."<br />".stripslashes($t['twcomm']);
		}
		else $state_file = "��������";
			
		$pstr = "";	
		if($t['workpart']=="����" && $t['plan_ok']=="n"){
			$pstr = "<br /><span class='scena'><small>�� ���������</small></span>";
		}
		if($t['workpart']=="����" && $t['plan_ok']=="y"){
			$pstr = "<br /><span class='sdate'><small>���������</small></span> ";
		}
		if($t['avtorsrok']==0) $avsrok = "-";
		else $avsrok = date("d.m.Y",$t['avtorsrok']);
		$out .= '<tr id="P_'.$i.'">
		<td>'.stripslashes($t['workpart']).$pstr.'</td>
		<td><span class="sdate">'.$avsrok.'</span></td>
		<td id="SF_'.$t['idpl'].'">'.$state_file.'</td>
		</tr>';
		$i++;
	}
	$out .= '</table>';
	return $out;
}
//-----------------------------------------------
function create_check($list,$value,$val_name,$add_par){
	$sel_str="";
	while (list($key, $name) = each($list)){
	  $comp=0;
	  for($i=0; $i<count($value); $i++){
	    if($key==$value[$i] && $comp==0) {
	       $sel_str.="<div><input type='checkbox' name='$val_name"."[]' value='$key' checked='checked' $add_par />&nbsp;<span id='V_$key'>$name</span></div>";
	       $comp=1;
	    }
	  }
	  if($comp==0) {
	       $sel_str.="<div><input type='checkbox' name='$val_name"."[]' value='$key' $add_par />&nbsp;<span id='V_$key'>$name</span></div>";
	  }
	}
	return $sel_str;
}

//======================================================
function create_option($list, $value){
	$sel_str = "";
	while (list($key, $name) = each($list)){
		if($name==$value) $sel_str.='<option selected=selected>'.$name.'</option>';
		else $sel_str.='<option>'.$name.'</option>';
	}
	return $sel_str;
}
/**
* ��������� ���������� � ������
*/
function SaveOrderContent(){
	global $_conf;
	if(trim($_REQUEST['o_content'])=="" || trim($_REQUEST['o_vvedenie'])=="" || trim($_REQUEST['o_zakluchenie'])=="" || trim($_REQUEST['o_literatura'])==""){
		return "����������, ��������� ��� ���� �����!";
	}
	$data['pars']['ido'] = $_REQUEST['ido'];
	$data['pars']['o_content'] = $_REQUEST['o_content'];
	$data['pars']['o_vvedenie'] = $_REQUEST['o_vvedenie'];
	$data['pars']['o_zakluchenie'] = $_REQUEST['o_zakluchenie'];
	$data['pars']['o_literatura'] = $_REQUEST['o_literatura'];
	$res = SendRemoteRequest("SaveOrderContentSoap", $data);
	if($res['status']['code']==0){
		return $res['status']['msg'];
	} else {
		return '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
	}
}


function SendRemoteRequestCURL($postdata){
	global $_conf;
	if(isset($_SESSION['A_CABINET'])){
		$postdata['strong'] = $_SESSION['A_STRONG'];
		$postdata['idu'] = $_SESSION['A_USER_IDU'];
		$postdata['owner_idu'] = $_SESSION['A_CABINET'];
	}
	$postdata['sys_pass'] = md5($_conf['sys_pass']);
	$postdata['rhost'] = $_conf['rhost'];
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $_conf['remote_curl_server']);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	//if($idu==8451) curl_setopt($ch, CURLOPT_USERPWD, "referatzru:xR73hT");
	
	ob_start();
	$bSuccess = curl_exec($ch); 
	$response=ob_get_contents();
	ob_end_clean();
	
	$data = curl_getinfo($ch);
	
	$http_result_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	return ($bSuccess && $http_result_code==200) ? $response : null;

}

?> 