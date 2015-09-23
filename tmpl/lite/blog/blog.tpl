{* Вывод блогов *}
{if $smarty.session.USER_IDU}
	<div style="padding:3px; border:solid 1px #ccc;margin:3px;">
    <a href="{$conf.www_patch}/?p=blog&act=myblog">Мої блоги</a> | <a href="{$conf.www_patch}/?p=writeblog">Написати в блог</a>
    </div><br />
{/if}

{if $outmsg && $outmsg=="deleted"}
	<p>Блог видалений!</p>
{/if}

{if $outblogs=="blognotfound"}
	<p>Блог не знайдено!</p>
{/if}

{if $outblogs=="single"}
	<span>{$item.b_date|date_format:"%d.%m.%Y %H:%M"}</span>, Рубрика {$item.b_rub} &nbsp;&nbsp;
	    {if $item.b_idu==$smarty.session.USER_IDU || $smarty.session.USER_GROUP=="super" || $smarty.session.USER_GROUP=="administrator"}
	    <a href="{$conf.www_patch}/?p=writeblog&b_id={$item.b_id}">Редагувати</a>
        {if $smarty.session.USER_GROUP=="super"}| <a href="{$conf.www_patch}/?p=blog&b_id={$item.b_id}&b_act=delBlog">Видалити</a>{/if}
	    {/if}<br  />
        <p><strong>Автор: {$item.u_login}</strong>{if $item.u_avatar!=""}<br /><img src="{$item.u_avatar}" />{/if}</p>
	<h2>{$item.b_title}</h2>
	<div>{$item.b_text}</div>
    <br />
    {*
    <div style="border-top:solid 1px #ccc;">
    <h3>Написати коментар</h3>
    <form method="post" action="" enctype="multipart/form-data" id="BCF">
    </form>
    </div>
    *}
{/if}

{if $outblogs=="list"}
{if $list_page}<br />{$list_page}<br />{/if}
{foreach item=item key=key from=$blogs}
	<span>{$item.b_date|date_format:"%d.%m.%Y %H:%M"}</span>, Рубрика {$item.b_rub} &nbsp;&nbsp;
	    {if $item.b_idu==$smarty.session.USER_IDU || $smarty.session.USER_GROUP=="super" || $smarty.session.USER_GROUP=="administrator"}
	    <a href="{$conf.www_patch}/?p=writeblog&b_id={$item.b_id}">Редагувати</a>
        {if $smarty.session.USER_GROUP=="super"}| <a href="{$conf.www_patch}/?p=blog&b_id={$item.b_id}&b_act=delBlog">Видалити</a>{/if}
	    {/if}<br  />
	<h2>{$item.b_title}</h2>
	<div>{$item.b_text}</div>
    <br />
    <p><a href="{$conf.www_patch}/?p=blog&{$item.b_link}">Дальше &raquo;</a></p>
    <br /><br />
{/foreach}
{if $list_page}<br />{$list_page}<br />{/if}
{/if}