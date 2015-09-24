<?
/**
* ������� �������� ������� �����
* @package ShiftCMS
* @subpackage ORDER
* @version 1.00 15.02.2011
* @author Volodymyr Demchuk, http://shiftcms.net
*/

if(!defined('SHIFTCMS')){
	exit;
}
$data = array();
$data['act'] = "noact";
$data['pars'] = array();

/* ��������� ���� ������������ �� ����� ��������.�� */
if(isset($_REQUEST['act']) && $_REQUEST['act'] == "saveReferatzIdu"){
	$data['act'] = "saveReferatzIdu";
	$data['pars']['referatz_idu'] = (int)$_REQUEST['referatz_idu'];
}

if(isset($_REQUEST['act']) && $_REQUEST['act']=="OrderRefPayment"){
	$data['act'] = "OrderRefPayment";
	$data['pars']['orderAmount'] = $_REQUEST['orderAmount'];
	$data['pars']['paymethod'] = $_REQUEST['paymethod'];
	$data['pars']['type'] = $_REQUEST['type'];
}

$res = SendRemoteRequest("LoadUserInfoPage", $data);

if($res['status']['code']==0){

	$PAGE .= "<h3>".$_SESSION['A_USER_FIO']." (".$_SESSION['A_USER_LOGIN'].", IDU:".$_SESSION['A_USER_IDU'].")</h3><br />";
	$PAGE .= '<small>���� �����������: '.date("d.m.Y H:i", $res['data']['ui']['dreg']).'<br />
	��������� ���� � �������: '.date("d.m.Y H:i", $_SESSION['A_USER_LAST_ACCES']).' � IP: '.$res['data']['ui']['ip'].'</small><br /><br />';
	
	if(isset($res['data']['info']) && $res['data']['info']!="") $PAGE .= "<p style='color:green;padding:3px; border:dotted 1px green;'><strong>".$res['data']['info']."</strong></p><br />";
	if(isset($res['data']['ermsg']) && $res['data']['ermsg']!="") $PAGE .= "<p style='color:red;padding:3px; border:dotted 1px red;'><strong>".$res['data']['ermsg']."</strong></p><br />";
	
	$PAGE .= "<ul>";
	$PAGE .= "<li><a title='�������������' href='#' onClick=\"divwin=dhtmlwindow.open('UserEditBox', 'inline', '', '�������������', 'width=850px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=functions&act=EditOwnData','UserEditBox_inner','".$_conf['base_url']."'); return false; \"><strong>������������� ������ ����������</strong></a></li>";
	//$PAGE .= "<li><a title='����������' href='javascript:void(null)' onClick=\"aswin=dhtmlwindow.open('AvtorStatBox', 'inline', '', '����������', 'width=500px,height=550px,left=450px,top=70px,resize=1,scrolling=1'); getdata('','get','?p=functions&act=AvtorStat&idu=".$_SESSION['A_USER_IDU']."','AvtorStatBox_inner','".$_conf['base_url']."'); return false; \">����������</a></li>";
	$PAGE .= '</ul><br /><br />';

	$PAGE .= '<div class="block">���� �� ���������������� �� ����� <a href="http://referatz.ru" target="_blank">http://referatz.ru</a>, ������� � ���� ���� ��� ���� � ����� �����.<br />
	����� �������, ������� ������� ����� �� ��������� ������ �� ����� referatz.ru �� ����� ����������� ������, ����� ������ ���������� � ����� �������.
	<form method="post" action="'.$_conf['base_url'].'/?p=user_info&act=saveReferatzIdu" enctype="multipart/form-data">
	<strong>��� ���� �� ����� referatz.ru: </strong><input type="text" name="referatz_idu" id="referatz_idu" value="'.$res['data']['ui']['referatz_idu'].'" size="10" />
	<input type="submit" value="���������" />
	</form>
	</div>';


if($res['data']['cab']['ref_admin']=="y" && $res['data']['cab']['ref_partner']=="y"){
	$paymethodsel = '<select name="paymethod" id="paymethod"><option value="'.stripslashes(trim($res['data']['ui']['webmoney'])).'">Webmoney: '.stripslashes(trim($res['data']['ui']['webmoney'])).'</option><option value="'.stripslashes(trim($res['data']['ui']['yandex'])).'">������.������: '.stripslashes(trim($res['data']['ui']['yandex'])).'</option></select>';
	$PAGE .= '<br /><div class="block">';
	
	$PAGE .= '<h3>����������� ���������</h3>';
	$PAGE .= '<p>���� ����������� ������: <strong>http://'.$_conf['rhost'].'/?refid='.$_SESSION['A_USER_IDU'].'</strong></p><br />';
	$PAGE .= '<p><strong>���� ��������</strong><!-- (<a title="������ ���������" href="'.$_conf['base_url'].'/?p=admin_user_tree"><strong>������ ���������</strong></a>)-->:</p>';
	$PAGE .= '<ul>';
		$PAGE .= '<li>��������� 1 ������: '.$res['data']['refstat']['ref1count'].'</li>';
		$PAGE .= '<li>��������� 2 ������: '.$res['data']['refstat']['ref2count'].'</li>';
	$PAGE .= '</ul>';
	
	//$rpay = GetRefAmount($_SESSION['USER_IDU']);
	
	$topay = $res['data']['refpay']['forpay']-$res['data']['refpay']['payed']-$res['data']['refpay']['payorder'];
	$ptopay = $res['data']['refpay']['pforpay']-$res['data']['refpay']['ppayed']-$res['data']['refpay']['ppayorder'];
	$PAGE .= '<br /><p><strong>��� �����:</strong></p>';
	$PAGE .= '<br /><p>�� �������� � �������</p>';
	$PAGE .= '<ul>';
	$PAGE .= '<li><p>����� �����: '.$res['data']['refpay']['forpay'].' ���. <!--(<a title="������ ���������� �� ����������� ��������� �� ����������� �������� � �������" href="#" onClick="divwin=dhtmlwindow.open(\'NachBox\', \'inline\', \'\', \'������ ����������\', \'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=functions&act=ShowNachList&idu='.$_SESSION['A_USER_IDU'].'&type=client\',\'NachBox_inner\',\''.$_conf['base_url'].'\'); return false; "><small>����������</small></a>)--></p></li>';
	$PAGE .= '<li><p style="color:red">��������, � �������� �������: '.$res['data']['refpay']['payorder'].' ���.<!-- (<a title="������ ������ �� �������" href="#" onClick="divwin=dhtmlwindow.open(\'PayOrderBox\', \'inline\', \'\', \'������ ������\', \'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=functions&act=ShowPayOrderList&idu='.$_SESSION['A_USER_IDU'].'&type=client\',\'PayOrderBox_inner\',\''.$_conf['base_url'].'\'); return false; "><small>������</small></a>)--></p></li>';
	$PAGE .= '<li><p style="color:green">����� ���������: '.$res['data']['refpay']['payed'].' ���.<!-- (<a title="������ ������ �� ����������� ���������" href="#" onClick="divwin=dhtmlwindow.open(\'PayedRefBox\', \'inline\', \'\', \'������ ������\', \'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=functions&act=ShowPayedRefList&idu='.$_SESSION['A_USER_IDU'].'&type=client\',\'PayedRefBox_inner\',\''.$_conf['base_url'].'\'); return false; "><small>�������</small></a>)--></p></li>';
	$PAGE .= '<li><p><strong>�������� � �������: '.$topay.' ���.</strong></p></li>';
	if($topay > $res['data']['cab']['ref_minout']){
		$PAGE .= '<li style="border:solid 1px #cccccc;padding:2px;">';
		$PAGE .= '<form method="post" action="'.$_conf['base_url'].'/?p=user_info&act=OrderRefPayment&type=client" enctype="multipart/form-data" id="ORP">';
		$PAGE .= '�������� �������:  <input type="text" name="orderAmount" id="orderAmount" value="'.$topay.'" size="10" /> ���. ';
		$PAGE .= '������ ������: '.$paymethodsel.' ';
		$PAGE .= '<input type="submit" value="��������" />';
		$PAGE .= '</form>';
		$PAGE .= '</li>';
	}else{
		$PAGE .= '<p>����������� ����� ��� ������ �������: '.$res['data']['cab']['ref_minout'].'���.</p>';
	}
	$PAGE .= '</ul>';
	
	
	if($res['data']['cab_main']['ref_admin']=="y" && $res['data']['cab_main']['ref_partner']=="y" && $res['data']['cab_main']['r_partner']=="y"){
		$PAGE .= '<br /><p>�� ���������</p>';
		$PAGE .= '<ul>';
		$PAGE .= '<li><p>����� �����: '.$res['data']['refpay']['pforpay'].' ���.<!-- (<a title="������ ���������� �� ����������� ��������� �� ����������� �������� � �������" href="#" onClick="divwin=dhtmlwindow.open(\'NachBox\', \'inline\', \'\', \'������ ����������\', \'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=functions&act=ShowNachList&idu='.$_SESSION['A_USER_IDU'].'&type=partner\',\'NachBox_inner\',\''.$_conf['base_url'].'\'); return false; "><small>����������</small></a>)--></p></li>';
		$PAGE .= '<li><p style="color:red">��������, � �������� �������: '.$res['data']['refpay']['ppayorder'].' ���.<!-- (<a title="������ ������ �� �������" href="#" onClick="divwin=dhtmlwindow.open(\'PayOrderBox\', \'inline\', \'\', \'������ ������\', \'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=functions&act=ShowPayOrderList&idu='.$_SESSION['A_USER_IDU'].'&type=partner\',\'PayOrderBox_inner\',\''.$_conf['base_url'].'\'); return false; "><small>������</small></a>)--></p></li>';
		$PAGE .= '<li><p style="color:green">����� ���������: '.$res['data']['refpay']['ppayed'].' ���.<!-- (<a title="������ ������ �� ����������� ���������" href="#" onClick="divwin=dhtmlwindow.open(\'PayedRefBox\', \'inline\', \'\', \'������ ������\', \'width=650px,height=550px,left=50px,top=70px,resize=1,scrolling=1\'); getdata(\'\',\'get\',\'?p=functions&act=ShowPayedRefList&idu='.$_SESSION['A_USER_IDU'].'&type=partner\',\'PayedRefBox_inner\',\''.$_conf['base_url'].'\'); return false; "><small>�������</small></a>)--></p></li>';
		$PAGE .= '<li><p><strong>�������� � �������: '.$ptopay.' ���.</strong></p></li>';
		if($ptopay > $res['data']['cab']['ref_minout']){
		$PAGE .= '<li style="border:solid 1px #cccccc;padding:2px;">';
		$PAGE .= '<form method="post" action="'.$_conf['base_url'].'/?p=user_info&act=OrderRefPayment&type=partner" enctype="multipart/form-data" id="ORP">';
		$PAGE .= '�������� �������:  <input type="text" name="orderAmount" id="orderAmount" value="'.$ptopay.'" size="10" /> ���. ';
		$PAGE .= '������ ������: '.$paymethodsel.' ';
		$PAGE .= '<input type="submit" value="��������" />';
		$PAGE .= '</form>';
		$PAGE .= '</li>';
		}else{
			$PAGE .= '<p>����������� ����� ��� ������ �������: '.$res['data']['cab']['ref_minout'].'���.</p>';
		}
		$PAGE .= '</ul>';
	}
	
		$PAGE .= '</div>';
	}

} else {
	$PAGE .= '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>