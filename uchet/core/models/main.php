<?php

class UModelMain extends UchetModel
{

	public function __construct()
	{}
	
	public function run()
	{
		//Если отправлены данные из формы авторизации, пытаемся авторизовать пользователя
		if(isset($this->request['u_method']) && $this->request['u_method'] == 'authorize') {
			UUser::$long = isset($this->request['u_long']) ? $this->request['u_long'] : 'no';
			UUser::$login = $this->request['u_login'];
			UUser::$pass = $this->request['u_pass'];
			if(!empty(UUser::$login) && !empty(UUser::$pass)) {
				$result = UUser::authorize('login');
				//В случае возникновения ошибки во время авторизации регистрируем сообщение об ошибке
				if(!$result['code']) {
					$this->goToUrl('orderlist');
					return true;
				}
			} else {
				if(empty(UUser::$login)) {
					UError::newErrorMessage('1.11');
				}
				if(empty(UUser::$pass)) {
					UError::newErrorMessage('1.10');
				}
			}
		}
		
		if(!UUser::isAuthorized()) {
			$this->assign('authorized', false);
		} else {
			$this->assign('authorized', true);
		}
		
		return true;	
	}
	
	public function isAuthorized()
	{
		return true;
	}
}