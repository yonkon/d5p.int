{if $gtype=="gallist"}
	<h1 class="gr">{$lang.gal_title}</h1>
    {foreach key=key item=item from=$gal_ar}
    	<div class="galcover">
    		<div class="coverimg"><img src="{$item.img}" alt="{$item.name}" width="102" height="103" /></div>
            <div class="covertxt">
            	<a href="?p=gallery&ids={$item.ids}">{$item.name}</a><br />
                <span>{$lang.agal_date}:</span> {$item.date|date_format:"%d.%m.%Y"}<br />
                <span>{$lang.agal_th_photo}:</span> {$item.photos}
            </div>
        </div>
    {/foreach}

{/if}

{if $gtype=="photolist"}
{*<h1 class="gr">{$lang.gal_title} > {$NAME}</h1>*}
{*{if $OPIS!=""}<div class="gopis">{$OPIS}</div>{/if}*}
<div>
	<script type="text/javascript" src="/js/highslide/highslide-full.js"></script>
	<link rel="stylesheet" type="text/css" href="/js/highslide/highslide.css" />
	{literal}
	<script type="text/javascript">
		hs.graphicsDir = '/js/highslide/graphics/';
		hs.align = 'center';
		hs.transitions = ['expand', 'crossfade'];
		hs.outlineType = 'rounded-white';
		hs.fadeInOut = true;
		hs.dimmingOpacity = 0.6;
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
    
    	<div class="glist">
    {foreach key=key item=item from=$gal_ar}
           	<a href="?p=gallery&ids={$item.ids}"{if $item.ids==$ids} class="gsel"{/if}>{$item.name}</a>
    {/foreach}
        </div>

{$pagelist}
    <div class="line"></div>
    <div class="highslide-gallery">
	{section name=ph loop=$ph_ar}
		<a href="{$ph_ar[ph].BIGIMG}" class="highslide" onclick="return hs.expand(this)"><img src="{$ph_ar[ph].IMG}" width="{$twidth}" alt="{$ph_ar[ph].COMMENTS}" title="{$lang.gal_showbig}" /></a>
		<div class="highslide-caption">{$ph_ar[ph].COMMENTS}</div>
        {if $smarty.section.ph.index%3==2}<br style="clear:both;" />{*<div class="line"></div>*}{/if}
    {/section}
    </div>
<div class="line"></div>	
{$pagelist}
<br />
</div>

{*
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td valign="top">
    <div class="highslide-gallery">
	{section name=ph loop=$ph_ar}
		<a href="{$ph_ar[ph].BIGIMG}" class="highslide" onclick="return hs.expand(this)"><img src="{$ph_ar[ph].IMG}" width="{$twidth}" alt="{$ph_ar[ph].COMMENTS}" title="{$lang.gal_showbig}" /></a>
		<div class="highslide-caption">{$ph_ar[ph].COMMENTS}</div>    
        {if $smarty.section.ph.index%2==1}<br style="clear:both;" /><div class="line"></div>{/if}
    {/section}
    </div>
</td>
<td width="70">&nbsp;</td>
<td valign="top" width="250">
    {foreach key=key item=item from=$gal_ar}
    	<ul class="gallist">
           	<li><a href="?p=gallery&ids={$item.ids}"{if $item.ids==$ids} class="gsel"{/if}>{$item.name}</a></li>
        </ul>
    {/foreach}
</td></tr></table>
*}

{/if}