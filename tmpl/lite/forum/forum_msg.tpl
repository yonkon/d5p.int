{* Вывод списка разделов форума *}

{if isset($infmsg)}{$infmsg}<br />{/if}

<table border="0" cellspacing="0" width="100%"><tr>
<td><div id="H_{$idt}"><h1>{$tname}</h1></div><a href="?p=forum">{$lang.forum}</a>{if isset($parent)} : <a href="?p=forum&t={$parent.idf}">{$parent.fname}</a> {/if} : <a href="?p=forum&show=theme&f={$idf}">{$section}</a></td>
<td align="right">
<a href="?p=forum&show=create&f={$idf}"><strong>{$lang.forum_createthe}</strong></a> | 
<a href="?p=forum&show=search"><strong>{$lang.forum_search}</strong></a>
<br />{include file="forum/forum_links.tpl"}
</td>
</tr></table>
<br />
{$listpage}
<table class='forumtab' cellspacing="0" width="100%">
		<tr>
		<th>{$lang.forum_author}</th>
		<th>{$lang.forum_msg}</th>
		</tr>
        {if $start==0}
		<tr>
		<td valign="top" class="avtortd">
        	{if isset($tavtor_avatar)}<img src="{$tavtor_avatar}" width="{$conf.avatar_w}" alt="" /><br />{/if}
        	<strong>{$tavtor_login}</strong><br />
            <small>{$lang.forum_msgs}: {$tavtor_msg}</small>
        </td>
		<td valign="top">
        	<div class="fdate"><img src="{$conf.tpl_dir}img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$tdate}</small></div>
        	<div id="T_{$idt}">{$ttext}</div>
            <br />
            <div class="fdate1">
            <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=reply&start=0#MsgForm">{$lang.forum_reply}</a> | 
            <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=cit&start=0#MsgForm">{$lang.forum_cit}</a>
            {if $access=="full"}
            | <a href="javascript:void(null)" onclick="EditTheme({$idt})">{$lang.forum_edit}</a>
            | <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=delTheme">{$lang.forum_deltheme}</a>
            {if $tfile!=""}| <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=delFile">{$lang.forum_delattach}</a>{/if}
            {/if}
            </div>
        </td>
		</tr>
        {/if}
  {section name=f_loop loop=$f}
		<tr>
		<td valign="top" class="avtortd">
        	{if isset($f[f_loop].mavtor_avatar)}<img src="{$f[f_loop].mavtor_avatar}" width="{$conf.avatar_w}" alt="" /><br />{/if}
        	<strong>{$f[f_loop].login}</strong><br />
            <small>{$lang.forum_msgs}: {$f[f_loop].mavtor_msg}</small>
        </td>
		<td valign="top">
        	<div class="fdate"><img src="{$conf.tpl_dir}img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$f[f_loop].mdate}</small></div>
        	<div id="M_{$f[f_loop].idm}">{$f[f_loop].mtext}</div>
            <br />
            <div class="fdate1">
            <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=reply&m={$f[f_loop].idm}&start={$start}#MsgForm">{$lang.forum_reply}</a> | 
            <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=cit&m={$f[f_loop].idm}&start={$start}#MsgForm">{$lang.forum_cit}</a>
            {if $access=="full"}
            | <a href="javascript:void(null)" onclick="EditMsg({$f[f_loop].idm})">{$lang.forum_edit}</a>
            | <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=delMsg&m={$f[f_loop].idm}&start={$start}">{$lang.forum_delmsg}</a>
            {if $f[f_loop].mfile!=""}| <a href="?p=forum&show=msg&t={$idt}&f={$idf}&fact=delFile&m={$f[f_loop].idm}&start={$start}">{$lang.forum_delattach}</a>{/if}
            {/if}
            </div>
        </td>
		</tr>
  {/section}
{if isset($preview)}
		<tr>
		<td valign="top" class="avtortd">
        	{if isset($mavtor_avatar)}<img src="{$mavtor_avatar}" width="{$conf.avatar_w}" alt="" /><br />{/if}
        	<strong>{$mavtor_login}</strong><br />
            <small>{$lang.forum_msgs}: {$mavtor_msg}</small>
        </td>
		<td valign="top">
        	<div class="fdate"><img src="{$conf.tpl_dir}img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$mdate}</small></div>
        	{$fapp}{$mtext}{$lapp}
        </td>
		</tr>
{/if}
  

{$listpage}
<br style="clear:both;" />  

<tr><td class="avtortd">&nbsp;</td><td>
{if isset($smarty.session.USER_IDU) && isset($showform)}
<a name="MsgForm"></a>
<h2>{$lang.forum_sendmsg}</h2>
{if $conf.forum_editor == "bbcode"}
{literal}
<script type="text/javascript">
XBB.path = "/include/bbcode";
XBB.textarea_id = "mtext";
XBB.area_width = "500px";
XBB.area_height = "300px";
XBB.state = "plain";
XBB.lang = "ru_utf8";
</script>
{/literal}
{/if}
<form method="post" action="?p=forum&show=msg&t={$idt}&f={$idf}#MsgForm" enctype="multipart/form-data" id="addMsgF">
{*
        <input type="hidden" name="f" id="f" value="{$idf}" />
        <input type="hidden" name="t" id="t" value="{$idt}" />
        <input type="hidden" name="show" id="show" value="msg" />
        <input type="hidden" name="p" id="p" value="forum" />
*}
        <input type="hidden" name="fact" id="fact" value="addMsg" />
        {if $conf.forum_editor == "bbcode"}
        <textarea name="mtext" id="mtext" style="width:700px;height:300px">{$FORMAREA}</textarea>
        {/if}
        {if $conf.forum_editor == "fckeditor"}
        {$FORMAREA}
        {/if}
        <br />
        {$lang.forum_attach}: {if $pfile!=""}<strong>{$pfile}</strong>{/if}<br />
        <input type="file" name="file" id="file" size="20" /><br />
        <input type="hidden" name="pfile" id="pfile" value="{$pfile}" />
        <input type="hidden" name="folder" id="folder" value="{$folder}" />
        <input type="checkbox" name="alert" id="alert" value="1" {$alert} /> {$lang.forum_getmail}<br /><br />
		<input type="submit" name="preview" id="preview" value="{$lang.forum_preview}" />&nbsp;&nbsp;&nbsp;
		<input type="submit" value="{$lang.send}" />
</form>
{if $conf.forum_editor == "bbcode"}
<script type="text/javascript">XBB.init();</script>
{/if}
{else}
	<p>{$lang.forum_needauth}</p>
{/if}
</td></tr></table>