<ul class="leftmenu">
{foreach key=key item=item from=$menu2}
	<li><a href="{$item.link}" title="{$item.linktitle}"{if $item.sel=="y"} class="lmsel"{/if}>{$item.linkname}</a></li>
{/foreach}
</ul>