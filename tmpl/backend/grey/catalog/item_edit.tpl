{if !empty($messageOut)}
	<strong>{$messageOut}</strong>
{/if}
<form action="admin.php?p=item_edit" method="post" enctype="multipart/form-data">
	<table border="0" cellspacing="0" class="selrow" width="100%" id="ItemTab">
		<tbody>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Раздел:</td>
				<td>
					<select name="parent_idc" id="categoryParent" style="width:200px;">
					{foreach key=idc item=item from=$categoriesList}
						<option {if $product.parent == $idc}selected="selected"{/if} value="{$idc}">{$item}</option>
					{/foreach}
					</select>
				</td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Включить показ на сайте:</td>
				<td><input type="checkbox" name="show" id="itemShow" {if $product.show == 1}checked="checked"{/if} /></td>
			</tr>
			<tr class="editSection-trHeight">
				<td class="editSection-tdName">Порядок сортировки:</td>
				<td><input type="text" name="sort_order" value="{$product.sortOrder}" size="3"></td>
			</tr>			
		</tbody>
	</table>
	
	<strong>Название:</strong><br />
	<input type='text' name='name' size='50' maxlenght='150' value="{$product.name}" /><br />

	{foreach key=id_additionalInfo item=current_additionalInfo from=$parameters}
		{if in_array($id_additionalInfo, $listIdParameters['input'])}
			<strong>{$parameters[$id_additionalInfo]}:</strong><br />
			<input type='text' name='addInfo[{$id_additionalInfo}]' size='50' maxlenght='150' value="{$product.addInfo[$id_additionalInfo]}" /><br />
		{/if}

		{if in_array($id_additionalInfo, $listIdParameters['textarea'])}
			<strong>{$parameters[$id_additionalInfo]}:</strong><br />
			<textarea name="addInfo[{$id_additionalInfo}]" rows="5" cols="120">{$product.addInfo[$id_additionalInfo]}</textarea><br />
		{/if}		
	{/foreach}

	<input type="hidden" name="act" value="{$act}" />
	<input type="hidden" name="idp" value="{$product.idp}" />
	<p><input type="submit" value="Сохранить" /></p>
</form>