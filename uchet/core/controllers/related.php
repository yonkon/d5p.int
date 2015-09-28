<?php
/**
 * Класс контроллер для управления приложением при подключении к сайту
 *
 * @author alexby <mail.alex.by@gmail.com>
 */
class UCore extends UchetController
{
	/**
	 * Вызываемый модуль
	 *
	 * @var string
	 */
	private static $callModule;

	/**
	 * Часовой пояс, установленный на сервере
	 *
	 * @var string название часового пояса
	 */
	private static $localServerTimeZone; 
	
	/**
	 * Пустой приватный конструктор
	 */
	private function __construct()
	{}
	
	/**
	 * Функция запуска контроллера
	 *
	 * @param string $callModule название модуля, который необходимо вызвать контроллеру
	 * @return bool
	 * @todo разбить метод
	 */
	public static function run($callModule)
	{
		self::$callModule = $callModule;
		ob_start();
		
		self::checkLastSync();
		
		self::setUchetTimeZone(); 
		
		UView::init();
		self::loadModel(self::$callModule);
		if(!self::$model->isAuthorized()) {
			self::$model->goToUrl('userblock');
		} else {
			self::$model->setRequest(self::prepareRequest());
			UDebug::add(self::prepareRequest(), 'request array');
			self::$model->run();
		}	
		if(!empty(self::$model->forward)) {
			self::forwardUrl(self::$model->forward);
		}
		UDebug::add(UError::getErrorCodes(), 'errors');
		self::assignDefaults();
		UView::setVars(self::$model->getResultVars());		
		
		self::$output = UView::render(self::$callModule);
		
		self::$wrongOutput .= ob_get_clean();

		if(UCONFIG::$debug == true) {
			UView::setVars(Array(
				'output' => self::$output,
				'wrongOutput' => self::$wrongOutput,
				'debugOutput' => UDebug::getVars()
			));
			UDebug::writeToLog();
			self::$output = UView::render('debug');
		}
		if (!empty(self::$wrongOutput)) {
			ULog::write('wrong_output', self::$wrongOutput);
		}
		
		self::$output = self::encFromUchet(self::$output);
		
		if(self::$model->isFile) {
			UView::outputFile(self::$model->file);
			exit();
		}
		
		if(UCONFIG::$printout) {
			echo self::$output;
		}
		
		self::garbageCollector();
		
		self::setLocalServerTimeZone();
		return true;
	}
	
	/**
	 * Подготавливает(кодировка, словари...) данные, переданные в приложение
	 *
	 * @return array of mixed подготовленные данные
	 */
	public static function prepareRequest() 
	{
		$request = parent::prepareRequest();
		if(UDicts::isNecessaryInModule(self::$callModule)) {
			$result = self::prepareRequestWithDicts($request);
		} else {
			$result = $request;
		}
		return self::encToUchet($result);
	}
	
	/**
	 * Преобразовывает данные по словарям
	 *
	 * @param array of mixed данные для преобразования
	 * @return array of mixed преобразованные данные
	 */
	public static function prepareRequestWithDicts($data)
	{
		$res = Array();
		foreach($data as $key => $val) {
			$res[UDicts::convertFromView($key)] = ((is_array($val)) ? $val : trim($val));
		}
		return $res;
	}

	/**
	 * Передает в вид дефолтные данные
	 *
	 * @return null
	 */
	private static function assignDefaults()
	{
		self::$model->assign('debug', UCONFIG::$debug);
		self::$model->assign('siteName', UCONFIG::$siteName);
		self::$model->assign('errorCodes', UError::getErrorCodes(), false);
		self::$model->assign('style', UCONFIG::$style, false);
		self::$model->assign('url', UCONFIG::$url, false);
		self::$model->assign('includePath', UCONFIG::$includePath, false);
		self::$model->assign('jsPath', UCONFIG::$jsPath, false);
		self::$model->assign('cssPath', UCONFIG::$cssPath, false);
		self::$model->assign('imgPath', UCONFIG::$imgPath, false);
		self::$model->assign('lang', UDicts::$lang, false);
		self::$model->assign('variables', UDicts::$variables, false);
		self::$model->assign('fields', UDicts::$fields, false);
		self::$model->assign('list', UDicts::$lists, false);
		self::$model->assign('spamDefenceMode',UCONFIG::$spamDefenceMode, false);
		self::$model->assign('onlinePay',UCONFIG::$onlinePay, false);
		self::$model->assign('paymentMethod',UCONFIG::$paymentMethod, false);
		self::$model->assign('paysysRegions',UCONFIG::$paysysRegions, false);
		self::$model->assign('siteEncoding',UCONFIG::$siteEncoding, false);
	}

	/**
	 * Меняет кодировку в данных для работы в приложении. 
	 * Исходную кодировку сайта берет из конфига.
	 *
	 * @param array of mixed $data
	 * @return array of mixed
	 */
	public static function encToUchet($data){
		if(UCONFIG::$siteEncoding != 'UTF8') {
			return self::encData($data, 'UTF8', UCONFIG::$siteEncoding);
		}
		return $data;
	}	
	
	/**
	 * Меняет кодировку в данных для возврата их из приложения на сайт.
	 * Результирующую кодировку сайта берет из конфига.
	 *
	 * @param array of mixed $data
	 * @return array of mixed
	 */	
	public static function encFromUchet($data){
		if(UCONFIG::$siteEncoding != 'UTF8') {
			return self::encData($data, UCONFIG::$siteEncoding, 'UTF8');
		}
		return $data;
	}	
	
	/**
	 * Меняет кодировку данных
	 *
	 * @param array of mixed исходные данные для смены кодировки
	 * @param string $encTo результирующая кодировка
	 * @param string $encFrom исходная кодировка
	 * @return array of mixed результат в новой кодировке
	 */
	private static function encData($data, $encTo, $encFrom) {
		if(is_array($data)){
			while(list($k,$v) = each($data)){
				$data[$k] = self::encData($v, $encTo,  $encFrom);
			}
			return $data;
		}
		return mb_convert_encoding($data, $encTo, $encFrom);
	}
	
	/**
	 * Сборщик мусора.
	 * Предназначен для очистки памяти и переменных при неоднократном инклюде приложения.
	 *
	 * @return null
	 */
	private static function garbageCollector()
	{
		self::$wrongOutput = '';
		UView::clear();
		UDebug::clear();
		UError::clear();
	}

	
	/**
	* Возвращаем часовой пояс сервера после окончания работы приложения
	*
	* @return null
	*/
	private static function setLocalServerTimeZone()
	{
		self::setTimeZone(self::$localServerTimeZone);
	}
	
	/**
	* Меняем часовой поясе сервера на московский
	*
	* @return null
	*/
	private static function setUchetTimeZone()
	{
		if (empty(self::$localServerTimeZone)) {
			self::$localServerTimeZone = date('e');
		}
		self::setTimeZone('Europe/Moscow');
	}
	
	/**
	 * Устанавливаем часовой пояс
	 *
	 * @param string $timeZone название часового пояса
	 */
	private static function setTimeZone($timeZone)
	{
		try{
			date_default_timezone_set($timeZone);
		} catch (Exception $e){
			try{
				ini_set('date.timezone', $timeZone);
			} catch (Exception $ex) {
				$error['timezone error (date_default_timezone_set)'] = $e;
				$error['timezone error (ini_set)'] = $ex;
				ULog::write('timezoneerror', $error);
			}
		}	
	}
	
	
	/**
	 * Проверка состояния синхронизации справочников и в случае необходимости инициализация синхронизации
	 *
	 * @return null
	 */
	private static function checkLastSync()
	{
		$set = self::loadINIset();
		if(!isset($set['lastsync']) || (time()-$set['lastsync']) > UCONFIG::$syncPeriod) {
			if(self::syncDictionary($set['version'])) {
				$set['lastsync'] = time();
				self::saveINIset($set);
			}
		}
	}

	/**
	 * Синхронизация справочников со сверкой
	 *
	 * @param string $version версия приложения
	 * @return bool удалось ли
	 */
	private static function syncDictionary($version)
	{
		return true;
		$req = new UClient(Array('version' => $version));
		if($req->makeRequest('loadDictionary') && (!$req->code)) {
			$dicts = Array('course','fromknow','paysys','shcooltype','worktype','workpart','gost','country','country_phone');
			$out = "<?"."php\n";
			while(list($key, $val) = each($dicts)) {
				$i = 0;
				$out .= chr(36).$val.'=Array(';
				if(count($req->result[$val])) {
					while(list($k,$v) = each($req->result[$val])) {
						if($val != 'country') {
							$k = str_replace("s_","",$k); //защищаем целочисленные индексы от изменения во время передачи с хоста на хост
						}
						if($i == 0) {
							$out.="'$k'=>'$v'";
						} else {
							$out.=",'$k'=>'$v'";
						}
						$i++;
					}
				}
				$out.=");\n";
			}
			$out .= chr(36).'mobile_code="'.$req->result['mobile_code'].'";';
			$fp = fopen(UCONFIG::$configDir.'/dicts.php', "w");
			fwrite($fp, $out);
			fclose($fp);
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Загрузка конфигурационных данных приложения
	 *
	 * @return array массив данных считанных с файла
	 */
	private static function loadINIset()
	{
		$inifile = UCONFIG::$configDir.'/set.ini';
		if(file_exists($inifile)) {
			return parse_ini_file($inifile);
		}
		return Array();
	}

	/**
	* Запись конфигурационных данных 
	*
	* @param array of mixed $data конфигурационные данных для сохранения
	*/
	private static function saveINIset($data)
	{
		$inifile = UCONFIG::$configDir.'/set.ini';
		$fp = fopen($inifile, 'w');
		while(list($key,$val) = each($data)) {
			fwrite($fp,$key.' = '.$val."\n");
		}
		fclose($fp);
	}	
	
	/**
	 * Переадресовывает пользователя на другую страницу
	 *
	 * @param string $url урл адрес для переадресации
	 * @return bool удалось ли переадресовать
	 */
	private static function forwardUrl($url)
	{
		if(UCONFIG::$debug) {
			UDebug::writeToLog();
		}
		self::$wrongOutput .= ob_get_clean();
		if (!empty(self::$wrongOutput)) {
			ULog::write('wrong_output', self::$wrongOutput);
		}
		if(headers_sent($file, $line)) {
			UError::newErrorMessage('6.1', Array(
				'url_to' => $url,
				'file' => $file,
				'line' => $line,
			));
			return false;
		}
		header('location:'.$url);
		exit();
	}
	
}