{* Вывод списка разделов форума *}
<table border="0" cellspacing="0" width="100%"><tr>
<td><h1><a href="?p=forum">{$lang.forum}</a>{if isset($parent)} : <a href="?p=forum&t={$parent.idf}">{$parent.fname}</a> {/if} : <a href="?p=forum&show=theme&f={$idf}">{$section}</a></h1></td>
<td align="right">
<a href="index.php?p=forum&show=create&f={$idf}"><strong>{$lang.forum_createthe}</strong></a> | 
<a href="index.php?p=forum&show=search"><strong>{$lang.forum_search}</strong></a>
</td>
</tr></table>
<br />
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
		<td><a href="?p=forum&show=msg&t={$f[f_loop].idt}&f={$f[f_loop].idf}"><strong>{$f[f_loop].tname}</strong></a> 
        {if $f[f_loop].pl!=""}[{$f[f_loop].pl}]{/if}</td>
		<td>{$f[f_loop].login}</td>
		<td class="bgg"><span class="red">{$f[f_loop].countmsg}</span>/{$f[f_loop].tview}</td>
		<td>{if $f[f_loop].lastmsg=="0"}-{else}
        <img src="{$conf.tpl_dir}img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$f[f_loop].lastmsg.mdate}</small> от <strong>{$f[f_loop].lastmsg.login}</strong>
        {/if}</td>
		</tr>
  {/section}
</table>
{$listpage}