<?php

class UModelUserblock extends UchetModel
{

	public function __construct()
	{}
	
	public function run()
	{
		//Если пользователь нажал на ссылку выхода из аккаунта - удаляем сессию и куки
		if(isset($this->request['u_method']) && $this->request['u_method'] == 'logout'){
			UUser::logout();
			$this->goToUrl('userblock');
			return true;
		}

		//Если отправлены данные из формы авторизации, пытаемся авторизовать пользователя
		if(isset($this->request['u_method']) && $this->request['u_method'] == 'authorize') {
			if(!empty($this->request['u_login']) && !empty($this->request['u_pass'])) {
				$result = UUser::enter($this->request['u_login'], $this->request['u_pass'], isset($this->request['u_long']) ? $this->request['u_long'] : 'no');
				//В случае возникновения ошибки во время авторизации регистрируем сообщение об ошибке
				if(!$result['code']) {
					$this->goToUrl('orderlist');
					return true;
				}
			} else {
				if(empty($this->request['u_login'])) {
					UError::newErrorMessage('1.11');
				}
				if(empty($this->request['u_pass'])) {
					UError::newErrorMessage('1.10');
				}
			}
		}
		
		//Если у пользователя установлены куки, но он не авторизован на сайте, пытаемся авторизовать его автоматически по данных куки
		if(isset($_COOKIE['U_USER_IDU']) && !isset($_SESSION['U_USER_IDU'])) {
			$result = UUser::restore();
			/*
			if($u_result[0] != 'ERROR'){
				header('location:'.$_conf['news_url']);
				exit;
			}
			*/
		}
	}
	
	public function isAuthorized()
	{
		return true;
	}
}