<?php
/**
 * Класс для управления текущим пользователем
 *
 * @author alexby <mail.alex.by@gmail.com>
 */
class UUser
{
	/**
	 * надолго ли запоминать
	 *
	 * @var string('yes', 'no')
	 */
	private static $long;

	private function __construct()
	{}

	/**
	 * Восстановление авторизации по кукам
	 *
	 * @return array of mixed статус операции
	 */
	public static function restore()
	{
		self::$long = 'yes';
		$data = Array(
			'type' => 'restore', 
			'long' => 'yes'
		);
		return self::authorizeRemote($data);
	}

	/**
	 * Авторизация пользователя
	 *
	 * @param string $login логин пользователя
	 * @param string $pass пароль пользователя
	 * @param string('yes', 'no') $long надолго ли запоминать
	 * @return array of mixed статус операции
	 */	
	public static function enter($login, $pass, $long)
	{
		self::$long = $long;
		$data = Array(
			'type' => 'create',
			'login' => $login, 
			'pass' => $pass, 
			'long' => $long,
		);
		return self::authorizeRemote($data);
	}

	/**
	 * Разлогиниться текущему пользователю
	 *
	 * @return null
	 */
	public static function logout()
	{
		$time = time()-42000;
		$keys = array('u_strong'=>'','U_USER_IDU'=>'','U_LOGIN'=>'','U_FIO'=>'','U_EMAIL'=>'','U_CAB'=>'','U_CAB_MAIN'=>'');
		while(list($key,$val) = each($keys)) {
			setcookie($key,'',$time,'/');
			//session_unregister($key);
			unset($_COOKIE[$key]);
			unset($_SESSION[$key]);
		}
		//session_destroy();	
	}

	/**
	 * Проверяет статус авторизации
	 *
	 * @return bool авторизован ли текущий пользователь
	 */
	public static function isAuthorized()
	{
		if(!empty($_SESSION['U_USER_IDU'])) {
			return true;
		}
		return false;
	}
	
	/**
	 * Восстановление авторизации по кукам при смене пароля
	 *
	 * @return array of mixed статус операции
	 */
	public static function updateAuthorizationWhenChangePassword($password)
	{
		self::enter($_SESSION['U_LOGIN'], $password, 'yes');
	}
	
	/**
	 * Запрашивает данные на удаленном сервере для авторизации
	 *
	 * @return array of mixed статус операции
	 */
	private static function authorizeRemote($data)
	{
		$req = new UClient($data);
		$req->makeRequest('authorizeRemoteUser');
		if(!$req->code) {
			if($req->result[2] == 'create') {
				if(self::$long == 'yes') {
					$dt = time() + 3600*24*365; // на целый год
				} else {
					$dt = time() + 3600*6; // на 6 часов
				}
				setcookie('u_strong', $req->result[3], $dt, UCONFIG::$cookiePath);
				setcookie('U_USER_IDU', $req->result[4]['idu'], $dt, UCONFIG::$cookiePath);
				setcookie('U_LOGIN', $req->result[4]['login'], $dt, UCONFIG::$cookiePath);
				setcookie('U_FIO', $req->result[4]['fio'], $dt, UCONFIG::$cookiePath);
				setcookie('U_EMAIL', $req->result[4]['email'], $dt, UCONFIG::$cookiePath);
				setcookie('refid', $req->result[4]['cabinet'], $dt, UCONFIG::$cookiePath);
			}
			$_SESSION['u_strong'] = $req->result[3];
			$_SESSION['U_USER_IDU'] = $req->result[4]['idu'];
			$_SESSION['U_LOGIN'] = $req->result[4]['login'];
			$_SESSION['U_FIO'] = $req->result[4]['fio'];
			$_SESSION['U_EMAIL'] = $req->result[4]['email'];
			$_SESSION['U_CAB'] = $req->result[5]; // данные офиса пользователя
			$_SESSION['U_CAB_MAIN'] = $req->result[6]; // данные главного офиса системы
		}
		return Array(
			'code' => $req->code, 
			'errors' => $req->errors);
	}
}