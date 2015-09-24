<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="/" /><!--[if IE]></base><![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta http-equiv="Content-Language" content="ru-RU" />
<meta name="Author" content="Volodymyr Demchuk, http://shiftcms.net" />
<meta name="Copyleft" content="ShiftCMS" />
<title>���� � ������� �����</title>
<meta name="Description" content="���� � ������� �����" />
<meta name="keywords" content="���� � ������� �����" />
<script src="<?=$_conf['base_url'];?>/js/func.js" type="text/javascript"></script>
<link href="<?=$_conf['base_url'];?>/template/style.css" rel="stylesheet" type="text/css" />
</head>

<body class="authbody">

<div id="authcontainer">
	<div id="authcontent">
		<div>
			<h1>������� �����</h1>
			<p>��� ����� � ������� ������� ���� ����� � ������.</p><br />
			<? if(isset($error)){?><div style="border:dashed 1px #cc0000; padding:5px; color:#cc0000;"><?=$error;?></div><br /><br /><? } ?>
			<? if(isset($infomsg)){?><div style="border:dashed 1px blue; padding:5px; color:blue;"><?=$infomsg;?></div><br /><br /><? } ?>
			<form method="post" action="<?=$_conf['base_url'];?>/" id="LogForm"> 
				<input type="hidden" name="act" id="act" value="authorize"/>
				<label for="login"><strong>�����:</strong></label><br />
				<input type="text" name="login" id="login" style="width:150px;" value="" /><br />
				<label for="password"><strong>������:</strong></label><br />
				<input type="password" name="password" style="width:150px;" id="password" value="" /><br /><br />
				<input type="checkbox" name="authperiod" id="authperiod" value="yes" />
				<label for="authperiod">���������</label> <br /><br />
				<input type="submit" id="AUTH" name="AUTH" value="����" style="width:150px;"  /><br /><br />
	          	<a href="javascript:void(null)" id="forgotpsswd" onclick="SwitchShow('ForgotArea')">������ ������?</a>
			</form>
		</div>
        <br />
        <div id="ForgotArea" style="display:none; border-top:solid 1px #666;">
        	<h2>������������ ������</h2>
			<form action="<?=$_conf['base_url'];?>/" method="post">
				<input type="hidden" name="act" id="act" value="restorePass"/>
				<label for="email"><strong>��� E-mail:</strong></label><br />
				<input type="text" name="email" id="email" style="width:200px;" /><br />
				<img src="<?=$_conf['base_url'];?>/check_code.php" border="0" vspace="1" hspace="1" id="ChkCodeImg" style="vertical-align:middle;"/><br />
                <small><a href="javascript:void(null)" onclick="document.getElementById('ChkCodeImg').src = '<?=$_conf['base_url'];?>/check_code.php?'+Math.random();">�������� ��������</a></small><br />
				<label for="check_code"><strong>��� � ��������:</strong></label><br />
				<input type="text" name="check_code" id="check_code" style="width:100px; text-align:center;" /><br /><br />
				<input type="submit" value="������������ ������"/>
			</form>
        </div>
	</div>
</div>

</body>
</html>