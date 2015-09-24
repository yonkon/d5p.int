<h2 class="tarrow">Мои заказы</h2>
<table border="0" cellspacing="0" cellpadding="o" class="rTab">
{section name=res_i loop=$res}
	<tr>
		<td>
			<h4>Заказ №{$res[res_i].ido}</h4>
			{if $res[res_i].enablecomm=='y'}
				<a style="color:red;" href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res[res_i].ido}">Пожалуйста, выставьте оценку и напишите отзыв о работе</a>
			{/if}
			<br />
			{$res[res_i].o_worktype}, {$res[res_i].o_course} от {$res[res_i].o_date}<br />
			<strong>Тема:</strong> <a href="{$url.orderinfo}{include file="hrefparam.tpl" hrefParam="ido" hrefVal=$res[res_i].ido}">{$res[res_i].o_thema}</a><br />
			<small><strong>Состояние:</strong> {$res[res_i].o_state}</small><br />
			{if $res[res_i].mails!='0'}
				<font color="red">Новая почта по заказу: {$res[res_i].mails}</font><br />
			{/if}
			<br />
		</td>
	</tr>
{/section}
</table>