<ul>
{foreach key=key item=item from=$menu1 name=tmenu}
	<li>
		<a href="{$item.link}" title="{$item.linktitle}"{if $item.sel=="y"} class="current"{/if}>{$item.linkname}</a>
		<span></span>
    </li>
    {*{if !$smarty.foreach.tmenu.last}&nbsp;|&nbsp;{/if}*}
{/foreach}
</ul>