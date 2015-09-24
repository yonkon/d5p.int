<h3>Форма обратной связи</h3>
{if $feedbackError != 'noError'}
	<div class="block_body feedback">
		<form id="form_feedback" action="{$feedback}" method="post">
		<table>
		<tr>
			<td>
				<label for="fio">Ф.И.О</label>
			</td>
			<td>
				<input type="text" id="fio" name="fio" value="{$feedbackData.fio}">
			</td>
		</tr>
		<tr>
			<td>
				<label for="phone">Телефон</label>
			</td>
			<td>
				<input type="text" id="phone" name="phone" value="{$feedbackData.phone}">
			</td>
		</tr>
		<tr>
			<td>
				<label for="email">E-mail</label>
			</td>
			<td>
				<input type="text" id="email" name="email" value="{$feedbackData.email}">
			</td>
		</tr>
		<tr>
			<td>
				<label for="coment">Комментарий</label>
			</td>
			<td>
				<textarea id="coment" name="coment">{$feedbackData.coment}</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="">
			</td>
		</tr>
		</table>
		<input type="hidden" name="act" value="feedback" />
		</form>
	</div>
{/if}
{if $feedbackError == 'noError'}
	<p class="feedback_success">Спасибо за проявленный интерес, мы свяжемся с вами в кратчайшие сроки.</p>
{elseif $feedbackError == 'notAllData'}
	<p class="feedback_error">Вы ввели не все данные, попробуйте снова.</p>
{/if}