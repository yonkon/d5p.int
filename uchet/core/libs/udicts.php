<?php
/*
* Статичный класс для работы со словарями и базой данных. Инициализируется один раз в конце текущего файла.
*
* @author alexby
*/
class UDicts
{
	private static $usingDicts = Array('order', 'registeravtor');
	private static $dbAutomatVars;
	private static $dbManualVars;

	public static $lang;
	public static $fields;
	public static $dicts;
	public static $lists;
	public static $variables;
	public static $orderFields;
	
	private function __construct()
	{}
	
	/*
	* Инициализация словарей. Вызывается один раз.
	*
	* @return bool
	*/
	public static function init()
	{
		include UCONFIG::$configDir.'db_manual.php';
		include UCONFIG::$configDir.'db_automat.php';
		self::$dbAutomatVars = $dbAutomatVars;
		self::$dbManualVars = $dbManualVars;
		self::$lang = $lang;
		self::$fields = $fields;
		self::$variables = $variablesName;
		self::$orderFields = $orderFields;

		include UCONFIG::$configDir.'dicts.php';
		self::$lists['course'] = $course;
		self::$lists['fromknow'] = $fromknow;
		self::$lists['paysys'] = $paysys;
		self::$lists['schooltype'] = $shcooltype;
		self::$lists['worktype'] = $worktype;
		self::$lists['file_part'] = $workpart;
		self::$lists['gost'] = $gost;
		self::$lists['country'] = $country;
		self::$lists['country_phone'] = $country_phone;

		return true;
	}
	
	/*
	* Каждому названию поля ставит в соответствие название для вывода в шаблоне
	*
	* @return string
	*/
	public static function convertToView($variable)
	{
		return (isset(self::$fields[$variable])) ? self::$fields[$variable] : $variable;
	}
	
	/*
	* Обратная для метода convertToView
	*
	* @return stirng
	*/
	public static function convertFromView($variable)
	{
		$index = array_search($variable, self::$fields);
		return ($index) ? $index : $variable;
	}
	
	/*
	* Необходимо ли использовать преобразование полей через словари
	*
	* @return bool
	*/
	public static function isNecessaryInModule($module)
	{
		if(in_array($module, self::$usingDicts)) {
			return true;
		}
		return false;
	}
	
	/*
	* Заполняет конкретный словарь новыми данными
	*
	* @param string $dict название словаря
	* @param array of mixed $data содержимое словаря
	* @return bool
	*/
	public static function setDict($dict, $data)
	{
		if(!in_array($dict, self::$dbAutomatVars)) {
			return false;
		}
		self::$$dict = $data;
		$out = '<?php'."\n";
		$out .= '$dbAutomatVars = '.self::makeVarToWrite(self::$dbAutomatVars, "\t").';'."\n\n";
		foreach(self::$dbAutomatVars as $val) {
			$out .= '$'.$val.' = '.self::makeVarToWrite(self::$$val, "\t").';'."\n\n";
		}
		self::writeDictToFile($out);
		return true;
	}
	
	/*
	* Возвращает содержимое словаря или все словари
	*
	* @param null/string $dict
	* @return array of mixed
	*/
	public static function getDicts($dict = null)
	{
		$all = Array();
		if(isset($dict)) {
			foreach($dict as $val) {
				if(isset(self::$$val)) {
					$all[$val] = self::$$val;
				}
			}
		} else {
			foreach(self::$dbAutomatVars as $val) {
				$all[$val] = self::$$val;
			}
		}
		return $all;
	}
	
	/*
	* Аналог print_f($var, true). Формирует из переменной читабельный для людей и валидный для php показ переменной.
	*
	* @param mixed $var содержимое
	* @param string $tabs табы вначале строки
	* @return string
	*/
	private static function makeVarToWrite($var, $tabs = '')
	{
		if(is_array($var)) {
			$out = 'Array('."\n";
			foreach($var as $key => $val) {
				$out .= $tabs.'\''.$key.'\' => '.self::makeVarToWrite($val, $tabs."\t").','."\n";
			}
			$out .= substr($tabs, 0, strlen($tabs)-1).')';
		} elseif(is_bool($var)) {
			$out = $var ? 'true' : 'false';
		} elseif(is_int($var)) {
			$out = $var;
		} else {
			$out = '\''.$var.'\'';
		}
		return $out;
	}
	
	/*
	* Записывает в файл словарей новые данные
	*
	* @param string $data данные
	* @return void
	*/
	private static function writeDictToFile($data)
	{
		$f = fopen(UCONFIG::$configDir.'/db_automat.php', "w");
		fwrite($f, $data);
		fclose($f);
	}
}

UDicts::init();