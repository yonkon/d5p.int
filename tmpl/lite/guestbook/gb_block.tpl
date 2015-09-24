<div class="gb_block">
<h2>{$lang.guestbook}</h2>
  {foreach key=key item=item from=$gb}
  <div class="gbb_item">
    <span class="gbb_name">{$item.g_who}</span>
    <p class="gbb_txt">{$item.g_text|truncate:300}</p>
    </div>
  {/foreach}
<p>&raquo;&raquo; <a href="?p=guestbook" class="all">{$lang.g_all}</a></p>
</div>
<br style="clear:both;" />