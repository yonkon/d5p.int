<?
/**
* Почтовый клиент для работы с почтой внутри системы
* @package ShiftCMS
* @version 1.00 10.06.2009
* @author Volodymyr Demchuk
* @link http://shiftcms.net
* Client
*/
if(!defined('SHIFTCMS')) exit;
$data = array();
if(isset($_REQUEST['mailact1']) && $_REQUEST['mailact1']=="UploadAttachment"){
		if(isset($_FILES) && $er==0){
			require_once("include/uploader.php");
			$upl = new uploader;
					$dir = $_conf['docroot']."/".$_conf['tmpdir'];
					$upl -> rewrite = 1;
					$upl -> fname = $dir."/".$_FILES['attach']['name'];
					$uplres = $upl -> SaveFile($_FILES['attach']);
					if($uplres == true){
						$pp = pathinfo($dir."/".$_FILES['attach']['name']);
					    $data['pars']['attach']['cont'] = base64_encode(file_get_contents($dir."/".$_FILES['attach']['name']));
					    $data['pars']['attach']['md5'] = md5_file($dir."/".$_FILES['attach']['name']);
						$data['pars']['attach']['ext'] = $pp['extension'];
						$data['pars']['attach']['name'] = $_FILES['attach']['name'];
					}else{
						$fres['successmsg'] = $uplres;
						$GLOBALS['_RESULT'] = $fres;
					}
		}
}

while(list($k,$v)=each($_REQUEST)){
	if($k!="A_CABSET") $data['pars'][$k] = $v;
}
$data['pars']['base_url'] = $_conf['base_url'];
$data['pars']['idu'] = $_SESSION['A_USER_IDU'];
$res = SendRemoteRequest("OutlookSoap", $data);

if($res['status']['code']==0){
	if(is_array($res['data']['page'])){
		$reply = $res['data']['page'];
		$GLOBALS['_RESULT'] = $reply;
		$PAGE = '';
				/*
				$fp = fopen("outlook_reply.txt","w");
				fwrite($fp,print_r($res['data']['page'],1));
				fclose($fp);
				*/
	}else{
		$PAGE .= $res['data']['page'];
	}
} else {
	$PAGE .= '<strong>Ошибка:</strong> '.$res['status']['code'].' - '.$res['status']['msg'];
}

?>