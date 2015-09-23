<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 16:28:05
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/orderform.tpl" */ ?>
<?php /*%%SmartyHeaderCode:851275116519332609307f9-67081120%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '268b06813174a2e9423e3e3853f88300cdc21ad4' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/orderform.tpl',
      1 => 1368624480,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '851275116519332609307f9-67081120',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51933260972b10_01699911',
  'variables' => 
  array (
    'orderformError' => 0,
    'orderform' => 0,
    'orderformData' => 0,
    'check_code' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51933260972b10_01699911')) {function content_51933260972b10_01699911($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['orderformError']->value=='noError'){?>
	<p style="font-size: 22px;font-weight:bold;color:#032d4a;">Спасибо за проявленный интерес, мы свяжемся с вами в кратчайшие сроки.</p>
<?php }elseif($_smarty_tpl->tpl_vars['orderformError']->value=='notAllData'){?>
	<p style="font-size: 22px;font-weight:bold;color:red;">Вы ввели не все данные, попробуйте снова.</p>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['orderformError']->value!='noError'){?>
	<div class="item_order_form">
		<h2>Форма заказа</h2>
		<div class="block_body">
			<form action="<?php echo $_smarty_tpl->tpl_vars['orderform']->value;?>
"  method="post" onsubmit="return CheckItemOrderForm();" id="ItemOrderForm">
				<input type="hidden" name="act" value="orderform"> 
				<div class="form_side">
					<table>
						<tr>
							<td>
								<span id="span_fio" style=" color: red; font-weight: bold;  display: none; margin-top: -16px;margin-left: 62px; position:absolute;" >Укажите ваши ФИО</span>
								<label for="fio"><span>*</span>ФИО</label>
							</td>
							<td><input type="text" name="fio" id="fio" class="req" value="<?php echo $_smarty_tpl->tpl_vars['orderformData']->value['fio'];?>
"/></td>
						</tr>
						<tr>
							<td><label for="phone">Телефон</label></td>
							<td><input type="text" name="phone" id="phone" value="<?php echo $_smarty_tpl->tpl_vars['orderformData']->value['phone'];?>
"/></td>
						</tr>
						<tr>
							<td><label for="ainf">Комментарий</label></td>
							<td><textarea name="coment" id="ainf"><?php echo $_smarty_tpl->tpl_vars['orderformData']->value['coment'];?>
</textarea></td>
						</tr>
					</table>
				</div>

				<div  class="form_side">
					<table>
						<tr>
							<td>
								<span id="span_email" style=" color: red; font-weight: bold;  display: none; margin-top: -16px;margin-left: 62px; position:absolute;">Укажите E-mail</span>
								<label for="email"><span>*</span>E-mail</label>
							</td>
							<td><input type="text" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['orderformData']->value['email'];?>
"  class="req"></td>
						</tr>
						<tr>
							<td><label for="icq">ICQ</label></td>
							<td><input type="text" name="icq" id="icq" value="<?php echo $_smarty_tpl->tpl_vars['orderformData']->value['icq'];?>
"></td>

						</tr>
						<tr>
							<td colspan="2">
							
								<img src="check_code.php"  id="ChkCodeImg" class="captcha_image"/>
								<?php if ($_smarty_tpl->tpl_vars['check_code']->value=='error'){?>
									<span style=" color: red; font-weight: bold;">Неверный код!</span>
								<?php }else{ ?>
									<span id="span_check_code" style=" color: red; font-weight: bold;  display: none;">Введите код!</span>
								<?php }?>
								<label for="check_code" style="text-align:left; margin-bottom:6px;"><span>*</span>Код с картинки</label>
								<input type="text" name="check_code" id="check_code" value="" class="captcha_input req" />
								<a href="javascript:void(null)" style="color: #666;font-size: 12px;text-decoration: none;" onclick="document.getElementById('ChkCodeImg').src = 'check_code.php?'+Math.random();">update image</a>
								<div style="clear:both; margin-top:20px;">
									<input type="checkbox" value="yes" name="dogovor" id="dogovor" checked="checked">
									<p>С условиями приобретения работ согласен.</p>
								</div>

							</td>
						</tr>
					</table>

					
				</div>
				<input type="submit" value="" name="order" onclick="if(checkuserorder()==false) return false;">
			</form>
		</div>
		
		<script type='text/javascript'>
			function CheckItemOrderForm() {
				var result = true;
			
				$('#ItemOrderForm input[type="text"].req').each(function() {
					if ($.trim( $(this).val()) == '') {
							$(this).addClass('has_error');
							$('#span_'+$(this).attr('id')).css("display","inline");
							result = false;
						}
					else 
						{
							$(this).removeClass('has_error');
							$('#span_'+$(this).attr('id')).css("display","none");
						}
				});

				if ($('input[name="dogovor"]:checked').length == 0)	{
					$('input[name="dogovor"]').parent('div').addClass('has_error');
					
					result = false;
				}
				else{
					$('#span_vid_rabot').css("display","none");
					$('input[name="vid"]').parent().parent('div').removeClass('has_error');

				}

				return result;
			}
		</script>
		
	</div>
<?php }?><?php }} ?>