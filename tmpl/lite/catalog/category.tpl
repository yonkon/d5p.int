<article>
	{if count($subCategories)}
		{foreach key=idc item=category from=$subCategories}
			{if count($category.productsList)}
				<h2>{$category.name}</h2>
				<ul>
					{foreach key=idp item=product from=$category.productsList}
					<li><a href="{$product.url}">{$product.name}</a></li>
					{/foreach}
				</ul>
			{/if}
		{/foreach}
	{else}
		В данной категории нет работ!
	{/if}
</article>

</div>