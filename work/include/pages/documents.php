<?
/**
* Страница с документами
* @author alexby
*/

if(!defined('SHIFTCMS')){
	exit;
}

$data = array();
$res = SendRemoteRequest("LoadMainPage", $data);

if($res['status']['code']==0){
//-----------------------------------------------------------------------------
	$PAGE .= '<table border="0" cellspacing="20"><tr><td valign="top">';

	if(count($res['data']['doc'])>0){
		$doc = '<table border="0" cellspacing="0" class="selrow">';
		while (list($k,$v)=each($res['data']['doc'])) { 
		    $doc .= '<tr>
			<td><a href="'.$_conf['base_url'].'?p=getfile&idd='.$res['data']['doc'][$k]['idd'].'&type=doc"><strong>'.$v['dfile'].'</strong></a></td>
			<td>'.$v['dsign'].'</td>
			<td>'.date("d.m.Y", $v['ddate']).'</td>
			</tr>';
		}
		$doc .= '</table>';
		$PAGE .= '<div id="docBlock">'.$doc.'</div>';
	}
		$PAGE .= '</td></tr></table><hr><br />';

} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}