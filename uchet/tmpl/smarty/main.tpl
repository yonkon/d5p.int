{if (!$authorized)}
	<p><strong>Для входа в личный кабинет необходимо пройти авторизацию</strong></p>
	<div class="login">
	<p class="warning">{include file='error.tpl'}</p>
	<form id="dform" method="post" action="{$url.userblock}">
		<input type="hidden" name="u_method" id="du_method" value="authorize" />
		<input class="input required" name="u_login" id="du_login" value="" type="text" size="26" minlength="1" placeholder="Логин..."><br />
		<input class="input required" name="u_pass" id="du_pass" type="password" size="26" minlength="1" placeholder="Пароль..."><br />
		<input class="checkbox" type="checkbox" name="u_long" id="du_long" value="yes">
		<label for="remember-me" class="checkbox-text">Запомнить меня</label><br />
		<input class="submit" id="dAUTH" name="AUTH" type="submit" value="Войти"><br /><br />
		<a href="{$url.recover}">Я забыл пароль</a>
		</fieldset>
	</form>
	</div>
{else}
	<p><strong>{$smarty.session.U_FIO}</strong></p>
    <a href="{$url.news}">Новости компании</a><br>
	<a href="{$url.orderlist}">Мои заказы</a><br>
	<a href="{$url.owninfo}">Личные данные</a><br>   
	<a href="{$url.logout}">Выход</a><br>
{/if}