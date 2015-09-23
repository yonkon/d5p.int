<div class="whitepage">

<h1>{$lang.rmb_title}</h1>
{if isset($message)}<p>{$message}</p>{/if}

{if $form}
<form action="" method="post">
   <input type="hidden" name="act" value="remember"/>
   <dl>
   <dt>{$ttitle.rem_email}:</dt>
   <dd><input type="text" name="email" size="32" /></dd>
   
   <dt></dt>
   <dd><img src="check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/>
        <small><a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();">{$lang.reg_updcode}</a></small></dd>
   
   <dt>{$ttitle.kod}:</dt>
   <dd><input type="text" name="check_code" /></dd>
   
   <dt></dt>
   <dd><input type="submit" value="{$ttitle.remember_submit}"/></dd>  
   </dl>
</form>
{/if}

</div>