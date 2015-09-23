<?php
/**
 * Пенрсональняа страница
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */
if(!defined("SHIFTCMS")) exit;

	if(isset($_SESSION['neworder']) && $_SESSION['neworder']!=''){
		$smarty -> assign("neworder", $_SESSION['neworder']);
		$_SESSION['neworder'] = '';
	}

	$rr = $db -> Execute("select id, idu, date_order, items from ".$_conf['prefix']."orders 
	where idu='".$_SESSION['USER_IDU']."' order by date_order desc");
	if($rr -> RecordCount() == 0){
		$smarty -> assign("userorder","no");
	}else{
		$smarty -> assign("userorder","yes");
		$orders = array(); 
		while(!$rr->EOF){
			$tt = $rr -> GetRowAssoc(false);
			$r = $db -> Execute("select * from ".$_conf['prefix']."orders_full where id='".$tt['id']."'");
			$basket = array(); $total = 0;
			$items = unserialize(stripslashes($tt['items']));
			//echo '<pre>';
			//print_r($items);
			//echo '</pre>';
			//while(list($k,$v)=each($items)){
			while(!$r->EOF){
				$t = $r -> GetRowAssoc(false);
				$total = $total + $t['icena']*$t['icount'];
				$stoimost = $t['icena']*$t['icount'];
				$basket[$t['ido']] = array(
					'id'=>$t['ido'],
					'cat'=>$t['cat'],
					'name'=>$t['iname'],
					'partno'=>$items[$t['item']]['partno'],
					'kolichestvo'=>$t['icount'],
					'cena'=>$t['icena'],
					'stoimost'=>$stoimost,
				);
				$r -> MoveNext();
			}
			$orders[] = array(
				'total'=>$total,
				'basket'=>$basket,
				'id'=>$tt['id'],
				'date_order'=>$tt['date_order'],
				'state'=>$order_state[$t['istate']],
			);
			$rr -> MoveNext();
		}
		$smarty -> assign("orders",$orders);
	}
	$ui = GetUserName($_SESSION['USER_IDU']);
	while(list($k,$v)=each($ui)) $ui[$k] = stripslashes($v);
	$ui['cityname'] = GetItemNameFromDict($ui['city'], "delivery_city");
	$smarty -> assign("ui", $ui);

$PAGE = $smarty -> fetch("cabinet.tpl");

?>