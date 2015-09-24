<h1>{$lang.enter_title}</h1>
<div class="enterblock">
			{if isset($er) && $er=="error"}
				<font style="color:red;">{$login_error}</font>
			{/if}
          <form method="post" action="auth.php" id="LogForm"  class='sf'> 
          	<table border="0">
            <tr>
             		<td><label for="login">{$lang.enter_login}:</label></td>
                	<td><input type="text" name="login" id="login" class="einp" value="" /></td>
             </tr><tr>
                	<td><label for="password">{$lang.enter_pass}:</label></td>
                	<td><input type="password" name="password" id="password" class="einp"  value="" /></td>
             </tr><tr>
             		<td>&nbsp;</td>
					<td><input type="checkbox" name="authperiod" id="authperiod" value="yes" />	<label for="authperiod">{$lang.enter_save}</label> </td>
             </tr><tr>
             		<td>&nbsp;</td>
                    <td><input type="submit" id="AUTH"  name="AUTH" class="einp" value="{$lang.enter_button}"  /></td>
             </tr><tr>
	          		<td colspan="2"><a href="?p=remember" id="forgotpsswd">{$lang.enter_restore}</a>{if $conf.enable_reg=="y"}<br /><a href="?p=register" id="register">{$lang.reg_regbuton}</a>{/if}</td>
              </tr></table>
          </form>
</div><br />