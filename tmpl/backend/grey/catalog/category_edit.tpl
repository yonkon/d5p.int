{if !empty($messageOut)}
	<strong>{$messageOut}</strong>
{/if}
</script>
<form action="admin.php?p=category_edit" method="post" id="info_form">

	<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
		<tbody>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Название:</td>
				<td><input type='text' name='name' size='50' maxlenght='150' value="{$currentCategory.name}" /></td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Родительский раздел:</td>
				<td>
					<select name="parent_idc" style="width:200px;">
					{foreach key=idc item=catName from=$categoriesList}
						<option {if $currentCategory.parentCat == $idc}selected="selected"{/if} value="{$idc}"> {$catName} </option>
					{/foreach}
					</select>
				</td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Порядок сортировки:</td>
				<td><input type="text" name="sort_order" value="{$currentCategory.sort}" size="3"></td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Включить показ на сайте:</td>
				<td><input type="checkbox" name="show" id="show" value="y" {if $currentCategory.show == 1}checked="checked" {/if}/></td>
			</tr>
		</tbody>
	</table>

	<input type="hidden" name="act" value="{$act}" />
	<input type="hidden" name="idc" value="{$currentCategory.idc}" />
	<p><input type="submit" value="Сохранить" /></p>
</form>