<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<base href="{$wwwadres}/admin.php" /><!--[if IE]></base><![endif]-->
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cash-Control" content="no-cash, must-revalidate" />
	<meta http-equiv="Content-Type" content="text/html; charset={$conf.encoding}" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Author" content="Volodymyr Demchuk, http://shiftcms.net" />
	<meta name="Copyleft" content="ShiftCMS" />
	<link rel="icon" href="favicon.ico" type="ico" />

	<link rel="StyleSheet" href="{$wwwadres}/{$conf.admin_tpl_dir}css/bw.css" type="text/css" />
	<link type="text/css" href="{$wwwadres}/js/jquery/themes/ui-lightness/jquery.ui.all.css" rel="stylesheet" />
	<script src="{$wwwadres}/js/admin_func.js" type="text/javascript"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/ui/minified/jquery.ui.core.min.js"></script>
	<script type="text/javascript" src="{$wwwadres}/js/jquery/ui/minified/jquery.ui.widget.min.js"></script>
    
	<title>{$TITLE}</title>
	{$HEADER}

</head>

<body>
<div id="mainContentAdmin_free">
	<div id="result">
		{$PAGE}
	</div>
</div>

<br />
{if $debug == true}
<hr />
<strong>DEBUG INFO:</strong>
<div id="debug" style='border:solid 1px red; padding:3px; background:#F8F1DE;'></div>
{/if}
</body>
</html>