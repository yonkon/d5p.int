{if count($paging)>0}
{foreach key=key item=item from=$paging}
    {if $key=="dot"}
        <span>...</span>
    {else}
        <a href="{$item}">{$key}</a> 
    {/if}
{/foreach}
{/if}