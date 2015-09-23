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

if(isset($_REQUEST['start'])) $_SESSION['nnstart'] = $_REQUEST['start'];
if(!isset($_SESSION['nnstart'])) $_SESSION['nnstart'] = 0;
$start = $_SESSION['nnstart'];

$data = array();
$data['pars']['start'] = $start;
$data['pars']['type'] = $type;
$res = SendRemoteRequest("LoadAvtorInvorkPage", $data);

if($res['status']['code']==0){
	
	$plist = Paging($res['data']['rows'],$res['data']['interval'],$start, $_conf['base_url']."/?p=order_avtor_invork&start=%start1%","");
	$PAGE .= $plist;
	$PAGE .= '<br />';
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>№</th><th>Срок сдачи</th><th>Цена</th><th>Тема</th><th>Предмет работы</th><th>Тип работы</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$res['data']['tab'][$k]['ido']."' style='".$res['data']['tab'][$k]['bgtype']."'>";
		while(list($key, $val) = each($v)){
			if($key != "o_sub"){
				if($key == "thema") $PAGE .= "<td><a href='".$_conf['base_url']."/?p=order_avtor&ido=".$res['data']['tab'][$k]['ido']."'>".$val."</a></td>";
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