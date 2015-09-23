<?php
/*
* Класс для работы со словарями
*
* @author alexby
*/
class UModelDicts extends UchetModel
{
	/*
	*
	*/
	public function __construct()
	{}
	
	/*
	*
	*/
	public function run()
	{
		if($this->request['operation'] == 'get') {
			$this->getDicts();
		}
		if($this->request['operation'] == 'set') {
			$this->setDict();
		}		
		return true;	
	}
	
	/*
	* Формирует и assign данные словарей
	*
	* @return void
	*/
	private function getDicts()
	{
		$dict = ($this->request['dicts'] == 'all') ? (null) : $this->request['dicts'];
		$this->assign('db', UDicts::getDicts($dict), false);
	}

	/*
	* Записывает данные словаря
	*
	* @return bool
	*/
	private function setDict()
	{
		foreach($this->request['dict'] as $key => $val) {
			if(!UDicts::setDict($key, $val)) {
				return false;
				//TODO: error
			}
			return true;
		}
	}
	
	
}