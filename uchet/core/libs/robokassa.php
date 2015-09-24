<?php
/**
* Класс для работы с платежной системой ROBOKASSA
*
* @author alexby <mail.alex.by@gmail.com>
*/
class Robokassa
{
	private $returnText;

	public function __construct()
	{
		$returnText = '';
	}
	
	/**
	* Вычисление контрольной подписи
	*
	* @param int $orderNumber уникальный номер
	* @param int $sumToPay сумма к оплате
	* @return str контрольная сумма платежа
	*/
    public function createSignatureToSend($pIdLocal, $pIdGeneral, $sumToPay) 
	{
		return md5(
			UCONFIG::$paymentMethod['robokassa']['merchantLogin']
			.':'.$sumToPay
			.':'.$pIdLocal
			.':'.UCONFIG::$paymentMethod['robokassa']['password1']
			.':Shp_item='.$pIdGeneral);
    }
	
	public function applyRecievedData($request)
	{
		if ($this->checkRecievedSignature($request)) {
			$req = new UClient(Array(
				'act' => 'conduct',
				'paysys' => 'robokassa',
				'pIdGeneral' => $request['Shp_item'],
				'sum' => $request['OutSum'],
				'paymentMethod' => $request['PaymentMethod'],
				'incCurrLabel' => $request['IncCurrLabel'],
			));
			if($req->makeRequest('payment')) {
				$this->returnText = 'OK'.$request['InvId'];
				return true;
			}
			return false;		
		} else {
			return false;
			//TODO: write in hack log
		}
	}
	
	private function createSignatureToRecieve($request)
	{
		return strtoupper(md5(
			$request['OutSum']
			.':'.$request['InvId']
			.':'.UCONFIG::$paymentMethod['robokassa']['password2']
			.':Shp_item='
			.$request['Shp_item']));
	}
	
	private function checkRecievedSignature($request)
	{
		return ($request['SignatureValue'] == $this->createSignatureToRecieve($request)) ? true : false;
	}
	
	public function getReturnText()
	{
		return $this->returnText;
	}
}