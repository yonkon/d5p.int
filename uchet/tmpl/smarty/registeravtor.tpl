<!--<noindex>-->
{* <script src="{$jsPath}/func.js" type="text/javascript"></script>  
<!-- Pavel Handleman 11.02.2013 -->
<!-- преношу содержимое этого скрипта в  этот tpl файл и проставляю  вместо жестко заданных идентификаторов - Smarty-переменные-->
*}

{include file='error.tpl'}

<form method="post" action="{$url.registeravtor}" id="avtorform" name="avtorform" enctype="multipart/form-data" onsubmit="return CheckRegisterAvtorForm();">

	<table border="0" class="rTab">
		<tr>
			<td colspan="2" style="{$style.alert_info}">{$lang.mandatoryFieldsDescription}</td>
		</tr>
		<tr>
			<th colspan="2" align="center">{$lang.detailsToEnter}</th>
		</tr>
		{*<tr>
			<td style="{$style.text_align1}">{$lang.mandatoryField}{$lang.login}:</td>
			<td style="{$style.td_right}">
				
				{include file='errorlabel.tpl' fieldName='login'}
				<input type="text" name="{$fields.login}" id="{$fields.login}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.login}" />
			</td>
		</tr>*}
        <tr>
            <td style="{$style.text_align1}">{$lang.mandatoryField}{$lang.email}:</td>
            <td style="{$style.td_right}">

                {include file='errorlabel.tpl' fieldName='email'}
                {include file='errorlabel.tpl' fieldName='email' param='correct'}

                <input type="text" name="{$fields.email}" id="{$fields.email}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.email}" />
            </td>
        </tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.mandatoryField}{$lang.pass}:</td>
			<td style="{$style.td_right}">
				
				{include file='errorlabel.tpl' fieldName='pass'}
				<input type="password" name="{$fields.pass}" id="{$fields.pass}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.pass}" />
			</td>
		</tr>
		<tr>
			<th colspan="2" align="center"><br /><h4>{$lang.contact_info}</h4></th>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.mandatoryField}{$lang.fio}:</td>
			<td style="{$style.td_right}">
			
				{include file='errorlabel.tpl' fieldName='fio'}
				
				<input type="text" name="fio" id="{$fields.fio}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.fio}" />
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.sphone}:</td>
			<td style="{$style.td_right}">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center"><small>{$lang.codc}</small></td>
						<td align="center"><small>{$lang.cods}</small></td>
						<td align="center"><small>{$lang.num}</small></td>
					</tr>
					<tr>
						<td align="center">+<input type="text" name="{$fields.sphone1}" id="{$fields.sphone1}" style="width:50px; {$style.border_normal}" value="{$fieldsValues.sphone1}" onkeypress="return CheckSymbol(event)" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();" onblur="check();" /></td>
						<td align="center"><input type="text" name="{$fields.sphone2}" id="{$fields.sphone2}" style="width:70px; {$style.border_normal}" value="{$fieldsValues.sphone2}" onkeypress="return CheckSymbol(event)" onfocus="this.select();" onblur="check();" /></td>
						<td align="center"><input type="text" name="{$fields.sphone3}" id="{$fields.sphone3}" style="width:150px; {$style.border_normal}" value="{$fieldsValues.sphone3}" onkeypress="return CheckSymbol(event)" onfocus="this.select();" onblur="check();" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.mandatoryField}{$lang.mphone}:</td>
			<td style="{$style.td_right}">

				{include file='errorlabel.tpl' fieldName='mphone' param='correct'}
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center"><small>{$lang.codc}</small></td>
						<td align="center"><small>{$lang.codo}</small></td>
						<td align="center"><small>{$lang.num}</small></td>
					</tr>
					<tr>
						<td align="center">
							+<input type="text" name="{$fields.mphone1}" id="{$fields.mphone1}" style="width:50px; {$style.border_normal}" value="{$fieldsValues.mphone1}" onkeypress="return CheckSymbol(event);" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();"  />
						</td>
						<td align="center">
							<input type="text" name="{$fields.mphone2}" id="{$fields.mphone2}" style="width:70px; {$style.border_normal}" value="{$fieldsValues.mphone2}" onkeypress="return CheckSymbol(event)" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();" />
						</td>
						<td align="center">
							<input type="text" name="{$fields.mphone3}" id="{$fields.mphone3}" style="width:150px; {$style.border_normal}" value="{$fieldsValues.mphone3}" onkeypress="return CheckSymbol(event)" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();"  />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.web}:</td>
			<td style="{$style.td_right}">
				<input type="text" name="{$fields.web}" id="{$fields.web}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.web}" />
			</td>
		</tr>

		<tr>
			<td style="{$style.text_align1}">{$lang.icq}:</td>
			<td style="{$style.td_right}">
				<input type="text" name="{$fields.icq}" id="{$fields.icq}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.icq}" />
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.skype}:</td>
			<td style="{$style.td_right}">
				<input type="text" name="{$fields.skype}" id="{$fields.skype}" style="width:300px; {$style.border_normal}" value="{$fieldsValues.skype}" />
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.other_contact}:</td>
			<td style="{$style.td_right}">
				<textarea name="{$fields.other_contact}" id="{$fields.other_contact}" style="width:300px;height:40px;">{$fieldsValues.other_contact}</textarea>
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.contact}:</td>
			<td style="{$style.td_right}">
				<textarea name="{$fields.contact}" id="{$fields.contact}" style="width:300px;height:100px;">{$fieldsValues.contact}</textarea>
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.fromknow}:</td>
			<td style="{$style.td_right}">
				<select name="{$fields.fromknow}" id="{$fields.fromknow}" style="width:300px;">
					{include file='list.tpl' listName='fromknow'}
				</select>
			</td>
		</tr>
		<tr>
			<td style="{$style.text_align1}">{$lang.specialization}:</td>
			<td style="{$style.td_right}">
				<div style="width:300px; height:200px; overflow:auto; border-bottom:dotted 1px #cccccc;">
					{include file='checklist.tpl' listName='course'}
				</div>
				<div id="ShowBox" style="width:300px;"></div>
			</td>
		</tr>
		{if $spamDefenceMode == 'securimage'}
		<tr>
			<td style="{$style.text_align1}">
				{$lang.mandatoryField}{$lang.captcha}:
			</td>
			<td style="{$style.td_right}">
				<img id="img_{$fields.captcha_code}" src="{$includePath}securimage/securimage_show.php" alt="CAPTCHA Image" /><br />
				<input type="text" name="{$fields.captcha_code}" id="{$fields.captcha_code}" maxlength="6" style="{$style.border_normal}" />
				<a href="#" onclick="document.getElementById('img_{$fields.captcha_code}').src = '{$includePath}securimage/securimage_show.php?' + Math.random(); return false">{$lang.changecaptcha}</a>
			</td>
		</tr>
		{/if}
		<tr>
			<td>&nbsp;</td>
			<td style="{$style.td_right}">
				<input type="hidden" name="{$fields.act}" id="{$fields.act}" value="parseRegisteravtorData" /><br />
				<input id="registerautor_submit" type="submit" value="Сохранить" style="width:300px; height:40px;"/>
			</td>
		</tr>
	</table>
</form>




{* <!-- begin by Pavel Handleman 11.02.2013 --> *}
<script  type="text/javascript">
function show_error_mphone() {
	$("#{$fields.mphone1}").css("border-color","red");
	$("#{$fields.mphone2}").css("border-color","red");
	$("#{$fields.mphone3}").css("border-color","red");
	$("#span_mphone_correct").css("display","inline");
	return false;
}

function show_ok_mphone() {
	$("#{$fields.mphone1}").css("border-color","#959595");
	$("#{$fields.mphone2}").css("border-color","#959595");
	$("#{$fields.mphone3}").css("border-color","#959595");
	$("#span_mphone_correct").css("display","none");	
}
function CheckSymbol(e) { 
	var key = e.charCode; 
	value = String.fromCharCode(key);
	var rep = /[0-9]/; 
	if ((rep.test(value)) || e.keyCode ==9 || e.keyCode==27 || e.keyCode==8 || e.keyCode==46 || e.keyCode==13  || e.keyCode==37 || e.keyCode==39 || e.keyCode==33 || e.keyCode==34 || e.keyCode==35 || e.keyCode==36 ) { 
		return value;
	}
	
	return false;
}

function ChangeFocus(obj,form_name) {
	if(obj.id == "{$fields.mphone1}") {
		if((obj.value == '7') || obj.value == '38' || obj.value.length == 3)
			next_focus_order(obj);
		return false;
	}
	if(obj.id == "{$fields.mphone2}") {
		if((obj.value.length == 3) || ($("#{$fields.mphone1}").val() == '375' && obj.value.length == 2))
			next_focus_order(obj);
		return false;
	}
	if(obj.id == "{$fields.mphone3}") {
		if(obj.value.length >= 7)
			next_focus_order(obj);
		return false;
	}	
}
function next_focus_order(obj) {	
	if(obj.id == "{$fields.mphone1}") {
		$("#{$fields.mphone2}").focus();
		return false;
	}
	if(obj.id == "{$fields.mphone2}") {
		$("#{$fields.mphone3}").focus();
		return false;
	}
	if(obj.id == "{$fields.mphone3}") {
		$("#{$fields.mphone1}").focus();
		return false;
	}
}


$('#registerauthor_submit').click(function(event){
  if ( CheckRegisterAvtorForm()) {
    var url = 'http://crm.diplom5plus.ru/api_handler.php';
    var postdataObj = $('#avtorform').serializeArray();
    var postdata = {literal}{}{/literal};
    for (var o = 0; o<postdataObj.length; o++) {
      postdata[postdataObj[o].name] = postdataObj[o].value;
    }
    $.ajax( {
      url : url,
      data : {
        action : 'add_author',
        params : postdata
      },
      success : function(data) {
        data = JSON.parse(data);
      }
    })
  }
});
function CheckRegisterAvtorForm() {
	var result = true;
	/* логин */

/*	if ($('#{$fields.login}').val() == '') {
		$('#{$fields.login}').css("border-color","red");
		$("#span_login").css("display","inline");
		result = false;
		}
	else 
		{
		$("{$fields.login}").css("border-color","#959595");
		$("span_login").css("display","none");
		}*/

	/* пароль */

	if ($('#{$fields.pass}').val() == '') {
		$("#{$fields.pass}").css("border-color","red");
		$("#span_pass").css("display","inline");
		result = false;
		}
	else 
		{
		$("#{$fields.pass}").css("border-color","#959595");
		$("#span_pass").css("display","none");
		}	
				
	/* фио */
	
	if ($('#{$fields.fio}').val() == '') {
		$("#{$fields.fio}").css("border-color","red");
		$("#span_fio").css("display","inline");
		result = false;
		}
	else 
		{
		$("#{$fields.fio}").css("border-color","#959595");
		$("#span_fio").css("display","none");
		}		
		
		var s1 = $('#{$fields.mphone1}').val();
		
		var s2 = $('#{$fields.mphone2}').val();
		
		var s3 = $('#{$fields.mphone3}').val();
		if ((s1 == '') || (s2 == '') || (s3 == '')) {
			show_error_mphone();
			
			}
		else if (((s1 != '') || (s2 != '') || (s3 != '')) && ((s1 == '') || (s2.length < 2 ) || (s3.length != 7))) {
			show_error_mphone();
		}
		else {
			show_ok_mphone();
		}					
			
	var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{ldelim}2,4{rdelim})$/;
	
	if ($('#{$fields.email}').val() == '') {
		$("#{$fields.email}").css("border-color","red");
		$("#span_email_correct").css("display","none");
		$("#span_email").css("display","inline");
		result = false;
		}
	else if (!(reg.test($('#{$fields.email}').val()))) {
		$("#{$fields.email}").css("border-color","red");
		$("#span_email_correct").css("display","inline");
		$("#span_email").css("display","none");
		result = false;
		}			
	else
		{
		$("#{$fields.email}").css("border-color","#959595");
		$("#span_email_correct").css("display","none");
		$("#span_email").css("display","none");
		}	
	/* capcha */
	if($("#{$fields.captcha_code}")) {		
		
		if ($("#{$fields.captcha_code}").val() == '') {
			$("#{$fields.captcha_code}").css("border-color","red");
			/* $("#span_captcha").css("display","inline"); */
			result = false;
		}
		else {
			$("#{$fields.captcha_code}").css("border-color","#959595");
			/* $("#span_captcha").css("display","none"); */
		}
	}

	return result;
}
</script> 
{* <!-- end Pavel Handleman 11.02.2013 --> *}
{literal}
<script type="text/javascript">
	function ShowChecked(obj,dest){
		if(obj.checked==true){
			var str = document.getElementById('V_'+obj.value).innerHTML;
			if(document.getElementById(dest).innerHTML != '') var app = ', ';
			else var app = '';
			document.getElementById('ShowBox').innerHTML += '<span id="Item_'+obj.value+'">'+app+str+'</span>';
		}else{
			delelem('Item_'+obj.value);
		}
	}

	function delelem(a) {
		/* Получаем доступ к ДИВу, содержащему поле */
		var contDiv = document.getElementById(a);
		/* Удаляем этот ДИВ из DOM-дерева */
		contDiv.parentNode.removeChild(contDiv);
	}
</script>
{/literal}