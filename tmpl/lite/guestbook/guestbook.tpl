{* Вывод списка новостей *}
{if $act=='list'}
<div class="gb_page">
	<h1>{$lang.guestbook}</h1>
	{$listpage}
  {section name=gb_loop loop=$gb}
  <div class="gb_item">
    <span class="gb_name">{$gb[gb_loop].g_who}, <small>{$gb[gb_loop].g_date|date_format:"%d.%m.%Y %H:%M"}</small></span>
    <div class="gb_txt">{$gb[gb_loop].g_text}</div>
    </div>
  {/section}
	<br style="clear:both;" />  
	{$listpage}
</div>
{/if}

<form action="index.php?p=guestbook&act=AddRecord" method="post" enctype="multipart/form-data" id="GuestbookForm">
<label for="g_who">{$lang.g_name}<span>*</span></label><br />
<input type="text" name="g_who" id="g_who" value="{$g_who}" size="30" /><br />
<label for="g_email">{$lang.g_email}</label><br />
<input type="text" name="g_email" id="g_email" value="{$g_email}" size="30" /><br />
<label for="g_text">{$lang.g_text|nl2br}<span>*</span></label><br />
<textarea name="g_text" id="g_text" style="width:400px; height:130px;">{$g_text}</textarea><br />
<label for="check_code">{$lang.g_checkcode}<span>*</span></label> <img src="./check_code.php" border="0" vspace="1" hspace="1" style="vertical-align:middle;"/> 
<input type="text" name="check_code" id="check_code" style="width:60px;" /><br />

<input type="submit" id="SendRecord" value="{$lang.g_send}" />
</form>