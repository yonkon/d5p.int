<link rel="stylesheet" href="{$jsPath}calendar.css" type="text/css" />
<script src="{$jsPath}c_calendar.js" type="text/javascript"></script>

<h2 class="tarrow">Личная информация</h2>

{include file='error.tpl'}
{if !empty($dataSaved)}
	<div>{$lang.ownDataSaved}</div>
{/if}

<form method="post" action="{$url.owninfo}" enctype="multipart/form-data">
	<table border='0' class="rTab">
		<tr><th colspan="2"><br /><span>Контактная информация</span><br /><br /></th></tr>
		<tr><th>ФИО:<span>*</span></th><td><input type="text" name="fio" style="width:300px;" value="{$fio}" /></td></tr>
		<tr><th>Телефон:</th><td><input type="text" name="phone" style="width:300px;" value="{$phone}" /></td></tr>
		<tr><th>Мобильный телефон:<span>*</span></th><td><input type="text" name="mphone" style="width:300px;" value="{$mphone}" /></td></tr>
		<tr><th>E-mail:<span>*</span></th><td><input type="text" name="email" style="width:300px;" value="{$email}" /></td></tr>
		<tr><th>ICQ:</th><td><input type="text" name="icq" style="width:300px;" value="{$icq}" /></td></tr>
		<tr><th>Адрес:</th><td><textarea name="contact" style="width:300px;height:100px;">{$contact}</textarea></td></tr>
		
		<tr><th>Skype:</th><td><input type="text" name="skype" style="width:300px;" value="{$skype}" /></td></tr>
		<tr><th>Другие способы связи:</th><td><textarea name="other_contact" style="width:300px; height:100px;">{$other_contact}</textarea></td></tr>
		<tr><th>Веб-адрес:</th><td><input type="text" name="web" style="width:300px;" value="{$web}" /></td></tr>
		<tr><th>Дата рождения:</th><td><input type="text" name="birthday" id="birthday" style="width:300px;" value="{$birthday}" /></td></tr>
		<tr><th>Страна:</th><td><input type="text" name="country" style="width:300px;" value="{$country}" /></td></tr>
		<tr><th>Город:</th><td><input type="text" name="city" style="width:300px;" value="{$city}" /></td></tr>
		
		<tr><th>Сфера деятельности:</th><td><input type="text" name="speciality" style="width:300px;" value="{$speciality}" /></td></tr>
		<tr><th>Заказывали ли раньше работы и где:</th><td><input type="text" name="orders_before" style="width:300px;" value="{$orders_before}" /></td></tr>
		<tr><th>Удобное время для связи:</th><td><input type="text" name="time_to_call" style="width:300px;" value="{$time_to_call}" /></td></tr>
		<tr><th>Предпочитаемые способы оплаты:</th><td><input type="text" name="payment_method" style="width:300px;" value="{$payment_method}" /></td></tr>
		<tr><th>В какм ВУЗе обучаетесь:</th><td><input type="text" name="university" style="width:300px;" value="{$university}" /></td></tr>
		<tr>
			<th>Когда у Вас начинается сессия:</th>
			<td>
				<input type="text" name="examinations_time[]" id="examinations_time0" style="width:300px;" value="{$examinations_time['0']}" /><br />
				<div id="AddExamTime">
					{if count($examinations_time) > 1}
						{foreach $examinations_time as $key => $val}
							{if $key != 0}
								<div><input name="examinations_time[]" id="examinations_time{$key}" type="text" style="width:300px" value="{$val}" /></div>
							{/if}
						{/foreach}
					{/if}
				
				</div><br />
				<a href="#" onclick="addExaminationsTimeField('examinations_time', 'AddExamTime'); return false;">Добавить ещё одно время сессии</a>
		</td></tr>
	
		<tr><th>&nbsp;</th><td><input type="checkbox" name="c_send_alert" {$ch_csa}/> Получать оповещения</td></tr>
		<tr><th colspan="2"><br /><span>Сменить пароль</span><br />Если Вы не желаете менять пароль - оставьте эти поля пустыми.<br /><br /></th></tr>
		<tr><th>Пароль:</th><td><input type="password" name="u_pass" style="width:300px;" value="" /></td></tr>
		<tr><td colspan="2" align="center" style="text-align:center;"><br /></td></tr>
	</table>
	<input type="hidden" name="act" value="parseUserData" />
	<input type="submit" value="Обновить" style="padding:10px;" />
</form>

<script type='text/javascript'>
	Calendar.setup({
		inputField : "birthday", 
		ifFormat : "%d.%m.%Y",
		showsTime : true
	});

	Calendar.setup({
		inputField : "examinations_time0", 
		ifFormat : "%d.%m.%Y",
		showsTime : true
	});
	{if count($examinations_time) > 1}
		{foreach $examinations_time as $key => $val}
			{if $key != 0}
				Calendar.setup({ldelim}
					inputField : "examinations_time{$key}", 
					ifFormat : "%d.%m.%Y",
					showsTime : true
				{rdelim});
			{/if}
		{/foreach}
	{/if}

	function addExaminationsTimeField(namefield, parent){
		count = countElements();
		var div = document.createElement("div");
		div.innerHTML = "<input name=\"" + namefield + "[]\" id=\"examinations_time" + count + "\" type=\"text\" style=\"width:300px\" />";
		document.getElementById(parent).appendChild(div);
		Calendar.setup({
			inputField : "examinations_time" + count, 
			ifFormat : "%d.%m.%Y",
			showsTime : true
		});
	}
	function countElements() {
		var w = document.getElementById('AddExamTime');
		var count = 0; // this will contain the total elements.
		for (var i = 0; i < w.childNodes.length; i++) {
			var node = w.childNodes[i];
			if (node.nodeType == Node.ELEMENT_NODE && node.nodeName == "DIV") {
				count++;
			}
		}
		return ++count;
	}
</script>