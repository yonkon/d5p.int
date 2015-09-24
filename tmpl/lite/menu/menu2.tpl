<ul class="footer_navigation">
{foreach key=key item=item from=$menu2}
	<li><a href="{$item.link}" title="{$item.linktitle}">{$item.linkname}</a></li>
{/foreach}
</ul>
