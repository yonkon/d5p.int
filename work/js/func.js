function getdata(loader, method, data, reptag, base) {
    if(reptag==null) reptag='result';
	if(reptag=="ActionRes") document.getElementById('ARC').style.display='block';
    document.getElementById(reptag).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
        var req = new JsHttpRequest();
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.responseJS) {
                    document.getElementById(reptag).innerHTML =req.responseText;
					runScripts(document.getElementById(reptag).getElementsByTagName('SCRIPT'));
                }
            }
        }
        req.caching = false;
        req.loader = loader;
        req.open(method, base+'/index.php'+data, true);
        var data = {
            q: data
        };
        req.send(data);
    }
//----------------------------------------------------------------------
function doLoad(fid,did,base) {
	if(did=="ActionRes") document.getElementById('ARC').style.display='block';
    document.getElementById(did).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle;" />';
    var req = new JsHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            document.getElementById(did).innerHTML = req.responseText;
			runScripts(document.getElementById(did).getElementsByTagName('SCRIPT'));
        }
    }
    req.open(null, base+'/index.php', true);
    req.send( { 'form': document.getElementById(fid) } );
}
//------------------------------------------------------------
function checkLen1(StrId,StrLen,StrMsg){
var str = document.getElementById(StrId).value;
var len = str.length;
var fullLen = StrLen - len;
var count0 = "<br>Текст не может быть длиннее, чем ";
  if ( StrLen < len){ document.getElementById(StrId).value = str.substring(0,StrLen);}
if(len<(StrLen-1)) {document.getElementById(StrMsg).innerHTML = 'Осталось: ' + fullLen;}
else {document.getElementById(StrMsg).innerHTML = count0 + StrLen + ' символов!';}
}

/* Функция активации скрипта вызванного через свойство innerHTML */
function runScripts(scripts) {
    if (!scripts) return false;
    for (var i = 0; i < scripts.length; i++) {
        var thisScript = scripts[i];   
        var text;
        if (thisScript.src) {
            var newScript = document.createElement("script");
            newScript.type = thisScript.type;       
            newScript.language = thisScript.language;
            newScript.src = thisScript.src;             
            document.body.appendChild(newScript);   
        } else if (text = (thisScript.text || thisScript.innerHTML)) {
            var text = (""+text).replace(/^\s*<!\-\-/, '').replace(/\-\->\s*$/, '');
            eval(text);
        }
    }
}

/* **************************************************************** */
function HideObject(fid){
	document.getElementById(fid).style.display='none';	
}

function ShowObject(id){
	document.getElementById(id).style.display='block';		
}

function getElementsByClass(searchClass,node,tag) {
	var classElements = new Array();
	if ( node == null )
		node = document;
	if ( tag == null )
		tag = '*';
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}


function setall(classname){
	var obj = getElementsByClass(classname,null,'input');
	for(i=0;i<obj.length;i++){
		if(obj[i].checked == true) obj[i].checked = false;
		else obj[i].checked = true;
	}	
}

function SwitchShow(id){
	if(document.getElementById(id).style.display == 'none')
		document.getElementById(id).style.display = 'block';
	else
		document.getElementById(id).style.display = 'none';
}

function delelem(a) {
	// Получаем доступ к ДИВу, содержащему поле
	var contDiv = document.getElementById(a);
	// Удаляем этот ДИВ из DOM-дерева
	contDiv.parentNode.removeChild(contDiv);
}

function ShowDebug(dcontent){
		document.getElementById('debug').innerHTML = dcontent;
}


function ChangeSelDate(obj){
	var obj1 = getElementsByClass('seld',null,'a');
	for(i=0;i<obj1.length;i++) obj1[i].className = 'cur';
	obj.className = "seld";
}

function SaveOwnData(formid,base){
    JsHttpRequest.query(
        base+'/?p=functions&act=SaveOwnData',
        {
            'form': document.getElementById(formid)
        },
        function(result, errors){
            if(result) alert(result['msg']); 
        },
        true
    );
}

function CloseInfo(){
	document.getElementById('ActionRes').innerHTML='';
	document.getElementById('ARC').style.display='none';
}

function ShowChecked(obj,dest){
	if(obj.checked==true){
		var str = document.getElementById('V_'+obj.value).innerHTML;
		if(document.getElementById(dest).innerHTML != '') var app = ', ';
		else var app = '';
		document.getElementById('ShowBox').innerHTML += '<span id="Item_'+obj.value+'">'+app+str+'</span>';
	}else{
		delelem('Item_'+obj.value);
	}
}
function addFileField(namefield, parent){
		var div = document.createElement("div");
		div.innerHTML = "<input name=\"" + namefield + "[]\" type=\"file\" style=\"width:250px\" /> &nbsp; <input type=\"button\" onclick=\"return deleteField(this)\" value=\" - \">";
		document.getElementById(parent).appendChild(div);
}

function deleteField(a) {
	var contDiv = a.parentNode;
	contDiv.parentNode.removeChild(contDiv);
}



/**
* Загрузка аттачмента на сервер
*/
function UpLoadAttach(formid, formareaid, base){
	document.getElementById(formareaid).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
	var free = "-";
    JsHttpRequest.query(
        base+'/?p=outlook&mailact1=UploadAttachment&mailact='+free,
        {
             'form': document.getElementById(formid),
			 'mailact':free
        },
        function(result, errors){
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
function DelTmpAttach(formareaid, filename, id, base){
	document.getElementById(formareaid).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact1=DelTmpAttach&file='+filename,
        {
             'file': filename
        },
        function(result, errors){
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
function SendMessage(formid, formareaid, idma, base){
	document.getElementById(formareaid).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=SendMsg&idma='+idma,
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                if(result){
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

function DeleteMessage(mailact, idm, idma, base){
	document.getElementById('OMSGBlock').innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact='+mailact+'&idm='+idm+'&idma='+idma,
        {
             'mailact': mailact,
			 'idm': idm,
			 'idma':idma
        },
        function(result, errors){
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
function EmptyTrash(idma, base){
	document.getElementById('OMSGBlock').innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" /> Очистка корзины...';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=EmptyTrash&idma='+idma,
        {
             'mailact': 'EmptyTrash',
			 'idma' : idma
        },
        function(result, errors){
                if(result){
					document.getElementById('OMSGBlock').innerHTML = result['msg'];
					getdata('','post', '?p=outlook&mailact=LoadMailList&folder=trash&outpage=page&idma='+idma,'OMailList', base); 
					ReCount(result['countmsg'],idma);
                }
        },
        true
    );
}
/** 
* Массовое удаление выбранных писем
*/
function DeleteSelectedMessages(base){
	var classname = "CHM";
	var idma = document.getElementById('CURRENT_IDMA').value;
	var obj = getElementsByClass(classname,null,'input');
	var items = 0;
	for(i=0;i<obj.length;i++){
		if(obj[i].checked == true){
				document.getElementById('OMSGBlock').innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" /> Удаляем выбранные сообщения...';
				//alert(obj[i].value);
				DeleteMessage("DeleteMessage",obj[i].value, idma, base);
				items++;
		}
	}
	if(items == 0) alert("Вы не выбрали ни одного сообщения для удаления!");
}
/**
* Вывод формы написания ответа на выбранное сообщение
*/
function ReplyForward(type, idma, base){
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
		getdata('','get', '?p=outlook&type='+type+'&mailact=WriteForm&idm='+id+'&idma='+idma,'WriteFormBox_inner', base); 
		return true;
	}
}

/**
* Вывод письма для чтения
*/
function ReadMessage(idm, base){
	var idma = document.getElementById('CURRENT_IDMA').value;
	rwin=dhtmlwindow.open('ReadMailBox', 'inline', '', 'Чтение письма', 'width=800px,height=500px,left=50px,top=70px,resize=1,scrolling=1'); 
	rwin.moveTo('middle','middle'); 
	getdata('','get', '?p=outlook&mailact=LoadMessageForRead&idm='+idm+'&idma='+idma,'ReadMailBox_inner', base);
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
function SaveUserSet(formid,msgarea,base){
	document.getElementById(msgarea).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=SaveUSet',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
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
function SaveUserSet1(formid,msgarea,base){
	document.getElementById(msgarea).innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=SaveUSet1',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
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
function SearchInContact(str,base){
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=SearchInContact&str='+str,
        {
             'str': str
        },
        function(result, errors){
                if(result){
					document.getElementById('ContactArea').innerHTML = result['msg'];
                }
        },
        true
    );
}

/**
* Фильтр выбора сообщений имеющих отношение к определенному заказу
*/
function LoadIdoMessages(ido,base){
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=SearchInContact&str='+str,
        {
             'str': str
        },
        function(result, errors){
                if(result){
					document.getElementById('ContactArea').innerHTML = result['msg'];
                }
        },
        true
    );
}


/**
* Check for new mail for selected account
*/
function CheckNewMail(idma,base){
	document.getElementById('OMSGBlock').innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" /> Проверяем почту...';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=CheckNewMail&idma='+idma,
        {
             'mailact': "CheckNewMail",
			 'idma':idma
        },
        function(result, errors){
                if(result){
					document.getElementById('OMSGBlock').innerHTML = result['msg'];
					ReCount(result['countmsg'], idma);
					getdata('','post','?p=outlook&mailact=LoadMailList&folder=inbox&outpage=page&idma='+idma,'OMailList', base); 
					document.getElementById('CURRENT_IDMA').value = idma;
                }
        },
        true
    );
}

function LoadUserContact(cidu, base){
	document.getElementById('AllUserMail').innerHTML ='<img src="'+base+'/js/img/loader.gif" style="vertical-align:middle" />';
    JsHttpRequest.query(
        base+'/?p=outlook&mailact=LoadUserContact&cidu='+cidu,
        {
             'mailact': "LoadUserContact",
			 'cidu':cidu
        },
        function(result, errors){
                if(result){
					document.getElementById('AllUserMail').innerHTML = result['mails'];
                }
        },
        true
    );
}


function ApplayFilter(base){
	var curfolder = document.getElementById('CurFolder').value;
	var idma = document.getElementById('CURRENT_IDMA').value;
	var obj = getElementsByClass('filter',null,'input');
	var query = '';
	for(i=0;i<obj.length;i++){
		if(obj[i].value!='' && obj[i].type=="text") query = query+'&'+obj[i].id+'='+obj[i].value;
		if(obj[i].type=="radio" && obj[i].checked==true) query = query+'&'+obj[i].name+'='+obj[i].value;
	}	
	getdata('','post', '?p=outlook&mailact=LoadMailList&folder='+curfolder+'&outpage=page&idma='+idma+query,'OMailList', base);
}

function LoadMailList(folder, outpage, idma, base){
	var obj = getElementsByClass('filter',null,'input');
	var query = '';
	for(i=0;i<obj.length;i++){
		if(obj[i].value!='' && obj[i].type=="text") query = query+'&'+obj[i].id+'='+obj[i].value;
		if(obj[i].type=="radio" && obj[i].checked==true) query = query+'&'+obj[i].name+'='+obj[i].value;
	}	

    JsHttpRequest.query(
        base+'/?p=outlook'+query+'mailact=UpdateMessageCount&idma='+idma,
        {
             'mailact': "UpdateMessageCount",
			 'idma':idma
        },
        function(result, errors){
                if(result){
					ReCount(result['countmsg'],idma);
                }
        },
        true  // do not disable caching
    );

	getdata('','post', '?p=outlook&mailact=LoadMailList&folder='+folder+'&outpage='+outpage+'&idma='+idma+query,'OMailList', base); 
	document.getElementById('CURRENT_IDMA').value = idma;
}