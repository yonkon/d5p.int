<div id="breadcrumbs">

{foreach key=key item=item from=$breadcrumbs_ar name=brc}
		<a href="{$item.link}" title="{$item.linktitle}">{$item.linkname}</a>
        {if !$smarty.foreach.brc.last}&nbsp;&raquo;&raquo;&nbsp;{/if}
{/foreach}

</div>