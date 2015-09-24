<ul class="pmenu">
{foreach key=key item=item from=$pmenu name=pmenu}
   <li><a href="{$item.link}" title="{$item.linktitle}"{if $item.sel=="y"} class="msel"{/if}>{$item.linkname}</a></li>
{/foreach}
</ul>
