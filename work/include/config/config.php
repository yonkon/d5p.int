<?
/**
 * Файл конфигурации сайта
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.00 15.02.2011
*/
 
$_conf['version'] = '1.07';
$_conf['base_url'] = "http://".$_SERVER['HTTP_HOST']."/work"; //полный путь к каталогу с скриптами
$_conf['rhost'] = $_SERVER['HTTP_HOST']; // адрес вашего сайта без http:// и других слешей
$_conf['tmpdir'] = "darejytopynvmjlrw";//каталог для временных файлов - необходимо установить права на запись chmod 0777
$_conf['docroot'] = $_SERVER['DOCUMENT_ROOT']."/work";

$_conf['remote_server'] = "http://sverka1.ru/avtors.php"; // адрес удаленного сервиса
$_conf['remote_curl_server'] = "http://sverka1.ru/avtors_curl.php"; // адрес удаленного curl-сервиса

/**
 * костыль на время переезда
 */
if (time() > 1384300800) {//всё ок, dns сменились
	$_conf['remote_server'] = "http://sverka1.ru/avtors.php"; // адрес удаленного сервиса
	$_conf['remote_curl_server'] = "http://sverka1.ru/avtors_curl.php"; // адрес удаленного curl-сервиса
} if (time() > 1384041600) {//dns ещё не сменились, заходимо по временному адресу
	$_conf['remote_server'] = "http://www2.sverka1.ru/avtors.php"; // адрес удаленного сервиса
	$_conf['remote_curl_server'] = "http://www2.sverka1.ru/avtors_curl.php"; // адрес удаленного curl-сервиса
} else if (time() > 1384027200) {//сайт не работает, переезжаем
	echo 'Проводятся технические работы. Ориентировочное время восстановления работы: 04:00 10.11.2013 по московскому времени'; 
	exit();
}

$_conf['sys_pass'] = 'klwejrnvwerndsfehlpoqzx'; //Пароль выдается на сайте сверка1.ру

$_conf['pages'] = array(
	'functions' => array(1 => 'include/functions.php', 2 => 'Набор функций для работы системы', 3 => 'ajax'),
	'alerts' => array(1 => 'include/pages/alerts.php', 2 => 'Оповещения о новых событиях', 3 => 'ajax'),
	'outlook' => array(1 => 'include/outlook.php', 2 => 'Почта', 3 => 'ajax'),
	'a_search' => array(1 => 'include/pages/a_search.php', 2 => 'Поиск заказов', 3 => 'ajax'),
	'a_searchres' => array(1 => 'include/pages/a_searchres.php', 2 => 'Результаты поиска заказов', 3 => 'site'),
	'main' => array(1 => 'include/pages/main.php', 2 => 'Главная страница', 3 => 'site'),
	'user_info' => array(1 => 'include/pages/user_info.php', 2 => 'Личная информация', 3 => 'site'),
	'usermail' => array(1 => 'include/pages/usermail.php', 2 => 'Почта', 3 => 'site'),
	'order_avtor_estimate' => array(1 => 'include/pages/order_avtor_estimate.php', 2 => 'Заказы на оценку', 3 => 'site'),
	'order_avtor_estres' => array(1 => 'include/pages/order_avtor_estres.php', 2 => 'Оцененные заказы', 3 => 'site'),
	'order_avtor_invork' => array(1 => 'include/pages/order_avtor_invork.php', 2 => 'Заказы на выполнении', 3 => 'site'),
	'order_avtor_towork' => array(1 => 'include/pages/order_avtor_towork.php', 2 => 'Заказы на доработке', 3 => 'site'),
	'order_avtor_ready' => array(1 => 'include/pages/order_avtor_ready.php', 2 => 'Выполненные заказы', 3 => 'site'),
	'order_avtor' => array(1 => 'include/pages/order_avtor.php', 2 => 'Страница заказа', 3 => 'site'),
	'for_pay' => array(1 => 'include/pages/for_pay.php', 2 => 'Заказы к оплате', 3 => 'site'),
	'pay_history' => array(1 => 'include/pages/pay_history.php', 2 => 'История выплат', 3 => 'site'),
	'avtor_grafic' => array(1 => 'include/pages/avtor_grafic.php', 2 => 'График сдачи', 3 => 'site'),
	'getfile' => array(1 => 'include/pages/getfile.php', 2 => 'Загрузка файлов', 3 => 'site'),
	'documents' => array(1 => 'include/pages/documents.php', 2 => 'Документы', 3 => 'site')
);

?>