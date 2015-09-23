<?php
/**
* Проверка формы. 
*/
$feedback = array(
	'fio' => '',
	'phone' => '',
	'email' => '',
	'coment' => ''			
);

$feedbackError = '';
if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'feedback')
{
	include_once 'feedback.class.php';
	$feedbackObj = new feedbackClass;

	if(
		!empty($_REQUEST['fio'])
		&& !empty($_REQUEST['coment'])
		&& (!empty($_REQUEST['phone']) || (!empty($_REQUEST['email']) && $feedbackObj->check_field($_REQUEST['email'], 'email')))
	)
	{
		$idp = $_REQUEST['idp'];
	
		$feedback['fio'] = $feedbackObj->check_field($_REQUEST['fio']);
		$feedback['coment'] = $feedbackObj->check_field($_REQUEST['coment']);

		if(!empty($_REQUEST['email']))
		{
			$feedback['email'] = $feedbackObj->check_field($_REQUEST['email']);
		}
		else
		{
			$feedback['email'] = 'Не указан.';
		}
		
		if(!empty($_REQUEST['phone']))
		{
			$feedback['phone'] = $feedbackObj->check_field($_REQUEST['phone']);
		}
		else
		{
			$feedback['phone'] = 'Не указан';
		}
		
		/**	
		* отправка письма
		*/
		$headers = 'MIME-Version: 1.0'."\n";
		$headers .= 'Content-type: text/html; charset=UTF-8'."\n";
		
		$message = 'Запрос клиента:<br />Дата отправки: '.date('d.m.Y H:i', time()).
			'<br />Отправитель: '.$feedback['fio'].
			'<br />Телефон: '.$feedback['phone'].
			'<br />Email: '.$feedback['email'].
			'<br />Комментарий: '.$feedback['coment'];
		
		$subject = 'Комментарий клиента на '.$_conf['www_patch'];
		
		mail($_conf['sup_email'], $subject, $message, $headers);
		$feedbackError = 'noError';
	}
	else
	{
		$feedback = array(
			'fio' => $_REQUEST['fio'],
			'phone' => $_REQUEST['phone'],
			'email' => $_REQUEST['email'],
			'coment' => $_REQUEST['coment']			
		);
		$feedbackError = 'notAllData';
	}
}

$smarty->assign('feedbackData', $feedback);
$smarty->assign('feedbackError', $feedbackError);
$feedbackPattern = $smarty->fetch('feedback.tpl');
$smarty->assign('feedbackPattern', $feedbackPattern);