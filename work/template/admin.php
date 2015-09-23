<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<base href="<?=$_conf['base_url'];?>/" /><!--[if IE]></base><![endif]-->
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cash-Control" content="no-cash, must-revalidate" />
	<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251" />
	<meta http-equiv="Content-Language" content="ru" />
	<meta name="Author" content="Volodymyr Demchuk, http://shiftcms.net" />
	<meta name="Copyleft" content="ShiftCMS" />
	<link rel="icon" href="favicon.ico" type="ico" />

	<link rel="stylesheet" href="<?=$_conf['base_url'];?>/template/style.css" type="text/css" />
	<script src="<?=$_conf['base_url'];?>/include/ajax/JsHttpRequest.js" type="text/javascript"></script>
	<script src="<?=$_conf['base_url'];?>/js/func.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="<?=$_conf['base_url'];?>/template/dropdown/pro_dropdown_2.css" />
	<script src="<?=$_conf['base_url'];?>/template/dropdown/stuHover.js" type="text/javascript"></script>

	<link type="text/css" href="<?=$_conf['base_url'];?>/js/jquery/themes/green/jquery.ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="<?=$_conf['base_url'];?>/js/jquery/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?=$_conf['base_url'];?>/js/jquery/jquery-ui-1.8.2.custom.min.js"></script>
    
	<link rel="stylesheet" href="<?=$_conf['base_url'];?>/js/jquery/external/jquery.tooltip.css" type="text/css" />
	<script type="text/javascript" src="<?=$_conf['base_url'];?>/js/jquery/external/jquery.dimensions.js"></script>
	<script type="text/javascript" src="<?=$_conf['base_url'];?>/js/jquery/external/jquery.tooltip.js"></script>

	<link rel="stylesheet" href="<?=$_conf['base_url'];?>/template/dhtmlwindow.css" type="text/css" />
	<script src="<?=$_conf['base_url'];?>/js/c_dhtmlwindow.js" type="text/javascript"></script>

	<link rel="stylesheet" href="<?=$_conf['base_url'];?>/js/calendar.css" type="text/css" />
	<script src="<?=$_conf['base_url'];?>/js/c_calendar.js" type="text/javascript"></script>

	<script type="text/javascript">
		var timerID = null
		var timerRunning = false
		function stopclock(){
		   if(timerRunning) clearInterval(timerID);
			timerRunning = false;
		}
		function startclock(){
	   		timerID = setInterval("Informer()",10000);
		    timerRunning = true;
		}
		function Informer(){
			getdata('','get','?p=alerts','Informer', '<?=$_conf['base_url'];?>');
		}
		$(document).ready(function(){
			$("a").tooltip({showURL: false, fade:150});
			$("span").tooltip({showURL: false, fade:150});
		});//ready function
	</script>

	<title><?=$TITLE;?></title>
	<?=$HEADER;?>
    <? if(isset($show_news_dialog) && $show_news_dialog==true){?>
	<script type="text/javascript">
	$(function() {
		$("#dialog-news").dialog("destroy");
		$("#dialog-news").dialog({
			modal: true,
			height:500,
			width:600,
			position:[200,200],
			show: 'slide',
			zIndex:10000,
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				}
			}
		});
		$( "#dialog-news" ).dialog({
			close: function(event, ui) { $("#newsBlock").css("display","block"); }
			});
		});
	</script>
	<? } ?>
</head>

<body onLoad="startclock();">
<div id="Header">
<ul id="nav">
	<li class="top"><a href="<?=$_conf['base_url'];?>/" id="M1" class="top_link"><span class="down">ГЛАВНАЯ</span></a>
	    <ul class="sub">
        	<li><a href="<?=$_conf['base_url'];?>/?p=user_info">Личная информация</a></li>
			<li><a href="<?=$_conf['base_url'];?>/?p=documents">Документы</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=usermail">Почта</a></li>
        	<!--<li><a href="<?=$_conf['base_url'];?>/?p=reply_from_client">Отзывы от клиентов</a></li>-->
        	<!--<li><a href="<?=$_conf['base_url'];?>/?p=myorders">Мои заказы</a></li>-->
        	<!--<li><a href="<?=$_conf['base_url'];?>/?p=buglist">Bug tracker</a></li>-->
        </ul>
    </li>
    <!--
	<li class="top"><a href="javascript:void(null)" id="M2" class="top_link"><span class="down">ОТДЕЛ ПРИЕМА</span></a>
	    <ul class="sub">
        	<li><a href="<?=$_conf['base_url'];?>/?p=order_create">Оформить заказ</a></li>
        </ul>
    </li>
    -->
	<li class="top"><a href="javascript:void(null)" id="M3" class="top_link"><span class="down">ЗАКАЗЫ</span></a>
	    <ul class="sub">
        	<li><a href="<?=$_conf['base_url'];?>/?p=order_avtor_estimate">Заказы на оценку</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=order_avtor_estres">Оцененные заказы</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=order_avtor_invork">На выполнении</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=order_avtor_towork">На доработке</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=order_avtor_ready">Выполненные заказы</a></li>
        </ul>
    </li>
	<li class="top"><a href="javascript:void(null)" id="M4" class="top_link"><span class="down">ОТЧЁТЫ</span></a>
	    <ul class="sub">
        	<li><a href="<?=$_conf['base_url'];?>/?p=for_pay">Заказы к оплате</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=pay_history">История выплат</a></li>
        	<li><a href="<?=$_conf['base_url'];?>/?p=avtor_grafic">График сдачи</a></li>
        </ul>
    </li>
</ul>
	<div id="Menu">
		<table border='0' cellspacing='0' cellpadding='0' style="padding-top:3px;"><tr>
		<td align="center" width="30" style="padding-left:10px;">
    	<div id="Informer" style='float:left;display:inline;text-align:center;'></div>
        </td>
        <td align="left">
        	<h3 style="display:inline;"><?=$_SESSION['A_USER_LOGIN'];?>:</h3> &nbsp;&nbsp;&nbsp;
          <img src="<?=$_conf['base_url'];?>/template/img/logout.png" style="vertical-align:middle;" alt="Выход" />&nbsp;
          <a href="<?=$_conf['base_url'];?>/logout.php">Выход</a> (<i>Последний визит: <?=date("d.m.Y H:i",$_SESSION['A_USER_LAST_ACCES']);?></i>)</td>
        <td width="50">&nbsp;</td>
	    <td width="30" align="center">
				<a title='Поиск заказов' href='javascript:void(null)' onClick="swin=dhtmlwindow.open('SearchBox', 'inline', '', 'Поиск заказов', 'width=500px, height=200px, left=70px, top=70px, resize=1, scrolling=1'); swin.moveTo('middle', 'middle'); getdata('', 'get', '?p=a_search', 'SearchBox_inner', '<?=$_conf['base_url'];?>'); return false; "><img src='<?=$_conf['base_url'];?>/template/img/search_icon1.png' width='16' height='16' alt='Поиск заказов' /></a>            
        </td>
	    <td width="30" align="center">
				<a title='Почта' href='javascript:void(null)' onClick="calwin=dhtmlwindow.open('OutlookBox', 'inline', '', 'Почта', 'width=790px, height=580px, left=50px, top=70px, resize=1, scrolling=1'); calwin.moveTo('middle', 'middle'); getdata('', 'get', '?p=outlook', 'OutlookBox_inner', '<?=$_conf['base_url'];?>'); return false; "><img src='<?=$_conf['base_url'];?>/template/img/mail_icon1.gif' width='16' height='16' alt='Почта' /></a>            
        </td>
		</tr></table>
	</div>

    <div id="PageTitle">
    	<table border="0" cellspacing="0" cellpadding="0"><tr>
    	<td><div id="aptitle"><h2><?=$PAGETITLE;?></h2></div></td>
        </tr></table>
        <div id="ARC">
        	<div id="ART"><a href="javascript:void(null)" onclick="CloseInfo();"><strong>Закрыть</strong></a></div>
            <div id="ActionRes"></div>
        </div>
    </div>
</div>

<div id="mainContentAdmin">
	<div id="result">
		<?=$PAGE;?>
	</div>
</div>

<br />

</body>
</html>