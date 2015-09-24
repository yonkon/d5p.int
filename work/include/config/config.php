<?
/**
 * ���� ������������ �����
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2011
 * @link http://shiftcms.net
 * @version 1.00 15.02.2011
*/
 
$_conf['version'] = '1.07';
$_conf['base_url'] = "http://".$_SERVER['HTTP_HOST']."/work"; //������ ���� � �������� � ���������
$_conf['rhost'] = $_SERVER['HTTP_HOST']; // ����� ������ ����� ��� http:// � ������ ������
$_conf['tmpdir'] = "darejytopynvmjlrw";//������� ��� ��������� ������ - ���������� ���������� ����� �� ������ chmod 0777
$_conf['docroot'] = $_SERVER['DOCUMENT_ROOT']."/work";

$_conf['remote_server'] = "http://sverka1.ru/avtors.php"; // ����� ���������� �������
$_conf['remote_curl_server'] = "http://sverka1.ru/avtors_curl.php"; // ����� ���������� curl-�������

/**
 * ������� �� ����� ��������
 */
if (time() > 1384300800) {//�� ��, dns ���������
	$_conf['remote_server'] = "http://sverka1.ru/avtors.php"; // ����� ���������� �������
	$_conf['remote_curl_server'] = "http://sverka1.ru/avtors_curl.php"; // ����� ���������� curl-�������
} if (time() > 1384041600) {//dns ��� �� ���������, �������� �� ���������� ������
	$_conf['remote_server'] = "http://www2.sverka1.ru/avtors.php"; // ����� ���������� �������
	$_conf['remote_curl_server'] = "http://www2.sverka1.ru/avtors_curl.php"; // ����� ���������� curl-�������
} else if (time() > 1384027200) {//���� �� ��������, ����������
	echo '���������� ����������� ������. ��������������� ����� �������������� ������: 04:00 10.11.2013 �� ����������� �������'; 
	exit();
}

$_conf['sys_pass'] = 'klwejrnvwerndsfehlpoqzx'; //������ �������� �� ����� ������1.��

$_conf['pages'] = array(
	'functions' => array(1 => 'include/functions.php', 2 => '����� ������� ��� ������ �������', 3 => 'ajax'),
	'alerts' => array(1 => 'include/pages/alerts.php', 2 => '���������� � ����� ��������', 3 => 'ajax'),
	'outlook' => array(1 => 'include/outlook.php', 2 => '�����', 3 => 'ajax'),
	'a_search' => array(1 => 'include/pages/a_search.php', 2 => '����� �������', 3 => 'ajax'),
	'a_searchres' => array(1 => 'include/pages/a_searchres.php', 2 => '���������� ������ �������', 3 => 'site'),
	'main' => array(1 => 'include/pages/main.php', 2 => '������� ��������', 3 => 'site'),
	'user_info' => array(1 => 'include/pages/user_info.php', 2 => '������ ����������', 3 => 'site'),
	'usermail' => array(1 => 'include/pages/usermail.php', 2 => '�����', 3 => 'site'),
	'order_avtor_estimate' => array(1 => 'include/pages/order_avtor_estimate.php', 2 => '������ �� ������', 3 => 'site'),
	'order_avtor_estres' => array(1 => 'include/pages/order_avtor_estres.php', 2 => '��������� ������', 3 => 'site'),
	'order_avtor_invork' => array(1 => 'include/pages/order_avtor_invork.php', 2 => '������ �� ����������', 3 => 'site'),
	'order_avtor_towork' => array(1 => 'include/pages/order_avtor_towork.php', 2 => '������ �� ���������', 3 => 'site'),
	'order_avtor_ready' => array(1 => 'include/pages/order_avtor_ready.php', 2 => '����������� ������', 3 => 'site'),
	'order_avtor' => array(1 => 'include/pages/order_avtor.php', 2 => '�������� ������', 3 => 'site'),
	'for_pay' => array(1 => 'include/pages/for_pay.php', 2 => '������ � ������', 3 => 'site'),
	'pay_history' => array(1 => 'include/pages/pay_history.php', 2 => '������� ������', 3 => 'site'),
	'avtor_grafic' => array(1 => 'include/pages/avtor_grafic.php', 2 => '������ �����', 3 => 'site'),
	'getfile' => array(1 => 'include/pages/getfile.php', 2 => '�������� ������', 3 => 'site'),
	'documents' => array(1 => 'include/pages/documents.php', 2 => '���������', 3 => 'site')
);

?>