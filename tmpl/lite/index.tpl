<!DOCTYPE html>
<html lang="{$smarty.session.lang}">
	<head>
		<base href="{$conf.www_patch}/" /><!--[if IE]></base><![endif]-->
		<!--[if lt IE 9]>
			<script src="{$conf.www_patch}js/html5shiv.js" media="all"></script>
			<script src="{$conf.www_patch}js/html5shiv-printshiv.js" media="print"></script>
		<![endif]-->

		<meta charset="{$conf.encoding}" />
		
		<link rel="alternate" type="application/rss+xml" title="News RSS" href="{$conf.www_patch}/files/rss/news_{$smarty.session.lang}.rss" />
		
		
		<title>{$TITLE}</title>
		<meta name="description" content="{$DESCRIPTION}" />
		<meta name="keywords" content="{$KEYWORDS}" /> 
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="stylesheet" href="{$conf.www_patch}/{$conf.tpl_dir}css/styles.css"/>

		<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="{$conf.www_patch}js/jquery-1.9.1.min.js"><\/script>')</script>-->
		<script src="{$conf.www_patch}/js/jquery-1.9.1.min.js"></script>
		<script src="{$conf.www_patch}/js/jquery.slides.min.js"></script>
		<script src="{$conf.www_patch}/js/page.js"></script>

		<!--[if lt IE 9]>

		<script src="{$conf.www_patch}/js/PIE.js"  type="text/javascript"></script>
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
		<link href="{$conf.www_patch}/{$conf.tpl_dir}css/styles_lt_ie9.css" rel="stylesheet" type="text/css" />
		<![endif]-->

	</head>

	<body {if isset($pageType)}class="slider_off"{/if}>
		<header  role="banner">
		<div class="header_wrap">
			<div class="row container">
				<div class="col span_5">
					<a href="/" class="logo">Информационно-образовательная компания «5 с плюсом»</a>
				</div>
				<div class="col span_7">
					<div class="search_block">
					
						{if isset($uchetResultUserblock) && $uchetResultUserblock!=""}{$uchetResultUserblock}{/if}

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
						{if isset($menu_block) && $menu_block!=""}{$menu_block}{/if}
					</nav>

				</div>

			</div>
		</div>
		</header>
		<div class="slider_wrap">
			<div class="slider_pattern"></div>
			{if !isset($pageType)}
				<div class="compozition">
					<div class="row container">
						<a href="/order/"><div class="order_button"></div></a>
						<div class="slides_wrapper">
							<div id="slides">
								<a href=""><img src="{$conf.www_patch}/{$conf.tpl_dir}images/slider/slide1.png"/></a>
								<a href=""><img src="{$conf.www_patch}/{$conf.tpl_dir}images/slider/slide2.png"/></a>
								<a href=""><img src="{$conf.www_patch}/{$conf.tpl_dir}images/slider/slide3.png"/></a>
							</div>
						</div>
					</div>
				</div>
			{/if}	
		</div>
		<div class="content_wrap">
			<div class="row container clip_area">
				<div class="textarea_back">&nbsp;</div>
			</div>
			<section  role="main">
				<div class="row container text_area">
					<div class="col span_8">

					<!-- CONTENT -->
					{if $pageType == 'order'}{$order}{/if}
					{if $pageType == 'catalogCategory'}{$catalogCategory}{/if}
					{if $pageType == 'catalogItem'}{$catalogItem}{/if}
					{if $pageType == 'catalogIndex'}{$catalogIndex}{/if}
					
					{if !isset($pageType)}
						<article>
							{$PAGE}
						</article>
					</div>
					{/if}
					<!-- /CONTENT -->

					<div class="col span_4 rightside">
						<aside>
							<div class="side_block">
								<a href="/?p=mikronaushnik" class="earphones">Микронаушники</a>
							</div>
							<div class="side_block">

								{if isset($feedback) && $feedback!=""}{$feedbackPattern}{/if}
								
							</div>
							{if isset($distribution) && $distribution!=""}{$distribution}{/if}
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

						{if isset($menu2_block) && $menu2_block!=""}{$menu2_block}{/if}
					
					</nav>
					<p style="text-align:right; margin-top:18px;"><a href="http://2foo.ru/" target="_blank" style=" font-size:13px;">Создание сайтов</a></p>
					<div class="counter">
						<!--LiveInternet counter--><script type="text/javascript"><!--

						document.write("<a href='http://www.liveinternet.ru/click' "+

						"target=_blank><img src='//counter.yadro.ru/hit?t17.2;r"+

						escape(document.referrer)+((typeof(screen)=="undefined")?"":

						";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?

						screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+

						";"+Math.random()+

						"' alt='' title='LiveInternet: показано число просмотров за 24"+

						" часа, посетителей за 24 часа и за сегодня' "+

						"border='0' width='88' height='31'><\/a>")

						//--></script><!--/LiveInternet-->
					</div>
					<style type="text/css">
						.counter{
							position: absolute;
							overflow: hidden;
							margin-top: -8px;
						}
						.counter a{
							border: 0;
						}
					</style>
				</footer>
			</div>
		</div>

	</body>
</html>