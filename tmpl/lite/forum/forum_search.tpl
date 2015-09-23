{* Вывод списка разделов форума *}

<table border="0" cellspacing="0" width="100%"><tr>
<td><h1><a href="?p=forum">{$lang.forum}</a> : <a href="?p=forum&show=search">{$lang.forum_search}</a></h1></td>
<td align="right">
<a href="?p=forum&show=search"><strong>{$lang.forum_search}</strong></a>
<br />{include file="forum/forum_links.tpl"}
</td>
</tr></table>
<br />
{if isset($infmsg)}{$infmsg}<br />{/if}

<table class='forumtab' cellspacing="0" width="100%">
<tr><td align="center">
<form method="post" action="?p=forum" enctype="multipart/form-data" id="sForumF">
        <input type="hidden" name="show" id="show" value="search" />
		{$lang.forum_keyword}: <input type="text" name="stext" id="stext" maxlength="50" size="50" value="{$stext}" />
		<input type="submit" name="search" id="search" value="{$lang.forum_search}" />
</form>
</td></tr>
</table>
<br />
{if isset($searchres)}
{$listpage}
<table class='forumtab' cellspacing="0" width="100%">
		<tr>
		<th>&nbsp;</th>
		<th>{$lang.forum_listtheme}</th>
		<th>{$lang.forum_author}</th>
		<th>{$lang.forum_repview}</th>
		<th>{$lang.forum_lastmsg}</th>
		</tr>
  {section name=f_loop loop=$f}
		<tr>
		<td>&nbsp;</td>
		<td><a href="?p=forum&show=msg&t={$f[f_loop].idt}&f={$f[f_loop].idf}{if $stext!=""}&stext={$stext}{/if}"><strong>{$f[f_loop].tname}</strong></a> 
        {if $f[f_loop].pl!=""}[{$f[f_loop].pl}]{/if}</td>
		<td>{$f[f_loop].login}</td>
		<td class="bgg"><span class="red">{$f[f_loop].countmsg}</span>/{$f[f_loop].tview}</td>
		<td>{if $f[f_loop].lastmsg=="0"}-{else}
        <img src="/tmpl/lite/img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$f[f_loop].lastmsg.mdate}</small> от <strong>{$f[f_loop].lastmsg.login}</strong>
        {/if}</td>
		</tr>
  {/section}
</table>
{$listpage}
{/if}
<br style="clear:both;" />  
