<?php
/**
 * Класс для работы с отзывами на стороне сайта
 *
 * @author alexby <mail.alex.by@gmail.com>
 */
class PhpResponses
{
	/**
	 * Добавляет отзыв в базу данных движка, на котором установлен кабинет
	 *
	 * @param array of string $params параметры отзыва
	 * @return bool удалось ли
	 */
	public function add($params)
	{	
		return SDB::execute(
			'
				INSERT 
				INTO `su_responses` 
				(`resp_date`, `resp_who`, `resp_text`, `resp_state`, `resp_show`, `resp_email`, `id_o`, `id_u` , `id_b`)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
			Array($params['date'], $params['who'], $params['text'], 'new', 'n', $params['email'], $params['ido'], $params['idu'], $params['idb']));	
	}
}