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

$addpar = "";
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
if($type!="") $addpar .= "&type=".$type;

if(isset($_REQUEST['start'])) $_SESSION['esstart'] = $_REQUEST['start'];
if(!isset($_SESSION['esstart'])) $_SESSION['esstart'] = 0;
$start = $_SESSION['esstart'];

$data = array();
$data['pars']['start'] = $start;
$data['pars']['type'] = $type;
$res = SendRemoteRequest("LoadAvtorEstresPage", $data);

if($res['status']['code']==0){
	
	$PAGE .= '<a href="'.$_conf['base_url'].'/?p=order_avtor_estres&start=0">Все</a> | <a href="'.$_conf['base_url'].'/?p=order_avtor_estres&type=yes&start=0">Только оцененные</a> | <a href="'.$_conf['base_url'].'/?p=order_avtor_estres&type=no&start=0">Только отказные</a><br /><br />';

	$plist = Paging($res['data']['rows'],$res['data']['interval'],$start, $_conf['base_url']."/?p=order_avtor_estres&start=%start1%".$addpar,"");
	$PAGE .= $plist;
	$PAGE .= '<br />';
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>№</th><th>Дата оформления</th><th>Тема</th><th>Дисциплина</th><th>Тип работы</th><th>Ваше решение</th><th>Ваша цена</th><th>Комментарий</th><th>Дата оценки</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$res['data']['tab'][$k]['ido']."' style='".$res['data']['tab'][$k]['bgtype']."'>";
		while(list($key, $val) = each($v)){
			if($key != "bgtype"){
				if($key == "thema") $PAGE .= "<td><a title='Оценить заказ №".$res['data']['tab'][$k]['ido']."' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('InfoEstimateOrderBox', 'inline', '', 'Оценить заказ №".$res['data']['tab'][$k]['ido']."', 'width=850px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=functions&act=InfoEstimateOrder&ido=".$res['data']['tab'][$k]['ido']."','InfoEstimateOrderBox_inner','".$_conf['base_url']."'); return false; \">".$val."</a></td>";
				else $PAGE .= "<td>".$val."</td>";
			}
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