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
if(isset($_REQUEST['ido']) && is_numeric($_REQUEST['ido'])) $ido = $_REQUEST['ido'];
else { echo "Не выбран заказ!"; exit; }

$uplmethod = function_exists("curl_init") ? 'curl' : 'soap';

/**
* Загрузка файла к заказу
*/
/*
if(isset($_REQUEST['act']) && $_REQUEST['act']=="AddFile"){
	$er = 0;
	$data = array(); $fdata = array();
	$data['pars']['ido'] = $ido;
	$res = SendRemoteRequest("LoadOrderPage", $data);
	
	$oi = $res['data']['oi'];
	if($oi == false) {$PAGE .= "Заказ не найден!"; $er = 1;}
	$ido = $oi['ido'];
	if($_REQUEST['f_part']=='0'){
		$er = 1; $PAGE .= "Пожалуйста, укажите тип загружаемого файла!";
	}
	$fdata['pars']['ido'] = $ido;
	$fdata['pars']['f_part'] = stripslashes($_REQUEST['f_part']);
	$fdata['pars']['f_comment'] = stripslashes($_REQUEST['f_comment']);
	if(stripslashes($_REQUEST['f_part'])=='Полностью работа' && 
	(strlen($oi['o_content'])<2 || strlen($oi['o_vvedenie'])<2 || strlen($oi['o_zakluchenie'])<2 || strlen($oi['o_literatura'])<2)){
		$er = 1; $PAGE .= "Пожалуйста, прежде, чем загрузить полностью работу, заполните все поля формы в блоке \"Оглавление\"!";
	}
		if(isset($_FILES) && $er==0){
			require_once("include/uploader.php");
			$upl = new uploader;
			$files = $upl -> ConvertFileArray("ofile");
			$f = 0;
			while(list($k,$v)=each($files)){
				if($v['name']!=""){
					$dir = $_conf['docroot']."/".$_conf['tmpdir'];
					$upl -> rewrite = 1;
					$upl -> fname = $dir."/".$v['name'];
					$uplres = $upl -> SaveFile($v);
					if($uplres == true){
						$pp = pathinfo($dir."/".$v['name']);
					    $fdata['pars']['file'][$f]['cont'] = base64_encode(file_get_contents($dir."/".$v['name']));
					    $fdata['pars']['file'][$f]['md5'] = md5_file($dir."/".$v['name']);
						$fdata['pars']['file'][$f]['ext'] = $pp['extension'];
						$fdata['pars']['file'][$f]['name'] = $v['name'];
						$f++;
					}else $PAGE .= $uplres.'<br />';
				}
			}
			$fres = SendRemoteRequest("UploadOrderFile", $fdata);
			if($fres['status']['code']==0){
				$PAGE .= $fres['status']['msg'];
			} else {
				$PAGE .= '<strong>Ошибка:</strong> '.$fres['status']['code'].' - '.$fres['status']['msg'];
			}
		}
	unset($_REQUEST['act']);
	unset($data);
}
*/



if(isset($_REQUEST['act']) && $_REQUEST['act']=="AddFile"){
	$er = 0;
	$data = array(); $fdata = array();
	$data['pars']['ido'] = $ido;
	$res = SendRemoteRequest("LoadOrderPage", $data);
	
	$oi = $res['data']['oi'];
	if($oi == false) {$PAGE .= "Заказ не найден!"; $er = 1;}
	$ido = $oi['ido'];
	if($_REQUEST['f_part']=='0'){
		$er = 1; $PAGE .= "Пожалуйста, укажите тип загружаемого файла!";
	}

	if($uplmethod=="soap"){
		$fdata['pars']['ido'] = $ido;
		$fdata['pars']['f_part'] = stripslashes($_REQUEST['f_part']);
		$fdata['pars']['f_comment'] = stripslashes($_REQUEST['f_comment']);
	}else{
		$fdata['ido'] = $ido;
		$fdata['f_part'] = stripslashes($_REQUEST['f_part']);
		$fdata['f_comment'] = stripslashes($_REQUEST['f_comment']);
	}
	if(stripslashes($_REQUEST['f_part'])=='Полностью работа' && 
	(strlen($oi['o_content'])<2 || strlen($oi['o_vvedenie'])<2 || strlen($oi['o_zakluchenie'])<2 || strlen($oi['o_literatura'])<2)){
		$er = 1; $PAGE .= "Пожалуйста, прежде, чем загрузить полностью работу, заполните все поля формы в блоке \"Оглавление\"!";
	}
		if(isset($_FILES) && $er==0){
			require_once("include/uploader.php");
			$upl = new uploader;
			$files = $upl -> ConvertFileArray("ofile");
			$f = 0;
			while(list($k,$v)=each($files)){
				if($v['name']!=""){
					$dir = $_conf['docroot']."/".$_conf['tmpdir'];
					$upl -> rewrite = 1;
					$upl -> fname = $dir."/".$v['name'];
					$uplres = $upl -> SaveFile($v);
					if($uplres == true){
						$pp = pathinfo($dir."/".$v['name']);
						if($uplmethod=="soap"){
						    $fdata['pars']['file'][$f]['cont'] = base64_encode(file_get_contents($dir."/".$v['name']));
						    $fdata['pars']['file'][$f]['md5'] = md5_file($dir."/".$v['name']);
							$fdata['pars']['file'][$f]['ext'] = $pp['extension'];
							$fdata['pars']['file'][$f]['name'] = $v['name'];
						}else{
					    //$fdata['pars']['file'][$f]['cont'] = base64_encode(file_get_contents($dir."/".$v['name']));
						    $fdata['md5'.$f] = md5_file($dir."/".$v['name']);
							$fdata['ext'.$f] = $pp['extension'];
							$fdata['name'.$f] = $v['name'];
							$fdata['work_attach'.$f] = '@'.$dir."/".$v['name'];
						}
						$f++;
					}else $PAGE .= $uplres.'<br />';
				}
			}
			
			
			if($uplmethod=="soap"){
				$fres = SendRemoteRequest("UploadOrderFile", $fdata);
				if($fres['status']['code']==0){
					$PAGE .= $fres['status']['msg'];
				} else {
					$PAGE .= '<strong>Ошибка:</strong> '.$fres['status']['code'].' - '.$fres['status']['msg'];
				}
			}else{
				$fdata['act'] = "UploadOrderFile";
				$fres = SendRemoteRequestCURL($fdata);
				$fr = explode("::",$fres);
				if($fr[0]=='OK'){
					$PAGE .= '<strong>'.$fr[1].'</strong>';
				} else {
					$PAGE .= '<strong>Ошибка:</strong> '.$fr[1];
				}
			}
		}
	unset($_REQUEST['act']);
	unset($data);
}



if(isset($_REQUEST['act']) && $_REQUEST['act']=="addPlagiat"){
	$er = 0;
	$data = array(); $fdata = array();
	$data['pars']['ido'] = $ido;
	$res = SendRemoteRequest("LoadOrderPage", $data);
	$oi = $res['data']['oi'];
	if($oi == false) {$PAGE .= "Заказ не найден!"; $er = 1;}
	$ido = $oi['ido'];
	
	if($uplmethod=="soap"){
		$fdata['pars']['plagiatcom'] = stripslashes($_REQUEST['plagiatcom']);
		$fdata['pars']['ido'] = $ido;
	}else{
		$fdata['plagiatcom'] = stripslashes($_REQUEST['plagiatcom']);
		$fdata['ido'] = $ido;
	}
	if(stripslashes($_REQUEST['plagiatcom'])=='' && $_FILES['plagiatfile']['name']==""){
		$er = 1;
		$PAGE .= "Пожалуйста, прежде, чем загрузить полностью работу, заполните все поля формы";
	}
		if(isset($_FILES) && $er==0){
			require_once("include/uploader.php");
			$upl = new uploader;
			if($_FILES['plagiatfile']['name']!=""){
				$dir = $_conf['docroot']."/".$_conf['tmpdir'];
				$upl -> rewrite = 1;
				$upl -> fname = $dir."/".$_FILES['plagiatfile']['name'];
				$uplres = $upl -> SaveFile($_FILES['plagiatfile']);
				if($uplres == true){
					$pp = pathinfo($dir."/".$_FILES['plagiatfile']['name']);
					if($uplmethod=="soap"){
					    $fdata['pars']['file']['cont'] = base64_encode(file_get_contents($dir."/".$_FILES['plagiatfile']['name']));
					    $fdata['pars']['file']['md5'] = md5_file($dir."/".$_FILES['plagiatfile']['name']);
						$fdata['pars']['file']['ext'] = $pp['extension'];
						$fdata['pars']['file']['name'] = $_FILES['plagiatfile']['name'];
					}else{
					    $fdata['md5'] = md5_file($dir."/".$_FILES['plagiatfile']['name']);
						$fdata['ext'] = $pp['extension'];
						$fdata['name'] = $_FILES['plagiatfile']['name'];
						$fdata['plagiat'] = '@'.$dir."/".$_FILES['plagiatfile']['name'];
					}
				}else $PAGE .= $uplres.'<br />';
			}
			if($uplmethod=="soap"){
				$fres = SendRemoteRequest("UploadPlagiatFile", $fdata);
				if($fres['status']['code']==0){
					$PAGE .= $fres['status']['msg'];
				} else {
					$PAGE .= '<strong>Ошибка:</strong> '.$fres['status']['code'].' - '.$fres['status']['msg'];
				}
			}else{
				$fdata['act'] = "UploadPlagiatFile";
				$fres = SendRemoteRequestCURL($fdata);
				echo $fres;
				$fr = explode("::",$fres);
				if($fr[0]=='OK'){
					$PAGE .= '<strong>'.$fr[1].'</strong>';
				} else {
					$PAGE .= '<strong>Ошибка:</strong> '.$fr[1];
				}
			}
		}
	unset($_REQUEST['act']);
	unset($data);
}

/* вывод страницы заказа */
$data = array();
$data['pars']['ido'] = $ido;
$res = SendRemoteRequest("LoadOrderPage", $data);

if($res['status']['code']==0){
	
	$oi = $res['data']['oi'];
	if($oi == false) {$PAGE .= "Заказ не найден!"; exit;}
	$ido = $oi['ido'];
	$PAGETITLE = $oi['stst']." : <a href='".$_conf['base_url']."/?p=order_avtor&ido=".$ido."'>Заказ №".$ido."</a>";
	if(trim($oi['o_substate'])=="") $oi['o_substate'] = "0";

	$PAGE .= "<table border='0' cellpadding='0' cellspacing='4' width='100%'><tr><td valign='top' width='50%'>";

	$PAGE .= "<div id='OrderBlock' class='OuterBlock'>
	<div class='BlockHeader'><table border='0' width='100%'><tr>
	<td width='20'><img src='".$_conf['base_url']."/template/img/down_ar.gif' id='go1' width='16' height='16' alt='' /></td><td><span>Информация о заказе</span></td>
	<td align='right'>
	 &nbsp;&nbsp;
	</td></tr></table></div></div>
	<div id='OB_inner' class='InnerBlock'>".OutOrderInfoSoap($oi)."</div>";

	$PAGE .= "<div id='PlanBlock' class='OuterBlock'>
	<div class='BlockHeader'><table border='0' width='100%'><tr>
	<td width='20'><img src='".$_conf['base_url']."/template/img/down_ar.gif' id='pgo' width='16' height='16' alt='' /></td><td><span>План выполнения работы</span></td>
	<td align='right'>&nbsp;</td></tr></table></div></div>
	<div id='PLB_inner' class='InnerBlock'>".OutOrderPlanSoap($ido, $res['data']['oi']['plan'])."</div>";

	$PAGE .= "</td><td valign='top' width='50%'>";  // ВТОРАЯ КОЛОНКА ТАБЛИЦЫ С БЛОКАМИ

	$PAGE .= "<div id='FileBlock' class='OuterBlock'>
	<div class='BlockHeader'><table border='0' width='100%'><tr>
	<td width='20'><img src='".$_conf['base_url']."/template/img/down_ar.gif' id='go3' width='16' height='16' alt='' /></td><td><span>Файлы</span></td>
	<td align='right'>&nbsp; </td></tr></table></div></div>
	<div id='FB_inner' class='InnerBlock'>";
	if(count($oi['files'])>0){
		$PAGE .= '<table border="0" width="100%" class="selrow" cellspacing="0">';
		while(list($k,$v)=each($oi['files'])){
			if($v['fdel']=="y"){
				$dl = '<a href="javascript:void(null)" onclick="if(!confirm(\'Удалить файл?\')) return false; else  getdata(\'\',\'get\',\'?p=functions&act=DelSingleFile&idf='.$v['idf'].'&ido='.$ido.'\',\'ActionRes\',\''.$_conf['base_url'].'\'); delelem(\'File_'.$v['idf'].'\'); return false; "><img src="'.$_conf['base_url'].'/template/img/delit.png" width="16" height="16" alt="Удалить файл"></a>';
			}else{
				$dl = '';
			}
			$PAGE .= '<tr id="File_'.$v['idf'].'"><td><a href="'.$_conf['base_url'].'?p=getfile&ido='.$ido.'&idf='.$v['idf'].'&type=ofile" target="_blank">'.$v['fname'].'</a></td><td><small>'.$v['fsize'].'</small></td><td>'.$v['fpart'].'</td><td><small>'.$v['fdate'].'</small></td><td>'.$v['fcom'].'</td><td>'.$dl.'</td></tr>';
		}
/*<a href="javascript:void(null)" onclick="if(!confirm('Удалить файл?')) return false; else  getdata('','get','?p=order_action&amp;act=DelSingleFile&amp;idf=16415&amp;ido=9945','FileRes'); delelem('File_16415'); return false; "><img src="tmpl/lite/adm_img/delit.png" width="16" height="16" alt="Удалить файл"></a>*/
		$PAGE .= '</table>';
	}
	$PAGE .= "<form class='blockf' action='?p=order_avtor&ido=".$ido."' id='FileForm' method='post' enctype='multipart/form-data'>";
	$PAGE .= "<input type='hidden' name='act' id='act' value='AddFile' />";
	$PAGE .= "Тип файла:<br /><select name='f_part' id='f_part' style='width:300px;'><option value='0'> - Выберите из списка - </option>".create_option($res['data']['oi']['workpart'], '')."</select><br /><input type='file' name='ofile[]' style='width:250px' /> &nbsp; <input type='button' value=' + ' onclick=\"addFileField('ofile', 'AddFile')\" /><div id='AddFile'></div><br />Комментарий к файлу(ам):<br /><textarea name='f_comment' id='f_comment' style='width:300px;height:50px;'></textarea>";
	
	$PAGE .= "<br /><input type='submit' value='Загрузить файл(ы)' />";
	$PAGE .= "</form>";
	/* файлы и форма проверки на плагиат */
	$PAGE .= '<br /><h3>Проверка на плагиате</h3>
	<div id="PlagiatList">
	<table border="0" cellspacing="0" class="selrow">';
	if(!empty($plg)){
	while(list($k,$v)=each($plg)){
		$PAGE .= '<tr>
		<td><a href="'.$_conf['base_url'].'?p=getfile&sop='.$v['sop'].'&type=plg" target="_blank">'.$v['p_file'].'</a></td>
		<td>'.stripslashes($v['p_com']).'</td>
		<td><span class="sdate">'.date("d.m.Y H:i",$v['p_date']).'</span></td>
		<td>'.stripslashes($v['fio']).' ('.$v['login'].', idu: '.$v['idu'].')</td>
		</tr>';
	}
	}
	$PAGE .= '</table></div>
	<form method="post" action="?p=order_avtor&ido='.$ido.'&act=addPlagiat" id="PlagiatForm" enctype="multipart/form-data" class="blockf">
	Загрузить файл:<br />
	<input type="file" name="plagiatfile" id="plagiatfile" size="20" /><br />
	Комментарий:<br />
	<textarea name="plagiatcom" id="plagiatcom" style="width:300px; height:70px;"></textarea><br />
	<input type="submit" value="Сохранить" />
	</form></div>';
	
	$PAGE .= "</div>";

	$PAGE .= "<div id='ContBlock' class='OuterBlock'>
	<div class='BlockHeader'><table border='0' width='100%'><tr>
	<td width='20'><img src='".$_conf['base_url']."/template/img/down_ar.gif' id='cc' width='16' height='16' alt='' /></td><td><span>Оглавление</span></td>
	<td align='right'>&nbsp; </td></tr></table></div></div>
	<div id='CC_inner' class='InnerBlock' style='display:none'>";

	$PAGE .= "<form class='blockf' action='javascript:void(null)' id='ContForm' method='post' enctype='multipart/form-data'>";
	$PAGE .= "<input type='hidden' name='p' id='p' value='functions' />";
	$PAGE .= "<input type='hidden' name='act' id='act' value='SaveOrderContent' />";
	$PAGE .= "<input type='hidden' name='ido' id='ido' value='".$ido."' />";
	$PAGE .= '<strong>Тема:</strong><br />
	<h3>'.stripslashes($oi['o_thema']).'</h3><br />
	<strong>Содержание:</strong><br />
	<textarea name="o_content" id="o_content" style="width:400px;height:100px;">'.htmlspecialchars(stripslashes($oi['o_content'])).'</textarea><br />
	<strong>Введение:</strong><br />
	<textarea name="o_vvedenie" id="o_vvedenie" style="width:400px;height:100px;">'.htmlspecialchars(stripslashes($oi['o_vvedenie'])).'</textarea><br />
	<strong>Заключение:</strong><br />
	<textarea name="o_zakluchenie" id="o_zakluchenie" style="width:400px;height:100px;">'.htmlspecialchars(stripslashes($oi['o_zakluchenie'])).'</textarea><br />
	<strong>Список литературы:</strong><br />
	<textarea name="o_literatura" id="o_literatura" style="width:400px;height:100px;">'.htmlspecialchars(stripslashes($oi['o_literatura'])).'</textarea><br />
	';
	$PAGE .= "<table border='0'><tr><td><input type='button' value='Сохранить' onclick=\"doLoad('ContForm','SCR','".$_conf['base_url']."')\" /></td><td><div id='SCR'></div></td></tr></table>";
	$PAGE .= "</form>";

	$PAGE .= "</div>";

	$PAGE .= "</td></tr></table>";

	$HEADER = '
	<script type="text/javascript">
	$(document).ready(function () {
		$("#go1").click(function () {$("#OB_inner").slideToggle("slow");});
		$("#go3").click(function () {$("#FB_inner").slideToggle("slow");});
		$("#go6").click(function () {$("#SEB_inner").slideToggle("slow");});
		$("#pgo").click(function () {$("#PLB_inner").slideToggle("slow");});
		$("#cc").click(function () {$("#CC_inner").slideToggle("slow");});
    });
	</script>
	';
	
} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}
?>