<div class="rblock">
<h3>{$lang.ns_hint}</h3>
{if isset($er) && $er=="error"}
	<p style="color:red;">{$login_error}</p>
{/if}
<div id="SignRes"></div>
	<form method="post" action="javascript:void(null)" id="NSForm" class="sf" enctype="multipart/form-data"> 
	<p><label for="ns_name">{$lang.ns_name}</label><br /><input name="ns_name" id="ns_name" class="einp" placeholder="{$lang.ns_name}" value="" type="text"></p>
	<p><label for="ns_email">{$lang.ns_email}</label><br /><input name="ns_email" id="ns_email" class="einp" placeholder="{$lang.ns_email}" value="" type="text"></p>
	<p><input id="NSS" name="NSS" class="einp" value="{$lang.ns_sign}" onclick="SignToNewsletter('NSForm','SignRes');" type="button"></p>
	</form>
</div>