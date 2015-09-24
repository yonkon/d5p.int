<article>
	<h1>Банк готовых работ:</h1>
	{if count($subCategories)}
		{$num = 0}
		{$lastLetter = ''}
		{foreach key=idc item=category from=$subCategories name=subCategories}
			{if $lastLetter != $category.name|truncate:1:""}
				{$num = $num+1}
				{$lastLetter = $category.name|truncate:1:""}
				{if !$smarty.foreach.subCategories.first}
		</ul>
	</div>
				{/if}
	<div class="bank_item {if $num % 4 == 0}first{/if}">
		<p>{$category.name|truncate:1:""}</p>
		<ul>
			{/if}
			<li><a href="{$category.url}">{$category.name}</a></li>					
		{/foreach}
		</ul>
	</div>
	{/if}

</article>

</div>