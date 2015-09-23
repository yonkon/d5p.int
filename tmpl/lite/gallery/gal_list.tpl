<ul class="gallist">
{foreach item=item key=key from=$lb_gallery_list}
	<li><a href="?p=gallery&ids={$item.ids}"{if $item.cur=="y"} class="glsel"{/if}>{$item.name}</a></li>
{/foreach}
</ul>