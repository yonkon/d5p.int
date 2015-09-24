{include file='error.tpl'}
{if isset($sended)}
	{if $sended == 1}
		Пароль успешно выслан
	{else}
		Пароль не выслан
	{/if}
	<br /><br />
{/if}
<form method="post" action="{$url.recover}">
	Введите e-mail:<br />
	<input type="text" name="email" value="" /><br />
	или логин:<br />
	<input type="text" name="login" value="" /><br />
	{$lang.captcha}:<br >
	<input type="text" name="captcha" maxlength="6" />
	<a href="#" onclick="document.getElementById('img_captcha').src = '{$includePath}securimage/securimage_show.php?' + Math.random(); return false">{$lang.changecaptcha}</a><br />
	<img id="img_captcha" src="{$includePath}securimage/securimage_show.php" alt="CAPTCHA Image" /><br />
	<input type="hidden" name="act" value="client" /><br />
	<input type="submit" value="Выслать" />
</form>
