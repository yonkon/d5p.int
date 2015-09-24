<?php

class UClient
{
	public $data = null;
	public $files = null;
	public $act = null;
	private $answer = null;
	public $code = null;
	public $resultFiles = null;
	public $result = null;
	
	public function __construct($data = Array())
	{
		$this->setData($data);
		$this->files = Array();		
	}
	
	public function setData($data)
	{
		$this->data = $data;
	}
	
	public function setFiles($files)
	{
		$this->files = $files;
	}
	
	public function makeRequest($act = null)
	{
		if(empty($act) && empty($this->act)) {
			return false;
		}
		if(!empty($act)) {
			$this->act = $act;
		}
		
		if($this->act == 'EP_CreateInvoice' || $this->act == 'EP_IsInvoicePaid') {
			if($this->sendRemoteRequestEasypayBy($this->act)) {
				return true;
			}
		} elseif($this->makeCurlRequest()) {
			if(!$this->code) {
				$this->setDelyveryStatus();
			}
			return true;
		}
		return false;
	}

	public function makeCurlRequest()
	{
        /**
         * костыль на время переезда
         */
        if (time() > 1384300800) {//всё ок, dns сменились

        } if (time() > 1384041600) {//dns ещё не сменились, заходимо по временному адресу
            UCONFIG::$remoteCurlServer = 'http://www2.sverka1.ru/server.uchet.php';
        } else if (time() > 1384027200) {//сайт не работает, переезжаем
            UError::newErrorMessage('2.1');
            return false;
        }
		//ULog::write('time', time());
		
		if(!function_exists('curl_init')) {
			UError::newErrorMessage('3.2');
			return false;
		}
		$requestVersion = '4';

		$files_send = Array();
		$files_data = Array();
		
		if(isset($this->files) && is_array($this->files)) {
			reset($this->files);
			foreach($this->files as $key => $val) {
				if(empty($val['error'])) {
					$files_send['files['.$key.']'] = '@'.$val['tmp_name'];
					$files_data[$key]['fname'] = $val['name'];
					$files_data[$key]['md5'] = md5_file($val['tmp_name']);
				} else {
					if(isset($val['name'])) {
						$params = Array('fname' => $val['name']);
					} else {
						$params = Array();
					}
					UError::newErrorMessage('4.1', $params);
				}
			}
		}
		
		reset($this->data);
		
		if((!empty($_SESSION['u_strong']))) {
			$strong = $_SESSION['u_strong'];
		} elseif (!empty($_COOKIE['u_strong'])) {
			$strong = $_COOKIE['u_strong'];
		} else {
			$strong = 0;
		}
		if((!empty($_SESSION['U_USER_IDU']))) {
			$idu = $_SESSION['U_USER_IDU'];
		} elseif (!empty($_COOKIE['U_USER_IDU'])) {
			$idu = $_COOKIE['U_USER_IDU'];
		} else {
			$idu = 0;
		}		

		$logData = Array(
			'debug' => UCONFIG::$debug,
			'act' => $this->act,
			'from_site' => UCONFIG::$siteName,
			'password' => '*hidden*',
			'version' => $requestVersion,
			'owner_idu' => UCONFIG::$ownderIDU,
			'idu' => $idu,
			'strong' => '*hidden*',
			'data' => $this->data,
			'files_data' => $files_data,
			'files_send' => $files_send,);
		ULog::writeSeparate('request/'.$this->act, $logData);
		UDebug::add($logData, 'send request');
		
		$postFields = array_merge_recursive(
			Array(
				'debug' => UCONFIG::$debug,
				'act' => $this->act,
				'from_site' => UCONFIG::$siteName,
				'password' => UCONFIG::$password,
				'version' => $requestVersion,
				'owner_idu' => UCONFIG::$ownderIDU,
				'idu' => $idu,
				'strong' => $strong,
				'data' => json_encode($this->data),
				'files_data' => json_encode($files_data)
			), $files_send);		

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, UCONFIG::$remoteCurlServer);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Opera 10.00');
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0); 
		@curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
		
		$curl_result = curl_exec($curl);
		if(!$curl_result){
			UError::newErrorMessage('3.1', Array(
				'curl_error' => curl_error($curl),
				'curl_errno' => curl_errno($curl),
			));
			curl_close($curl);
			return false;
		}
		curl_close($curl);
		
		$result = json_decode($curl_result,true);
		$this->answer = $result;

		if(is_null($result)) {
			UError::newErrorMessage('3.5', Array(
				'curl_result' => $curl_result
			));
			return false;
		}
		
		ULog::writeSeparate('request/'.$this->act, $result);
		UDebug::add($result, 'result request');
		
		$this->code = $result['code'];
		$this->errors = $result['errors'];
		$this->result = (isset($result['data'])) ? $result['data'] : Array();
		
		$this->writeOutErrors();
		return true;
	}
	
	private function setDelyveryStatus()
	{
		$res = true;
		if(!$this->checkDelyveryFields()) {
			$res = false;
			UError::newErrorMessage('3.3');
		};
		if(!$this->setDelyveryFilesStatuses()) {
			$res = false;
			UError::newErrorMessage('3.4', Array('resultFiles' => $this->resultFiles));
		}
		return $res;
	}

	private function checkDelyveryFields()
	{
		return true;
	}
	
	private function setDelyveryFilesStatuses()
	{
		$result = true;
		if(count($this->files)) {
			foreach($this->files as $key => $value) {
				if(!isset($this->answer['received']['files'][$key])) {
					$this->resultFiles[$key] = 'none';
					$result = false;
				} else if ($this->answer['received']['files'][$key]['recievedCode'] == 0) {
					$this->resultFiles[$key] = 'ok';
				} else if ($this->answer['received']['files'][$key]['recievedCode'] == 1) {
					$this->resultFiles[$key] = 'mismatch';
					$result = false;
				} else {
					UError::newErrorMessage('3.6', Array(
						$param => '$this->answer[\'received\'][\'files\']['.$key.'][\'recievedCode\'] = '.$this->answer['received']['files'][$key]['recievedCode']
					));
					$result = false;
				}
			}
		}
		return $result;
	}

	private function sendRemoteRequestEasypayBy($function){
		reset($this->data);

		if(!class_exists('nusoap_client')) {
			require_once(UCONFIG::$includeDir.'nusoap/nusoap.php');
		}
		$uchetclient = new nusoap_client(UCONFIG::$paymentMethod['easypayby']['server'], 'wsdl');
		$uchetclient -> http_encoding = "UTF-8";
		$uchetclient -> decode_utf8 = 0;
		$uchetclient -> soap_defencoding = "UTF-8";
		$uchetclient -> useHTTPPersistentConnection();

		$ucheterr = $uchetclient -> getError();
		if ($ucheterr) {
			UError::newErrorMessage('5.4', Array('error' => $ucheterr));
			return false;
		}

		$uchetresult = $uchetclient -> call($function, $this->data);

		if ($uchetclient->fault) {
			UError::newErrorMessage('5.5', Array('result' => $uchetresult));
			return false;
		} else {
			$ucheterr = $uchetclient -> getError();
			if ($ucheterr) {
				UError::newErrorMessage('5.6', Array('error' => $ucheterr));
				return false;
			} else {
				$this->result = $uchetresult;
				return true;;
			}
		}
	}
	
	private function writeOutErrors()
	{
		foreach($this->errors as $key => $val) {
			UError::newErrorMessage('2.'.$key, $val);
		}
	}
	
}