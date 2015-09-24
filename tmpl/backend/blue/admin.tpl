<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<base href="{$wwwadres}/" /><!--[if IE]></base><![endif]-->
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cash-Control" content="no-cash, must-revalidate" />
	<meta http-equiv="Content-Type" content="text/html; charset={$conf.encoding}" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Author" content="Volodymyr Demchuk, http://shiftcms.net" />
	<meta name="Copyleft" content="ShiftCMS" />
	<link rel="icon" href="favicon.ico" type="ico" />

	<link rel="StyleSheet" href="{$wwwadres}/{$conf.admin_tpl_dir}css/bw.css" type="text/css" />
	<link type="text/css" href="{$wwwadres}/js/jquery/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
	<script src="{$wwwadres}/js/admin_func.js" type="text/javascript"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/ui/minified/jquery.ui.core.min.js"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/ui/minified/jquery.ui.widget.min.js"></script>

{literal}
	<script type="text/javascript">
		var timerID = null
		var timerRunning = false
		function stopclock(){
		   if(timerRunning)
		      clearInterval(timerID)
			timerRunning = false
		}
		function startclock(){
	   		timerID = setInterval("Informer()",30000)
		    timerRunning = true
		}
		function Informer(){
			getdata('','get','?p=site_server&act=Informer','Informer')
		}
	</script>
{/literal}

	<title>{$TITLE}</title>
	{$HEADER}

</head>

<body onLoad="startclock();">

<div id="Header">
<ul id="nav">
	{$fly_menu}
</ul>
	<div id="Menu">
		<table border='0' cellspacing='0' cellpadding='0' width='100%'><tr>
        <td align="left">
        	<h3 style="display:inline;">{$smarty.session.USER_LOGIN}:</h3> &nbsp;&nbsp;&nbsp;
          <a href="{$wwwadres}/logout.php"><img src="{$conf.admin_tpl_dir}img/logout.png" style="vertical-align:middle;" alt="Выход" /></a>&nbsp;
          <a href="{$wwwadres}/logout.php">{$alang.logout}</a> <small>(<i>{$alang.last_visit}: {$smarty.session.USER_LAST_ACCES|date_format:"%d.%m.%Y %H:%M"}</i>)</small></td>
		<td align="center" width="30" style="padding-left:20px;">
    	<div id="Informer" style='float:left;display:inline;text-align:center;'>
          {if $NewMessage!=""}
			<div id="somediv" style="display:none;">{$NewMessage}</div>
			<a href="#" onClick="divwin=dhtmlwindow.open('divbox', 'div', 'somediv', '{$alang.informer}', 
            'width=450px,height=400px,left=50px,top=50px,resize=1,scrolling=1'); return false" style="padding:0px;margin:0px;"><img src='{$conf.admin_tpl_dir}img/alert.gif' width='16' height='16' alt='{$alang.informer}' style="border:0px;vertical-align:middle;" /></a>
          {/if}
        </div>
        </td>
        <td>&nbsp;</td>
	    <td width="30" align="center">
				<a title='Главная страница' href='admin.php'><img src='{$conf.admin_tpl_dir}img/menu/main.png' width='16' height='16' alt='Главная страница' /></a>            
        </td>
	    <td width="30" align="center">
				<a title='Почта' href='javascript:void(null)' onClick="calwin=dhtmlwindow.open('OutlookBox', 'inline', '', 'Почта', 'width=790px, height=580px, left=150px, top=91px, resize=1, scrolling=1'); getdata('', 'get', '?p=outlook', 'OutlookBox_inner'); return false; "><img src='{$conf.admin_tpl_dir}img/mail_icon1.gif' width='16' height='16' alt='Почта' /></a>            
        </td>
	    <td width="30" align="center">
				<a title='Календарь' href='javascript:void(null)' onClick="calwin=dhtmlwindow.open('CalendarBox', 'inline', '', 'Календарь', 'width=790px, height=580px, left=150px, top=91px, resize=1, scrolling=1'); getdata('', 'get', '?p=calendar', 'CalendarBox_inner'); return false; "><img src='{$conf.admin_tpl_dir}img/calendar.gif' width='16' height='16' alt='Календарь' /></a>            
        </td>
        <td width="100">&nbsp;</td>
        {if isset($langs)}
        <td align="center" width="{$lw}">
        	{foreach key=key item=item from=$langs}
				<a href="admin.php?admin_lang={$item}"><img src="{$wwwadres}/{$tpldir}flags/{$item}.gif" style="vertical-align:middle;" /></a>&nbsp;
    		{/foreach}
        </td>
        {/if}
        <td align="right" width="150">
			<a href="{$wwwadres}/">{$alang.gotosite}</a>&nbsp;&nbsp;
        </td>
        {*
	    <td width="25" align="center">
			{if $HELP!=""}
				<a title='{$alang.help}' href='javascript:void(null)' onClick="helpwin=dhtmlwindow.open('SysHelpBox', 'inline', '', '{$alang.help}', 'width=550px, height=500px, left=50px, top=70px, resize=1, scrolling=1'); getdata('', 'get', 'admin_server&amp;act=GetPageHelp&amp;source=docs/{$HELP}', 'SysHelpBox_inner'); return false; "><img src='{$conf.admin_tpl_dir}img/help_a.gif' width='16' height='16' alt='{$alang.help}' /></a>&nbsp;&nbsp;            
            {else}            	
            	&nbsp;&nbsp;&nbsp;            
            {/if}
        </td>
        *}
        <td align="right"><a href="http://shiftcms.net" title="shiftcms.net"><img src="{$tpldir}img/shiftcms.png" style="vertical-align:middle;" width="60" height="22" alt="shiftcms.net" /></a></td>
		</tr></table>
	</div>

    <div id="PageTitle">
    	<table border="0" cellspacing="0" cellpadding="0"><tr>
        <td>{if isset($modSet)}<a title='Конфигурация модуля' href='javascript:void(null)' onClick="modSetwin=dhtmlwindow.open('ModSetBox', 'inline', '', 'Конфигурация модуля', 'width=500px, height=500px, left=0px, top=91px, resize=1, scrolling=1'); getdata('', 'get', '?p=admin_config&amp;act=modlist&amp;mod={$modSet}', 'ModSetBox_inner'); return false; "><img src='{$conf.admin_tpl_dir}img/setting_icon.gif' width='19' height='19' alt='Конфигурация модуля' /></a>{/if}</td>
        <td width="10">&nbsp;</td>
    	<td><div id="aptitle">{$PAGETITLE}</div></td>
        </tr></table>
        <div id="ARC">
        	<div id="ART"><a href="javascript:void(null)" onclick="CloseInfo();"><strong>{$alang.close}</strong></a></div>
            <div id="ActionRes"></div>
        </div>
    </div>
</div>


<div id="mainContentAdmin">
	<div id="result">
		{$PAGE}
	</div>
</div>

<br />
{if $debug == true}
<hr />
<strong>DEBUG INFO:</strong>
<div id="debug" style='border:solid 1px red; padding:3px; background:#F8F1DE;'></div>
{/if}
</body>
</html>