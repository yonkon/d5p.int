<?php

class UModelOrdercreated extends UchetModel
{

	function __construct()
	{}
	
	public function run()
	{
		if(!isset($_SESSION['orderInfo'])) {
			$this->goToUrl('orderlist');
			return false;
		}
		
		$this->assign('orderInfo',$_SESSION['orderInfo']);
		if(isset($_SESSION['clientInfo'])) {
			$this->assign('clientInfo',$_SESSION['clientInfo']);
		}
		$this->assign('filesInfo',$_SESSION['filesInfo']);
		
		unset($_SESSION['orderInfo']);
		unset($_SESSION['clientInfo']);
		unset($_SESSION['filesInfo']);
	}
	
	public function isAuthorized()
	{
		return true;
	}
}