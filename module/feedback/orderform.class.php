<?php
class orderformClass
{
	
	function check_field($field, $type = 'str')
	{
		switch($type)
		{
			case 'str':
				$field = trim(stripslashes(strip_tags($field)));
				return $field;
			case 'email':
				//работает начиная с версии 5.2
				$field = filter_var($field, FILTER_VALIDATE_EMAIL);
				return $field;
		}
	}
	
	/*
	*	Функция не принимает значений и возвращает урл текущей страницы.
	*/
	function gotoPage() {
		$gotoPage = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $gotoPage;
	}

}