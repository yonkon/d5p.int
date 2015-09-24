{if !empty($messageOut)}
	<strong>{$messageOut}</strong>
{/if}
<form action="admin.php?p=" method="post">
	<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
		<thead>
			<tr>
				<th>ID (просмотр<br />на сайте)</th>
				<th>Раздел</th>
				<th>Название (редактирование продукта)</th>
{*
				<th class="cat-tdMin">Включить показ на сайте</th>
*}
				<th class="cat-tdMin">Удалить</th>
			</tr>
		</thead>
		<tbody>
			{foreach key=idp item=product from=$products name=products}
			<tr>
				<td><a href="{$product.url}">{$idp}</a></td>
				<td>{$product.parentName}</td>
				<td><a href="/admin.php?p=item_edit&act=edit&idp={$idp}">{$product.name}</a></td>	
{*
				<td class="cat-tdMin"><input type="checkbox" name="pshow[{$idp}]" id="pshow[{$idp}]" value="1"{if $product.show == 1} checked="checked"{/if} /></td>
*}
				<td class="cat-tdMin"><a href="/admin.php?p=item_edit&act=delete&idp={$idp}" onclick="if(!confirm('Удалить объект?')||!confirm('Вы точно уверены? После удаления восстановить объект будет невозможно!')) return false" title="Удалить"><img src="tmpl/backend/grey/img/delit.png" width="16" height="16" alt="Удалить" border="0"></a></td>
			</tr>
			{/foreach}
		</tbody>
	</table>
</form>