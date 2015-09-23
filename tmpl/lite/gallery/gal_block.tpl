{if !isset($nofoto)}
<center>

<div>
{$pagelist}
	<script type="text/javascript" src="/js/highslide/highslide-full.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/highslide/highslide.css" />
	{literal}
	<script type="text/javascript">
		hs.graphicsDir = '/js/highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.fadeInOut = true;
		//hs.dimmingOpacity = 0.75;
		// Add the controlbar
		hs.addSlideshow({
			//slideshowGroup: 'group1',
			interval: 2000,
			repeat: false,
			useControls: true,
			fixedControls: 'fit',
			overlayOptions: {
				opacity: .75,
				position: 'bottom center',
				hideOnMouseOut: true
			}
		});
	</script>
    {/literal}
    
    <div class="highslide-gallery">
	{foreach key=key item=item from=$ph_ar}
    	<div><a href="{$item.BIGIMG}" class="highslide" onclick="return hs.expand(this)"><img src="{$item.IMG}" width="{$conf.gal_thumb_w}" height="{$conf.gal_thumb_h}" alt="{$item.COMMENTS}" /></a></div>
		<div class="highslide-caption">{$item.COMMENTS}</div>
        <br />
    {/foreach}
    </div>
    <br />
</div>

{if $ids=='0'}
	<a href="?p=gallery">ещё фото</a>
{else}
	<a href="?p=gallery&ids={$ids}">ещё фото</a>
{/if}

</center>

{/if}