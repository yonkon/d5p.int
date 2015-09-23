<?php /* Smarty version Smarty-3.1.8, created on 2013-05-03 14:29:26
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/catalogItem.tpl" */ ?>
<?php /*%%SmartyHeaderCode:109882433251839f96132a85-85913857%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65ad3d9bcb9d877cc737b87e2d074a6e32e44791' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/catalog/catalogItem.tpl',
      1 => 1367507262,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109882433251839f96132a85-85913857',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'conf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51839f9615e008_96248824',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51839f9615e008_96248824')) {function content_51839f9615e008_96248824($_smarty_tpl) {?>						<article>
							<h1>Административная ответственность, как вид юридической ответственности. Административная ответственность за нарушение ПДД.</h1>
							<h2>Содержание:</h2>
							<div class="work_contents">
								<p class="dotted_line">&nbsp;</p>
								<p class="pre">
								4<br/>
								1  Законодательное основание административной ответственности. 7<br/>
								2 Административная ответственность, как вид юридической ответственности. 14<br/>
								2.1  Понятиен принципы юридической ответственности. 14<br/>
								2.2 Понятие административной ответственности. 23<br/>
								3 Меры административной ответственности. 28<br/>
								3.1 Общая характеристика административно-правовой ответственности в сфере безопасности дорожного движения. 28<br/>
								3.2 Особенности производства по делам об административных правонарушениях в области дорожного движения. 33<br/>
								4 Меры административного принуждения в области дорожного движения. 47<br/>
								4.1 Административно- предупредительные меры. 47<br/>
								4.2 Меры административного пресечения. 59<br/>
								4.3. Меры по совершенствованию законодательства в сфере безопасности дорожного движения. 65<br/>
								Выводы и предложения. 67<br/>
								Список использованной литературы. 72<br/>
								Приложения
								</p>
								<div class="item_params">
									<p>Объем работы:<span>52 стр.</span></p>
									<p>Год сдачи:<span>2009</span></p>
									<p>Стоимость:<span>1000 руб.</span></p>
								</div>
								<p class="dotted_line">&nbsp;</p>
							</div>
							<div class="item_order_form">
								<h2>Форма заказа</h2>
								<div class="block_body">
									<form action=""  method="post" onsubmit="return CheckItemOrderForm();" id="ItemOrderForm">
										<input type="hidden" name="act" value="order_work"> 
										<div class="form_side">
											<table>
												<tr>
													<td>
														<span id="span_fio" style=" color: red; font-weight: bold;  display: none; margin-top: -16px;margin-left: 62px; position:absolute;" >Укажите ваши ФИО</span>
														<label for="fio"><span>*</span>ФИО</label>
													</td>
													<td><input type="text" name="fio" id="fio" class="req" value=""/></td>
												</tr>
												<tr>
													<td><label for="phone">Телефон</label></td>
													<td><input type="text" name="phone" id="phone" value=""/></td>
												</tr>
												<tr>
													<td><label for="ainf">Комментарий</label></td>
													<td><textarea name="ainf" id="ainf"></textarea></td>
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
													<td><input type="text" name="email" id="email" value=""  class="req"></td>
												</tr>
												<tr>
													<td><label for="icq">ICQ</label></td>
													<td><input type="text" name="icq" id="icq" value=""></td>

												</tr>
												<tr>
													<td colspan="2">
														<img src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
images/captcha.png" border="0"  alt="Укажите код с картинки" class="captcha_image">
														<span id="span_check_code" style=" color: red; font-weight: bold;  display: none;">Неверный код!</span>
														<label for="check_code" style="text-align:left; margin-bottom:6px;"><span>*</span>Код с картинки</label>
														<input type="text" name="check_code" id="check_code" style="width:60px;" class="captcha_input req" >
														<div style="clear:both; margin-top:20px;">
														<input type="checkbox" value="yes" name="dogovor" id="dogovor" checked="checked">
														<p>С  условиями приобретения работ согласен.</p>
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
							 

						</article>

					</div><?php }} ?>