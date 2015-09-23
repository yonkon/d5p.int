<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 16:36:27
         compiled from "Z:/home/5plus.off/www/tmpl/lite\catalog\order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:460851826bdb5a10d1-70132302%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0ceafd77abd6a22624a9843fdab87e6023806f3' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\catalog\\order.tpl',
      1 => 1367501785,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '460851826bdb5a10d1-70132302',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51826bdb5f22c7_10413520',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51826bdb5f22c7_10413520')) {function content_51826bdb5f22c7_10413520($_smarty_tpl) {?>						<article>
							<h2>Форма заказа:</h2>
								<form method="post" action="/order.htm" id="orderform" name="orderform" enctype="multipart/form-data" onsubmit="return CheckOrderForm();">

								<div class="form-part-wrap">
									<div class="holder">
										<h4>Информация о заказе</h4>
										<div class="f-row">
											<span id="span_o_thema" style=" color: red; font-weight: bold;  display: none;">Введите тему работы</span>
											<span  class="f-label">
												<span style="color: red;">*</span>
												Тема работы:
											</span>
											<textarea name="o_thema" id="o_thema" ></textarea>
										</div>
										<div class="f-row">

											<span id="span_o_course" style=" color: red; font-weight: bold; display: none;">Выберите предмет работы</span>
											<span  class="f-label">
												<span style="color: red;">*</span>
												Предмет работы:
											</span>

											<div class="f-input">
												<select name="o_course" id="o_course" >
													<option value="">- Выберите из списка -</option>
													<option value="135">Анатомия</option>
													<option value="65">Английский язык</option>
													<option value="161">Антикризисное управление</option>
													<option value="126">Аудит</option>
													<option value="105">Аудит, бухгалтерский и управленческий учет</option>
													<option value="74">АХД</option>
													<option value="6">Банковский и инвестиционный менеджмент</option>
													<option value="55">БЖД</option>
													<option value="8">Бухучет, статистика</option>
													<option value="58">Гражданское право</option>
													<option value="54">Делопроизводство</option>
													<option value="137">Деньги, кредит,банки</option>
													<option value="29">Детали машин</option>
													<option value="80">Жилищное право</option>
													<option value="99">Журналистика</option>
													<option value="35">Земельное право</option>
													<option value="149">Инвестиционный менеджмент</option>
													<option value="37">Инвестиция</option>
													<option value="9">Иностранные языки</option>
													<option value="27">Информатика</option>
													<option value="108">История</option>
													<option value="170">Конфликтология</option>
													<option value="57">Криминалистика</option>
													<option value="139">Кулинария</option>
													<option value="120">Культура и искусство</option>
													<option value="44">Культурология</option>
											
												</select>
											</div>

										</div>
										<div class="f-row">

											<span id="span_o_type" style=" color: red; font-weight: bold;  display: none;">Выберите тип работы</span>
											<span  class="f-label">
												<span style="color: red;">*</span>
												Тип работы:
											</span>
											<div class="f-input">
												<select name="o_type" id="o_type" >
													<option value="">- Выберите из списка -</option>
													<option value="10">Бакалавр</option>
													<option value="1">Диплом</option>
													<option value="6">Диплом MBA</option>
													<option value="5">Диссертация</option>
													<option value="11">Доклад</option>
													<option value="9">Другое</option>
													<option value="20">Задачи</option>
													<option value="4">Контрольная</option>
													<option value="2">Курсовая</option>
													<option value="32">Курсовая практическая</option>
													<option value="28">Курсовая теория</option>
													<option value="12">Магистерская</option>
													<option value="13">Ответы на вопросы</option>
									
												</select>
											</div>

										</div>
										<div class="f-row">

											<span id="span_o_client_srok" style=" color: red; font-weight: bold;  display: none;">Выберите срок выполнения работы</span>
											<span  class="f-label">
												<span style="color: red;">*</span>
												Срок выполнения:
											</span>
											<div class="f-input">
												<input type="text" name="o_client_srok" id="o_client_srok" class="class="datetextbox"" ></div>
										</div>
										<div class="f-row">

											<span  class="f-label">
												<span style="color: red;">*</span>
												Объем работы:
											</span>
											<div class="f-input">
												<input type="text" name="o_volume" id="o_volume" value=""
										></div>
										</div>
									</div>
									<div class="holder">
										<h4>Контактная информация:</h4>
										<div class="f-row">
											<span id="span_fio" style=" color: red; font-weight: bold; display: none;">Введите ФИО</span>
											<span  class="f-label">
												<span style="color: red;">*</span>
												ФИО:
											</span>
											<div class="f-input">
												<input type="text"  name="fio" id="fio" value="" ></div>
										</div>

										<div class="f-row">
											<span id="span_email" style=" color: red; font-weight: bold; display: none;">Введите e-mail</span>
											<span id="span_email_error" style=" color: red; font-weight: bold; display: none;">Введите верный e-mail</span>
											<span  class="f-label">
												<span style="color: red;">*</span>
												E-mail:
											</span>
											<div class="f-input">
												<input type="text" name="email" id="email" value="" ></div>
										</div>

										<div class="f-row">
											<span id="span_mphone1" style=" color: red; font-weight: bold; display: none;">
												Warning: Smarty error: unable to read resource: "errorcode.tpl" in /var/www/vhosts/data/www/finzakaz.ru/include/smarty/Smarty.class.php on line 1092
											</span>
											<span  class="f-label">
												Мобильный телефон:
												<br>
												<small>
													на ваш номер будет поступать информация о номере заказа, статусе выполнения
												</small>
											</span>
											<div class="f-input">
												<input type="text" name="mphone1" id="mphone1"  value="" onkeypress="return CheckSymbol(event);" >
											</div>

										</div>

									</div>

									<div class="holder">
										<h4>Загрузить файл(ы):</h4>

									
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
											<span  class="f-label">Тип файла:</span>
											<div class="f-input">
												<select name="f_part" id="f_part">
													<option value="">- Выберите из списка -</option>
													<option value="0" selected="selected">Доп. материалы</option>
													<option value="1">План</option>
												</select>
											</div>
											<br>
											<br>
											<div class="f-input">
												<input type="file"  name="ofile[]" >
												&nbsp;
												<br>

												<div id="AddFile"></div>
												<a href="#" onclick="addFileField('ofile', 'AddFile'); return false;">Добавить ещё один файл</a>
											</div>
										</div>
										<div class="f-row">
											<span  class="f-label">Комментарии к файлу(ам):</span>
											<textarea name="f_comment" id="f_comment"></textarea>
										</div>
									</div>
								</div>

								<div class="form-part-wrap">
									<div class="holder">
										<h4>Дополнительная информация</h4>
									</div>
									<div class="f-row">

										<span  class="f-label">Город:</span>
										<div class="f-input">
											<input type="text" name='o_cc2' id="o_cc2" value="" ></div>
									</div>
									<div style="width:100%; clear:both;"></div>
									<div class="f-row">

										<span  class="f-label">Дополнительные требования:</span>

										<textarea name="o_addinfo" id="o_addinfo"></textarea>

									</div>
									<div style="width:100%; clear:both;"></div>
								</div>

								<div class="form-part-wrap">

									<div class="clearall"></div>

								</div>

								<input type="hidden" name="user" id="user" value="new">

								<div class="form-part-wrap">

									<div>
										<input type="hidden" name="act" id="act" value="parseOrderData">
										<input type="submit" value=" "  class="button"></div>

								</div>
							</form>
							<link rel="stylesheet" type="text/css" href="css/chosen.css">
			  				<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
			  				<link rel="stylesheet" href="css/calendar.css" type="text/css" />
							<script src="js/c_calendar.js" type="text/javascript"></script>
			  
							
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


												
										if ($('#o_course').val() == '') {
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
											

												
										if ($("#o_type").val() == '') {
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
							

						</article>

					</div><?php }} ?>