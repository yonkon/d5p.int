<h1>{$lang.sitemap}</h1>
<div class="sitemap">
<ul>
{foreach key=key item=item from=$smaps}
{if $item.type=="html"}<li><a href="{$item.link}" title="{$item.title}"><strong>{$item.title}</strong></a>{if $item.sub!=""}
	<ul>
	{foreach key=key1 item=item1 from=$item.sub}
	{if $item1.type=="html"}<li><a href="{$item1.link}" title="{$item1.title}">{$item1.title}</a>{if $item1.sub!=""}
		<ul>
		{foreach key=key2 item=item2 from=$item1.sub}
		{if $item2.type=="html"}<li><a href="{$item2.link}" title="{$item2.title}">{$item2.title}</a>{if $item2.sub!=""}
			<ul>
			{foreach key=key3 item=item3 from=$item2.sub}
			{if $item3.type=="html"}<li><a href="{$item3.link}" title="{$item3.title}">{$item3.title}</a>{if $item3.sub!=""}
				<ul>
				{foreach key=key4 item=item4 from=$item3.sub}
				{if $item4.type=="html"}<li><a href="{$item4.link}" title="{$item4.title}">{$item4.title}</a>
			
				</li>{/if}
				{/foreach}
				</ul>		
			{/if}</li>{/if}
			{/foreach}
			</ul>	
		{/if}</li>{/if}
		{/foreach}
		</ul>	
	{/if}</li>{/if}
	{/foreach}
	</ul>
{/if}</li>{/if}
{/foreach}
</ul>

</div>