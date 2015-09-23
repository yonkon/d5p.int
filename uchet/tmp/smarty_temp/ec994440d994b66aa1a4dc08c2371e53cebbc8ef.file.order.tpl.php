<?php /* Smarty version Smarty-3.1.8, created on 2015-01-09 08:09:07
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26586816754af62737016f1-42037334%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec994440d994b66aa1a4dc08c2371e53cebbc8ef' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/order.tpl',
      1 => 1369048480,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26586816754af62737016f1-42037334',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'lang' => 0,
    'orderFields' => 0,
    'style' => 0,
    'fieldsValues' => 0,
    'showRegisterUserForm' => 0,
    'fields' => 0,
    'variables' => 0,
    'jsPath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54af62738a4c95_25903902',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54af62738a4c95_25903902')) {function content_54af62738a4c95_25903902($_smarty_tpl) {?><h2>Форма заказа:</h2>

<?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['order'];?>
" id="orderform" name="orderform" enctype="multipart/form-data" onsubmit="return CheckOrderForm();">

<div class="form-part-wrap">
	<div class="holder">
		<h4><?php echo $_smarty_tpl->tpl_vars['lang']->value['order_info'];?>
</h4>
		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['thema']['enabled']){?>
			<div class="f-row">
				<span id="span_o_thema" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_red'];?>
 display: none;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error_thema'];?>
</span>
				<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['thema']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['thema'];?>
:</span>
				<textarea name="o_thema" id="o_thema" ><?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['thema'];?>
</textarea>
			</div>
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['course']['enabled']){?>
			<div class="f-row">
				<span id="span_o_course" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_red'];?>
display: none;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error_course'];?>
</span>
				<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['course']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['course'];?>
:</span>

				<div class="f-input">
					<select name="o_course" id="o_course" >
						<?php echo $_smarty_tpl->getSubTemplate ('list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('listName'=>'course'), 0);?>

					</select>
				</div>
			</div>
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['worktype']['enabled']){?>
		<div class="f-row">
			<span id="span_o_type" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_red'];?>
 display: none;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error_worktype'];?>
</span>
			<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['worktype']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['worktype'];?>
:</span>
			<div class="f-input">
				<select name="o_type" id="o_type" >
					<?php echo $_smarty_tpl->getSubTemplate ('list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('listName'=>'worktype'), 0);?>

				</select>
			</div>
		</div>
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['client_srok']['enabled']){?>
		<div class="f-row">
			<span id="span_o_client_srok" style=" color: red; font-weight: bold;  display: none;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error_client_srok'];?>
</span>
			<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['client_srok']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['client_srok'];?>
:</span>
			<div class="f-input">
				<input type="text" name="o_client_srok" id="o_client_srok" class="datetextbox" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['client_srok'];?>
" >
			</div>
		</div>
		<?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['volume']['enabled']){?>
		<div class="f-row">

			<span  class="f-label">
				<?php echo $_smarty_tpl->tpl_vars['lang']->value['volume'];?>
:
			</span>
			<div class="f-input">
				<input type="text" name="o_volume" id="o_volume" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['volume'];?>
">
			</div>
		</div>
		<?php }?>
		
	<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['vuz']['enabled']){?>
		<div class="f-row">
			<span  class="f-label">
				<?php echo $_smarty_tpl->tpl_vars['lang']->value['vuz'];?>
:
			</span>
			<div class="f-input">
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['orderFields']->value['vuz']['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['orderFields']->value['vuz']['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['vuz'];?>
" maxlength="255" />
			</div>
		</div>
	<?php }?>
	</div>
	
	<?php if ($_smarty_tpl->tpl_vars['showRegisterUserForm']->value){?>
	<div class="holder">
		<h4><?php echo $_smarty_tpl->tpl_vars['lang']->value['contact_info'];?>
:</h4>
		
		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['fio']['enabled']){?>
		<div class="f-row">
			<span id="span_fio" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_red'];?>
display: none;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['error_fio'];?>
</span>
			<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['fio']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['fio'];?>
:</span>
			<div class="f-input">
				<input type="text"  name="fio" id="fio" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['fio'];?>
" >
			</div>
		</div>
		<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['email']['enabled']){?>
		<div class="f-row">
			<span id="span_email" style=" color: red; font-weight: bold; display: none;">Введите e-mail</span>
			<span id="span_email_error" style=" color: red; font-weight: bold; display: none;">Введите верный e-mail</span>
			<span  class="f-label">
				<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['email']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['email'];?>
:
			</span>
			<div class="f-input">
				<input type="text" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['email'];?>
" >
			</div>
		</div>
		<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['mphone']['enabled']){?>
		<div class="f-row">
			<span id="span_mphone1" style=" color: red; font-weight: bold; display: none;">
				<?php echo $_smarty_tpl->tpl_vars['lang']->value['error_mphone'];?>

			</span>
			<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['mphone']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['mphone'];?>
:<br /><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['mphone_small'];?>
</small></span>
			<div class="f-input">
				<input type="text" name="mphone1" id="mphone1"  value="" onkeypress="return CheckSymbol(event);" >
			</div>

		</div>
		<?php }?>
		
		<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['user'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['user'];?>
" value="new" />
	</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['addinfo']['enabled']){?>
	<div class="holder">
		<h4><?php echo $_smarty_tpl->tpl_vars['lang']->value['load_files'];?>
:</h4>

		
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
		

		<div class="f-row">
			<span  class="f-label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['file_part'];?>
:</span>
			<div class="f-input">
				<select name="f_part" id="f_part">
					<?php echo $_smarty_tpl->getSubTemplate ('list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('listName'=>'file_part'), 0);?>

				</select>
			</div>
			<br>
			<br>
			
			<div class="f-input">
				<input type="file"  name="<?php echo $_smarty_tpl->tpl_vars['orderFields']->value['file_arr']['name'];?>
[]" >
				&nbsp;
				<br>

				<div id="<?php echo $_smarty_tpl->tpl_vars['variables']->value['addfile'];?>
"></div>
				<a href="#" onclick="addFileField('<?php echo $_smarty_tpl->tpl_vars['orderFields']->value['file_arr']['name'];?>
', '<?php echo $_smarty_tpl->tpl_vars['variables']->value['addfile'];?>
'); return false;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['onemorefile'];?>
</a>
			</div>
		</div>
		
		<div class="f-row">
			<span  class="f-label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['file_comment'];?>
:</span>
			<textarea name="f_comment" id="f_comment"><?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['file_comment'];?>
</textarea>
		</div>
	</div>
	<?php }?>
</div>

<div class="form-part-wrap">
	<div class="holder">
		<h4>Дополнительная информация</h4>
	</div>
	
	<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['city']['enabled']){?>
	<div class="f-row">

		<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['city']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['city'];?>
:</span>
		<div class="f-input">
			<input type="text" name='o_cc2' id="o_cc2" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['city'];?>
" >
		</div>
	</div>
	<?php }?>
	
	<div style="width:100%; clear:both;"></div>
	
	<?php if ($_smarty_tpl->tpl_vars['orderFields']->value['addinfo']['enabled']){?>
	<div class="f-row">

		<span  class="f-label"><?php if ($_smarty_tpl->tpl_vars['orderFields']->value['addinfo']['mandatory']){?><?php echo $_smarty_tpl->tpl_vars['lang']->value['necessarys'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['lang']->value['addinfo'];?>
:</span>

		<textarea name="o_addinfo" id="o_addinfo"><?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['addinfo'];?>
</textarea>

	</div>
	<div style="width:100%; clear:both;"></div>
	<?php }?>
	
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

<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['jsPath']->value;?>
chosen.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['jsPath']->value;?>
chosen.jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jsPath']->value;?>
calendar.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->tpl_vars['jsPath']->value;?>
c_calendar.js" type="text/javascript"></script>


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
<?php }} ?>