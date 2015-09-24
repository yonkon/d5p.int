<h1>Персональная страница</h1>

{if isset($neworder)}<div class="good">{$neworder}</div>{/if}

<h2>Ваши заказы:</h2>
{if $userorder=="no"}
<div class="error">У Вас нет ни одного заказа!</div>
{else}
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="singleItemTab">
<tr><th>Наименование товара</th><th>Кол-во</th><th>Цена</th><th>Стоимость</th></tr>
<tr><td colspan="4" class="tdseparator">&nbsp;</td></tr>
{foreach key=key item=item from=$orders}
	<tr id="TR_{$item.id}">
    <td colspan="4"><h4>Заказ №<span class="ordernumber">{$item.id}</span> от {$item.date_order|date_format:"%d.%m.%Y %H:%M"} : <span class="cena">{$item.state}</span></h4></td>
    </tr>
    {foreach key=k item=i from=$item.basket}
    <tr>
    <td>{$i.name}</td>
    <td>{$i.kolichestvo}</td>
    <td><span class="cena">${$i.cena}</span></td>
    <td><span class="cena">${$i.stoimost}</span></td>
    </tr>
    {/foreach}
	<tr><td>&nbsp;</td><td>&nbsp;</td><td align="right"><strong>Итого:</strong></td><td><strong>${$item.total}</strong></td></tr>
    <tr><td colspan="4" class="tdseparator">&nbsp;</td></tr>
{/foreach}
</table>
{/if}

<br /><br />
<h2>Ваши данные:</h2>
   	<table border="0" width="100%" cellspacing="0" class="OF"> 
        <tr><td class="t01">{$lang.reg_email}:</td><td class="t02"><strong>{$ui.email}</strong></td></tr>
        <tr><td class="t01" nowrap="nowrap">ФИО:</td><td class="t02"><strong>{$ui.sname} {$ui.fname} {$ui.mname}</strong></td></tr>
        <tr><td class="t01">Телефон:</td><td class="t02"><strong>{$ui.phone}</strong></td></tr>
        <tr><td class="t01">Мобильный телефон:</td><td class="t02"><strong>{$ui.mphone}</strong></td></tr>
        <tr><td class="t01">Факс:</td><td class="t02"><strong>{$ui.fax}</strong></td></tr>
        <tr><td class="t01">Город:</td><td class="t02"><strong>{$ui.cityname}</strong></td></tr>
        <tr><td class="t01">{$lang.reg_adres}:</td><td class="t02"><strong>{$ui.contact}</strong></td></tr>
		{if $ui.organisation!='&nbsp;'}
        <tr><td class="t01">Организация:</td><td class="t02"><strong>{$ui.organisation}</strong></td></tr>
        <tr><td class="t01">Юридический адрес:</td><td class="t02"><strong>{$ui.firmadres}</strong></td></tr>
        <tr><td class="t01">Номер свидетельства:</td><td class="t02"><strong>{$ui.svnomer}</strong></td></tr>
        <tr><td class="t01">Номер плательщика НДС:</td><td class="t02"><strong>{$ui.pdvnomer}</strong></td></tr>
        {/if}
		<tr><td class="t01">&nbsp;</td><td class="t02"><a href="?p=useredit">Редактировать личную информацию</a></td></tr>
    </table>
