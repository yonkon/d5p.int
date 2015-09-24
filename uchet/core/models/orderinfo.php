<?php

class UModelOrderinfo extends UchetModel
{
	public function __construct()
	{}
	
	public function run()
	{
		// Формирование запроса
		
        if(empty($this->request['ido'])) {
            $this->goToUrl('orderlist');
            return false;
        }
        
        $data['ido'] = $this->request['ido'];
		if(isset($this->request['act'])) {
			$data['mail']['act'] = $this->request['act'];
			if($this->request['act'] == 'readMail') {
				$data['mail']['idm'] = $this->request['idm'];
			} elseif($this->request['act'] == 'sendMail') {
				if(isset($this->request['idm'])) {
					$data['mail']['idm'] = $this->request['idm'];
				}
				$data['mail']['m_message'] = $this->request['m_message'];
				$this->prepareRecievedFiles();
			} elseif($this->request['act'] == 'deleteMail') {
				$data['mail']['idm'] = $this->request['idm'];
			} elseif($this->request['act'] == 'sendBall') {
				$data['mail']['ball'] = isset($this->request['ball']) ? $this->request['ball'] : 0;
				$data['mail']['wcomm'] = $this->request['wcomm'];
			} 
		}
                       
		$req = new UClient($data);
		$req->setFiles($this->receivedFiles);
		if($req->makeRequest('getUserOrderInfo')) {
			if($req->code == 0) {
				$this->assign('res', $req->result['order']);
				$this->assign('plan', $req->result['plan'], false);
				$this->assign('payments', $req->result['payments']);
				$this->assign('files', $req->result['files']);
				if(isset($req->result['mail'])) {
					$this->assign('mail', $req->result['mail'], false);
				}
				
				if(isset($req->result['readMail'])) {
					$this->assign('readMail', 'readMail');
					$this->assign('rm_idm', $req->result['readMail']['idm']);
					$this->assign('rm_subject', $req->result['readMail']['subject']);
					$this->assign('rm_message', $req->result['readMail']['message'], false);
					if(isset($req->result['readMail']['attach'])) {
						$this->assign('attach', $req->result['readMail']['attach']);
					}
				}
				
				if(isset($this->request['act']) && $this->request['act'] == 'writeMail') {
					$this->assign('writeMail', 'writeMail');
					if(isset($this->request['idm'])) {
						$this->assign('idm', $this->request['idm']);
					}
				}
				if(isset($req->result['sendmsg'])){
					$this->assign('sendmsg', $req->result['sendmsg']);
				}
			} 
		}
                                      
		return true;
	}
}