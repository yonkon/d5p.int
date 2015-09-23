<option value="0">{$lang.choosefromlist}</option>
{foreach from=$list[$listName] key=k item=v}
	<option value="{$k}"{if $fieldsValues[$listName] == $k} selected="selected"{/if}>{$v}</option>
{/foreach}