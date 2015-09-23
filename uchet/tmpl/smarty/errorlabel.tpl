<span id="span_{$fieldName}{if isset($param)}_{$param}{/if}" style="{$style.text_red} display: none;">
	{assign var="lang_name" value='error_'|cat:$fieldName}
	{if isset($param)}
		{assign var="lang_name" value=$lang_name|cat:'_'|cat:$param}
	{/if}
	{$lang.$lang_name}
</span>