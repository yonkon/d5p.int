<center>
	<strong>Заказ успешно оформлен!</strong><br /><br />
	<h3>Номер заказа: {$orderInfo.ido}</h3>
</center>
<p>Пожалуйста, во время переписки с менеджерами, указывайте номер заказа в теме письма<br />
В ближайшее время мы свяжемся с Вами для согласования всех деталей работы.</p>

{if isset($clientInfo)}
	<p>
		<strong>Ваши данные для входа в аккаунт:</strong><br />
		Логин: <strong>{$clientInfo.login}</strong><br />
		Пароль: <strong>{$clientInfo.password}</strong>
	</p>
	<p>
		<strong>Контактная информация:</strong><br />
		{$lang.fio}: {$clientInfo.fio}<br />
		{$lang.email}: {$clientInfo.email}<br />
		{$lang.mphone}: +{$clientInfo.mphone}<br />
		{$lang.sphone}: +{$clientInfo.sphone}<br />
		{$lang.icq}: {$clientInfo.icq}<br />
		{$lang.contact}: {$clientInfo.contact}<br />
	</p>
{/if}
<p>
	<strong>Информация по вашему заказу:</strong><br />
	{$lang.thema}: {$orderInfo.thema}<br />
	{$lang.course}: {if ($orderInfo.course != 0)}{$list.course[$orderInfo.course]}{/if}<br />
	{$lang.worktype}: {if ($orderInfo.worktype != 0)}{$list.worktype[$orderInfo.worktype]}{/if}<br />
	{$lang.client_srok}: {$orderInfo.client_srok}<br />
	{$lang.schooltype}: {if ($orderInfo.schooltype != 0)}{$list.schooltype[$orderInfo.schooltype]}{/if}<br />
	{$lang.cnc}: {if !empty($orderInfo.country)}{$list.country[$orderInfo.country]}, {/if}{$orderInfo.city}<br />
	{$lang.vuz}: {$orderInfo.vuz}<br />
	{$lang.volume}: {$orderInfo.volume}<br />
	{$lang.gost}: {if ($orderInfo.gost != 0)}{$list.gost[$orderInfo.gost]}{/if}<br />
	{$lang.font}: {$orderInfo.font}<br />
	{$lang.interval}: {$orderInfo.interval}<br />
	{$lang.listsource}: {$orderInfo.listsource}<br />
	{$lang.addinfo}: {$orderInfo.addinfo}<br />
	{$lang.precost}: {$orderInfo.precost} {$lang.currency}<br />
</p>
<p>
	{if count($filesInfo.files) != 0}
		<strong>Прикреплённые файлы</strong>{if isset($filesInfo.file_part) && $filesInfo.file_part != ''}({$lang.file_part}: {$list.file_part[$filesInfo.file_part]}){/if}:<br />
		{foreach from=$filesInfo.files key=key item=item}
			{$key+1}: {$item.name}
			{if $item.status == 'none'}
				- {$lang.fileUploadingError1}
			{elseif $item.status == 'mismatch'}
				- {$lang.fileUploadingError2}
			{/if}
			<br />
		{/foreach}
		{if isset($filesInfo.f_comment) && $filesInfo.f_comment != ''}
			{$lang.file_comment} {$filesInfo.f_comment}<br />
		{/if}		
	{else}
		<strong>Прикреплённых файлов нет.</strong><br />
	{/if}	
</p>
<p>Вы всегда можете войти в свой аккаунт для просмотра состояния заказа, переписки с менеджерами, загрузки файлов по выполненным заказам.<br /></p>
<p>С уважением, администрация сайта!</p>