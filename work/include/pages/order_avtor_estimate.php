<?
/**
* Главная страница системы учёта
* @package ShiftCMS
* @subpackage ORDER
* @version 1.00 15.02.2011
* @author Volodymyr Demchuk, http://shiftcms.net
*/

if(!defined('SHIFTCMS')){
	exit;
}

if(isset($_REQUEST['start'])) $_SESSION['oestart'] = $_REQUEST['start'];
if(!isset($_SESSION['oestart'])) $_SESSION['oestart'] = 0;
$start = $_SESSION['oestart'];

$data = array();
if(isset($_REQUEST['act']) && $_REQUEST['act']=="Estimate"){
	$data['pars']['act'] = "Estimate";
	$data['pars']['ido'] = $_REQUEST['ido'];
	$data['pars']['type'] = $_REQUEST['type'];
	if(isset($_REQUEST['amount'])) $data['pars']['amount'] = $_REQUEST['amount'];
	if(isset($_REQUEST['srok'])) $data['pars']['srok'] = $_REQUEST['srok'];
	if(isset($_REQUEST['id'])) $data['pars']['id'] = $_REQUEST['id'];
	if(isset($_REQUEST['messag'])) $data['pars']['messag'] = $_REQUEST['messag'];
	if(isset($_REQUEST['messag1'])) $data['pars']['messag1'] = $_REQUEST['messag1'];
}
$data['pars']['start'] = $start;
$res = SendRemoteRequest("LoadAvtorEstimatePage", $data);

if($res['status']['code']==0){

	if(isset($res['data']['info']) && $res['data']['info']!="") $PAGE .= "<p style='color:green;padding:3px; border:dotted 1px green;'><strong>".$res['data']['info']."</strong></p><br />";
	if(isset($res['data']['ermsg']) && $res['data']['ermsg']!="") $PAGE .= "<p style='color:red;padding:3px; border:dotted 1px red;'><strong>".$res['data']['ermsg']."</strong></p><br />";
	
	$plist = Paging($res['data']['rows'],$res['data']['interval'],$start, $_conf['base_url']."/?p=order_avtor_estimate&start=%start1%","");
	$PAGE .= $plist;
	$PAGE .= '<br /><form method="post" action="'.$_conf['base_url'].'/?p=order_avtor_estimate&act=Estimate&type=nomass" enctype="multipart/form-data" id="MassEst">';
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th><input type=\"checkbox\" onclick=\"setall('checkbox_ido');\" /></th><th>№</th><th>Дата оформления</th><th>Срок сдачи</th><th>Тема</th><th>Дисциплина</th><th>Тип работы</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$res['data']['tab'][$k]['ido']."'>";
		while(list($key, $val) = each($v)){
			if($key != "state" && $key != "id"){
				if($key == "thema") $PAGE .= "<td><a title='Оценить заказ №".$res['data']['tab'][$k]['ido']."' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('EstimateOrderBox', 'inline', '', 'Оценить заказ №".$res['data']['tab'][$k]['ido']."', 'width=850px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=functions&act=EstimateOrder&ido=".$res['data']['tab'][$k]['ido']."&state=".$res['data']['tab'][$k]['state']."&id=".$res['data']['tab'][$k]['id']."','EstimateOrderBox_inner','".$_conf['base_url']."'); return false; \">".$val."</a></td>";
				else $PAGE .= "<td>".$val."</td>";
			}
		}
		$PAGE .= "</tr>";
	}
	$PAGE .= '</tbody></table>';
	$PAGE .= '<input type="submit" value="Отказаться от выбранных заказов" />';
	$PAGE .= '</form><br />';
	$PAGE .= $plist;
	
	
} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>