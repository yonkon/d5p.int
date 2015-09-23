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
	var contDiv = document.getElementById(a);
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

function doLoadData(formid, formareaid){
    JsHttpRequest.query(
        'loader.php?p=feedback&fb_act=sendFeedBackData',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['errormsg']); 
					}else{
						document.getElementById(formareaid).innerHTML = '';
						alert(result['successmsg']); 
					}
                }
        },
        true
    );
}
function doLoadRegData(formid, formareaid){
    JsHttpRequest.query(
        'loader.php?p=register&fb_act=sendRegisterData',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['errormsg']); 
					}else{
						document.getElementById(formareaid).innerHTML = result['successmsg'];
					}
                }
        },
        true
    );
}

function doLoadEdData(formid, formareaid){
    JsHttpRequest.query(
        'loader.php?p=useredit&fb_act=sendEditData',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['errormsg']); 
					}else{
						alert(result['successmsg']); 
					}
                }
        },
        true
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
                //alert(errors); 
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
        true
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
        true 
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
        true
    );
}

function SignToNewsletter(formid, formareaid){
    JsHttpRequest.query(
        'loader.php?p=newssign&nsact=NewSign',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['errormsg']); 
					}else{
						document.getElementById(formareaid).innerHTML = '<p style="color:green;">'+result['successmsg']+'</p>';
					}
                }
        },
        true
    );
}

function sendOwnForm(formid, formareaid, loadarea){
	document.getElementById(loadarea).innerHTML ='<img src="/js/img/loader.gif" />';
    JsHttpRequest.query(
        'loader.php?p=form_parse&act=parseData',
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
						document.getElementById(loadarea).innerHTML ='';
					}else{
						document.getElementById(formareaid).innerHTML = result['msg'];
					}
                }
        },
        true
    );
}

// -------------------------------------------------------------------
// DHTML Window Widget- By Dynamic Drive, available at: http://www.dynamicdrive.com
// v1.0: Script created Feb 15th, 07'
// v1.01: Feb 21th, 07' (see changelog.txt)
// v1.02: March 26th, 07' (see changelog.txt)
// v1.03: May 5th, 07' (see changelog.txt)
// v1.1:  Oct 29th, 07' (see changelog.txt)
// -------------------------------------------------------------------
/*
Модифікація: 
рядок 36: додано айді до внутрішнього діва по імені вікна плюс "_inner"
*/

var dhtmlwindow={
imagefiles:['tmpl/lite/dhtmlwindow/min.png', 'tmpl/lite/dhtmlwindow/close.png', 'tmpl/lite/dhtmlwindow/restore.png', 'tmpl/lite/dhtmlwindow/resize.gif'], //Path to 4 images used by script, in that order
ajaxbustcache: true, //Bust caching when fetching a file via Ajax?
ajaxloadinghtml: '<b>Loading Page. Please wait...</b>', //HTML to show while window fetches Ajax Content?

minimizeorder: 0,
zIndexvalue:100,
tobjects: [], //object to contain references to dhtml window divs, for cleanup purposes
lastactivet: {}, //reference to last active DHTML window

init:function(t){
	var domwindow=document.createElement("div") //create dhtml window div
	domwindow.id=t
	domwindow.className="dhtmlwindow"
	var domwindowdata=''

	domwindowdata+='<table width="100%" cellspacing="0" cellpadding="0" height="24" class="drag-DHT"><tr><td id="TLC">&nbsp;</td><td id="TCC">'
	domwindowdata+='<div class="drag-handle">'
	
	domwindowdata+='DHTML Window <div class="drag-controls" id="WinButton"><img src="'+this.imagefiles[0]+'" title="Minimize" />&nbsp;<img src="'+this.imagefiles[1]+'" title="Close" />&nbsp;</div>'
	
	domwindowdata+='</div>'
	domwindowdata+='</td><td id="TRC">&nbsp;</td></td></tr></table>'
	
	domwindowdata+='<table width="100%" cellspacing="0" cellpadding="0" class="drag-DHT"><tr><td id="CLC">&nbsp;</td><td id="CCC">'
	domwindowdata+='<div id="'+t+'_inner" class="drag-contentarea"></div>'
	domwindowdata+='</td><td id="CRC">&nbsp;</td></td></tr></table>'
	
	domwindowdata+='<table width="100%" cellspacing="0" cellpadding="0" height="19" class="drag-DHT"><tr><td id="SLC">&nbsp;</td><td id="SCC">'
	domwindowdata+='<div class="drag-statusarea">&nbsp;</div>'
	domwindowdata+='</td><td id="SRC" valign="top"><div class="drag-resizearea">&nbsp;</div></td></td></tr></table>'
	
	domwindowdata+='</div>'
	
	domwindow.innerHTML=domwindowdata
	document.getElementById("dhtmlwindowholder").appendChild(domwindow)
	//this.zIndexvalue=(this.zIndexvalue)? this.zIndexvalue+1 : 100 //z-index value for DHTML window: starts at 0, increments whenever a window has focus
	var t=document.getElementById(t)
	var divs=t.getElementsByTagName("div")
	for (var i=0; i<divs.length; i++){ //go through divs inside dhtml window and extract all those with class="drag-" prefix
		if (/drag-/.test(divs[i].className))
			t[divs[i].className.replace(/drag-/, "")]=divs[i] //take out the "drag-" prefix for shorter access by name
	}
	//t.style.zIndex=this.zIndexvalue //set z-index of this dhtml window
	t.handle._parent=t //store back reference to dhtml window
	t.resizearea._parent=t //same
	t.controls._parent=t //same
	t.onclose=function(){return true} //custom event handler "onclose"
	t.onmousedown=function(){dhtmlwindow.setfocus(this)} //Increase z-index of window when focus is on it
	t.handle.onmousedown=dhtmlwindow.setupdrag //set up drag behavior when mouse down on handle div
	t.resizearea.onmousedown=dhtmlwindow.setupdrag //set up drag behavior when mouse down on resize div
	t.controls.onclick=dhtmlwindow.enablecontrols
	t.show=function(){dhtmlwindow.show(this)} //public function for showing dhtml window
	t.hide=function(){dhtmlwindow.hide(this)} //public function for hiding dhtml window
	t.close=function(){dhtmlwindow.close(this)} //public function for closing dhtml window (also empties DHTML window content)
	t.setSize=function(w, h){dhtmlwindow.setSize(this, w, h)} //public function for setting window dimensions
	t.moveTo=function(x, y){dhtmlwindow.moveTo(this, x, y)} //public function for moving dhtml window (relative to viewpoint)
	t.isResize=function(bol){dhtmlwindow.isResize(this, bol)} //public function for specifying if window is resizable
	t.isScrolling=function(bol){dhtmlwindow.isScrolling(this, bol)} //public function for specifying if window content contains scrollbars
	t.load=function(contenttype, contentsource, title){dhtmlwindow.load(this, contenttype, contentsource, title)} //public function for loading content into window
	this.tobjects[this.tobjects.length]=t
	return t //return reference to dhtml window div
},

open:function(t, contenttype, contentsource, title, attr, recalonload){
	var d=dhtmlwindow //reference dhtml window object
	function getValue(Name){
		var config=new RegExp(Name+"=([^,]+)", "i") //get name/value config pair (ie: width=400px,)
		return (config.test(attr))? parseInt(RegExp.$1) : 0 //return value portion (int), or 0 (false) if none found
	}
	if (document.getElementById(t)==null) //if window doesn't exist yet, create it
		t=this.init(t) //return reference to dhtml window div
	else
		t=document.getElementById(t)
	this.setfocus(t)
	t.setSize(getValue(("width")), (getValue("height"))) //Set dimensions of window
	var xpos=getValue("center")? "middle" : getValue("left") //Get x coord of window
	var ypos=getValue("center")? "middle" : getValue("top") //Get y coord of window
	//t.moveTo(xpos, ypos) //Position window
	if (typeof recalonload!="undefined" && recalonload=="recal" && this.scroll_top==0){ //reposition window when page fully loads with updated window viewpoints?
		if (window.attachEvent && !window.opera) //In IE, add another 400 milisecs on page load (viewpoint properties may return 0 b4 then)
			this.addEvent(window, function(){setTimeout(function(){t.moveTo(xpos, ypos)}, 400)}, "load")
		else
			this.addEvent(window, function(){t.moveTo(xpos, ypos)}, "load")
	}
	t.isResize(getValue("resize")) //Set whether window is resizable
	t.isScrolling(getValue("scrolling")) //Set whether window should contain scrollbars
	t.style.visibility="visible"
	t.style.display="block"
	t.contentarea.style.display="block"
	t.moveTo(xpos, ypos) //Position window
	t.load(contenttype, contentsource, title)
	if (t.state=="minimized" && t.controls.firstChild.title=="Restore"){ //If window exists and is currently minimized?
		t.controls.firstChild.setAttribute("src", dhtmlwindow.imagefiles[0]) //Change "restore" icon within window interface to "minimize" icon
		t.controls.firstChild.setAttribute("title", "Minimize")
		t.state="fullview" //indicate the state of the window as being "fullview"
	}
	return t
},

setSize:function(t, w, h){ //set window size (min is 150px wide by 100px tall)
	t.style.width=Math.max(parseInt(w), 150)+"px"
	t.contentarea.style.height=Math.max(parseInt(h), 100)+"px"
},

moveTo:function(t, x, y){ //move window. Position includes current viewpoint of document
	this.getviewpoint() //Get current viewpoint numbers
	t.style.left=(x=="middle")? this.scroll_left+(this.docwidth-t.offsetWidth)/2+"px" : this.scroll_left+parseInt(x)+"px"
	t.style.top=(y=="middle")? this.scroll_top+(this.docheight-t.offsetHeight)/2+"px" : this.scroll_top+parseInt(y)+"px"
},

isResize:function(t, bol){ //show or hide resize inteface (part of the status bar)
	t.statusarea.style.display=(bol)? "block" : "none"
	t.resizeBool=(bol)? 1 : 0
},

isScrolling:function(t, bol){ //set whether loaded content contains scrollbars
	t.contentarea.style.overflow=(bol)? "auto" : "hidden"
},

load:function(t, contenttype, contentsource, title){ //loads content into window plus set its title (3 content types: "inline", "iframe", or "ajax")
	if (t.isClosed){
		alert("DHTML Window has been closed, so no window to load contents into. Open/Create the window again.")
		return
	}
	var contenttype=contenttype.toLowerCase() //convert string to lower case
	if (typeof title!="undefined")
		t.handle.firstChild.nodeValue=title
	if (contenttype=="inline")
		t.contentarea.innerHTML=contentsource
	else if (contenttype=="div"){
		var inlinedivref=document.getElementById(contentsource)
		t.contentarea.innerHTML=(inlinedivref.defaultHTML || inlinedivref.innerHTML) //Populate window with contents of inline div on page
		if (!inlinedivref.defaultHTML)
			inlinedivref.defaultHTML=inlinedivref.innerHTML //save HTML within inline DIV
		inlinedivref.innerHTML="" //then, remove HTML within inline DIV (to prevent duplicate IDs, NAME attributes etc in contents of DHTML window
		inlinedivref.style.display="none" //hide that div
	}
	else if (contenttype=="iframe"){
		t.contentarea.style.overflow="hidden" //disable window scrollbars, as iframe already contains scrollbars
		if (!t.contentarea.firstChild || t.contentarea.firstChild.tagName!="IFRAME") //If iframe tag doesn't exist already, create it first
			t.contentarea.innerHTML='<iframe src="" style="margin:0; padding:0; width:100%; height: 100%" name="_iframe-'+t.id+'"></iframe>'
		window.frames["_iframe-"+t.id].location.replace(contentsource) //set location of iframe window to specified URL
		}
	else if (contenttype=="ajax"){
		this.ajax_connect(contentsource, t) //populate window with external contents fetched via Ajax
	}
	t.contentarea.datatype=contenttype //store contenttype of current window for future reference
},

setupdrag:function(e){
	var d=dhtmlwindow //reference dhtml window object
	var t=this._parent //reference dhtml window div
	d.etarget=this //remember div mouse is currently held down on ("handle" or "resize" div)
	var e=window.event || e
	d.initmousex=e.clientX //store x position of mouse onmousedown
	d.initmousey=e.clientY
	d.initx=parseInt(t.offsetLeft) //store offset x of window div onmousedown
	d.inity=parseInt(t.offsetTop)
	d.width=parseInt(t.offsetWidth) //store width of window div
	d.contentheight=parseInt(t.contentarea.offsetHeight) //store height of window div's content div
	if (t.contentarea.datatype=="iframe"){ //if content of this window div is "iframe"
		t.style.backgroundColor="#F8F8F8" //colorize and hide content div (while window is being dragged)
		t.contentarea.style.visibility="hidden"
	}
	document.onmousemove=d.getdistance //get distance travelled by mouse as it moves
	document.onmouseup=function(){
		if (t.contentarea.datatype=="iframe"){ //restore color and visibility of content div onmouseup
			t.contentarea.style.backgroundColor="white"
			t.contentarea.style.visibility="visible"
		}
		d.stop()
	}
	return false
},

getdistance:function(e){
	var d=dhtmlwindow
	var etarget=d.etarget
	var e=window.event || e
	d.distancex=e.clientX-d.initmousex //horizontal distance travelled relative to starting point
	d.distancey=e.clientY-d.initmousey
	if (etarget.className=="drag-handle") //if target element is "handle" div
		d.move(etarget._parent, e)
	else if (etarget.className=="drag-resizearea") //if target element is "resize" div
		d.resize(etarget._parent, e)
	return false //cancel default dragging behavior
},

getviewpoint:function(){ //get window viewpoint numbers
	var ie=document.all && !window.opera
	var domclientWidth=document.documentElement && parseInt(document.documentElement.clientWidth) || 100000 //Preliminary doc width in non IE browsers
	this.standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body //create reference to common "body" across doctypes
	this.scroll_top=(ie)? this.standardbody.scrollTop : window.pageYOffset
	this.scroll_left=(ie)? this.standardbody.scrollLeft : window.pageXOffset
	this.docwidth=(ie)? this.standardbody.clientWidth : (/Safari/i.test(navigator.userAgent))? window.innerWidth : Math.min(domclientWidth, window.innerWidth-16)
	this.docheight=(ie)? this.standardbody.clientHeight: window.innerHeight
},

rememberattrs:function(t){ //remember certain attributes of the window when it's minimized or closed, such as dimensions, position on page
	this.getviewpoint() //Get current window viewpoint numbers
	t.lastx=parseInt((t.style.left || t.offsetLeft))-dhtmlwindow.scroll_left //store last known x coord of window just before minimizing
	t.lasty=parseInt((t.style.top || t.offsetTop))-dhtmlwindow.scroll_top
	t.lastwidth=parseInt(t.style.width) //store last known width of window just before minimizing/ closing
},

move:function(t, e){
	t.style.left=dhtmlwindow.distancex+dhtmlwindow.initx+"px"
	t.style.top=dhtmlwindow.distancey+dhtmlwindow.inity+"px"
},

resize:function(t, e){
	t.style.width=Math.max(dhtmlwindow.width+dhtmlwindow.distancex, 150)+"px"
	t.contentarea.style.height=Math.max(dhtmlwindow.contentheight+dhtmlwindow.distancey, 100)+"px"
},

enablecontrols:function(e){
	var d=dhtmlwindow
	var sourceobj=window.event? window.event.srcElement : e.target //Get element within "handle" div mouse is currently on (the controls)
	if (/Minimize/i.test(sourceobj.getAttribute("title"))) //if this is the "minimize" control
		d.minimize(sourceobj, this._parent)
	else if (/Restore/i.test(sourceobj.getAttribute("title"))) //if this is the "restore" control
		d.restore(sourceobj, this._parent)
	else if (/Close/i.test(sourceobj.getAttribute("title"))) //if this is the "close" control
		d.close(this._parent)
	return false
},

minimize:function(button, t){
	dhtmlwindow.rememberattrs(t)
	button.setAttribute("src", dhtmlwindow.imagefiles[2])
	button.setAttribute("title", "Restore")
	t.state="minimized" //indicate the state of the window as being "minimized"
	t.contentarea.style.display="none"
	t.statusarea.style.display="none"
	if (typeof t.minimizeorder=="undefined"){ //stack order of minmized window on screen relative to any other minimized windows
		dhtmlwindow.minimizeorder++ //increment order
		t.minimizeorder=dhtmlwindow.minimizeorder
	}
	t.style.left="10px" //left coord of minmized window
	t.style.width="200px"
	var windowspacing=t.minimizeorder*10 //spacing (gap) between each minmized window(s)
	t.style.top=dhtmlwindow.scroll_top+dhtmlwindow.docheight-(t.handle.offsetHeight*t.minimizeorder)-windowspacing+"px"
},

restore:function(button, t){
	dhtmlwindow.getviewpoint()
	button.setAttribute("src", dhtmlwindow.imagefiles[0])
	button.setAttribute("title", "Minimize")
	t.state="fullview" //indicate the state of the window as being "fullview"
	t.style.display="block"
	t.contentarea.style.display="block"
	if (t.resizeBool) //if this window is resizable, enable the resize icon
		t.statusarea.style.display="block"
	t.style.left=parseInt(t.lastx)+dhtmlwindow.scroll_left+"px" //position window to last known x coord just before minimizing
	t.style.top=parseInt(t.lasty)+dhtmlwindow.scroll_top+"px"
	t.style.width=parseInt(t.lastwidth)+"px"
},


close:function(t){
	try{
		var closewinbol=t.onclose()
	}
	catch(err){ //In non IE browsers, all errors are caught, so just run the below
		var closewinbol=true
 }
	finally{ //In IE, not all errors are caught, so check if variable isn't defined in IE in those cases
		if (typeof closewinbol=="undefined"){
			alert("An error has occured somwhere inside your \"onclose\" event handler")
			var closewinbol=true
		}
	}
	if (closewinbol){ //if custom event handler function returns true
		if (t.state!="minimized") //if this window isn't currently minimized
			dhtmlwindow.rememberattrs(t) //remember window's dimensions/position on the page before closing
		if (window.frames["_iframe-"+t.id]) //if this is an IFRAME DHTML window
			window.frames["_iframe-"+t.id].location.replace("about:blank")
		else
			t.contentarea.innerHTML=""
		t.style.display="none"
		t.isClosed=true //tell script this window is closed (for detection in t.show())
	}
	return closewinbol
},


setopacity:function(targetobject, value){ //Sets the opacity of targetobject based on the passed in value setting (0 to 1 and in between)
	if (!targetobject)
		return
	if (targetobject.filters && targetobject.filters[0]){ //IE syntax
		if (typeof targetobject.filters[0].opacity=="number") //IE6
			targetobject.filters[0].opacity=value*100
		else //IE 5.5
			targetobject.style.filter="alpha(opacity="+value*100+")"
		}
	else if (typeof targetobject.style.MozOpacity!="undefined") //Old Mozilla syntax
		targetobject.style.MozOpacity=value
	else if (typeof targetobject.style.opacity!="undefined") //Standard opacity syntax
		targetobject.style.opacity=value
},

setfocus:function(t){ //Sets focus to the currently active window
	this.zIndexvalue++
	t.style.zIndex=this.zIndexvalue
	t.isClosed=false //tell script this window isn't closed (for detection in t.show())
	this.setopacity(this.lastactivet.handle, 0.5) //unfocus last active window
	this.setopacity(t.handle, 1) //focus currently active window
	this.lastactivet=t //remember last active window
},


show:function(t){
	if (t.isClosed){
		alert("DHTML Window has been closed, so nothing to show. Open/Create the window again.")
		return
	}
	if (t.lastx) //If there exists previously stored information such as last x position on window attributes (meaning it's been minimized or closed)
		dhtmlwindow.restore(t.controls.firstChild, t) //restore the window using that info
	else
		t.style.display="block"
	this.setfocus(t)
	t.state="fullview" //indicate the state of the window as being "fullview"
},

hide:function(t){
	t.style.display="none"
},

ajax_connect:function(url, t){
	var page_request = false
	var bustcacheparameter=""
	if (window.XMLHttpRequest) // if Mozilla, IE7, Safari etc
		page_request = new XMLHttpRequest()
	else if (window.ActiveXObject){ // if IE6 or below
		try {
		page_request = new ActiveXObject("Msxml2.XMLHTTP")
		} 
		catch (e){
			try{
			page_request = new ActiveXObject("Microsoft.XMLHTTP")
			}
			catch (e){}
		}
	}
	else
		return false
	t.contentarea.innerHTML=this.ajaxloadinghtml
	page_request.onreadystatechange=function(){dhtmlwindow.ajax_loadpage(page_request, t)}
	if (this.ajaxbustcache) //if bust caching of external page
		bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
	page_request.open('GET', url+bustcacheparameter, true)
	page_request.send(null)
},

ajax_loadpage:function(page_request, t){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)){
	t.contentarea.innerHTML=page_request.responseText
	}
},


stop:function(){
	dhtmlwindow.etarget=null //clean up
	document.onmousemove=null
	document.onmouseup=null
},

addEvent:function(target, functionref, tasktype){ //assign a function to execute to an event handler (ie: onunload)
	var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false)
	else if (target.attachEvent)
		target.attachEvent(tasktype, functionref)
},

cleanup:function(){
	for (var i=0; i<dhtmlwindow.tobjects.length; i++){
		dhtmlwindow.tobjects[i].handle._parent=dhtmlwindow.tobjects[i].resizearea._parent=dhtmlwindow.tobjects[i].controls._parent=null
	}
	window.onload=null
}

} //End dhtmlwindow object

document.write('<div id="dhtmlwindowholder"><span style="display:none">.</span></div>') //container that holds all dhtml window divs on page
window.onunload=dhtmlwindow.cleanup
