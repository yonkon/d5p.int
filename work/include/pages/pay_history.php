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

if(isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
else $fromdate = "01.".date("m.Y");

if(isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
else $todate = date("t").".".date("m.Y");

if(isset($_REQUEST['start'])) $_SESSION['phstart'] = $_REQUEST['start'];
if(!isset($_SESSION['phstart'])) $_SESSION['phstart'] = 0;
$start = $_SESSION['phstart'];

$data = array();
$data['pars']['start'] = $start;
$data['pars']['type'] = $type;
$data['pars']['fromdate'] = $fromdate;
$data['pars']['todate'] = $todate;
$res = SendRemoteRequest("LoadPayHistoryPage", $data);

if($res['status']['code']==0){
	
	$PAGE .= '<div class="block"><form method="post" action="'.$_conf['base_url'].'/?p=pay_history&start=0" enctype="multipart/form-data" id="SOForm">
	<table border="0" cellpadding="2">
	<tr><td>за период 
		с  <input type="text" name="fromdate" id="fromdate" class="datetextbox" style="width:100px;" value="'.$fromdate.'" />
		по <input type="text" name="todate" id="todate" class="datetextbox" style="width:100px;" value="'.$todate.'" />
		<input type="submit" name="selectdata" id="selectdata" value="Показать" />
	</td></tr>
	</table>
	</form></div>
	<script type="text/javascript">
 	Calendar.setup({
 		inputField : "fromdate",
		ifFormat : "%d.%m.%Y",
		showsTime : true
	});
 	Calendar.setup({
 		inputField : "todate",
		ifFormat : "%d.%m.%Y",
		showsTime : true
	});
	</script>
	';

	$plist = Paging($res['data']['rows'],$res['data']['interval'],$start, $_conf['base_url']."/?p=pay_history&start=%start1%&fromdate=".$fromdate."&todate=".$todate,"");
	$PAGE .= $plist;
	$PAGE .= '<br />';
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>Заказ №</th><th>Тип</th><th>Цена</th><th>Штраф</th><th>Дата платежа</th><th>Выплачено</th><th>Комментарий</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$res['data']['tab'][$k]['ido']."' style='".$res['data']['tab'][$k]['bgtype']."'>";
		while(list($key, $val) = each($v)){
			if($key == "ido") $PAGE .= "<td><a title='Заказ №".$res['data']['tab'][$k]['ido']."' href='javascript:void(null)' onClick=\"owin=dhtmlwindow.open('InfoEstimateOrderBox', 'inline', '', 'Заказ №".$res['data']['tab'][$k]['ido']."', 'width=850px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); owin.moveTo('middle','middle'); getdata('','get','?p=functions&act=InfoEstimateOrder&ido=".$res['data']['tab'][$k]['ido']."','InfoEstimateOrderBox_inner','".$_conf['base_url']."'); return false; \">".$val."</a></td>";
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