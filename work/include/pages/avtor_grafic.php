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

$days = 10; // За какой период (дней) выводить график от стартовой даты

$date_start = isset($_REQUEST['date_start']) ? stripslashes($_REQUEST['date_start']) : date("d.m.Y", time());

$data = array();
$data['pars']['start'] = $start;
$data['pars']['date_start'] = $date_start;
$data['pars']['days'] = $days;

$res = SendRemoteRequest("LoadAvtorGraficPage", $data);

if($res['status']['code']==0){
	
			$aidu = $_SESSION['USER_IDU'];
			$avtor_ar[$aidu] = array('pro'=>array(),'emp'=>'&nbsp;');
			for($j=0;$j<$days;$j++){
				$avtor_ar[$aidu][$j] = array();
			}

	$PAGE .= '<div class="block"><form method="post" action="'.$_conf['base_url'].'/?p=avtor_grafic" enctype="multipart/form-data" id="SOForm">
	<table border="0" cellpadding="2">
	<tr>
		<td>Дата:<br /><input type="text" name="date_start" id="date_start" class="datetextbox" style="width:100px;" value="'.$date_start.'" /></td>
		<td>&nbsp;<br /><input type="submit" name="selectdata" id="selectdata" value="Показать" /></td>
	</tr>
	</table>
	</form></div>
	<script type="text/javascript">
 	Calendar.setup({
 		inputField : "date_start",
		ifFormat : "%d.%m.%Y",
		showsTime : true
	});
	</script>
	';
	$PAGE .= '<br />
	<span class="plan_n">План, не утвержден</span>
	<span class="full">Полностью работа</span>
	<span class="towork">На доработке</span>
	<span class="fre"></span>
	<br />';

	/**
	* Вывод данных на печать
	*/
	$PAGE .= '<table border="0" cellspacing="0" class="selrow" width="100%" id="OrderTab">';
	$PAGE .= "<thead><tr><th>Просроченные</th>
	<th><a href='".$_conf['base_url']."/?p=avtor_grafic&date_start=".date("d.m.Y",$res['data']['d_start_left'])."'> &laquo;&laquo; </a></th>";

	$IS = date("I",$res['data']['d_start']);
	for($j=0; $j<$days; $j++){
		$dd1 = $res['data']['d_start'] + 86400*$j;
		$dd2 = $dd1 + 86400-1;
		$I2 = date("I",$dd2); $I1 = date("I",$dd1); 
		if($IS > $I2){ $dd2 = $dd2 + 3600; if($I1 == $I2) $dd1 = $dd1 + 3600; }
		if($IS < $I2){ $dd2 = $dd2 - 3600; if($I1 == $I2) $dd1 = $dd1 - 3600; }

		$ap = "";
		if(date("d.m.Y",$dd1)==date("d.m.Y",time())) $ap = "<br /><span class='scena'>Сегодня</span>";
		elseif(date("d.m.Y",$dd1)==date("d.m.Y",time()+24*3600)) $ap = "<br /><span class='syellow'>Завтра</span>";
		elseif($dd1 < time()-24*3600) $ap = "<br /><span class='sselect'>".$_conf['week_list1'][date("w",$dd1)]."</span>";
		else $ap = "<br /><span class='sdate'>".$_conf['week_list1'][date("w",$dd1)]."</span>";
		$PAGE .= "<th>".date("d.m.Y",$dd1).$ap."</th>";
	}
	$PAGE .= "<th><a href='".$_conf['base_url']."/?p=avtor_grafic&date_start=".date("d.m.Y",$res['data']['d_start_right'])."'> &raquo;&raquo; </a></th></tr></thead><tbody>";

	reset($res['data']['avtor_ar']); 

	$i = 0;
	while(list($k, $v) = each($res['data']['avtor_ar'])){
		$PAGE .= "<tr id='R_".$k."'>";
		while(list($key, $val) = each($v)){
			if(is_array($val) && count($val)>0){
				if(isset($val['class'])){ $tdc = $val['class']; unset($val['class']); }
				else $tdc = "";
				$PAGE .= "<td class='".$tdc."'>".implode(", ",$val)."</td>";
			}
			else if(!is_array($val)) $PAGE .= "<td>".$val."</td>";
			else $PAGE .= "<td>&nbsp;</td>";
		}
		$PAGE .= "<td>&nbsp;</td></tr>";
		$i++;
	}
	$PAGE .= '</tbody></table>';
	
} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>