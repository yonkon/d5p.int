function CheckRegisterAvtorForm() {
	var result = true;
	//логин
	var s = document.avtorform.a_login.value;
	if (s == '') {
		$("#a_login").css("border-color","red");
		$("#span_a_login").css("display","inline");
		result = false;
		}
	else 
		{
		$("#a_login").css("border-color","#959595");
		$("#span_a_login").css("display","none");
		}	
		
	//пароль
	var s = document.avtorform.a_pass.value;
	if (s == '') {
		$("#a_pass").css("border-color","red");
		$("#span_a_pass").css("display","inline");
		result = false;
		}
	else 
		{
		$("#a_pass").css("border-color","#959595");
		$("#span_a_pass").css("display","none");
		}	
		
	//совпадение паролей
	var s = document.avtorform.a_pass.value;
	var s1 = document.avtorform.a_pass1.value;
	if (s1 != s) {
		$("#a_pass1").css("border-color","red");
		$("#span_a_pass1").css("display","inline");
		result = false;
		}
	else 
		{
		$("#a_pass1").css("border-color","#959595");
		$("#span_a_pass1").css("display","none");
		}		
		
	//фио
	var s = document.avtorform.a_fio.value;
	if (s == '') {
		$("#a_fio").css("border-color","red");
		$("#span_a_fio").css("display","inline");
		result = false;
		}
	else 
		{
		$("#a_fio").css("border-color","#959595");
		$("#span_a_fio").css("display","none");
		}	
		
	//мобильный телефон
	var s1 = document.avtorform.a_mphone1.value;
	var s2 = document.avtorform.a_mphone2.value;
	var s3 = document.avtorform.a_mphone3.value;
	if (s1 == '')
		result = show_error_phone();
	else if (s1 == '7') {
		if (s2.length < 3)
			result = show_error_phone();
		else if (s3.length < 7)
			result = show_error_phone();
		else show_ok_phone();
	}
	else if (s1 == '375') {
		if (s2.length < 2)
			result = show_error_phone();
		else if (s3.length < 7)
			result = show_error_phone();
		else show_ok_phone();		
	}	
	else if (s1 == '38') {
		if (s2.length < 3)
			result = show_error_phone();
		else if (s3.length < 7)
			result = show_error_phone();
		else show_ok_phone();		
	}
	else {
		if (s2.length < 2)		
			result = show_error_phone();
		else if (s3.length < 7)
			result = show_error_phone();
		else show_ok_phone();		
	}
		
	//email
	var reg=/^([a-z0-9]+[a-z0-9_\.\-]+)@([a-z0-9]+[a-z0-9\.\-]+)\.([a-z]{2,6})$/i;				
	var s = document.avtorform.a_email.value;
	if (s == '') {
		$("#a_email").css("border-color","red");
		$("#span_a_email_error").css("display","none");
		$("#span_a_email").css("display","inline");
		result = false;
		}
	else if (!(reg.test(s))) {
		$("#a_email").css("border-color","red");
		$("#span_a_email_error").css("display","inline");
		$("#span_a_email").css("display","none");
		result = false;
		}			
	else
		{
		$("#a_email").css("border-color","#959595");
		$("#span_a_email_error").css("display","none");
		$("#span_a_email").css("display","none");
		}			
		
	//capcha
	if(document.avtorform.captcha_code) {		
		var s = document.avtorform.captcha_code.value;
		if (s == '') {
			$("#captcha_code").css("border-color","red");
			$("#span_captcha").css("display","inline");
			result = false;
		}
		else {
			$("#captcha_code").css("border-color","#959595");
			$("#span_captcha").css("display","none");
		}
	}
	return result;
}