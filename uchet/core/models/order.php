<?php
/*
 * Класс для формирования формы заказа и обработки и передачи его на удалённый сервер
 *
 * author alexby <mail.alex.by@gmail.com>
 */
class UModelOrder extends UchetModel
{
	/**
	 * Обработанные данные, которые пришли с формы заказа
	 *
	 * @var array of mixed
	 */
	private $receivedData;
	
	/**
	 * Данные, которые подставляются в поля формы заказа по дефолту
	 *
	 * @var array of mixed
	 */
	private $defaultData;
	
	/**
	 * Объект с методами для защиты от спама
	 *
	 * @var object
	 */
	private $spamDefence;
	
	/**
	 * Список полей и их свойств в форме заказа
	 *
	 * @var array of mixed
	 */
	private $orderFields;

	/**
	 * Список полей в форме заказа
	 *
	 * @var array of string
	 */
	private $orderFormFields = Array('thema', 'course', 'worktype', 'client_srok', 'file_part', 'file_comment', 'schooltype', 'country', 'city', 'vuz', 'volume', 'gost', 'font', 'interval', 'listsource', 'addinfo', 'precost', 'fio', 'email', 'icq', 'contact', 'fromknow', 'captcha_code', 'user', 'act', 'mphone1', 'mphone2', 'mphone3', 'sphone1', 'sphone2', 'sphone3');
	
	/**
	 * Пустой конструктор
	 */
	public function __construct()
	{}
	
	/**
	 * Запуск модели
	 *
	 * @return bool
	 */		
	public function run()
	{
		$this->init();
		if($this->receivedData['act'] == 'parseOrderData') {//проверка данных, введенных пользователем
			if ($this->checkInputData()) {
				$req = new UClient($this->selectDataToSend($this->receivedData));
				$req->setFiles($this->receivedFiles);
				if($req->makeRequest('makeOrder')) {
					foreach($this->receivedFiles as $key => $val) {
						$this->receivedFiles[$key]['status'] = $req->resultFiles[$key];
					}
					if($req->code == 0) {
						if(!UUser::isAuthorized()) {
							UUser::enter($req->result['login'], $req->result['password'], 'yes');
						}
						$this->makeAnons();
						$this->storeRequestResult($req->result);
						$this->goToUrl('ordercreated', (UCONFIG::$purposeSwitch) ? Array('purpose' => $this->receivedData['worktype']) : Array());
						return true;
					}
				}
			}
			$this->assign('fieldsValues', $this->receivedData);
		} elseif($this->receivedData['act'] == 'prepareFromMiniForm') {// вызов формы с миниформы
			$this->prepareDataFromMiniForm();
			$this->assign('fieldsValues', $this->receivedData);
		} else {// первый вызов формы
			$this->fillDefaultData();
			$this->assign('fieldsValues', $this->defaultData);		
		}

		/*
		* showing form
		*/
		$this->assign('showRegisterUserForm', !(UUser::isAuthorized()));
		$this->assign('orderFields', $this->orderFields);
		
		return true;
	}
	
	/**
	 * Проверка введённых в форму заказа данных.
	 *
	 * @return bool прошла ли проверка
	 */
	public function checkInputData()
	{
		$errorsFields1 = Array(
			'thema' => '1.1',
			'course' => '1.2',
			'worktype' => '1.3',
			'client_srok' => '1.4',
			'city' => '1.12',
			'country' => '1.26',
			'vuz' => '1.13',
			'volume' => '1.14',
			'gost' => '1.15',
			'font' => '1.16',
			'interval' => '1.17',
			'listsource' => '1.18',
			'addinfo' => '1.19',
			'precost' => '1.20',

		);
		$errorsFields2 = Array(
			'fio' => '1.5',
			'email' => '1.6',
			'mphone' => '1.9',
			'sphone' => '1.21',
			'icq' => '1.22',
			'contact' => '1.23',
			'fromknow' => '1.24',
			'schooltype' => '1.25',
		);

		$ret = true;

		foreach($errorsFields1 as $key => $val) {
			if(!$this->checkField($key)) {
				$ret = false;
				UError::newErrorMessage($val);
			}
		}

		if(!UUser::isAuthorized()) {
			foreach($errorsFields2 as $key => $val) {
				if(!$this->checkField($key)) {
					$ret = false;
					UError::newErrorMessage($val);
				}
			}
			if($this->orderFields['captcha_code']['enabled']) { 
				if(UCONFIG::$spamDefenceMode == 'securimage') {
					if(!$this->checkField('captcha_code')) {
						$ret = false;
						UError::newErrorMessage('1.7');
					} elseif(!($this->spamDefence->check($this->receivedData['captcha_code']))) {
						$ret = false;
						UError::newErrorMessage('1.8');
					}		
				}
			}
		}
		return $ret;
	}
	
	/**
	 * Проверка введённых в конкретное поле данных.
	 *
	 * @param string $name название поля
	 * @return bool прошла ли проверку
	 */
	private function checkField($name)
	{
		UDebug::add(
			Array(
				$this->orderFields[$name]['enabled'], 
				$this->orderFields[$name]['mandatory'], 
				trim($this->receivedData[$name])), 
			$name.'-arr');
		if(
			($this->orderFields[$name]['enabled']) 
			&& ($this->orderFields[$name]['mandatory']) 
			&& (trim($this->receivedData[$name]) == '' || trim($this->receivedData[$name]) == '0')
		) {
			return false;
		}
		return true;
	}

	/**
	 * Заполнение $this->defaultData данными по умолчанию
	 *
	 * @return void
	 */
	public function fillDefaultData()
	{
		$this->defaultData = Array(
			'act' => 'parseOrderData',
			'user' => 'exists',
			'thema' => '',
			'course' => '',
			'worktype' => '',
			'client_srok' => '',
			'file_part' => '',
			'file_comment' => '',
			'schooltype' => '',
			'country' => '',
			'city' => '',
			'vuz' => '',
			'volume' => '',
			'gost' => '',
			'font' => '',
			'interval' => '',
			'listsource' => '',
			'addinfo' => '',
			'precost' => '',
			'fio' => '',
			'email' => '',
			'icq' => '',
			'contact' => '',
			'fromknow' => '',
			'captcha_code' => '',
			'mphone1' => '',
			'mphone2' => '',
			'mphone3' => '',
			'sphone1' => '',
			'sphone2' => '',
			'sphone3' => ''
		);
	}

	/**
	 * Формировка данных для отправки на сверку
	 *
	 * @param array of string $data входные данные
	 * @return array of string
	 */
	public function selectDataToSend($data)
	{
		$senddata['o_thema'] = $data['thema'];
		$senddata['o_course'] = $data['course'];
		$senddata['o_type'] = $data['worktype'];
		$senddata['o_shcooltype'] = $data['schooltype'];
		$senddata['o_volume'] = $data['volume'];
		$senddata['gost'] = $data['gost'];
		$senddata['o_font'] = $data['font'];
		$senddata['o_interval'] = $data['interval'];
		$senddata['o_listsource'] = $data['listsource'];
		$senddata['o_addinfo'] = $data['addinfo'];
		$senddata['o_client_srok'] = strtotime($data['client_srok']);
		$senddata['f_part'] = $data['file_part'];
		$senddata['f_comment'] = $data['file_comment'];
		$senddata['o_precost'] = $data['precost'];
		$senddata['o_cc'] = $data['cc'];
		$senddata['country'] = $data['country'];
		$senddata['city'] = $data['city'];
		$senddata['o_vuz'] = $data['vuz'];

		if(isset($data['user']) && $data['user'] == 'new' && !(UUser::isAuthorized())) {
			$senddata['user'] = 'new';
			$senddata['fio'] = $data['fio'];
			$senddata['phone'] = $data['sphone'];
			$senddata['mphone'] = $data['mphone'];
			$senddata['email'] = $data['email'];
			$senddata['icq'] = $data['icq'];
			$senddata['contact'] = $data['contact'];
			$senddata['o_fromknow'] = $data['fromknow'];
		}
		
		return $senddata;
	}
	
	/**
	 * Сохраняем для передачи на страницу оформленного заказа данных по заказу
	 *
	 * @param array of string $data входные данные
	 * @return void
	 */
	public function storeRequestResult($data)
	{
		$_SESSION['orderInfo'] = Array(
			'ido' => $data['ido'],
			'thema' => $this->receivedData['thema'],
			'course' => $this->receivedData['course'],
			'worktype' => $this->receivedData['worktype'],
			'client_srok' => $this->receivedData['client_srok'],
			'schooltype' => $this->receivedData['schooltype'],
			'country' => $this->receivedData['country'],
			'city' => $this->receivedData['city'],
			'vuz' => $this->receivedData['vuz'],
			'volume' => $this->receivedData['volume'],
			'gost' => $this->receivedData['gost'],
			'font' => $this->receivedData['font'],
			'interval' => $this->receivedData['interval'],
			'listsource' => $this->receivedData['listsource'],
			'addinfo' => $this->receivedData['addinfo'],
			'precost' => $this->receivedData['precost']
		);
		if(isset($data['login'])) {
			$_SESSION['clientInfo'] = Array(
				'login' => $data['login'],
				'password' => $data['password'],
				'fio' => $this->receivedData['fio'],
				'email' => $this->receivedData['email'],
				'mphone' => $this->receivedData['mphone'],
				'sphone' => $this->receivedData['sphone'],
				'icq' => $this->receivedData['icq'],
				'contact' => $this->receivedData['contact']
			);
		}
		$_SESSION['filesInfo'] = Array(
			'file_part' =>  $this->receivedData['file_part'], 
			'files' => $this->receivedFiles
		);
	}
	
	/**
	 * Перекрытие метода родителя.
	 * Авторизация пользователя на этом методе пользователя не обязательна
	 *
	 * @return bool
	 */
	public function isAuthorized()
	{
		return true;
	}
	
	/**
	 * Инициализация метода
	 *
	 * @return void
	 */
	private function init()
	{
		if(UCONFIG::$spamDefenceMode == 'securimage') {
			include_once UCONFIG::$includeDir.'securimage/securimage.php';
			$this->spamDefence = new Securimage();
		}
		if(isset($this->request['act']) && ($this->request['act'] == 'parseOrderData' || $this->request['act'] == 'prepareFromMiniForm')) {
			$this->prepareRecievedData();
			$this->prepareRecievedFiles();
		}
		$this->orderFields = UDicts::$orderFields;
	}
	
	/**
	 * Подготовка введённых в форму данных перед обработкой
	 *
	 * @return void
	 */
	private function prepareRecievedData()
	{
		foreach($this->orderFormFields as $key => $val) {
			if (isset($this->request[$val])) {
				$this->receivedData[$val] = $this->request[$val];
			} else {
				$this->receivedData[$val] = '';
			}
		}
		if(isset($this->receivedData['mphone1']) || isset($this->receivedData['mphone2']) || isset($this->receivedData['mphone3'])) {
			$this->receivedData['mphone'] = 
				((isset($this->receivedData['mphone1'])) ? $this->receivedData['mphone1'] : '').
				((isset($this->receivedData['mphone2'])) ? $this->receivedData['mphone2'] : '').
				((isset($this->receivedData['mphone3'])) ? $this->receivedData['mphone3'] : '');
		}
		if(isset($this->receivedData['sphone1']) || isset($this->receivedData['sphone2']) || isset($this->receivedData['sphone3'])) {
			$this->receivedData['sphone'] = 
				((isset($this->receivedData['sphone1'])) ? $this->receivedData['sphone1'] : '').
				((isset($this->receivedData['sphone2'])) ? $this->receivedData['sphone2'] : '').
				((isset($this->receivedData['sphone3'])) ? $this->receivedData['sphone3'] : '');
		}
		if(isset($this->receivedData['country']) || isset($this->receivedData['city'])) {
			$this->receivedData['cc'] = 
				((!empty($this->receivedData['country'])) ? UDicts::$lists['country'][$this->receivedData['country']] : '')
				.((!empty($this->receivedData['city']) && (!empty($this->receivedData['country']))) ? ', ' : '')
				.((!empty($this->receivedData['city'])) ? $this->receivedData['city'] : '');
		}
	}
	
	/**
	 * Формируем и записывам файл с последними оформленными заказами
	 *
	 * @return void
	 */
	private function makeAnons()
	{
		$recs = 1;
		$afile = UCONFIG::$tmpDirG.'anons.php';
		if(file_exists($afile)) {
			include($afile);
		}
		$coursestr = UDicts::$lists['course'][$this->receivedData['course']];
		$wtype = UDicts::$lists['worktype'][$this->receivedData['worktype']];
		if($this->receivedData['worktype']=='2001') {
			$asubd = 'kontrolnye';
		} elseif($this->receivedData['worktype']=='1999' || $this->receivedData['worktype']=='2007') {
			$asubd = 'kursovaya';
		} elseif($this->receivedData['worktype']=='2000') {
			$asubd = 'referaty';
		} else {
			$asubd = '';
		}
		$out = "<?"."php\n";
		$out .= chr(36).'anons = Array(';
		$th = $this->receivedData['thema'];
		$type = $wtype.' по предмету '.$coursestr;
		$out .= "'0'=>array('subd'=>'".$asubd."','type'=>'".$type."','thema'=>'".addslashes(htmlspecialchars($th))."'),";
		if(isset($anons)){
			$anons = UCore::encToUchet($anons);
			$i=1;
			while(list($key, $val) = each($anons)) {
				if(($recs<6 && $asubd==$val['subd']) || $asubd!=$val['subd']) {
					$out .= "'".$i."'=>array('subd'=>'".$val['subd']."','type'=>'".$val['type']."','thema'=>'".addslashes(htmlspecialchars($val['thema']))."'),";
				}
				if($asubd==$val['subd']) {
					$recs++;
				}
				$i++;
			}
		}
		$out .=");";
		$out = UCore::encFromUchet($out);
		$fp = fopen($afile, "w");
		fwrite($fp, $out);
		fclose($fp);
	}
	
	/**
	 * Функция подгатавливает в массив $this->receivedData данные, переданных с миниформы
	 *
	 * @return array of mixed
	 */
	private function prepareDataFromMiniForm()
	{
		foreach($this->orderFormFields as $key => $val) {
			if (isset($this->request[$val])) {
				$this->receivedData[$val] = $this->request[$val];
			} else {
				$this->receivedData[$val] = '';
			}
		}
	}
	
}