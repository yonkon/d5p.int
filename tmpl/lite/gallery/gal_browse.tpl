<h2>{$NAME}</h2>
<br />
<div class="bgal">

{$pagelist}<br />
<div style='float:left;width:{$dw};'>
<img src='{$IMG}' style='border:solid 1px #cccccc;padding:2px;display:block;' title='{$COMMENTS}' />
<br style='clear:both;' />
{$COMMENTS}
</div>
<div style='clear:both;'></div>
<br />{$pagelist}
</div>
    {if $comments=="1"}
    	<br /><h2>{$lang.gal_comm}</h2>

		{$comlistpage}
		{section name=com_loop loop=$com}
	    	<strong>{$com[com_loop].whopost}</strong>, <small>{$com[com_loop].date|date_format:"%d.%m.%Y %M:%S"}</small>
    		<div class="bcom">
				{$com[com_loop].comtext}
    		</div>
		{/section}
		{$comlistpage}
		<br style="clear:both;" /> 
        {if isset($smarty.session.USER_IDU)}
        <h3>{$lang.gal_writecomm}</h3>
        <form method="post" action="index.php" id="ComForm" enctype="multipart/form-data">
        <input type="hidden" name="idp" id="idp" value="{$IDP}" />
        <input type="hidden" name="p" id="p" value="gal_browse" />
        <input type="hidden" name="start" id="start" value="{$start}" />
        <input type="hidden" name="nact" id="nact" value="addcomment" />
        <input type="hidden" name="comstart" id="comstart" value="{$comstart}" />
        {$FORMAREA}<br />
        <input type="submit" value="{$lang.save}" />
        </form>
        {/if}
    {/if}

<br /><p align="left"><a href='?p=gallery&ids={$IDS}'>{$lang.gal_back}</a></p>
