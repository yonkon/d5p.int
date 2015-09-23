<?php
/**
 * Класс для работы с личной информацией клиента
 * 
 * @author alexby <mail.alex.by@gmail.com>
 */
class UModelOwninfo extends UchetModel
{
	public function __construct()
	{}
	
	public function run()
	{	
		if(isset($this->request['act']) && $this->request['act'] == 'parseUserData') {			
			if ($this->checkInputData()) {
				$req = new UClient($this->selectDataToSend($this->request));
				if($req->makeRequest('updateUserData')) {
					$this->assign('dataSaved', true);
					if(!empty($this->request['u_pass'])) {
						UUser::updateAuthorizationWhenChangePassword($this->request['u_pass']);
					}
				}
			}
		}
		$req1 = new UClient();
		$req1->makeRequest('getUserData');
		$this->assignUserInfoData($req1->result);
		
		return true;	
	}

	/**
	 * Проверяем данные, введенные пользователем
	 *
	 * @return bool результат проверки
	 */
	public function checkInputData()
	{
		$result = true;
		if(empty($this->request['fio'])) {
			$result = false;
			UError::newErrorMessage('1.5');
		}
		if(empty($this->request['mphone'])) {
			$result = false;
			UError::newErrorMessage('1.9');
		}
		if(empty($this->request['email'])) {
			$result = false;
			UError::newErrorMessage('1.6');
		}
		if(!empty($this->request['birthday']) && !$this->checkingDate($this->request['birthday'])) {
			$result = false;
			UError::newErrorMessage('1.27');
		}
		//TODO
		return $result;
	}	
	
	
	/**
	 * Выбираем данные для отправки на сверку
	 *
	 * @param array of mixed $data данные, введенные пользователем в форме
	 * @return array of mixed данные для отправки
	 */
	private function selectDataToSend($data)
	{
		return Array(
			'fields' => Array(
				'fio' => $data['fio'],
				'phone' => $data['phone'],
				'mphone' => $data['mphone'],
				'email' => $data['email'],
				'icq' => $data['icq'],
				'contact' => $data['contact'],
				'c_send_alert' => isset($data['c_send_alert']) ? 'y' : 'n',
				'u_pass' => $data['u_pass'],

				'skype' => $data['skype'],
				'other_contact' => $data['other_contact'],
				'web' => $data['web'],
				'birthday' => $data['birthday'],
				'country' => $data['country'],
				'city' => $data['city'],
				'speciality' => $data['speciality'],
				'orders_before' => $data['orders_before'],
				'time_to_call' => $data['time_to_call'],
				'payment_method' => $data['payment_method'],
				'university' => $data['university'],
				'examinations_time' => $data['examinations_time'],
			));		
	}

	/**
	 * Отдаем шаблонизатору данные о клиенте
	 *
	 * @param array of mixed $userData данные о клиенте
	 */
	private function assignUserInfoData($userData)
	{		
		$this->assign('fio', $userData['fio']);
		$this->assign('phone', $userData['phone']);
		$this->assign('mphone', $userData['mphone']);
		$this->assign('email', $userData['email']);
		$this->assign('icq', $userData['icq']);
		$this->assign('contact', $userData['contact']);
		$this->assign('ch_csa', ($userData['c_send_alert'] == 'y') ? 'checked="checked" ' : '');
		
		$this->assign('skype', $userData['skype']);
		$this->assign('other_contact', $userData['other_contact']);
		$this->assign('web', $userData['web']);
		$this->assign('birthday', $userData['birthday']);
		$this->assign('country', $userData['country']);
		$this->assign('city', $userData['city']);
		$this->assign('speciality', $userData['speciality']);
		$this->assign('orders_before', $userData['orders_before']);
		$this->assign('time_to_call', $userData['time_to_call']);
		$this->assign('payment_method', $userData['payment_method']);
		$this->assign('university', $userData['university']);
		$this->assign('examinations_time', $userData['examinations_time']);
	}
	
	/**
	 * Проверяем дату на существование
	 *
	 * @param string $date дата в формате ДД.ММ.ГГГГ
	 * @todo вынести в другой класс
	 */
	private function checkingDate($date)
	{ 
		$stamp = strtotime($date);

		if(!is_numeric($stamp)) { 
			return false; 
		} 
		$month = date('m', $stamp); 
		$day = date('d', $stamp); 
		$year = date('Y', $stamp); 
		
		if(checkdate($month, $day, $year)) { 
			return true; 
		} 
		
		return false;
	}
}