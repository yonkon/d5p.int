{if $showvote}
	{if $head=="show"}
    	<div id="VOTE">
		<h2>{$vote_name}</h2>
		<p><small>{$vote_desc}</small></p>
    {/if}
    
	<div id="VoteArea">

    {* вивід форми опитування*}
	{if $show=="form"}
    	<form method="post" action="javascript:void(null)" method="post" enctype="multipart/form-data" id="VoteForm">
		{foreach from=$data.quest key=key item=item}
        	{if $item!=""}
            	{if $data.type=="r"}
            		<input type="radio" name="quest[]" id="quest[{$key}]" value="{$key}" /> <label for="quest[{$key}]">{$item}</label><br />
                {else}
            		<input type="checkbox" name="quest[{$key}]" id="quest[{$key}]" value="{$key}" /> <label for="quest[{$key}]">{$item}</label><br />
                {/if}
            
            {/if}
		{/foreach}
        {if $data.com=="y"}
        	<label for="usercom">Ваш коментарій:</label>
        	<textarea name="usercom" id="usercom" style="width:180px;height:70px;"></textarea><br />
        {/if}
        <input type="hidden" name="id" id="id" value="{$data.id}" />
        <input type="button" name="SendVote" value="{$lang.vote_govote}" onclick="doSendVote('VoteForm','VoteArea')" />
        </form>
    {/if}

    {* вивід результатів опитування*}
	{if $show=="result"}
    	<table border="0" cellspacing="0" cellpadding="0" class="VoteResTab">
		{foreach from=$data.graf key=key item=item}
        	<tr>
        	<td class="vote_pr">{$item.procent}%</td>
        	<td class="vote_quest">{$item.quest}<br /><div style="width:{$item.width}px;" class="vote_gr vote_color{$item.number}"></div></td>
            </tr>
		{/foreach}
        </table>
    {/if}
	</div>
	{if $head=="show"}
    	</div>
    {/if}
    
{/if}