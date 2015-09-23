<?php /* Smarty version Smarty-3.1.8, created on 2015-01-09 13:14:06
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/registeravtor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22139869854afa9ee4c09a6-88903230%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e7e907df3724c2f8ec6c2fa45da493f8da05bef' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/registeravtor.tpl',
      1 => 1368627507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22139869854afa9ee4c09a6-88903230',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'style' => 0,
    'lang' => 0,
    'fields' => 0,
    'fieldsValues' => 0,
    'spamDefenceMode' => 0,
    'includePath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54afa9ee7c2d60_37849502',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54afa9ee7c2d60_37849502')) {function content_54afa9ee7c2d60_37849502($_smarty_tpl) {?><!--<noindex>-->


<?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['registeravtor'];?>
" id="avtorform" name="avtorform" enctype="multipart/form-data" onsubmit="return CheckRegisterAvtorForm();">

	<table border="0" class="rTab">
		<tr>
			<td colspan="2" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['alert_info'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryFieldsDescription'];?>
</td>
		</tr>
		<tr>
			<th colspan="2" align="center"><?php echo $_smarty_tpl->tpl_vars['lang']->value['detailsToEnter'];?>
</th>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryField'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['login'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				
				<?php echo $_smarty_tpl->getSubTemplate ('errorlabel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('fieldName'=>'login'), 0);?>

				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['login'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['login'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['login'];?>
" />
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryField'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['pass'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				
				<?php echo $_smarty_tpl->getSubTemplate ('errorlabel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('fieldName'=>'pass'), 0);?>

				<input type="password" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['pass'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['pass'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['pass'];?>
" />
			</td>
		</tr>
		<tr>
			<th colspan="2" align="center"><br /><h4><?php echo $_smarty_tpl->tpl_vars['lang']->value['contact_info'];?>
</h4></th>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryField'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['fio'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
			
				<?php echo $_smarty_tpl->getSubTemplate ('errorlabel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('fieldName'=>'fio'), 0);?>

				
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['fio'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['fio'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['fio'];?>
" />
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['sphone'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center"><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['codc'];?>
</small></td>
						<td align="center"><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['cods'];?>
</small></td>
						<td align="center"><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['num'];?>
</small></td>
					</tr>
					<tr>
						<td align="center">+<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['sphone1'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['sphone1'];?>
" style="width:50px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['sphone1'];?>
" onkeypress="return CheckSymbol(event)" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();" onblur="check();" /></td>
						<td align="center"><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['sphone2'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['sphone2'];?>
" style="width:70px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['sphone2'];?>
" onkeypress="return CheckSymbol(event)" onfocus="this.select();" onblur="check();" /></td>
						<td align="center"><input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['sphone3'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['sphone3'];?>
" style="width:150px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['sphone3'];?>
" onkeypress="return CheckSymbol(event)" onfocus="this.select();" onblur="check();" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryField'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['mphone'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">

				<?php echo $_smarty_tpl->getSubTemplate ('errorlabel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('fieldName'=>'mphone','param'=>'correct'), 0);?>

				<table border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center"><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['codc'];?>
</small></td>
						<td align="center"><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['codo'];?>
</small></td>
						<td align="center"><small><?php echo $_smarty_tpl->tpl_vars['lang']->value['num'];?>
</small></td>
					</tr>
					<tr>
						<td align="center">
							+<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
" style="width:50px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['mphone1'];?>
" onkeypress="return CheckSymbol(event);" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();"  />
						</td>
						<td align="center">
							<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
" style="width:70px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['mphone2'];?>
" onkeypress="return CheckSymbol(event)" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();" />
						</td>
						<td align="center">
							<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
" style="width:150px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['mphone3'];?>
" onkeypress="return CheckSymbol(event)" onkeyup="return ChangeFocus(this,'avtor');" onfocus="this.select();"  />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['web'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['web'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['web'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['web'];?>
" />
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryField'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['email'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				
				<?php echo $_smarty_tpl->getSubTemplate ('errorlabel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('fieldName'=>'email'), 0);?>

				<?php echo $_smarty_tpl->getSubTemplate ('errorlabel.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('fieldName'=>'email','param'=>'correct'), 0);?>

				
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['email'];?>
" />
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['icq'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['icq'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['icq'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['icq'];?>
" />
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['skype'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['skype'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['skype'];?>
" style="width:300px; <?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['skype'];?>
" />
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['other_contact'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<textarea name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['other_contact'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['other_contact'];?>
" style="width:300px;height:40px;"><?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['other_contact'];?>
</textarea>
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['contact'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<textarea name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['contact'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['contact'];?>
" style="width:300px;height:100px;"><?php echo $_smarty_tpl->tpl_vars['fieldsValues']->value['contact'];?>
</textarea>
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['fromknow'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<select name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['fromknow'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['fromknow'];?>
" style="width:300px;">
					<?php echo $_smarty_tpl->getSubTemplate ('list.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('listName'=>'fromknow'), 0);?>

				</select>
			</td>
		</tr>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
"><?php echo $_smarty_tpl->tpl_vars['lang']->value['specialization'];?>
:</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<div style="width:300px; height:200px; overflow:auto; border-bottom:dotted 1px #cccccc;">
					<?php echo $_smarty_tpl->getSubTemplate ('checklist.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('listName'=>'course'), 0);?>

				</div>
				<div id="ShowBox" style="width:300px;"></div>
			</td>
		</tr>
		<?php if ($_smarty_tpl->tpl_vars['spamDefenceMode']->value=='securimage'){?>
		<tr>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['text_align1'];?>
">
				<?php echo $_smarty_tpl->tpl_vars['lang']->value['mandatoryField'];?>
<?php echo $_smarty_tpl->tpl_vars['lang']->value['captcha'];?>
:
			</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<img id="img_<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['includePath']->value;?>
securimage/securimage_show.php" alt="CAPTCHA Image" /><br />
				<input type="text" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
" maxlength="6" style="<?php echo $_smarty_tpl->tpl_vars['style']->value['border_normal'];?>
" />
				<a href="#" onclick="document.getElementById('img_<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
').src = '<?php echo $_smarty_tpl->tpl_vars['includePath']->value;?>
securimage/securimage_show.php?' + Math.random(); return false"><?php echo $_smarty_tpl->tpl_vars['lang']->value['changecaptcha'];?>
</a>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td>&nbsp;</td>
			<td style="<?php echo $_smarty_tpl->tpl_vars['style']->value['td_right'];?>
">
				<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['fields']->value['act'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['fields']->value['act'];?>
" value="parseRegisteravtorData" /><br />
				<input type="submit" value="Сохранить" style="width:300px; height:40px;"/>
			</td>
		</tr>
	</table>
</form>





<script  type="text/javascript">
function show_error_mphone() {
	$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
").css("border-color","red");
	$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
").css("border-color","red");
	$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
").css("border-color","red");
	$("#span_mphone_correct").css("display","inline");
	return false;
}

function show_ok_mphone() {
	$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
").css("border-color","#959595");
	$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
").css("border-color","#959595");
	$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
").css("border-color","#959595");
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
	if(obj.id == "<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
") {
		if((obj.value == '7') || obj.value == '38' || obj.value.length == 3)
			next_focus_order(obj);
		return false;
	}
	if(obj.id == "<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
") {
		if((obj.value.length == 3) || ($("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
").val() == '375' && obj.value.length == 2))
			next_focus_order(obj);
		return false;
	}
	if(obj.id == "<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
") {
		if(obj.value.length >= 7)
			next_focus_order(obj);
		return false;
	}	
}
function next_focus_order(obj) {	
	if(obj.id == "<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
") {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
").focus();
		return false;
	}
	if(obj.id == "<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
") {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
").focus();
		return false;
	}
	if(obj.id == "<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
") {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
").focus();
		return false;
	}
}

function CheckRegisterAvtorForm() {
	var result = true;
	/* логин */
	
	if ($('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['login'];?>
').val() == '') {
		$('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['login'];?>
').css("border-color","red");
		$("#span_login").css("display","inline");
		result = false;
		}
	else 
		{
		$("<?php echo $_smarty_tpl->tpl_vars['fields']->value['login'];?>
").css("border-color","#959595");
		$("span_login").css("display","none");
		}	
		
	/* пароль */

	if ($('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['pass'];?>
').val() == '') {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['pass'];?>
").css("border-color","red");
		$("#span_pass").css("display","inline");
		result = false;
		}
	else 
		{
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['pass'];?>
").css("border-color","#959595");
		$("#span_pass").css("display","none");
		}	
				
	/* фио */
	
	if ($('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['fio'];?>
').val() == '') {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['fio'];?>
").css("border-color","red");
		$("#span_fio").css("display","inline");
		result = false;
		}
	else 
		{
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['fio'];?>
").css("border-color","#959595");
		$("#span_fio").css("display","none");
		}		
		
		var s1 = $('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone1'];?>
').val();
		
		var s2 = $('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone2'];?>
').val();
		
		var s3 = $('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['mphone3'];?>
').val();
		if ((s1 == '') || (s2 == '') || (s3 == '')) {
			show_error_mphone();
			
			}
		else if (((s1 != '') || (s2 != '') || (s3 != '')) && ((s1 == '') || (s2.length < 2 ) || (s3.length != 7))) {
			show_error_mphone();
		}
		else {
			show_ok_mphone();
		}					
			
	var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
	
	if ($('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
').val() == '') {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
").css("border-color","red");
		$("#span_email_correct").css("display","none");
		$("#span_email").css("display","inline");
		result = false;
		}
	else if (!(reg.test($('#<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
').val()))) {
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
").css("border-color","red");
		$("#span_email_correct").css("display","inline");
		$("#span_email").css("display","none");
		result = false;
		}			
	else
		{
		$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['email'];?>
").css("border-color","#959595");
		$("#span_email_correct").css("display","none");
		$("#span_email").css("display","none");
		}	
	/* capcha */
	if($("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
")) {		
		
		if ($("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
").val() == '') {
			$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
").css("border-color","red");
			/* $("#span_captcha").css("display","inline"); */
			result = false;
		}
		else {
			$("#<?php echo $_smarty_tpl->tpl_vars['fields']->value['captcha_code'];?>
").css("border-color","#959595");
			/* $("#span_captcha").css("display","none"); */
		}
	}

	return result;
}
</script> 


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
<?php }} ?>