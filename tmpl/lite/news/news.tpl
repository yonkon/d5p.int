{* Вывод одной полной новости *}

{if isset($newsnotfound)}
<h1>{$lang.news}</h1><br />
{$newsnotfound}
{/if}

{if $act=='full'}
<div class="news">
<h1>{$NTITLE}</h1>
    <div class="nitem">
    <span class="ndate">{$DATE|date_format:"%d.%m.%Y"}</span>
    {if $PHOTO != 'no'}
    	<img src="{$PHOTO}" alt="{$NTITLE}" width="{$conf.nthumb_w}" class="nimg" />
    {/if}
    {$NTEXT}
    </div>
    {if $comments=="1"}
    <br style="clear:both;" />
    	<div class="comarea" style="border-top:solid 1px #990000;">
    	<h2>{$lang.news_com}</h2>
		{$comlistpage}
		{section name=com_loop loop=$com}
    		<div class="bcomitem">
	    	<strong><small>{$com[com_loop].date|date_format:"%d.%m.%Y %M:%S"}</small><br /><span class="uname">{$com[com_loop].whopost}:</span></strong> {$com[com_loop].comtext}
    		</div>
		{/section}
		{$comlistpage}
		<br style="clear:both;" /> 
        {if isset($smarty.session.USER_IDU)}
        <h3>{$lang.news_writecom}</h3>
		{if $message}{$message}{/if}
        <form method="post" action="?p=news&idn={$IDN}" id="ComForm" enctype="multipart/form-data">
        <input type="hidden" name="nact" id="nact" value="addcomment" />
        <input type="hidden" name="comstart" id="comstart" value="{$comstart}" />
        <strong>Ваше имя:</strong><br />
        <input type="text" name="uname" id="uname" value="{$uname}" style="width:200px;" maxlength="50" /><br />
        <strong>Ваш e-mail:</strong><br />
        <input type="text" name="uemail" id="uemail" value="{$uemail}" style="width:200px;" maxlength="100" /><br />
        <strong>Комментарий:</strong>
        <textarea style="width:500px;height:100px;" id="comtext" name="comtext">{$comtext}</textarea><br />
        <input type="submit" value="{$lang.save}" />
        </form>
        {/if}
        </div>
    <br style="clear:both;" />
    {/if}
<p>&raquo; <a href="?p=news" class="red">{$lang.allnews}</a></p>
</div>
{/if}	


{* Вывод списка новостей *}
{if $act=='list'}
<div class="news">
<h1>{$lang.news}{if isset($category_name)} : {$category_name}{/if}</h1>
{if $news_category!=""}<div class="news_category">
{foreach key=key item=item from=$news_category}
{if $item.items>0}<a href="?p=news&category={$item.ntrans}" title="{$lang.news} : {$item.name}">{$item.name}</a>&nbsp;{/if}
{/foreach}
</div><br />{/if}
	{$listpage}
  {section name=rssfull_loop loop=$rssfull}
  <div class="nitem">
    {if $rssfull[rssfull_loop].NLINK != ''}
    	<span class="ntitle"><a href="{$rssfull[rssfull_loop].NLINK}" target="_blank">{$rssfull[rssfull_loop].NTITLE}</a></span>
    {else}
    	<span class="ntitle"><a href="?p=news&idn={$rssfull[rssfull_loop].IDN}" target="_parent">{$rssfull[rssfull_loop].NTITLE}</a></span>
    {/if}
    <span class="ndate">{$rssfull[rssfull_loop].DATE|date_format:"%d.%m.%Y"}</span>
    {if $rssfull[rssfull_loop].PHOTO != 'no'}
    	<img src="{$rssfull[rssfull_loop].PHOTO}" alt="{$rssfull[rssfull_loop].NTITLE}" width="{$conf.nthumb_w}" class="nimg" />
    {/if}
   	<p class="ntxt">{$rssfull[rssfull_loop].NTEXT|strip_tags|truncate:800}</p>
    </div>
  {/section}
	{$listpage}
</div>
{/if}