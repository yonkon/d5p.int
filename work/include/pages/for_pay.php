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

if(isset($_REQUEST['fromdate'])) $fromdate = $_REQUEST['fromdate'];
else $fromdate = "01.".date("m.Y");

if(isset($_REQUEST['todate'])) $todate = $_REQUEST['todate'];
else $todate = date("t").".".date("m.Y");

$data = array();
$data['pars']['fromdate'] = strtotime($fromdate);
$data['pars']['todate'] = strtotime($todate);

$res = SendRemoteRequest("LoadForPayPage", $data);

if($res['status']['code']==0){
	$PAGE .= '<div class="block"><form method="post" action="'.$_conf['base_url'].'/?p=for_pay" enctype="multipart/form-data" id="SOForm">
	<table border="0" cellpadding="2">
	<tr><td>�� ������ 
		�  <input type="text" name="fromdate" id="fromdate" class="datetextbox" style="width:100px;" value="'.$fromdate.'" />
		�� <input type="text" name="todate" id="todate" class="datetextbox" style="width:100px;" value="'.$todate.'" />
		<input type="submit" name="selectdata" id="selectdata" value="��������" />
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
	
	if(count($res['data']['tab'])>0){
	$PAGE .= '<br />';
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>����� �</th><th>���������, ������ ��������</th><th>���</th><th>����</th><th>�����</th><th>��������</th><th>� ������</th></tr></thead><tbody>";
	reset($res['data']['tab']);
	while(list($k, $v) = each($res['data']['tab'])){
		$PAGE .= "<tr id='R_".$res['data']['tab'][$k]['ido']."' style='".$res['data']['tab'][$k]['bgtype']."'>";
		while(list($key, $val) = each($v)){
			if($key != "thema"){
				if($key == "ido") $PAGE .= "<td><a title='".$res['data']['tab'][$k]['thema']."' href='".$_conf['base_url']."/?p=order_avtor&ido=".$res['data']['tab'][$k]['ido']."'>".$val."</a></td>";
				else $PAGE .= "<td>".$val."</td>";
			}
		}
		$PAGE .= "</tr>";
	}
	$PAGE .= "<tr><td colspan='3' style='font-weight:bold;text-align:right;'>�����:</td><td><strong>".$res['data']['summary']['avtor_cena']."</strong></td><td><strong>".$res['data']['summary']['penalty']."</strong></td><td><strong>".$res['data']['summary']['payed']."</strong></td><td><strong>".$res['data']['summary']['topay']."</strong></td></tr>";
	$PAGE .= '</tbody></table>';
	$PAGE .= '<br />';
	}else{
		$PAGE .= '<strong>��� ������ ��������������� �������!</strong>';
	}
} else {
	$PAGE .= '<strong>������:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>