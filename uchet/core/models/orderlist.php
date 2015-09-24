<?php

class UModelOrderlist extends UchetModel
{
	public function __construct()
	{}
	
	public function run()
	{
		$this->assign('res', $this->getData());
		return true;	
	}

	public function getData()
	{
		$req = new UClient();
		if($req->makeRequest('getUserOrderList')) {
			return $req->result['orders'];
		}
		return false;
	}

}