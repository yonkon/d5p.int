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
$res = SendRemoteRequest("LoadMainPage", $data);

if($res['status']['code']==0){
//-----------------------------------------------------------------------------
	$PAGE .= '<table border="0" cellspacing="20"><tr><td valign="top">
	<h2>Здравствуйте, '.$_SESSION['A_USER_LOGIN'].'!</h2><br />
	Для продолжения работы выберите пункт меню из выпадающего списка.<br />
	Если в левом верхнем углу мерцает восклицательный знак, значит произошли события требующие Вашего внимания.
	';

	if(count($res['data']['doc'])>0){
		$doc = "<br /><br /><h1>Документация</h1><br />";
		$doc .= '<table border="0" cellspacing="0" class="selrow">';
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


		$show_news_dialog = false;
	if(count($res['data']['news'])>0 && $res['data']['news'][0]['ntime'] > $_SESSION['A_USER_LAST_ACCES'] && $_SESSION['A_SHOWPOPUPNEWS']){
		$_SESSION['A_SHOWPOPUPNEWS'] = false;
		$show_news_dialog = true;
		$news = "<br /><br /><h1>Новости</h1><br />";
		while (list($k,$v)=each($res['data']['news'])) { 
		    $news .= "<div style='margin-bottom:5px;border:solid 1px #cccccc;padding:5px;'>
			<strong>".$res['data']['news'][$k]['date']."</strong><br />
		    <h3>".$res['data']['news'][$k]['title']."</h3>".$res['data']['news'][$k]['text']."</div>";
		}
		$PAGE .= '<div style="display:none;" id="newsBlock">'.$news.'</div>';

		$PAGE .= '<div id="dialog-news" title="Новости системы">'.$news.'</div>';
	}

	
		$PAGE .= '</td><td valign="top" width="220">';
	
		$PAGE .= "<div class='blockw' style='padding-left:10px; padding-right:10px;'>";
		$PAGE .= "<h2>Ваш работодатель:</h2><strong>".$res['data']['owner']['fio']."</strong><br />
		<small>E-mail:</small> ".$res['data']['owner']['email']."<br />";
		if(trim($res['data']['owner']['mphone'])!="") $PAGE .= "Телефон: ".$res['data']['owner']['mphone']."<br />";	
		if(trim($res['data']['owner']['skype'])!="") $PAGE .= "Skype: ".$res['data']['owner']['skype']."<br />";	
		if(trim($res['data']['owner']['icq'])!="") $PAGE .= "ICQ #: ".$res['data']['owner']['icq']."<br />";	
		$PAGE .= "<hr />";
	
	if(count($res['data']['partner'])>0){
		$PAGE .= "<br /><h2>Директор:</h2>";
		while(list($k,$v)=each($res['data']['partner'])){
			$PAGE .= "<strong>".$res['data']['partner'][$k]['fio']."</strong><br />
			<small>E-mail:</small> ".$res['data']['partner'][$k]['email']."<br />";
			if(trim($res['data']['partner'][$k]['mphone'])!="") $PAGE .= "Телефон: ".$res['data']['partner'][$k]['mphone']."<br />";
			if(trim($res['data']['partner'][$k]['skype'])!="") $PAGE .= "Skype: ".$res['data']['partner'][$k]['skype']."<br />";
			if(trim($res['data']['partner'][$k]['icq'])!="") $PAGE .= "ICQ #: ".$res['data']['partner'][$k]['icq']."<br />";
			$PAGE .= "<hr />";
		}
	}

	if(count($res['data']['manager'])>0){
		$PAGE .= "<br /><h2>Менеджеры:</h2>";
		while(list($k,$v)=each($res['data']['manager'])){
			$PAGE .= "<strong>".$res['data']['manager'][$k]['fio']."</strong><br />
			<small>E-mail:</small> ".$res['data']['manager'][$k]['email']."<br />";
			if(trim($res['data']['manager'][$k]['mphone'])!="") $PAGE .= "Телефон: ".$res['data']['manager'][$k]['mphone']."<br />";
			if(trim($res['data']['manager'][$k]['skype'])!="") $PAGE .= "Skype: ".$res['data']['manager'][$k]['skype']."<br />";
			if(trim($res['data']['manager'][$k]['icq'])!="") $PAGE .= "ICQ #: ".$res['data']['manager'][$k]['icq']."<br />";
			$PAGE .= "<hr />";
		}
	}

	$PAGE .= '</td></tr></table><hr><br />';

} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>