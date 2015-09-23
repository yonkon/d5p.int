<h2>Форма заказа:</h2>

{include file='error.tpl'}

<form method="post" action="{$url.order}" id="orderform" name="orderform" enctype="multipart/form-data" onsubmit="return CheckOrderForm();">

<div class="form-part-wrap">
	<div class="holder">
		<h4>{$lang.order_info}</h4>
		{if $orderFields.thema.enabled}
			<div class="f-row">
				<span id="span_o_thema" style="{$style.text_red} display: none;">{$lang.error_thema}</span>
				<span  class="f-label">{if $orderFields.thema.mandatory}{$lang.necessarys}{/if}{$lang.thema}:</span>
				<textarea name="o_thema" id="o_thema" >{$fieldsValues.thema}</textarea>
			</div>
		{/if}
		
		{if $orderFields.course.enabled}
			<div class="f-row">
				<span id="span_o_course" style="{$style.text_red}display: none;">{$lang.error_course}</span>
				<span  class="f-label">{if $orderFields.course.mandatory}{$lang.necessarys}{/if}{$lang.course}:</span>

				<div class="f-input">
					<select name="o_course" id="o_course" >
						{include file='list.tpl' listName='course'}
					</select>
				</div>
			</div>
		{/if}
		
		{if $orderFields.worktype.enabled}
		<div class="f-row">
			<span id="span_o_type" style="{$style.text_red} display: none;">{$lang.error_worktype}</span>
			<span  class="f-label">{if $orderFields.worktype.mandatory}{$lang.necessarys}{/if}{$lang.worktype}:</span>
			<div class="f-input">
				<select name="o_type" id="o_type" >
					{include file='list.tpl' listName='worktype'}
				</select>
			</div>
		</div>
		{/if}
		
		{if $orderFields.client_srok.enabled}
		<div class="f-row">
			<span id="span_o_client_srok" style=" color: red; font-weight: bold;  display: none;">{$lang.error_client_srok}</span>
			<span  class="f-label">{if $orderFields.client_srok.mandatory}{$lang.necessarys}{/if}{$lang.client_srok}:</span>
			<div class="f-input">
				<input type="text" name="o_client_srok" id="o_client_srok" class="datetextbox" value="{$fieldsValues.client_srok}" >
			</div>
		</div>
		{/if}
		
		{if $orderFields.volume.enabled}
		<div class="f-row">

			<span  class="f-label">
				{$lang.volume}:
			</span>
			<div class="f-input">
				<input type="text" name="o_volume" id="o_volume" value="{$fieldsValues.volume}">
			</div>
		</div>
		{/if}
		
	{if $orderFields.vuz.enabled}
		<div class="f-row">
			<span  class="f-label">
				{$lang.vuz}:
			</span>
			<div class="f-input">
				<input type="text" name="{$orderFields.vuz.name}" id="{$orderFields.vuz.name}" value="{$fieldsValues.vuz}" maxlength="255" />
			</div>
		</div>
	{/if}
	</div>
	
	{if $showRegisterUserForm}
	<div class="holder">
		<h4>{$lang.contact_info}:</h4>
		
		{if $orderFields.fio.enabled}
		<div class="f-row">
			<span id="span_fio" style="{$style.text_red}display: none;">{$lang.error_fio}</span>
			<span  class="f-label">{if $orderFields.fio.mandatory}{$lang.necessarys}{/if}{$lang.fio}:</span>
			<div class="f-input">
				<input type="text"  name="fio" id="fio" value="{$fieldsValues.fio}" >
			</div>
		</div>
		{/if}

		{if $orderFields.email.enabled}
		<div class="f-row">
			<span id="span_email" style=" color: red; font-weight: bold; display: none;">Введите e-mail</span>
			<span id="span_email_error" style=" color: red; font-weight: bold; display: none;">Введите верный e-mail</span>
			<span  class="f-label">
				{if $orderFields.email.mandatory}{$lang.necessarys}{/if}{$lang.email}:
			</span>
			<div class="f-input">
				<input type="text" name="email" id="email" value="{$fieldsValues.email}" >
			</div>
		</div>
		{/if}

		{if $orderFields.mphone.enabled}
		<div class="f-row">
			<span id="span_mphone1" style=" color: red; font-weight: bold; display: none;">
				{$lang.error_mphone}
			</span>
			<span  class="f-label">{if $orderFields.mphone.mandatory}{$lang.necessarys}{/if}{$lang.mphone}:<br /><small>{$lang.mphone_small}</small></span>
			<div class="f-input">
				<input type="text" name="mphone1" id="mphone1"  value="" onkeypress="return CheckSymbol(event);" >
			</div>

		</div>
		{/if}
		
		<input type="hidden" name="{$fields.user}" id="{$fields.user}" value="new" />
	</div>
	{/if}

	{if $orderFields.addinfo.enabled}
	<div class="holder">
		<h4>{$lang.load_files}:</h4>

		{literal}
		<script type="text/javascript">
			function addFileField(namefield, parent){
				var div = document.createElement("div");
				div.innerHTML = "<input name=\"" + namefield + "[]\" type=\"file\" class=\"addnew\" /> &nbsp; <input type=\"image\" onclick=\"return deleteField(this)\" class=\"addnew_btn\"  src=\"tmpl/lite/images/del.png\">";
				document.getElementById(parent).appendChild(div);
			}

			function deleteField(a) {
				var contDiv = a.parentNode;
				contDiv.parentNode.removeChild(contDiv);
			}
		</script>
		{/literal}

		<div class="f-row">
			<span  class="f-label">{$lang.file_part}:</span>
			<div class="f-input">
				<select name="f_part" id="f_part">
					{include file='list.tpl' listName='file_part'}
				</select>
			</div>
			<br>
			<br>
			
			<div class="f-input">
				<input type="file"  name="{$orderFields.file_arr.name}[]" >
				&nbsp;
				<br>

				<div id="{$variables.addfile}"></div>
				<a href="#" onclick="addFileField('{$orderFields.file_arr.name}', '{$variables.addfile}'); return false;">{$lang.onemorefile}</a>
			</div>
		</div>
		
		<div class="f-row">
			<span  class="f-label">{$lang.file_comment}:</span>
			<textarea name="f_comment" id="f_comment">{$fieldsValues.file_comment}</textarea>
		</div>
	</div>
	{/if}
</div>

<div class="form-part-wrap">
	<div class="holder">
		<h4>Дополнительная информация</h4>
	</div>
	
	{if $orderFields.city.enabled}
	<div class="f-row">

		<span  class="f-label">{if $orderFields.city.mandatory}{$lang.necessarys}{/if}{$lang.city}:</span>
		<div class="f-input">
			<input type="text" name='o_cc2' id="o_cc2" value="{$fieldsValues.city}" >
		</div>
	</div>
	{/if}
	
	<div style="width:100%; clear:both;"></div>
	
	{if $orderFields.addinfo.enabled}
	<div class="f-row">

		<span  class="f-label">{if $orderFields.addinfo.mandatory}{$lang.necessarys}{/if}{$lang.addinfo}:</span>

		<textarea name="o_addinfo" id="o_addinfo">{$fieldsValues.addinfo}</textarea>

	</div>
	<div style="width:100%; clear:both;"></div>
	{/if}
	
</div>

<div class="form-part-wrap">

	<div class="clearall"></div>

</div>

<div class="form-part-wrap">

	<div>
		<input type="hidden" name="act" id="act" value="parseOrderData">
		<input type="submit" value=" "  class="button">
	</div>

</div>

</form>

<link rel="stylesheet" type="text/css" href="{$jsPath}chosen.css" />
<script type="text/javascript" src="{$jsPath}chosen.jquery.min.js"></script>
<link rel="stylesheet" href="{$jsPath}calendar.css" type="text/css" />
<script src="{$jsPath}c_calendar.js" type="text/javascript"></script>

{literal}
<script type="text/javascript">
	Calendar.setup({
		inputField : "o_client_srok", 
		ifFormat : "%d.%m.%Y",
		showsTime : true
	});
	$(function() {

	if (screen.width>800){
			$('#o_course').chosen({no_results_text: "Не найдено: "}).change(function() {
				$(this).validationEngine('validate');
			});
			$('#o_type').chosen({no_results_text: "Не найдено: "}).change(function() {
				$(this).validationEngine('validate');
			});
			$('#f_part').chosen({no_results_text: "Не найдено: ", disable_search:true});
			$('#o_shcooltype').chosen({no_results_text: "Не найдено: "});
			$('#o_cc1').chosen({no_results_text: "Не найдено: ", disable_search:true});
			$('#gost').chosen({no_results_text: "Не найдено: ", disable_search:true});
			$('#o_fromknow').chosen({no_results_text: "Не найдено: "});
		}    
	});	
	function CheckOrderForm() {
		var result = true;
			if ($('#o_thema').val() == '') {
				$("#o_thema").css("border","solid 1px #ff0000");
				$("#span_o_thema").css("display","inline");
				result = false;
				}
			else 
				{
				$("#o_thema").css("border-color","#959595");
				$("#span_o_thema").css("display","none");
				}	


					
			if ($('#o_course').val() == '0') {
				$("#o_course").css("border","solid 1px #ff0000");
				$("#span_o_course").css("display","inline");
				$('#o_course').parent().addClass('s_red');
				result = false;
				}
			else 
				{
				$("#o_course").css("border-color","#959595");
				$("#span_o_course").css("display","none");
				$('#o_course').parent().removeClass('s_red');
				}
				

					
			if ($("#o_type").val() == '0') {
				$("#o_type").css("border","solid 1px #ff0000");
				$("#span_o_type").css("display","inline");
				$('#o_type').parent().addClass('s_red');
				result = false;
				}
			else 
				{
				$("#o_type").css("border-color","#959595");
				$("#span_o_type").css("display","none");
				$('#o_type').parent().removeClass('s_red');
				}
				

					
			if ($("#o_client_srok").val() == '') {
				$("#o_client_srok").css("border","solid 1px #ff0000");
				$("#span_o_client_srok").css("display","inline");
				result = false;
				}
			else 
				{
				$("#o_client_srok").css("border-color","#959595");
				$("#span_o_client_srok").css("display","none");
				}

					var s = document.orderform.user.value;
			if(s == 'new') {

							
			if ($("#fio").val() == '') {
				$("#fio").css("border","solid 1px #ff0000");
				$("#span_fio").css("display","inline");
				result = false;
				}
			else 
				{
				$("#fio").css("border-color","#959595");
				$("#span_fio").css("display","none");
				}		

						var reg=/^([a-z0-9]+[a-z0-9_\.\-]+)@([a-z0-9]+[a-z0-9\.\-]+)\.([a-z]{2,6})$/i;				
			
			if ($("#email").val() == '') {
				$("#email").css("border","solid 1px #ff0000");
				$("#span_email_error").css("display","none");
				$("#span_email").css("display","inline");
				result = false;
				}
			else if (!(reg.test($("#email").val()))) {
				$("#email").css("border","solid 1px #ff0000");
				$("#span_email_error").css("display","inline");
				$("#span_email").css("display","none");
				result = false;
				}			
			else
				{
				$("#Array").css("border-color","#959595");
				$("#span_Array_error").css("display","none");
				$("#span_Array").css("display","none");
				}
						}
			return result;
		}
	function CheckSymbol(e) { 
		var keynum;
			var keychar;
		var numcheck;
		var return2;
		if(window.event) // IE
		{
			keynum = e.keyCode;
		}
		else if(e.which) // Firefox/Opera
		{
			keynum = e.which;
		}
		keychar = String.fromCharCode(keynum);
		if (keynum < 45 || keynum > 57) {
			return2 = false;
			if (keynum == 8) return2 = true; // backspace
			}
		else return2 = true;
		return return2;
	}


</script>
{/literal}