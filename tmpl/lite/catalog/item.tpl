<article>
	<h1>{$pageTitle}</h1>
	<div class="work_contents">
		{foreach item=idpar from=$addInfoLeft}
			{if $productAddInfo[$idpar] != ''}
			<h2>{$parameters[$idpar]}:</h2>
			<p class="dotted_line">&nbsp;</p>
			<div class="pre">
				{$productAddInfo[$idpar]}
			</div>
			<br />
				{/if}
		{/foreach}

		<div class="item_params">
			{foreach item=idpar from=$addInfoRight}
				{if $productAddInfo[$idpar] != ''}
					<p>{$parameters[$idpar]}:<span>{$productAddInfo[$idpar]}</span></p>
				{/if}
			{/foreach}
		</div>
		<p class="dotted_line">&nbsp;</p>
	</div>

	{if isset($orderform) && $orderform!=""}{$orderformPattern}{/if}

</article>

</div>