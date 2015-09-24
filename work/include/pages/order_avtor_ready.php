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

if(isset($_REQUEST['start'])) $_SESSION['rstart'] = $_REQUEST['start'];
if(!isset($_SESSION['rstart'])) $_SESSION['rstart'] = 0;
$start = $_SESSION['rstart'];

$data = array();
$data['pars']['start'] = $start;
$res = SendRemoteRequest("LoadAvtorReadyPage", $data);

if($res['status']['code']==0){
	
	$plist = Paging($res['data']['rows'],$res['data']['interval'],$start, $_conf['base_url']."/?p=order_avtor_ready&start=%start1%","");
	$PAGE .= $plist;
	$PAGE .= '<br />';
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>№</th><th>Срок сдачи</th><th>Цена</th><th>Тема</th><th>Предмет работы</th><th>Тип работы</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$res['data']['tab'][$k]['ido']."' style='".$res['data']['tab'][$k]['bgtype']."'>";
		while(list($key, $val) = each($v)){
				if($key == "thema") $PAGE .= "<td><a title='Оценить заказ №".$res['data']['tab'][$k]['ido']."' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('InfoEstimateOrderBox', 'inline', '', 'Оценить заказ №".$res['data']['tab'][$k]['ido']."', 'width=850px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=functions&act=InfoEstimateOrder&ido=".$res['data']['tab'][$k]['ido']."','InfoEstimateOrderBox_inner','".$_conf['base_url']."'); return false; \">".$val."</a></td>";
				else $PAGE .= "<td>".$val."</td>";
		}
		$PAGE .= "</tr>";
	}
	$PAGE .= '</tbody></table>';
	$PAGE .= '<br />';
	$PAGE .= $plist;
	
	
} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>