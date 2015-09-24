<?php

class UchetModel
{
	public $forward;
	public $isFile;
	
	protected $request;
	protected $receivedFiles;
	
	private $resultVars;
	private $file;
		
	public function __construct()
	{}
	
	public function assign($variable, $value, $makeSecure = true)
	{
		$this->resultVars[$variable] = ($makeSecure) ? $this->makeSecureHtml($value) : $value;
	}
	
	public function assignArray($arr, $makeSecure = true)
	{
		foreach($arr as $key => $val) {
			$this->assign($key, $val, $makeSecure);
		}
	}
	
	public function getResultVars()
	{
		return $this->resultVars;
	}
	
	public function setRequest($request)
	{
		$this->request = $request;
	}
	
	public function goToUrl($page, $params = Array())
	{
		$url = UCONFIG::$url[$page];
		if(count($params)) {
			if(strpos(UCONFIG::$url[$page], '?')) {
				$url .= '&';
			} else {
				$url .= '?';
			}
			foreach($params as $key => $val) {
				$url .= $key.'='.$val.'&';
			}
			$url = substr($url, 0, strlen($url)-1);
		}
		$this->forward = $url;
	}
	
	public function isAuthorized()
	{
		return UUser::isAuthorized();
	}
	
	protected function prepareRecievedFiles()
	{
		$this->receivedFiles = Array();
		if(isset($_FILES) && is_array($_FILES)) {
			$_FILES = UCore::encToUchet($_FILES);
			foreach($_FILES as $k => $v) {
				if(is_array($_FILES[$k]['name'])) {
					while(list($key,$val) = each($_FILES[$k]['name'])) {
						if($_FILES[$k]['error'][$key] != 4) {
							$this->receivedFiles[] = Array(
								'name' => $_FILES[$k]['name'][$key],
								'type' => $_FILES[$k]['type'][$key],
								'tmp_name' => $_FILES[$k]['tmp_name'][$key],
								'error' => $_FILES[$k]['error'][$key],
								'size' => $_FILES[$k]['size'][$key]
							);	
						}
					}
				} else {
					if($_FILES[$k]['error'] != 4) {
						$this->receivedFiles[] = Array(
							'name' => $_FILES[$k]['name'],
							'type' => $_FILES[$k]['type'],
							'tmp_name' => $_FILES[$k]['tmp_name'],
							'error' => $_FILES[$k]['error'],
							'size' => $_FILES[$k]['size'],
						);	
					}
				}
			}
		}
		UDebug::add($this->receivedFiles, 'sendfiles');
		UDebug::add($_FILES, '$_FILES');
	}

	private function makeSecureHtml($variable) {
		if (is_array($variable)) {
			foreach($variable as $key => $val) {
				$variable[$key] = $this->makeSecureHtml($val);
			}
			return $variable;
		} else {
			return htmlspecialchars($variable);
		}
	}
	
}