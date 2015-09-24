<?php

class UModelDownload extends UchetModel
{

	public function __construct()
	{}
	
	public function run()
	{
		$req = new UClient();
		if(isset($this->request['idf'])){
			$data['idf'] = $this->request['idf'];
			$data['ido'] = $this->request['ido'];
			$req->act = 'pDownloadOrderFile';
		} elseif (isset($this->request['ida'])) {
			$data['ido'] = $this->request['ido'];
			$data['ida'] = $this->request['ida'];
			$data['idm'] = $this->request['idm'];
			$req->act = 'pDownloadMailAttach';
		}
		$req->setData($data);
		if($req->makeRequest()) {
			if($req->code) {
				return false;
			}

			if(headers_sent($file, $line)) {
				$this->assign('headers_sent', true);
				UError::newErrorMessage('4.2', Array(
					'fname' => $req->result['fname'],
					'file' => $file, 
					'line' => $line,
				));
				return false;
			}
			
			$this->file['fcont'] = base64_decode($req->result['fcont']);
			if($req->result['fmd5'] != md5($this->file['fcont'])) {
				UError::newErrorMessage('4.3', Array('fname' => $req->result['fname']));
				return false;
			}

			$this->file['ext'] = $req->result['ext'];
			$this->file['name'] = $req->result['fname'];
			$this->file['fsize'] = $req->result['fsize'];
			$this->isFile = true;
			
			return true;
		}
		return false;
	}
	
	
}