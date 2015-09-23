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

$data = array();
$res = SendRemoteRequest("LoadAlerts", $data);

if($res['status']['code']==0){
//-----------------------------------------------------------------------------
	$NewMessage = '';
	if(count($res['data']['alerts'])>0){
		if(isset($res['data']['alerts']['neworder'])){
			$NewMessage .= "<div id='IEst'><a href='".$_conf['base_url']."/?p=order_avtor_estimate'>У Вас есть новые заказы на оценку (".$res['data']['alerts']['neworder'].")</a><br /></div>";
		}
		if(isset($res['data']['alerts']['newmail'])){
			$NewMessage .= "<div id='AMail'><a href='".$_conf['base_url']."/?p=usermail'>У Вас есть новая почта (".$res['data']['alerts']['newmail'].")</a><br /></div>";
		}
		
			$PAGE .= '<div id="somediv" style="display:none;">'.$NewMessage.'</div>
			<a href="javascript:void(null)" onClick="divwin=dhtmlwindow.open(\'divbox\', \'div\', \'somediv\', \'Информер\', 
            \'width=450px,height=400px,left=50px,top=100px,resize=1,scrolling=1\'); return false" style="padding:0px;margin:0px;">
			<img src=\''.$_conf['base_url'].'/template/img/alert.gif\' width=\'16\' height=\'16\' 
			alt=\'Информер\' style="border:0px;vertical-align:middle;" /></a>';
	}else{
		$PAGE .= '';
	}
} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>