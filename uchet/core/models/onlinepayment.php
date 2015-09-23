<?php
/*
* Класс для работы с платёжными системами
*
* @author alexby <mail.alex.by@gmail.com>
*/
class UModelOnlinepayment extends UchetModel
{
	/*
	* Пустой конструктор
	*/
	public function __construct()
	{}
	
	/*
	* Запуск приложения
	*
	* @return bool результат выполнения
	*/
	public function run()
	{
		if(!UCONFIG::$onlinePay) {
			UError::newErrorMessage('5.1');
			$this->goToUrl('orderlist');			
			return false;
		}
		
		if(isset($this->request['resultpayment'])) {
			$this->outPaymentRestul();
			return true;
		}
		
		if(empty($this->request['ido'])) {
			$this->goToUrl('orderlist');
			return false;
		}
		
		$req = new UClient(Array(
			'ido' => $this->request['ido'],
			'mail' => Array('act' => ''),
		));
		if(isset($this->request['prepare_paysys'])) {
			if($req->makeRequest('getUserOrderInfo')) {
				if(!$req->code) {
					$this->assign('paysys', $this->request['prepare_paysys']);
					$this->assign('sum', $this->request['sum']);
					$this->assign('res', $req->result['order']);					
					if($this->request['prepare_paysys'] == 'easypay') {
						$this->assign('ep_hash', $this->createAuthorizationKeyEasyPay($req->result['order']['ep_payment_id'], $this->request['sum']));
					} elseif($this->request['prepare_paysys'] == 'robokassa') {
						$rk = new Robokassa();
						$this->assign('hash', $rk->createSignatureToSend($req->result['order']['rk_pid_local'], $req->result['order']['rk_pid_general'], $this->request['sum']));
					}
				} else {
					return false;
				}
			}
		}
		return false;
	}
	
	/**
	* Вычисление контрольной подписи для EasyPay.by
	*
	* @param int $orderNumber уникальный номер
	* @param int $sumToPay сумма к оплате
	* @return str контрольная сумма платежа
	*/
    function createAuthorizationKeyEasyPay($paymentId, $sumToPay) 
	{
        return md5(
			UCONFIG::$paymentMethod['easypayby']['login']
			.UCONFIG::$paymentMethod['easypayby']['web_key']
			.$paymentId
			.$sumToPay);
    }
	
	/*
	* Вывод информации о проведённом платеже
	*
	* @return null
	*/
	private function outPaymentRestul()
	{
		$this->assign('showPaymentResult', true);
		$this->assign('paysys', $this->request['paysys']);		
		
		if($this->request['paysys'] == 'interkassa') { //Интеркасса
			$this->assign('ik_payment_id', $this->request['ik_payment_id']);
			$this->assign('ik_payment_state', $this->request['ik_payment_state']);
			$this->assign('ik_trans_id', $this->request['ik_trans_id']);
		} elseif($this->request['paysys'] == 'privat24') { //Приват24
			ULog::writeSeparate('privat24', $this->request);
			parse_str($this->request['payment'], $rData);
			$this->assign('p24_state', $rData['state']);
			$this->assign('p24_payment_id', $rData['order']);
		} elseif($this->request['paysys'] == 'qiwi') { //Qiwi
            $this->assign('resultpayment', $this->request['resultpayment']);
            $this->assign('order', $this->request['order']);
        } elseif($this->request['paysys'] == 'easypayby') { //Easypay
            $this->assign('resultpayment', $this->request['resultpayment']);
            $this->assign('EP_OrderNo', $this->request['EP_OrderNo']);
        } elseif($this->request['paysys'] == 'robokassa') { //Robokassa
            $this->assign('resultpayment', $this->request['resultpayment']);
			$this->assign('paymentNumber', $this->request['InvId'].'-'.$this->request['Shp_item']);
        }
	}
}
