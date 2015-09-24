<?php

class UModelRecover extends UchetModel
{
	public function __construct()
	{}
	
	public function run()
	{
		include_once UCONFIG::$includeDir.'securimage/securimage.php';
		$securImageObj = new Securimage();
		if(!empty($this->request['act'])) {
			$correctInput = true;
			if(empty($this->request['email']) && empty($this->request['login'])) {
				UError::newErrorMessage('1.6');
				UError::newErrorMessage('1.11');
				$correctInput = false;
			}
			if(!$securImageObj->check($this->request['captcha'])) {
				UError::newErrorMessage('1.8');
				$correctInput = false;
			}
			if($correctInput) {
				$req = new UClient(Array('email' => $this->request['email'], 'login' => $this->request['login']));
				if($req->makeRequest('recoverPassword')) {
					$this->assign('sended', ($req->code == 0) ? 1 : 0);
					return true;
				}
			}
		}
		return true;
	}

	public function isAuthorized()
	{
		return true;
	}
}