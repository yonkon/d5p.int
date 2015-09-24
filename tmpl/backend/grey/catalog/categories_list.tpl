{if !empty($messageOut)}
	<strong>{$messageOut}</strong>
{/if}
<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
	<thead>
		<tr>
			<th>ID (просмотр<br />категории)</th>
			<th>Название (редактирование категории)</th>
{*				
			<th class="cat-tdMin">Включить показ на сайте</th>
			<th class="cat-tdMin">Порядок сортировки</th>
*}				
			<th class="cat-tdMin">Удалить</th>
		</tr>
	</thead>
	<tbody>
		{foreach key=idc item=category from=$categoriesList name=subCategories}
		<tr>
			<td><a href="{$category.url}">{$idc}</a></td>
			<td><a href="/admin.php?p=category_edit&act=edit&idc={$idc}">{$category.name}</a></td>
{*
			<td class="cat-tdMin"><input type="checkbox" name="sshow[{$category.idSection}]" id="sshow[{$category.idSection}]" value="1" {if $category.sectionShow == 1}checked="checked"{/if} /></td>
			<td class="cat-tdMin"><input type="text" id="sid[{$category.idSection}]" name="sid[{$category.idSection}]" value="{$category.sectionSort}" size="3" /></td>
*}
			<td class="cat-tdMin"><a href="/admin.php?p=category_edit&act=delete&idc={$idc}" onclick="if(!confirm('Удалить раздел?')||!confirm('Вы точно уверены? После удаления восстановить раздел будет невозможно!')) return false" title="Удалить"><img src="tmpl/backend/grey/img/delit.png" width="16" height="16" alt="Удалить" border="0"></a></td>
		</tr>
		{/foreach}
	</tbody>
</table>