<?php /* Smarty version Smarty-3.1.8, created on 2013-05-15 13:18:32
         compiled from "/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:757766104518282dda90214-45302343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14e9e0bf130fd8e4419d6c348e0e6cc10dfb2599' => 
    array (
      0 => '/var/www/vhosts/data/www/test1.2foo.ru/tmpl/lite/index.tpl',
      1 => 1368613103,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '757766104518282dda90214-45302343',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_518282ddb271b5_29843407',
  'variables' => 
  array (
    'conf' => 0,
    'TITLE' => 0,
    'DESCRIPTION' => 0,
    'KEYWORDS' => 0,
    'pageType' => 0,
    'uchetResultUserblock' => 0,
    'menu_block' => 0,
    'order' => 0,
    'catalogCategory' => 0,
    'catalogItem' => 0,
    'catalogIndex' => 0,
    'PAGE' => 0,
    'feedback' => 0,
    'feedbackPattern' => 0,
    'distribution' => 0,
    'menu2_block' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518282ddb271b5_29843407')) {function content_518282ddb271b5_29843407($_smarty_tpl) {?><!DOCTYPE html>
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
		
		<link rel="alternate" type="application/rss+xml" title="News RSS" href="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/files/rss/news_<?php echo $_SESSION['lang'];?>
.rss" />
		
		
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
					
						<?php if (isset($_smarty_tpl->tpl_vars['uchetResultUserblock']->value)&&$_smarty_tpl->tpl_vars['uchetResultUserblock']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['uchetResultUserblock']->value;?>
<?php }?>

						<div class="search_form">
							<form method="post" action="?p=search" enctype="multipart/form-data" onsubmit="if(document.getElementById('query').value=='Поиск') document.getElementById('query').value='';">
								<div>
									<input type="submit" name="search" class="tsb" value="">
									<input type="text" name="stext" id="query"  value="Поиск" onblur="if(this.value=='' || this.value=='Поиск') this.value='Поиск';" onfocus="if(this.value=='' || this.value=='Поиск') this.value='';">
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
						<a href="/order/"><div class="order_button"></div></a>
						<div class="slides_wrapper">
							<div id="slides">
								<a href=""><img src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
images/slider/slide1.png"/></a>
								<a href=""><img src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
images/slider/slide2.png"/></a>
								<a href=""><img src="<?php echo $_smarty_tpl->tpl_vars['conf']->value['www_patch'];?>
/<?php echo $_smarty_tpl->tpl_vars['conf']->value['tpl_dir'];?>
images/slider/slide3.png"/></a>
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
					<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='catalogCategory'){?><?php echo $_smarty_tpl->tpl_vars['catalogCategory']->value;?>
<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='catalogItem'){?><?php echo $_smarty_tpl->tpl_vars['catalogItem']->value;?>
<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['pageType']->value=='catalogIndex'){?><?php echo $_smarty_tpl->tpl_vars['catalogIndex']->value;?>
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

								<?php if (isset($_smarty_tpl->tpl_vars['feedback']->value)&&$_smarty_tpl->tpl_vars['feedback']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['feedbackPattern']->value;?>
<?php }?>
								
							</div>
							<?php if (isset($_smarty_tpl->tpl_vars['distribution']->value)&&$_smarty_tpl->tpl_vars['distribution']->value!=''){?><?php echo $_smarty_tpl->tpl_vars['distribution']->value;?>
<?php }?>
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
					<a href="/order/"><div class="order_button"></div></a>
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