<?php /* Smarty version Smarty-3.1.8, created on 2015-01-12 14:40:59
         compiled from "/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/owninfo.tpl" */ ?>
<?php /*%%SmartyHeaderCode:123257829854b3b2cb7c3450-14763993%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad1d56fc2b7d0881c7ae5fbb6d24492a525b3dfb' => 
    array (
      0 => '/home/s/spluso/diplom5plus.ru/public_html/uchet/tmpl/smarty/owninfo.tpl',
      1 => 1368627508,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '123257829854b3b2cb7c3450-14763993',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'jsPath' => 0,
    'dataSaved' => 0,
    'lang' => 0,
    'url' => 0,
    'fio' => 0,
    'phone' => 0,
    'mphone' => 0,
    'email' => 0,
    'icq' => 0,
    'contact' => 0,
    'skype' => 0,
    'other_contact' => 0,
    'web' => 0,
    'birthday' => 0,
    'country' => 0,
    'city' => 0,
    'speciality' => 0,
    'orders_before' => 0,
    'time_to_call' => 0,
    'payment_method' => 0,
    'university' => 0,
    'examinations_time' => 0,
    'key' => 0,
    'val' => 0,
    'ch_csa' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_54b3b2cb909433_04377336',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b3b2cb909433_04377336')) {function content_54b3b2cb909433_04377336($_smarty_tpl) {?><link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['jsPath']->value;?>
calendar.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->tpl_vars['jsPath']->value;?>
c_calendar.js" type="text/javascript"></script>

<h2 class="tarrow">Личная информация</h2>

<?php echo $_smarty_tpl->getSubTemplate ('error.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if (!empty($_smarty_tpl->tpl_vars['dataSaved']->value)){?>
	<div><?php echo $_smarty_tpl->tpl_vars['lang']->value['ownDataSaved'];?>
</div>
<?php }?>

<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['url']->value['owninfo'];?>
" enctype="multipart/form-data">
	<table border='0' class="rTab">
		<tr><th colspan="2"><br /><span>Контактная информация</span><br /><br /></th></tr>
		<tr><th>ФИО:<span>*</span></th><td><input type="text" name="fio" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['fio']->value;?>
" /></td></tr>
		<tr><th>Телефон:</th><td><input type="text" name="phone" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
" /></td></tr>
		<tr><th>Мобильный телефон:<span>*</span></th><td><input type="text" name="mphone" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['mphone']->value;?>
" /></td></tr>
		<tr><th>E-mail:<span>*</span></th><td><input type="text" name="email" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" /></td></tr>
		<tr><th>ICQ:</th><td><input type="text" name="icq" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['icq']->value;?>
" /></td></tr>
		<tr><th>Адрес:</th><td><textarea name="contact" style="width:300px;height:100px;"><?php echo $_smarty_tpl->tpl_vars['contact']->value;?>
</textarea></td></tr>
		
		<tr><th>Skype:</th><td><input type="text" name="skype" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['skype']->value;?>
" /></td></tr>
		<tr><th>Другие способы связи:</th><td><textarea name="other_contact" style="width:300px; height:100px;"><?php echo $_smarty_tpl->tpl_vars['other_contact']->value;?>
</textarea></td></tr>
		<tr><th>Веб-адрес:</th><td><input type="text" name="web" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['web']->value;?>
" /></td></tr>
		<tr><th>Дата рождения:</th><td><input type="text" name="birthday" id="birthday" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['birthday']->value;?>
" /></td></tr>
		<tr><th>Страна:</th><td><input type="text" name="country" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['country']->value;?>
" /></td></tr>
		<tr><th>Город:</th><td><input type="text" name="city" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['city']->value;?>
" /></td></tr>
		
		<tr><th>Сфера деятельности:</th><td><input type="text" name="speciality" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['speciality']->value;?>
" /></td></tr>
		<tr><th>Заказывали ли раньше работы и где:</th><td><input type="text" name="orders_before" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['orders_before']->value;?>
" /></td></tr>
		<tr><th>Удобное время для связи:</th><td><input type="text" name="time_to_call" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['time_to_call']->value;?>
" /></td></tr>
		<tr><th>Предпочитаемые способы оплаты:</th><td><input type="text" name="payment_method" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['payment_method']->value;?>
" /></td></tr>
		<tr><th>В какм ВУЗе обучаетесь:</th><td><input type="text" name="university" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['university']->value;?>
" /></td></tr>
		<tr>
			<th>Когда у Вас начинается сессия:</th>
			<td>
				<input type="text" name="examinations_time[]" id="examinations_time0" style="width:300px;" value="<?php echo $_smarty_tpl->tpl_vars['examinations_time']->value['0'];?>
" /><br />
				<div id="AddExamTime">
					<?php if (count($_smarty_tpl->tpl_vars['examinations_time']->value)>1){?>
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['examinations_time']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
							<?php if ($_smarty_tpl->tpl_vars['key']->value!=0){?>
								<div><input name="examinations_time[]" id="examinations_time<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" type="text" style="width:300px" value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" /></div>
							<?php }?>
						<?php } ?>
					<?php }?>
				
				</div><br />
				<a href="#" onclick="addExaminationsTimeField('examinations_time', 'AddExamTime'); return false;">Добавить ещё одно время сессии</a>
		</td></tr>
	
		<tr><th>&nbsp;</th><td><input type="checkbox" name="c_send_alert" <?php echo $_smarty_tpl->tpl_vars['ch_csa']->value;?>
/> Получать оповещения</td></tr>
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
	<?php if (count($_smarty_tpl->tpl_vars['examinations_time']->value)>1){?>
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['examinations_time']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
			<?php if ($_smarty_tpl->tpl_vars['key']->value!=0){?>
				Calendar.setup({
					inputField : "examinations_time<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
", 
					ifFormat : "%d.%m.%Y",
					showsTime : true
				});
			<?php }?>
		<?php } ?>
	<?php }?>

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
</script><?php }} ?>