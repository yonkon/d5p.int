<?
/**
* Поиск заказов по базе, вывод результатов поиска
* @package ShiftCMS
* @subpackage ORDER
* @version 1.00 19.02.2011
* @author Volodymyr Demchuk
* @link http://shiftcms.net
* CLIENT
*/

if(!defined('SHIFTCMS')){
	exit;
}
include("include/pages/a_search.php");

$addpar = '';
if(isset($_REQUEST['start'])) $_SESSION['astart'] = $_REQUEST['start'];
if(!isset($_SESSION['astart'])) $_SESSION['astart'] = 0;
$start = $_SESSION['astart'];

$data = array();
$data['pars']['start'] = $start;
$data['pars']['ido'] = $ido;
$data['pars']['o_thema'] = $o_thema;
$data['pars']['o_state'] = $o_state;
$res = SendRemoteRequest("LoadSearchResPage", $data);

if($res['status']['code']==0){
	
	$plist = Paging($res['data']['rows'],$res['data']['interval'],$start, $_conf['base_url']."/?p=a_searchres&start=%start1%&ido=".$ido."&o_state=".$o_state."&o_thema=".$o_thema,"");
	$PAGE .= $plist;
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>№</th><th>Тема</th><th>Раздел</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$v['ido']."'>";
		while(list($key, $val) = each($v)){
			if($key!="ltype"){
				if($key=="thema"){
					if($res['data']['tab'][$k]['ltype']=="window") $PAGE .= "<td><a title='Заказ №".$res['data']['tab'][$k]['ido']."' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('InfoEstimateOrderBox', 'inline', '', 'Заказ №".$res['data']['tab'][$k]['ido']."', 'width=850px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=functions&act=InfoEstimateOrder&ido=".$res['data']['tab'][$k]['ido']."','InfoEstimateOrderBox_inner','".$_conf['base_url']."'); return false; \">".$val."</a></td>";
					if($res['data']['tab'][$k]['ltype']=="page") $PAGE .= "<td><a title='Заказ №".$res['data']['tab'][$k]['ido']."' href='".$_conf['base_url']."/?p=order_avtor&ido=".$res['data']['tab'][$k]['ido']."'>".$val."</a></td>";
				}else{
					$PAGE .= "<td>".$val."</td>";
				}
			}
		}
		$PAGE .= "</tr>";
	}
	$PAGE .= '</tbody></table>';
	$PAGE .= $plist;

} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}

?>