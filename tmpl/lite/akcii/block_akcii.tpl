<div class="bakcii">
<h2 class="decor"><span class="txt">Акции</span></h2>
{foreach key=key item=item name=akc from=$akcii}
<div class="bitem">
   <div class="btitle"><a href="?p=akcii&id={$item.id}">{$item.title}</a></div>
   <div class="btxt">{$item.anons|truncate:270}</div>
</div>
{/foreach}
<p style="text-align:right;padding-right:10px; clear:both;"><a href="?p=akcii">Все акции</a></p>
</div>