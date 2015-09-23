<h1>Оплата заказа</h1>
{if (!empty($showPaymentResult))}
	{if $paysys == 'interkassa'}
		{if $ik_payment_state == 'success'}
			Ваш платёж принят.<br />
			Номер платежа в системе Interkassa: {$ik_trans_id}<br />
			Номер платежа на сайте {$siteName}: {$ik_payment_id}
		{else}
			Ваш платёж не принят<br />
		{/if}
	{elseif $paysys == 'privat24'}
		{if $p24_state == 'ok'}
		    Ваш платёж принят.<br />
            Номер платежа в системе Приват24: {$p24_payment_id}<br />
		{else}
			Ваш платёж не принят<br />
		{/if}
    {elseif $paysys == 'qiwi'} 
        {if $resultpayment == 'success'}
            Ваш платёж принят.<br />
            Номер платежа в системе QIWI: {$order}<br />
        {else}
            Ваш платёж не принят<br />
        {/if}
    {elseif $paysys == 'easypayby'} 
            {if $resultpayment == 'success'}
                Ваш платёж принят.<br />
                Номер платежа в системе EasyPay: {$EP_OrderNo}<br />
            {else}
                Ваш платёж не принят<br />
            {/if}    
    {elseif $paysys == 'robokassa'} 
            {if $resultpayment == 'success'}
                Ваш платёж принят.<br />
                Номер платежа на нашем сайте: {$paymentNumber}<br />
            {else}
                Ваш платёж не принят<br />
            {/if}    
	{/if}
	<a href="{$url.orderlist}">Вернуться</a>
{else}
	{if isset($errormsg)}<div style="border:dotted 1px red; color:red; padding:4px; margin:4px;">{$errormsg}</div>{/if}
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab">
		<tr><td>№</td><td><strong>{$res.ido}</strong></td></tr>
		<tr><td>Тема:</td><td><strong>{$res.o_thema}</strong></td></tr>
		<tr><td>Стоимость:&nbsp;</td><td><strong>{$res.o_cost}&nbsp;{$lang.currency}</strong></td></tr>
		<tr><td>К оплате:</td><td><strong>{$sum}&nbsp;{$lang.currency}</strong></td></tr>
	</table>
	<br />
	{if $paysys == 'easypayby'}
		<div style="border:dotted 1px #ccc; padding:4px;margin:2px;">
			<form action="{$paymentMethod.easypayby.server}" method="post" target="_top" enctype="application/x-www-form-urlencoded; charset=windows-1251" accept-charset="windows-1251">
				<input type="hidden" name="EP_MerNo" value="{$paymentMethod.easypayby.login}" />
				<input type="hidden" name="EP_Expires" value="{$paymentMethod.easypayby.expires}" />
				<input type="hidden" name="EP_Hash" value="{$ep_hash}" />
				<input type="hidden" name="EP_Success_URL" value="{$paymentMethod.easypayby.url.success}" />
				<input type="hidden" name="EP_Cancel_URL"  value="{$paymentMethod.easypayby.url.fail}" />
				<input type="hidden" name="EP_Debug" value="{$paymentMethod.easypayby.debug}" />
				<input type="hidden" name="EP_OrderNo" value="{$res.ep_payment_id}" />
				<input type="hidden" name="EP_Comment" value="{$res.o_worktype}" />
				<input type="hidden" name="EP_OrderInfo" value="{$res.o_worktype}, {$res.o_course} на тему: {$res.o_thema}" /> 
				<table><tr>
					<td>Сумма: {$sum} {$lang.currency}</td>
					<td><input type="submit" value="Оплатить {$paymentMethod.easypayby.fullname}" /></td>
				</tr></table>
			</form>
		</div>
	{elseif $paysys == 'robokassa'}
		<form action="{$paymentMethod.robokassa.server}" method="POST" />
			<input type="hidden" name="MrchLogin" value="{$paymentMethod.robokassa.merchantLogin}" />
			<input type="hidden" name="OutSum" value="{$sum}" />
			<input type="hidden" name="InvId" value="{$res.rk_pid_local}" />
			<input type="hidden" name="Desc" value="" />
			<input type="hidden" name="SignatureValue" value="{$hash}" />
			<input type="hidden" name="Shp_item" value="{$res.rk_pid_general}" />
			<input type="hidden" name="IncCurrLabel" value="" />
			<input type="hidden" name="Culture" value="ru" />
			<input type="submit" value="Оплатить {$paymentMethod.robokassa.fullname}"/>
		</form>
	{/if}
	<br /><br />
	<a href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}">Вернуться к заказу</a>
{/if}