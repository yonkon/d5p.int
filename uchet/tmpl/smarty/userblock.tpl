{if !isset($smarty.session.U_USER_IDU)}
	<div class="enter_block">
		<form method="post" action="{$url.userblock}" id="U_LoginForm">
			<input type="hidden" name="u_method" id="u_method" value="authorize">
			<table border="0" cellspacing="0" class="FormTab">
				<tr>
					<td  colspan="2">
						<label for="u_login"><strong>Логин</strong></label>
					</td>
				</tr><tr>
					<td  colspan="2">
						<input type="text" name="u_login" id="u_login" value="">
					</td>
				</tr>
				<tr>
					<td  colspan="2">
						<label for="password"><strong>Пароль</strong></label>
					</td>
				</tr><tr>
					<td  colspan="2">
						<input type="password" name="u_pass" id="u_pass" value="">
					</td>
				</tr>
				<tr>
					<td  class="padded">
						<input type="checkbox" name="u_long" id="u_long" value="yes">
						<label for="u_long" class="black_label">Запомнить</label>
						
					</td>
					<td>
						<input type="image" id="AUTH" name="AUTH" src="{$imgPath}userbutton.png">
					</td>	
				</tr>
				<tr>
					<td colspan="2" class="padded">
						
							<a href="{$url.recover}"  class="black_label">Забыли пароль?</a>
					</td>
				</tr>
				<tr>	
				
					<td colspan="2" class="padded"> 
						
						<a href="/work/" class="avtors">Вход для авторов</a>
					</td>
				</tr>
			</table>
		</form>
		{include file='error.tpl'}
		<div class="clearall"></div>
	</div>
	<p><a href="#enter" class="enter_block_call">Вход</a>&nbsp;|&nbsp;<a href="/registeravtor/">Регистрация</a> </p>
{else}
<div class="personal_room">
	<h3>Личный кабинет</h3>
	<p><em><strong>Здравствуйте, {$smarty.session.U_FIO}!</strong></em></p><br />
	<a href="{$url.news}">Новости компании</a><br />
	<a href="{$url.orderlist}">Мои заказы</a><br />
	<a href="{$url.owninfo}">Личные данные</a><br />
	<a href="{$url.logout}">Выход</a>
</div>
{/if}