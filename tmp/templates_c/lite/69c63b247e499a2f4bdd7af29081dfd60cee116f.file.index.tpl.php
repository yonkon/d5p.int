<?php /* Smarty version Smarty-3.1.8, created on 2013-05-02 16:42:13
         compiled from "Z:/home/5plus.off/www/tmpl/lite\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2523851825dd05cd4b8-66291798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69c63b247e499a2f4bdd7af29081dfd60cee116f' => 
    array (
      0 => 'Z:/home/5plus.off/www/tmpl/lite\\index.tpl',
      1 => 1367502129,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2523851825dd05cd4b8-66291798',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_51825dd0705b29_55682974',
  'variables' => 
  array (
    'conf' => 0,
    'TITLE' => 0,
    'DESCRIPTION' => 0,
    'KEYWORDS' => 0,
    'pageType' => 0,
    'menu_block' => 0,
    'order' => 0,
    'category' => 0,
    'item' => 0,
    'PAGE' => 0,
    'menu2_block' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51825dd0705b29_55682974')) {function content_51825dd0705b29_55682974($_smarty_tpl) {?><!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'];?>
">
	<head>
		<base href="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/" /><!--[if IE]></base><![endif]-->
		<!--[if lt IE 9]>
			<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
js/html5shiv.js" media="all"></script>
			<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
js/html5shiv-printshiv.js" media="print"></script>
		<![endif]-->

		<meta charset="<?php echo $_smarty_tpl->tpl_vars['conf']->value['encoding'];?>
" />
		<meta name="Generator" content="ShiftCMS.NET" />
		<link rel="alternate" type="application/rss+xml" title="News RSS" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/files/rss/news_<?php echo $_SESSION['lang'];?>
.rss" />
		<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/include/ajax/JsHttpRequest.js" type="text/javascript"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/js/func.js" type="text/javascript"></script>
		
		<title><?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
</title>
		<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['DESCRIPTION']->value;?>
" />
		<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['KEYWORDS']->value;?>
" /> 
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
css/styles.css"/>

		<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
js/jquery-1.9.1.min.js"><\/script>')</script>-->
		<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/js/jquery-1.9.1.min.js"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/js/jquery.slides.min.js"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/js/page.js"></script>

		<!--[if lt IE 9]>

		<script src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/js/PIE.js"  type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				
				
				$('.text_area h1').each(function() {
					PIE.attach(this);
				});
				$('.feedback input[type="text"]').each(function() {
					PIE.attach(this);
				});
				$('.feedback textarea').each(function() {
					PIE.attach(this);
				});
				$('.main_navigation .current a').each(function() {
					PIE.attach(this);
				});
				$('.slides_wrapper').each(function() {
					PIE.attach(this);
				});
				$('.slides_wrapper img').each(function() {
					PIE.attach(this);
				});
				$('.text_area h1').each(function() {
					PIE.attach(this);
				});
				$('header nav ul').each(function() {
					PIE.attach(this);
				});

				$('.block_body').each(function() {
					PIE.attach(this);
				});
				$('.subscribe input[type="text"]').each(function(){
					PIE.attach(this);
				});
				$('.item_order_form .block_body').each(function(){
					PIE.attach(this);
				});
			//end of doc.ready				
			});
		</script>
		<link href="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
css/styles_lt_ie9.css" rel="stylesheet" type="text/css" />
		<![endif]-->

	</head>

	<body <?php if (isset($_smarty_tpl->tpl_vars['pageType']->value)){?>class="slider_off"<?php }?>>
		<header  role="banner">
		<div class="header_wrap">
				<div class="row container">
					<div class="col span_5">
						<a href="/" class="logo">Информационно-образовательная компания «5 с плюсом»</a>
					</div>
					<div class="col span_7">
						<div class="search_block">
							<div class="enter_block">
								  
									<form method="post" action="/" id="U_LoginForm">
										<input type="hidden" name="u_method" id="u_method" value="authorize">
										<table border="0" cellspacing="0" class="FormTab">
											<tr>
												<td  colspan="2">
													<label for="u_login"><strong>Логин</strong></label>
												</td>
											</tr><tr>
												<td  colspan="2">
													<input type="text" name="u_login" id="u_login" value="">
												</td>
											</tr>
											<tr>
												<td  colspan="2">
													<label for="password"><strong>Пароль</strong></label>
												</td>
											</tr><tr>
												<td  colspan="2">
													<input type="password" name="u_pass" id="u_pass" value="">
												</td>
											</tr>
											<tr>
												<td  class="padded">
													<input type="checkbox" name="u_long" id="u_long" value="yes">
													<label for="u_long" class="black_label">Запомнить</label>
													
												</td>
												<td>
													<input type="image" id="AUTH" name="AUTH" src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
images/userbutton.png">
												</td>	
											</tr><tr>
												<td colspan="2" class="padded">
													
														<a href="http://minskdiplom.by/cabinet/page/recover/"  class="black_label">Забыли пароль?</a>
												</td>
												</tr><tr>	
											
												<td colspan="2" class="padded"> 
													
													<a href="/avtors/" class="avtors">Вход для авторов</a>
												</td>
											</tr>
											
										</table>
									</form>
									<div class="clearall">
										
									</div>
								
							</div>
							<p><a href="#enter" class="enter_block_call">Вход</a>&nbsp;|&nbsp;<a href="#register">Регистрация</a> </p>
							<div class="search_form">
								<form method="get" action="/poisk/" onsubmit="if(document.getElementById('query').value=='Поиск') document.getElementById('query').value='';">
									<div>
										<input type="submit" name="search" class="tsb" value="">
										<input type="text" name="search" id="query"  value="Поиск" onblur="if(this.value=='' || this.value=='Поиск') this.value='Поиск';" onfocus="if(this.value=='' || this.value=='Поиск') this.value='';">
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="logo_back">&nbsp;</div>
					
					
					<div class="main_navigation">
						<nav  role="navigation">
							<?php if (isset($_smarty_tpl->tpl_vars['menu_block']->value)&&$_smarty_tpl->tpl_vars['menu_block']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['menu_block']->value;?>
<?php }?>
						</nav>

					</div>

				</div>
		</div>
		</header>
		<div class="slider_wrap">
			<div class="slider_pattern"></div>
			<?php if (!isset($_smarty_tpl->tpl_vars['pageType']->value)){?>
				<div class="compozition">
					<div class="row container">
						<div class="order_button">&nbsp;</div>
						<div class="slides_wrapper">
							<div id="slides">
								<a href=""><img src="http://placehold.it/546x196"></a>
								<a href=""><img src="http://placehold.it/546x196"></a>
								<a href=""><img src="http://placehold.it/546x196"></a>
								<a href=""><img src="http://placehold.it/546x196"></a>
								<a href=""><img src="http://placehold.it/546x196"></a>
							</div>
						</div>
					</div>
				</div>
			<?php }?>	
		</div>
		<div class="content_wrap">
			<div class="row container clip_area">
				<div class="textarea_back">&nbsp;</div>
			</div>
			<section  role="main">
				<div class="row container text_area">
					<div class="col span_8">

		<!-- CONTENT -->
			<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='order'){?><?php echo $_smarty_tpl->tpl_vars['order']->value;?>
<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='category'){?><?php echo $_smarty_tpl->tpl_vars['category']->value;?>
<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='item'){?><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
<?php }?>
			
			<?php if (!isset($_smarty_tpl->tpl_vars['pageType']->value)){?>
					<article>
						<?php echo $_smarty_tpl->tpl_vars['PAGE']->value;?>

					</article>
				</div>
			<?php }?>
		<!-- /CONTENT -->

					<div class="col span_4 rightside">
						<aside>
							<div class="side_block">
								<a href="" class="earphones">Микронаушники</a>
							</div>
							<div class="side_block">
								<h3>Форма обратной связи</h3>
								<div class="block_body feedback">
									<form id="form_feedback" action="" method="post">
									<table>
									<tr>
										<td>
											<label for="fio">Ф.И.О</label>
										</td>
										<td>
											<input type="text" id="fio" name="fio">
										</td>
									</tr>
									<tr>
										<td>
											<label for="phone">Телефон</label>
										</td>
										<td>
											<input type="text" id="phone" name="phone">
										</td>
									</tr>
									<tr>
										<td>
											<label for="email">E-mail</label>
										</td>
										<td>
											<input type="text" id="email" name="email">
										</td>
									</tr>
									<tr>
										<td>
											<label for="coment">Комментарий</label>
										</td>
										<td>
											<textarea id="coment" name="coment"></textarea>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" value="">
										</td>
									</tr>
									</table>
									</form>
								</div>
							</div>
							<div class="side_block">
								<h3>Подписаться на рассылку:</h3>
								<div class="block_body subscribe">
									<form action="" method="post">
										<table>
											<tr>
												<td><label for="subscribe_text">E-mail</label></td>
												<td><input type="text" id="subscribe_text"></td>
											</tr>
											<tr>
												<td colspan="2">
													<input type="submit" value=" ">
												</td>
											</tr>
										</table>

									</form>
								</div>
							</div>
						</aside>
					</div>
					
				</div>
			</section>
		</div>
		<div class="line_wrap">
			<!-- <div class="line_left"></div> -->
			<div class="line_right">&nbsp;</div>
			<div class="container line_head">
				&nbsp;
			</div>
			<div class="container row">
				<div class="col span_9">
					<div class="footer_compozition">&nbsp;</div>
				</div>
				<div class="col span_3">
					<div class="order_button">&nbsp;</div>
				</div>
			</div>

		</div>
		<div class="footer_wrap">
			<div class="row container">
				<footer role="contentinfo">
					<nav>

						<?php if (isset($_smarty_tpl->tpl_vars['menu2_block']->value)&&$_smarty_tpl->tpl_vars['menu2_block']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['menu2_block']->value;?>
<?php }?>
					
					</nav>
					<p style="text-align:right; margin-top:18px;"><a href="http://2foo.ru/" target="_blank" style=" font-size:13px;">Создание сайтов</a></p>
				</footer>
			</div>
		</div>

	</body>
</html><?php }} ?>