{* Вывод одного вопроса *}
<div class="faq">
<h1>{$lang.s_faq}</h1>
<div class="s_faq_area">
<form method="post" action="index.php?p=faq" enctype="multipart/form-data" id="FindFAQ">
<input type="text" name="sph" id="sph" size="40" value="{$sph}" />
<input type="submit" value="{$lang.search}" />
</form>
</div>

{if isset($newsnotfound)}
{$faqnotfound}
{/if}

{if $act=='full'}
    <div class="faqoneitem">
		<span class="faq_date">{$faq.q_date|date_format:"%d.%m.%Y"}</span>
    	<span class="faq_title faq_opened" id="I{$faq.q_id}">{$faq.q_quest}</span>
        <div id="FQI{$faq.q_id}">
			<div class="faq_reply">{$faq.q_reply}
	        <p>{$lang.s_faq_reply_date} {$faq.q_date1|date_format:"%d.%m.%Y"}</p>
            </div>
        </div>
    </div>
	<p>&raquo; <a href="?p=faq">{$lang.s_faq_allquest}</a></p>
{/if}	


{* Вывод списка вопросов *}
{if $act=='list'}
	{$listpage}
    {foreach key=key item=item from=$faq}
		<div class="faq_item">
		<span class="faq_date">{$item.q_date|date_format:"%d.%m.%Y"}</span>
    	<span class="faq_title" id="I{$item.q_id}">{$item.q_quest}</span>
        <div id="FQI{$item.q_id}" style="display:none;">
			<div class="faq_reply">{$item.q_reply}
	        <p>{$lang.s_faq_reply_date} {$item.q_date1|date_format:"%d.%m.%Y"}</p>
            </div>
        </div>
		</div>
	{/foreach}
	{$listpage}
{/if}

{if $conf.faq_addquest=="y"}
	<br style="clear:both;" /> 
	<h3 class="faqH3" onclick="SwitchShow('QFA')">{$lang.s_faq_add}</h3>
    <div id="QFA" style="display:none;">
    <form method="post" action="javascript:void(null)" id="QForm" enctype="multipart/form-data">
    <table border="0"><tr>
    <td valign="top">
    <textarea id="q_quest" name="q_quest"></textarea>
    </td>
    <td valign="top">
    {if $conf.faq_uname=="y"}
    <label for="q_name">{$lang.s_faq_name}:</label>
    <input type="text" name="q_name" id="q_name" value="" maxlength="150" /><br />
    {/if}
    {if $conf.faq_uemail=="y"}
    <label for="q_email">{$lang.s_faq_email}:</label>
    <input type="text" name="q_email" id="q_email" value="" maxlength="100" /><br />
    {/if}
	<img src="check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/>
	<small><a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();">{$lang.reg_updcode}</a></small><br />
	<label for="check_code">{$lang.s_faq_code}:</label>
	<input type="text" name="check_code" id="check_code" size="8" /><br />
    
    <input type="button" onclick="sendQuestion()" value="{$lang.s_faq_send}" />
    <span id="FQL"></span>
    </td>
    </tr></table>
    </form>
    </div>
{/if}
</div><!--faq-->
