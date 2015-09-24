<?php

class UModelSregisteravtor extends UchetModel
{

	public function __construct()
	{}
	
	public function run()
	{
		$this->assign('avtorInfo',$_SESSION['avtorInfo']);
		UDebug::add($_SESSION['avtorInfo']);
	}
	
	public function isAuthorized()
	{
		return true;
	}	
	
}