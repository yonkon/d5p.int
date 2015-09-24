<div class="bnews">
<h2>{$lang.news}</h2>
{if $conf.news_calendar=="y"}
<div id="newsdate"></div>
{/if}
  {section name=rss_loop loop=$rss}
  <div class="bnitem">
    <span class="bndate">{$rss[rss_loop].DATE|date_format:"%d.%m.%Y"}</span>
    {if $rss[rss_loop].NLINK != ''}
    	{* если ссылка на внешний ресурс *}
    	<span class="bntitle"><a href="{$rss[rss_loop].NLINK}" target="_blank">{$rss[rss_loop].NTITLE}</a></span>
    {else}
    	{* если ссылка на внутренние новости *}
    	<span class="bntitle"><a href="?p=news&idn={$rss[rss_loop].IDN}">{$rss[rss_loop].NTITLE}</a></span>
    {/if}
    {if $rss[rss_loop].PHOTO != 'no'}
    	<img src="{$rss[rss_loop].PHOTO}" alt="{$rss[rss_loop].NTITLE|escape}" width="{$conf.nthumb_w}" class="bnimg" />
    {/if}
    <p class="bntxt">{$rss[rss_loop].NTEXT|strip_tags|truncate:300}</p>
    </div>
  {/section}
<p>&raquo;&raquo; <a href="?p=news" class="red">{$lang.allnews}</a></p>
</div>