function request(loader, method, data,reptag, data2) {
    if(reptag==null) reptag='result';
			var reg = new RegExp('.htm?');
			if (reg.test(data) == true){
         var spstr=data.split(".htm?");
         var tmpdata='';
         for (var i=0; i < spstr.length; i++) {
               tmpdata=tmpdata+spstr[i]+'&';
         }
         data=tmpdata;
      }
    document.getElementById(reptag).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
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
        req.open(method, 'loader.php'+data, true);
        var data = {
            q: data,
            'data2': data2
        };
        if (data2 == null) delete data.data2;
        req.send(data);
    }
//----------------------------------------------------------------------
function getdata(loader, method, data,reptag, data2) {
    if(reptag==null) reptag='result';
			var reg = new RegExp('.htm?');
			if (reg.test(data) == true){
         var spstr=data.split(".htm?");
         var tmpdata='';
         for (var i=0; i < spstr.length; i++) {
               tmpdata=tmpdata+spstr[i]+'&';
         }
         data='?p='+tmpdata;
      }
	if(reptag=="ActionRes") document.getElementById('ARC').style.display='block';
    document.getElementById(reptag).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle" />';
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
        req.open(method, 'loader.php'+data, true);
        var data = {
            q: data,
            'data2': data2
        };
        if (data2 == null) delete data.data2;
        req.send(data);
    }
//----------------------------------------------------------------------
function appenddata(loader, method, data,reptag, data2) {
    if(reptag==null) reptag='result';
			var reg = new RegExp('.htm?');
			if (reg.test(data) == true){
         var spstr=data.split(".htm?");
         var tmpdata='';
         for (var i=0; i < spstr.length; i++) {
               tmpdata=tmpdata+spstr[i]+'&';
         }
         data='?p='+tmpdata;
      }
   // document.getElementById(reptag).innerHTML ='<img src="/js/img/loader.gif" width="16" height="16" style="vertical-align:middle" />';
        var req = new JsHttpRequest();
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.responseJS) {
                    document.getElementById(reptag).innerHTML+=req.responseText;
					runScripts(document.getElementById(reptag).getElementsByTagName('SCRIPT'));
                }
            }
        }
        req.caching = false;
        req.loader = loader;
        req.open(method, 'loader.php'+data, true);
        var data = {
            q: data,
            'data2': data2
        };
        if (data2 == null) delete data.data2;
        req.send(data);
    }	
//----------------------------------------------------------------------
function doLoad(fid,did) {
	if(did=="ActionRes") document.getElementById('ARC').style.display='block';
    document.getElementById(did).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    var req = new JsHttpRequest();
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            document.getElementById(did).innerHTML = req.responseText;
			runScripts(document.getElementById(did).getElementsByTagName('SCRIPT'));
        }
    }
    req.open(null, 'loader.php', true);
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
function add_file(id, i) {
	if (document.getElementById(id + '_' + i).innerHTML.search('uploadinputbutton') == -1) {
		document.getElementById(id + '_' + i).innerHTML = '<input type="file" class="uploadinputbutton" name="' + id + '[]" onchange="return add_file(\'' + id + '\', ' + (i+1) + ');" /><br /><span id="' + id + '_' + (i+1) + '"><input type="button" value="Добавить другой" onclick="add_file(\'' + id + '\', ' + (i+1) + ');" /><\/span>\n';
	}
}
/*
<input type="file" class="uploadinputbutton" maxsize="2097152" name="file[]" onchange="add_file('file', 1);" /><br />
<span id="file_1"><input type="button" value="Додати інший" onclick="add_file('file', 1);" /></span><br />
*/

function CloseInfo(){
	document.getElementById('ActionRes').innerHTML='';
	document.getElementById('ARC').style.display='none';
}

function doLoadPagePhoto(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',
        {
             'form': document.getElementById(formid),
			 'p' : 'admin_list_action',
			 'act' : 'UploadPhoto'
        },
        function(result, errors){
                // Write errors to the debug div.
                //alert(errors); 
                // Write the answer.
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						var newphoto = '<div style="float:left; padding:2px; margin:2px;text-align:center;" id="PID'+result['photo_id']+'"><small>Галерея:</small>'+result['photo_group']+'<br />'+result['psign']+'<br /><a href="'+result['bigphoto']+'" target="_bigphoto"><img src="'+result['thumb']+'" height="50" /></a><br /><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=admin_list_action&act=DeletePhoto&photo_id='+result['photo_id']+'\',\'PhotoMsg\'); delelem(\'PID'+result['photo_id']+'\');">Удалить</a></div>';
						$("#PhotoList").append(newphoto);
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}

function doLoadUserPagePhoto(formid, formareaid){
    JsHttpRequest.query(
        'loader.php',
        {
             'form': document.getElementById(formid),
			 'p' : 'site_server',
			 'act' : 'UploadUserPhoto'
        },
        function(result, errors){
                // Write errors to the debug div.
                //alert(errors); 
                // Write the answer.
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						var newphoto = '<div style="float:left; padding:2px; margin:2px;text-align:center;" id="PID'+result['photo_id']+'"><small>Галерея:</small>'+result['photo_group']+'<br />'+result['psign']+'<br /><a href="'+result['bigphoto']+'" target="_bigphoto"><img src="'+result['thumb']+'" height="50" /></a><br /><a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=site_server&act=DeletePhoto&photo_id='+result['photo_id']+'\',\'PhotoMsg\'); delelem(\'PID'+result['photo_id']+'\');">Удалить</a></div>';
						$("#PhotoList").prepend(newphoto);
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}

function doLoadUserPageVideo(formid, formareaid){
    JsHttpRequest.query(
        'loader.php',
        {
             'form': document.getElementById(formid),
			 'p' : 'site_server',
			 'act' : 'UploadUserVideo'
        },
        function(result, errors){
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						var newvideo = '<div style="padding:2px;" id="VID'+result['video_id']+'">Видео:'+result['video_group']+'. <a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=site_server&act=EditUserVideo&video_id='+result['video_id']+'\',\'EDV'+result['video_id']+'\');">'+result['video_id']+': '+result['vsign']+'</a> | <a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=site_server&act=DeleteUserVideo&video_id='+result['video_id']+'\',\'VideoMsg\'); delelem(\'VID'+result['video_id']+'\');">Удалить</a></div>';
						$("#VideoList").append(newvideo);
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}

function doLoadUserPageVideo1(formid, formareaid, aid){
    JsHttpRequest.query(
        'loader.php',
        {
             'form': document.getElementById(formid),
			 'p' : 'site_server',
			 'act' : 'UploadUserVideo1'
        },
        function(result, errors){
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						document.getElementById(aid).innerHTML = ''; 
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}
