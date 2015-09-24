{* Вывод одной полной новости *}
<div class="artarea">
{if isset($newsnotfound)}
	<h1>{$lang.art_title}</h1>
	{$newsnotfound}
{/if}

{if $act=='full'}
    <div class="artitem">
	<h1>{$r.r_title}</h1>
    <span class="artdate">{$r.r_dadd|date_format:"%d.%m.%Y"}</span>{if $r.r_avtor!=''}, <span class="artavtor">{$r.r_avtor}</span>{/if}<br />
    {if $r.r_abstract!=''}<p class="artanons">{$r.r_abstract}</p>{/if}
    <div class="arttxt">{$r.r_content}</div>
    {if $r.r_source!=""}<p class="artsrc">{$lang.art_src}: <a href="{$r.r_source}" target="_blank">{$r.r_source}</a></p>{/if}
    </div>
	<p class="artall">&raquo; <a href="?p=articles">{$lang.art_allart}</a></p>
{/if}	


{* Вывод списка новостей *}
{if $act=='list'}
	<h1>{$lang.art_title}</h1>
	{$listpage}
    <ul class="artlist">
	{foreach key=key item=item from=$rfull}
	    <li><span class="artdate">{$item.r_dadd|date_format:"%d.%m.%Y"}</span>{if $item.r_avtor!=''}<span class="artavtor">, {$item.r_avtor}</span><br />{/if}
	   	<a href="?p=articles&r_id={$item.r_id}">{$item.r_title}</a>
	   	{if $item.r_abstract!=''}<span class="artanons">{$item.r_abstract}</span>{/if}
	    </li>
	{/foreach}
	</ul>
	{$listpage}
{/if}

</div>