{foreach from=$list[$listName] key=k item=v}
	<div>
		<input type="checkbox" name="{$fields[$listName]}[]" value="{$k}"{if in_array($k, $fieldsValues.course)} checked="checked"{/if} />
		&nbsp;<span>{$v}</span>
	</div>
{/foreach}