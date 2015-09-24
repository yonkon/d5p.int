{* Вывод списка разделов форума *}
<table border="0" cellspacing="0" width="100%"><tr>
	<td><h1><a href="?p=forum">{$lang.forum}</a></h1></td>
	<td align="right">
		<a href="?p=forum&show=search"><strong>{$lang.forum_search}</strong></a><br />
		{include file="forum/forum_links.tpl"}
	</td>
</tr></table>

<br />

<table border="0" class="forumtab" cellspacing="0" width="100%">
  {section name=f_loop loop=$f}
  	{if $f[f_loop].parent_idf==0}
		<tr><th>&nbsp;</th>
		<th>{*<a href="?p=forum&t={$f[f_loop].idf}"><strong>*}{$f[f_loop].fname}{*</strong></a>*}<br /><span>{$f[f_loop].fdesc}</span></th>
		<th>{$lang.forum_themes}</th>
		<th>{$lang.forum_msgs}</th>
		<th>{$lang.forum_lastmsg}</th>
		</tr>
     {else}
		<tr><td>&nbsp;</td>
		<td><a href="?p=forum&show=theme&f={$f[f_loop].idf}"><strong>{$f[f_loop].fname}</strong></a><br /><small>{$f[f_loop].fdesc}</small></td>
		<td>{$f[f_loop].counttheme}</td>
		<td class="bgg">{$f[f_loop].countmsg}</td>
		<td>{if $f[f_loop].lastmsg=="0"}-{else}
        <img src="{$conf.tpl_dir}img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$f[f_loop].lastmsg.mdate}</small><br />
        <a href="?p=forum&show=msg&t={$f[f_loop].lastmsg.idt}&f={$f[f_loop].idf}">{$f[f_loop].lastmsg.tname}</a> от <strong>{$f[f_loop].lastmsg.login}</strong>{/if}</td>
		</tr>
     {/if}
  {/section}
</table>