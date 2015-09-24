{* Вывод списка разделов форума *}

{if isset($infmsg)}{$infmsg}<br />{/if}
{$rurl}
<table border="0" cellspacing="0" width="100%"><tr>
<td><h1>{$lang.forum_newtheme}</h1><a href="?p=forum">{$lang.forum}</a>{if isset($parent)} : <a href="?p=forum&t={$parent.idf}">{$parent.fname}</a> {/if} : <a href="?p=forum&show=theme&f={$idf}">{$section}</a></td>
<td align="right">
<a href="?p=forum&show=create&f={$idf}"><strong>{$lang.forum_createthe}</strong></a> | 
<a href="?p=forum&show=search"><strong>{$lang.forum_search}</strong></a>
<br />{include file="forum/forum_links.tpl"}
</td>
</tr></table>
<br />

{if isset($preview)}
<table border="0" cellspacing="0" width="100%"><tr>
<td><h1>{$tname}</h1><a href="index.php?p=forum">{$lang.forum}</a> : <a href="?p=forum&show=theme&f={$idf}">{$section}</a></td>
<td align="right">
<a href="?p=forum&show=create&f={$idf}">{$lang.forum_createthe}</a> | 
<a href="?p=forum&show=search">{$lang.forum_search}</a>
</td>
</tr></table>
<br />
<table class='forumtab' cellspacing="0" width="100%">
		<tr>
		<th>{$lang.forum_author}</th>
		<th>{$lang.forum_msg}</th>
		</tr>
		<td valign="top" class="avtortd">
        	{if isset($tavtor_avatar)}<img src="{$tavtor_avatar}" width="{$conf.avatar_w}" alt="" /><br />{/if}
        	<strong>{$tavtor_login}</strong><br />
            <small>{$lang.forum_msgs}: {$tavtor_msg}</small>
        </td>
		<td valign="top">
        	<img src="{$conf.tpl_dir}img/small_arrow.gif" width="9" height="9" alt="" /> <small>{$tdate}</small><br />
        	{$fapp}{$ttext}{$lapp}
        </td>
		</tr>
</table>
{/if}

<br style="clear:both;" />  
<table class='forumtab' cellspacing="0" width="100%">
		<tr>
		<td>&nbsp;</td><td>
<h2>{$lang.forum_makenewth}</h2>
{if isset($smarty.session.USER_IDU)}
{if $conf.forum_editor == "bbcode"}
{literal}
<script type="text/javascript">
XBB.path = "/include/bbcode";
XBB.textarea_id = "ttext";
XBB.area_width = "500px";
XBB.area_height = "300px";
XBB.state = "plain";
XBB.lang = "ru_utf8";
</script>
{/literal}
{/if}
<form method="post" action="?p=forum&show=create&f={$idf}" enctype="multipart/form-data" id="addThemeF">
{*
        <input type="hidden" name="f" id="f" value="{$idf}" />
        <input type="hidden" name="show" id="show" value="create" />
        <input type="hidden" name="p" id="p" value="forum" />
*}
        <input type="hidden" name="fact" id="fact" value="addTheme" />
        {$lang.forum_themename}:<br />
        <input type="text" name="tname" id="tname" value="{$tname}" style="width:400px;" /><br />
        {if $conf.forum_editor == "bbcode"}
        <textarea name="ttext" id="ttext" style="width:500px;height:300px">{$FORMAREA}</textarea>
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
        </td>
		</tr>
</table>
