    <div class="highslide-gallery">
    {foreach key=key item=item from=$pgal}
		<a href="{$item.photo}" class="highslide" onclick="return hs.expand(this)"><img src="{$item.thumb}" height="{$conf.pgal_thumb_h}" alt="{$item.sign}" title="{$item.sign}" /></a>
		<div class="highslide-caption">{$item.sign}</div>    
    {/foreach}
    </div>