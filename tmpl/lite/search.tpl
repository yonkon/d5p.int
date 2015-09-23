
{* Вывод списка товаров из выбранного раздела *}
<div id="search">
	{if isset($warn)}<strong>По Вашему запросту ничего найти не удалось. Попробуйте изменить параметры поиска</strong>{/if}
	
    {if isset($pagelist) && count($pagelist)>0}
    <div class="catpagelist">
	{section name=pl_loop loop=$pagelist}
	    {if $pagelist[pl_loop].type=="number"}<a href="{$pagelist[pl_loop].link}">{$pagelist[pl_loop].number}</a>{/if}
	    {if $pagelist[pl_loop].type=="back"}<a href="{$pagelist[pl_loop].link}">&laquo;</a>{/if}
	    {if $pagelist[pl_loop].type=="forward"}<a href="{$pagelist[pl_loop].link}">&raquo;</a>{/if}
	    {if $pagelist[pl_loop].type=="current"}<span>{$pagelist[pl_loop].number}</span>{/if}
	{/section}
    </div>
    {/if}
    
    {if isset($found) && count($found)>0}
    <table border="0" cellspacing="3">
	{foreach key=key item=item from=$found}
        <tr>
        <td valign="top">{$key+1}.</td>
        <td valign="top"><a href="{$item.slink}"><strong>{$item.stitle}</strong></a><br /><small>{$item.stext}</small></td>
        </tr>
    {/foreach}
	</table>
    {/if}

    {if isset($pagelist) && count($pagelist)>0}
    <div class="catpagelist">
	{section name=pl_loop loop=$pagelist}
	    {if $pagelist[pl_loop].type=="number"}<a href="{$pagelist[pl_loop].link}">{$pagelist[pl_loop].number}</a>{/if}
	    {if $pagelist[pl_loop].type=="back"}<a href="{$pagelist[pl_loop].link}">&laquo;</a>{/if}
	    {if $pagelist[pl_loop].type=="forward"}<a href="{$pagelist[pl_loop].link}">&raquo;</a>{/if}
	    {if $pagelist[pl_loop].type=="current"}<span>{$pagelist[pl_loop].number}</span>{/if}
	{/section}
    </div>
    {/if}

</div>