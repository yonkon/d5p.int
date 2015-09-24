/**
* Загрузка аттачмента на сервер
*/
function UpLoadAttach(formid, formareaid){
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
	var free = "-";
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact1=UploadAttachment',
        {
             'form': document.getElementById(formid),
			 'mailact':free
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById(formareaid).innerHTML = result['successmsg'];
					document.getElementById('AFiles').innerHTML = document.getElementById('AFiles').innerHTML+' '+result['fileinfo'];
                }
        },
        true  // do not disable caching
    );
}
/**
* Удаляем временный аттачмент
*/
function DelTmpAttach(formareaid, filename, id){
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact1=DelTmpAttach',
        {
             'file': filename
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById(formareaid).innerHTML = result['successmsg'];
					delelem(id);
                }
        },
        true  // do not disable caching
    );
}

/**
* Отправка сообщения
*/
function SendMessage(formid, formareaid, idma){
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact=SendMsg&idma='+idma,
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					//alert(result['state']);
					if(result['state']=="ERROR"){
						document.getElementById(formareaid).innerHTML = result['msg'];
					}else{
						document.getElementById(formareaid).innerHTML = result['msg'];
						document.getElementById('MainFormMsg').innerHTML = '';
						ReCount(result['countmsg'], idma);
					}
                }
        },
        true  // do not disable caching
    );
}

/**
* Смена количества писем в левой панели
*/
function ReCount(items, idma){
	document.getElementById('ACount_'+idma).innerHTML = items['all'];
	document.getElementById('ICount_'+idma).innerHTML = items['inb'];
	document.getElementById('NCount_'+idma).innerHTML = items['new'];
	document.getElementById('SCount_'+idma).innerHTML = items['out'];
	document.getElementById('TCount_'+idma).innerHTML = items['trash'];
}

function DeleteMessage(mailact, idm, idma){
	document.getElementById('OMSGBlock').innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook',
        {
             'mailact': mailact,
			 'idm': idm,
			 'idma':idma
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById('OMSGBlock').innerHTML = result['msg'];
					delelem('tr'+idm); 
					ReCount(result['countmsg'], idma);
                }
        },
        true  // do not disable caching
    );
}
/**
* Очистка корзины
*/
function EmptyTrash(idma){
	document.getElementById('OMSGBlock').innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" /> Очистка корзины...';
    JsHttpRequest.query(
        'loader.php?p=outlook',
        {
             'mailact': 'EmptyTrash',
			 'idma' : idma
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById('OMSGBlock').innerHTML = result['msg'];
					getdata('','post','?p=outlook&mailact=LoadMailList&folder=trash&outpage=page&idma='+idma,'OMailList'); 
					ReCount(result['countmsg'],idma);
					/*document.getElementById('OMessageArea').innerHTML = '';*/
					//document.getElementById('TCount').innerHTML = '0';
                }
        },
        true  // do not disable caching
    );
}
/** 
* Массовое удаление выбранных писем
*/
function DeleteSelectedMessages(){
	var classname = "CHM";
	var idma = document.getElementById('CURRENT_IDMA').value;
	var obj = getElementsByClass(classname,null,'input');
	var items = 0;
	for(i=0;i<obj.length;i++){
		if(obj[i].checked == true){
				document.getElementById('OMSGBlock').innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" /> Удаляем выбранные сообщения...';
				//alert(obj[i].value);
				DeleteMessage("DeleteMessage",obj[i].value, idma);
				items++;
		}
	}
	if(items == 0) alert("Вы не выбрали ни одного сообщения для удаления!");
}
/**
* Вывод формы написания ответа на выбранное сообщение
*/
function ReplyForward(type, idma){
	var classname = "CHM";
	var idma = document.getElementById('CURRENT_IDMA').value;
	var obj = getElementsByClass(classname,null,'input');
	var items = 0; 
	for(i=0;i<obj.length;i++){
		if(obj[i].checked == true){
				var id = obj[i].value;
				items++;
		}
	}
	if(items != 1) {
			alert("Отметьте одно сообщение для написания ответа или пересылки!");
			return
	}else{
		owin=dhtmlwindow.open('WriteFormBox', 'inline', '', 'Ответить на сообщение', 'width=800px,height=550px,left=50px,top=70px,resize=1,scrolling=1'); 
		owin.moveTo('middle','middle'); 
		getdata('','get','?p=outlook&type='+type+'&mailact=WriteForm&idm='+id+'&idma='+idma,'WriteFormBox_inner'); 
		return true;
	}
}

/**
* Вывод письма для чтения
*/
function ReadMessage(idm){
	var idma = document.getElementById('CURRENT_IDMA').value;
	rwin=dhtmlwindow.open('ReadMailBox', 'inline', '', 'Чтение письма', 'width=800px,height=500px,left=50px,top=70px,resize=1,scrolling=1'); 
	rwin.moveTo('middle','middle'); 
	getdata('','get','?p=outlook&mailact=LoadMessageForRead&idm='+idm+'&idma='+idma,'ReadMailBox_inner');
}

/**
* Выбор всех сообщений
*/
function CheckAllMsg(classname, cur){
	var obj = getElementsByClass(classname,null,'input');
	var curch = cur.checked;
	for(i=0;i<obj.length;i++){
		if(curch == true){
			obj[i].checked = true;
			document.getElementById('tr'+obj[i].value).className = 'Omainsel';
		}else{
			obj[i].checked = false;
			document.getElementById('tr'+obj[i].value).className = 'Orow1 Omainbody';
		}
	}	
}

/**
* Сохраняем настройки почтового аккаунта пользователя
*/
function SaveUserSet(formid,msgarea){
	document.getElementById(msgarea).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact=SaveUSet',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById(msgarea).innerHTML = result['msg'];
                }
        },
        true  // do not disable caching
    );
}

/**
* Сохраняем настройки почтового аккаунта пользователя
*/
function SaveUserSet1(formid,msgarea){
	document.getElementById(msgarea).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact=SaveUSet1',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById(msgarea).innerHTML = result['msg'];
                }
        },
        true  // do not disable caching
    );
}
/**
 * Update "Port" textbox at login page.
 */
function updateLoginPort() {
	var option = document.getElementById('mailtls').value;
  if (option == 'imap' || option == 'notls') {
    document.getElementById('port').value = 143;
  }
  else if (option == 'ssl' || option == 'ssl/novalidate-cert') {
    document.getElementById('port').value = 993;
  }
  else if (option == 'pop3' || option == 'pop3/notls') {
    document.getElementById('port').value = 110;
  }
  else if (option == 'pop3/ssl' || option == 'pop3/ssl/novalidate-cert') {
    document.getElementById('port').value = 995;
  }
}

/**
* Поиск по контактам и вывод результата
*/
function SearchInContact(str){
	//document.getElementById(msgarea).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact=SearchInContact',
        {
             'str': str
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById('ContactArea').innerHTML = result['msg'];
                }
        },
        true  // do not disable caching
    );
}

/**
* Фильтр выбора сообщений имеющих отношение к определенному заказу
*/
function LoadIdoMessages(ido){
	//document.getElementById(msgarea).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook&mailact=SearchInContact',
        {
             'str': str
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById('ContactArea').innerHTML = result['msg'];
                }
        },
        true  // do not disable caching
    );
}


/**
* Check for new mail for selected account
*/
function CheckNewMail(idma){
	document.getElementById('OMSGBlock').innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" /> Проверяем почту...';
    JsHttpRequest.query(
        'loader.php?p=outlook',
        {
             'mailact': "CheckNewMail",
			 'idma':idma
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById('OMSGBlock').innerHTML = result['msg'];
					ReCount(result['countmsg'], idma);
					getdata('','post','?p=outlook&mailact=LoadMailList&folder=inbox&outpage=page&idma='+idma,'OMailList'); 
					document.getElementById('CURRENT_IDMA').value = idma;
                }
        },
        true  // do not disable caching
    );
}

function LoadUserContact(idu){
	document.getElementById('AllUserMail').innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        'loader.php?p=outlook',
        {
             'mailact': "LoadUserContact",
			 'idu':idu
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					document.getElementById('AllUserMail').innerHTML = result['mails'];
                }
        },
        true  // do not disable caching
    );
}


function ApplayFilter(){
	var curfolder = document.getElementById('CurFolder').value;
	var idma = document.getElementById('CURRENT_IDMA').value;
	var obj = getElementsByClass('filter',null,'input');
	var query = '';
	for(i=0;i<obj.length;i++){
		//alert(obj[i].id+'='+obj[i].value+' type='+obj[i].type);
		if(obj[i].value!='' && obj[i].type=="text") query = query+'&'+obj[i].id+'='+obj[i].value;
		if(obj[i].type=="radio" && obj[i].checked==true) query = query+'&'+obj[i].name+'='+obj[i].value;
	}	
	getdata('','post','?p=outlook&mailact=LoadMailList&folder='+curfolder+'&outpage=page&idma='+idma+query,'OMailList');
}

function LoadMailList(folder, outpage, idma){
	var obj = getElementsByClass('filter',null,'input');
	var query = '';
	for(i=0;i<obj.length;i++){
		//alert(obj[i].id+'='+obj[i].value+' type='+obj[i].type);
		if(obj[i].value!='' && obj[i].type=="text") query = query+'&'+obj[i].id+'='+obj[i].value;
		if(obj[i].type=="radio" && obj[i].checked==true) query = query+'&'+obj[i].name+'='+obj[i].value;
	}	

    JsHttpRequest.query(
        'loader.php?p=outlook'+query,
        {
             'mailact': "UpdateMessageCount",
			 'idma':idma
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug2").innerHTML = errors; 
                // Write the answer.
                if(result){
					ReCount(result['countmsg'],idma);
                }
        },
        true  // do not disable caching
    );

	getdata('','post','?p=outlook&mailact=LoadMailList&folder='+folder+'&outpage='+outpage+'&idma='+idma+query,'OMailList'); 
	document.getElementById('CURRENT_IDMA').value = idma;
}