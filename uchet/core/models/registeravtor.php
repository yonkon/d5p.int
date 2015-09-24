<?php

class UModelRegisteravtor extends UchetModel
{
	private $receivedData = null;
	private $defaultData = null;
	private $spamDefence = null;
	
	public function __construct()
	{}
	
	private function init()
	{
		if(UCONFIG::$spamDefenceMode == 'securimage') {
			include_once UCONFIG::$includeDir.'securimage/securimage.php';
			$this->spamDefence = new Securimage();
		}
		if(isset($this->request['act']) && $this->request['act'] == 'parseRegisteravtorData') {
			$this->prepareRecievedData();
		}
	}
	
	public function run()
	{
		$this->init();	
		
		if($this->receivedData['act'] == 'parseRegisteravtorData') {
			if ($this->checkInputData()) {
				$req = new UClient($this->selectDataToSend($this->receivedData));
				if($req->makeRequest('registeravtor')) {
					if($req->code == 0) {
						$this->storeRequestResult($req->result);
						$this->goToUrl('sregisteravtor');
						return true;
					}
				}
			}
			$this->assign('fieldsValues',$this->receivedData);
		} else {//first call to form
			$this->fillDefaultData();
			$this->assign('fieldsValues',$this->defaultData);	
		}		
		$this->assign('PAGETITLE', 'Регистрация нового автора');
		return true;	
	}
	
	public function checkInputData()
	{
		$ret = true;
		if($this->receivedData['login'] == '') {
			$ret = false;
			UError::newErrorMessage('1.9');
		}
		if($this->receivedData['pass'] == '') {
			$ret = false;
			UError::newErrorMessage('1.10');
		}
		if($this->receivedData['fio'] == '') {
			$ret = false;
			UError::newErrorMessage('1.5');
		}
		if(trim($this->receivedData['mphone']) == '') {
			$ret = false;
			UError::newErrorMessage('1.9');
		}
		if(trim($this->receivedData['email']) == '') {
			$ret = false;
			UError::newErrorMessage('1.6');
		}
		if(UCONFIG::$spamDefenceMode == 'securimage') {
			if($this->receivedData['captcha_code'] == '') {
				$ret = false;
				UError::newErrorMessage('1.7');
			} else if(!($this->spamDefence->check($this->receivedData['captcha_code']))) {
				$ret = false;
				UError::newErrorMessage('1.8');
			}		
		}		

		return $ret;
	}

	public function fillDefaultData()
	{
		$this->defaultData = Array(
			'act' => 'parseRegisteravtorData',
			'login' => '',
			'pass' => '',
			'fio' => '',			
			'mphone1' => '',
			'mphone2' => '',
			'mphone3' => '',
			'sphone1' => '',
			'sphone2' => '',
			'sphone3' => '',
			'web' => '',
			'email' => '',
			'icq' => '',
			'skype' => '',
			'fromknow' => '',
			'contact' => '',
			'other_contact' => '',
			'captcha_code' => '',
			'course' => Array(),
		);
	}
	
	public function selectDataToSend($data)
	{
		$senddata['a_login'] = $data['login'];
		$senddata['a_pass'] = $data['pass'];
		$senddata['a_fio'] = $data['fio'];
		$senddata['a_mphone'] = $data['mphone'];
		$senddata['a_phone'] = $data['sphone'];
		$senddata['a_web'] = $data['web'];
		$senddata['a_email'] = $data['email'];
		$senddata['a_icq'] = $data['icq'];
		$senddata['a_skype'] = $data['skype'];
		$senddata['a_fromknow'] = $data['fromknow'];
		$senddata['a_contact'] = $data['contact'];
		$senddata['a_other_contact'] = $data['other_contact'];
		$senddata['a_special'] = $data['course'];
		return $senddata;
	}
	
	public function storeRequestResult($data)
	{
		$_SESSION['avtorInfo'] = $data;
	}
	
	private function prepareRecievedData()
	{
		foreach(Array('act', 'login', 'pass', 'fio', 'mphone1', 'mphone2', 'mphone3', 'sphone1', 'sphone2', 'sphone3', 'web', 'email', 'icq', 'skype', 'fromknow', 'contact', 'other_contact', 'captcha_code', 'course') as $key => $val) {
			if (isset($this->request[$val])) {
				$this->receivedData[$val] = $this->request[$val];
			}
		}
		if(!isset($this->receivedData['course']) || !is_array($this->receivedData['course'])) {
			$this->receivedData['course'] = Array();
		}
		if(isset($this->receivedData['mphone1']) || isset($this->receivedData['mphone2']) || isset($this->receivedData['mphone3'])) {
			$this->receivedData['mphone'] = 
				((isset($this->receivedData['mphone1'])) ? $this->receivedData['mphone1'] : '').
				((isset($this->receivedData['mphone2'])) ? $this->receivedData['mphone2'] : '').
				((isset($this->receivedData['mphone3'])) ? $this->receivedData['mphone3'] : '');
		}
		if(isset($this->receivedData['sphone1']) || isset($this->receivedData['sphone2']) || isset($this->receivedData['sphone3'])) {
			$this->receivedData['sphone'] = 
				((isset($this->receivedData['sphone1'])) ? $this->receivedData['sphone1'] : '').
				((isset($this->receivedData['sphone2'])) ? $this->receivedData['sphone2'] : '').
				((isset($this->receivedData['sphone3'])) ? $this->receivedData['sphone3'] : '');
		}
	}
	
	public function isAuthorized()
	{
		return true;
	}	
	
}