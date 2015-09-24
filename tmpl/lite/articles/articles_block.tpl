<div id="art_block">
	<h2>{$lang.art_title}</h2>
	<ul class="artblist">
  {foreach key=key item=item from=$rb}
   	<li><a href="?p=articles&r_id={$item.r_id}">{$item.r_title}</a></li>
  {/foreach}
  </ul>
	<p class="artball">&raquo;<a href="?p=articles">{$lang.art_allart}</a></p>
</div>