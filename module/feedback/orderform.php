<?php
/**
* Проверка формы. 
*/
$orderform = array(
	'fio' => '',
	'phone' => '',
	'email' => '',
	'coment' => '',
	'icq' => '',
);
$check_code = '';

$orderformError = '';
if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'orderform')
{
	include_once 'orderform.class.php';
	$orderformObj = new orderformClass;

	if(!empty($_REQUEST['fio']) && !empty($_REQUEST['email']) && ($_REQUEST['check_code'] == $_SESSION['check_code']))
	{
		if(!empty($_REQUEST['fio']))
		{
			$orderform['fio'] = $orderformObj->check_field($_REQUEST['fio']);
		}
		else
		{
			$orderform['fio'] = 'Не указан.';
		}

		if(!empty($_REQUEST['email']))
		{
			$orderform['email'] = $orderformObj->check_field($_REQUEST['email']);
		}
		else
		{
			$orderform['email'] = 'Не указан.';
		}
		
		if(!empty($_REQUEST['phone']))
		{
			$orderform['phone'] = $orderformObj->check_field($_REQUEST['phone']);
		}
		else
		{
			$orderform['phone'] = 'Не указан';
		}
		
		if(!empty($_REQUEST['icq']))
		{
			$orderform['icq'] = $orderformObj->check_field($_REQUEST['icq']);
		}
		else
		{
			$orderform['icq'] = 'Не указан';
		}
		
		if(!empty($_REQUEST['coment']))
		{
			$orderform['coment'] = $orderformObj->check_field($_REQUEST['coment']);
		}
		else
		{
			$orderform['coment'] = 'Не указан.';
		}
		
		$pageUrl = $orderformObj->gotoPage();
		/**
		* отправка письма
		*/
		$headers = 'MIME-Version: 1.0'."\n";
		$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
		
		$message = 'Заказ:<br />Дата отправки: '.date('d.m.Y H:i', time()).
			'<br />Отправитель: '.$orderform['fio'].
			'<br />Email: '.$orderform['email'].
			'<br />Телефон: '.$orderform['phone'].
			'<br />ICQ: '.$orderform['icq'].
			'<br />Комментарий: '.$orderform['coment'].
			'<br /><a href="http://'.$pageUrl.'">Страница товара...</a>';
		
		$subject = 'Форма заказа на сайте '.$_conf['www_patch'];
		
		mail($_conf['sup_email'], $subject, $message, $headers);
		$orderformError = 'noError';
	}
	else
	{
		if($_REQUEST['check_code'] != $_SESSION['check_code']) 
		{
			$check_code = 'error';
		}

		$orderform = array(
			'fio' => $_REQUEST['fio'],
			'phone' => $_REQUEST['phone'],
			'email' => $_REQUEST['email'],
			'coment' => $_REQUEST['coment'],
			'icq' => $_REQUEST['icq'],	
		);
		$orderformError = 'notAllData';
	}
}

$smarty->assign('check_code', $check_code);
$smarty->assign('orderformData', $orderform);
$smarty->assign('orderformError', $orderformError);
$orderformPattern = $smarty->fetch('orderform.tpl');
$smarty->assign('orderformPattern', $orderformPattern);