<?php

class UModelNews extends UchetModel
{

	public function __construct()
	{}
	
	public function run()
	{
		$req = new UClient(Array(
			'idu' => $_SESSION['U_USER_IDU'],
			'strong' => $_SESSION['u_strong'],
		));
		$req->makeRequest('getNewsList');

		$this->assign('res', $req->result, false);
		
		return true;	
	}
	
	
}