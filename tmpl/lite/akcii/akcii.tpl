{* Вывод одной полной новости *}
{if isset($newsnotfound)}
{$newsnotfound}
{/if}

{if $act=='full'}
<div class="akcii">

    <div class="nitem1">
	<div class="ntitle"><h1>{$title}</h1></div>
    <div class="ndate">
	    {if $photo != 'no'}<div class="nimg"><img src="{$photo}" alt="{$title}" /></div>{/if}
    </div>
	<div class="ninfo">
	    {$text}
    </div>
    </div>
<p style="clear:both;">&raquo; <a href="?p=akcii" class="red">Все акции</a></p>
</div>
{/if}	


{* Вывод списка новостей *}
{if $act=='list'}
<div class="akcii">

{section name=rssfull_loop loop=$akcii}
<div class="nitem">
   	<div class="ntitle">{$akcii[rssfull_loop].title}</div>
    <div class="ndate">
	    {if $akcii[rssfull_loop].photo != 'no'}<div class="nimg"><img src="{$akcii[rssfull_loop].photo}" alt="{$akcii[rssfull_loop].title}" /></div>{/if}
    </div>
    <div class="ninfo">
	   	<p class="ntxt">{$akcii[rssfull_loop].anons|truncate:500}</p>
        <p style="text-align:right; padding-right:40px;"><a href="?p=akcii&id={$akcii[rssfull_loop].id}" target="_parent">Подробнее</a></p>
    </div>
</div>
{if $smarty.section.rssfull_loop.index%2==1}<br style="clear:both;" />{/if}
{/section}
<br style="clear:both;" />
{$listpage}
</div>
{/if}