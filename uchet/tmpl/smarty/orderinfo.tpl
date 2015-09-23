{if count($errorCodes)}
    {include file='error.tpl'}
{else}
	<p><a href="{$url.orderlist}">&laquo;&laquo; Назад к списку заказов</a></p><br />

	{if isset($res.ballMSG)}
		<p style="border:dotted 1px red; padding:2px;">{$res.ballMSG}</p>
	{/if}

	{if isset($infomsg)}
		<div style="border:dotted 1px green; color:green; padding:4px; margin:4px;">{$infomsg}</div>
	{/if}

	{if $res.enablecomm=="y"}
		<h3>Ваш отзыв о работе</h3>
		<form method="post" action="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}{include file="hrefparam.tpl" hrefParam="act" hrefVal="sendBall"}" id="rForm" enctype="multipart/form-data">
		<strong>Ваша оценка работы:</strong><br />
		<input type="radio" name="ball" id="ball1" value="1" /> 1 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball2" value="2" /> 2 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball3" value="3" /> 3 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball4" value="4" /> 4 &nbsp;&nbsp;
		<input type="radio" name="ball" id="ball5" value="5" /> 5
		<br />
		<strong>Комментарий:</strong><br />
		<textarea name="wcomm" id="wcomm" style="width:400px; height:100px;">{if isset($res.wcomm)}{$res.wcomm}{/if}</textarea><br />
		<input type="submit" value="Отправить" />
		</form>
		<hr /><br />
	{/if}
       			
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab">
		<tr><td>№</td><td><strong>{$res.ido}</strong> <small>({$res.o_state})</small></td></tr>
		<tr><td>Дата оформления:</td><td>{$res.o_date|date_format:"%d.%m.%Y"}</td></tr>
		<tr><td>Тема:</td><td><strong>{$res.o_thema}</strong></td></tr>
		<tr><td>Предмет работы:</td><td>{$res.o_worktype}</td></tr>
		<tr><td>Тип работы:</td><td>{$res.o_course}</td></tr>
		<tr><td>Объем:</td><td>{if !empty($res.o_volume)}{$res.o_volume}{else}-{/if}</td></tr>
		<tr><td>ГОСТ:</td><td>{if !empty($res.gost)}{$res.gost}{else}-{/if}</td></tr>
		<tr><td>Шрифт:</td><td>{if !empty($res.o_font)}{$res.o_font}{else}-{/if}</td></tr>
		<tr><td>Интервал:</td><td>{if !empty($res.o_interval)}{$res.o_interval}{else}-{/if}</td></tr>
		<tr><td>К-во используемых источников:</td><td>{if !empty($res.o_listsource)}{$res.o_listsource}{else}-{/if}</td></tr>
		<tr><td>Дополнительная информация:</td><td>{if !empty($res.o_addinfo)}{$res.o_addinfo}{else}-{/if}</td></tr>
		<tr><td style="border-bottom: 1px solid black">Срок выполнения:</td><td style="border-bottom: 1px solid black">{$res.o_client_srok|date_format:"%d.%m.%Y"}</td></tr>
		<tr><td>Стоимость:</td><td><strong>{$res.o_cost}&nbsp;{$lang.currency}</strong></td></tr>
	</table>
	<br /><br /><br />

	<h4>План выполнения работы</h4>
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab" style="width: 100%">
		<tr><th>Этап</th><th>Срок сдачи</th><th>Состояние</th><th>Оплата</th></tr>
		{section name=p_loop loop=$plan}
			<tr>
				<td>{$plan[p_loop].workpart}</td>
				<td>{$plan[p_loop].srok|date_format:"%d.%m.%Y"}</td>
				<td>{$plan[p_loop].sfile}</td>
				<td>{$plan[p_loop].spay}</td>
			</tr>
		{/section}
	</table>
	<br /><br /><br />
	
	<h4>Ваши платежи</h4>
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab" style="width: 100%">
		<tr><th>Сумма</th><th>Способ</th><th>Дата</th><th>Комментарий</th></tr>
		{section name=p_loop loop=$payments}
			<tr>
				<td>{$payments[p_loop].pamount}&nbsp;{$lang.currency}</td>
				<td>{$payments[p_loop].paysys}</td>
				<td>{$payments[p_loop].pdate|date_format:"%d.%m.%Y"}</td>
				<td>{$payments[p_loop].pcomment}</td>
			</tr>
		{/section}
	</table>
	<p><small>Чтобы отправить квитанцию об оплате, напишите письмо менеджеру (ниже) и прикрепите отсканированную копию квитанции.</small></p>
	<br /><br />
	
	<h4>Файлы</h4>
	<table border="0" cellspacing="0" cellpadding="0" class="dataTab" style="width: 100%">
		<tr><th>Файл</th><th>Тип</th><th>Дата</th></tr>
		{section name=f_loop loop=$files}
			<tr>
				<td>
					<img src="{$files[f_loop].ficon}" />
					{if $files[f_loop].upload=="y"}
						<a href="{$url.download}{include file="hrefparam.tpl" hrefParam="idf" hrefVal=$files[f_loop].idf}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}">{$files[f_loop].fname}</a> 
						<small>({$files[f_loop].fsize})</small>
					{else}
						{$files[f_loop].fname} <small>({$files[f_loop].fsize})</small>
					{/if}
				</td>
				<td>{$files[f_loop].fpart}</td>
				<td>{$files[f_loop].fdate|date_format:"%d.%m.%Y"}</td>
			</tr>
		{/section}
	</table>
	<br /><br /><br />

    {* Оплата*}
    {if ($onlinePay)}
    <h3>Оплата заказа №{$res.ido}</h3>
        {if isset($errormsg)}<div style="border:dotted 1px red; color:red; padding:4px; margin:4px;">{$errormsg}</div>{/if}
        <br />
        <h4>Выберите способ оплаты</h4>
		{foreach item=region from=$paysysRegions}
			<h3>{$region.text}</h3>
			{foreach item=paysys from=$region.payments}
				{assign var="item" value=$paymentMethod[$paysys]}
				{if $item.switch}
					<div style="border:dotted 1px #ccc; padding:4px;margin:2px;">
						<h4>{$item.fullname}</h4>
						{if $paysys == 'easypayby'}
							{if isset($item.info)}{$item.info}{/if}
							{if !empty($item.login)}
								<form action="{$url.onlinepayment}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}" method="post" target="_top" >
									<table> 
									<tr>
										<td><input type="text" name="sum" value="{$res.topay}" />&nbsp;{$lang.currency}</td>
										<td><input type="submit" value="Оплатить" /></td>
									</tr>
									</table>
									<input type="hidden" name="prepare_paysys" value="esaypay" />
								</form>
							{/if}
						{elseif $paysys == 'interkassa'}
							<form name="payment" action="{$item.server}" method="post" target="_top">
								<input type="hidden" name="ik_shop_id" value="{$item.ik_shop_id}">
								<input type="text" name="ik_payment_amount" value="{$res.topay}">&nbsp;{$lang.currency}
								<input type="hidden" name="ik_payment_id" value="{$res.ik_payment_id}">
								<input type="hidden" name="ik_payment_desc" value="{$res.ido}">
								<input type="hidden" name="ik_paysystem_alias" value="">
								<input type="hidden" name="ik_fail_url" value="{$item.url.fail}&ido={$res.ido}">
								<input type="hidden" name="ik_success_url" value="{$item.url.success}&ido={$res.ido}">
								<input type="submit" name="process" value="Оплатить">
							</form>
						{elseif $paysys == 'privat24'}
							<form action="{$item.server}" method="POST">
								<input type="text" name="amt" value="{$res.topay}"/>&nbsp;{$lang.currency}
								<input type="hidden" name="ccy" value="UAH" />
								<input type="hidden" name="merchant" value="{$item.mid}" />
								<input type="hidden" name="order" value="{$res.p24_payment_id}" />
								<input type="hidden" name="details" value="{$res.ido}" />
								<input type="hidden" name="ext_details" value="" />
								<input type="hidden" name="pay_way" value="privat24" />
								<input type="hidden" name="return_url" value="{$item.url.client}&ido={$res.ido}" />
								<input type="hidden" name="server_url" value="{$item.url.server}" />
								<input type="submit" value="Оплатить" />
							</form>
						{elseif $paysys == 'qiwi'} 
							<form  action="{$item.server}" method="get">
								<input name="from" value="{$item.qiwi_shop_id}" type="hidden" /> 
								<input name="txn_id" value="{$res.qw_payment_id}" type="hidden" /> 
								<input name="com" value="{$res.o_worktype},{$res.o_course} на тему: {$res.o_thema}" type="hidden" />
								<table>
									<tr><td> Номер телефона (счет qiwi):</td><td colspan="2"><input name="to" value="" /> </td> </tr>
									<tr><td> Сумма(руб.):</td><td><input name="summ" value="{$res.topay}" /> </td> </tr> 
									<tr><td></td><td><input type="submit" value="Оплатить" /></td></tr>
								</table>
							</form>
						{elseif $paysys == 'robokassa'}
							<form action="{$url.onlinepayment}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}" method="post" target="_top" >
								<table> 
								<tr>
									<td><input type="text" name="sum" value="{$res.topay}" />&nbsp;{$lang.currency}</td>
									<td><input type="submit" value="Оплатить" /></td>
								</tr>
								</table>
								<input type="hidden" name="prepare_paysys" value="robokassa" />
							</form>
						{elseif $paysys == 'cash1' || $paysys == 'cash2' || $paysys == 'cash3' || $paysys == 'cash4'}
							{$item.info}
						{elseif $paysys == 'bank1' || $paysys == 'bank2' || $paysys == 'bank3' || $paysys == 'bank4'}
							{$item.info}<br />
							Платежку можно скачать <a href="{$item.file}">тут</a>						
						{/if}
					</div>
				{/if}
			{/foreach}
		{/foreach}
    {/if}
    
    {* вывод почты: писем к заказу *}
        
    <h3 style="border-top:solid 1px #cccccc;">Почта по заказу №{$res.ido}</h3><a name="mailpoint"></a>

    {if isset($sendmsg)}
        <p style="padding:3px; color:red; border:dashed 1px blue;">{$sendmsg}</p>
    {/if}

    <p><a href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}{include file="hrefparam.tpl" hrefParam="act" hrefVal="writeMail"}#mailpoint">Написать письмо менеджеру</a></p>

    {if !empty($mail)}
        <table border="0" cellspacing="0" cellpadding="0" class="dataTab">
            <tr>
                <td valign="top" width="50%">
                    <table border="0" cellspacing="0" cellpadding="0" class="dataTab">
                        {foreach key=key item=item from=$mail}
                            <tr>
                                <td><small>{$item.mdate|date_format:"%d.%m.%Y %H:%M"}</small></td>
                                <td><a href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}{include file="hrefparam.tpl" hrefParam="act" hrefVal="readMail"}{include file="hrefparam.tpl" hrefParam="idm" hrefVal=$item.idm}#mailpoint">{if $item.mstate=="new"}<strong>{/if}{$item.subject}{if $item.mstate=="new"}</strong>{/if}</a></td>
                            </tr>
                        {/foreach}
                    </table>
                
                </td>
            </tr>
            <tr>
                <td valign="top">
                    {if !empty($readMail)}
                        <br /><br />
                        <p style="padding-bottom:5px; border-bottom:solid 1px #cccccc;"><a href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}{include file="hrefparam.tpl" hrefParam="act" hrefVal="writeMail"}{include file="hrefparam.tpl" hrefParam="idm" hrefVal=$rm_idm}#mailpoint">Ответить</a> | <a href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}{include file="hrefparam.tpl" hrefParam="act" hrefVal="deleteMail"}{include file="hrefparam.tpl" hrefParam="idm" hrefVal=$rm_idm}#mailpoint">Удалить</a></p>
                        <p><strong>{$rm_subject}</strong></p>
                        {if !empty($attach)}
                        <div style="border:solid 1px #cccccc;padding:3px;margin:3px;">
                            {foreach key=key item=item from=$attach}
                             <a href="{$url.download}{include file="hrefparam.tpl" hrefParam="ida" hrefVal=$item.ida}{include file="hrefparam.tpl" hrefParam="idm" hrefVal=$rm_idm}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}">{$item.fname} <small>({$item.fsize})</small></a> &nbsp;&nbsp;&nbsp;
                            {/foreach}        
                        </div>
                        {/if}
                        <div style="border:solid 1px #cccccc; padding:3px;">{$rm_message}</div>
                    {/if}
                    {if empty($writeMail)} 
                        </td></tr></table>
                    {/if}
    {/if}
    {if !empty($writeMail)}
        <div style="border:solid 1px #cccccc; padding:3px;">
            <p><strong>Информация по заказу № {$res.ido}</strong></p>
            <form method="post" action="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res.ido}{include file="hrefparam.tpl" hrefParam="act" hrefVal="sendMail"}#mailpoint" enctype="multipart/form-data">
                {if !empty($idm)}
                    <input type="hidden" name="idm" id="idm" value="{$idm}" />
                {/if}
                Текст сообщения:<br />
                <textarea name="m_message" id="m_message" style="width:350px;height:200px;"></textarea><br />
                Прикрепить файл:<br />
                <input type="file" name="attach" id="attach" size="30" /><br /><br />
                <input type="submit" value="Отправить" style="width:100px;height:26px;" />
            </form>
        </div>
        {if !empty($mail)}
            </td></tr></table>
        {/if}
    {/if}

    {* конец вывода почты *}
{/if}