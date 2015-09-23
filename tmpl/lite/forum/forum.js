/**
 * Скрипты для работы форума
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00	12.10.2009
 */
function EditMsg(idm){
	if(document.getElementById('EMF')!=null){
		alert("У вас уже открыто окно редактирования сообщения. Сначала закройте его.");
		return false;
	}
	getdata('','post','?p=forum_action&act=MakeEditFormMsg&idm='+idm,'M_'+idm);
	//alert(document.getElementById('mtext1').value);
			XBB.path = "/include/bbcode";
			XBB.textarea_id = "mtext1";
			XBB.area_width = "700px";
			XBB.area_height = "300px";
			XBB.state = "plain";
			XBB.lang = "ru_utf8";
			XBB.init();
}

function StopEditMsg(idm){
    JsHttpRequest.query(
        'loader.php?p=forum_action&act=cancelEditMsg',
        {
             'idm': idm
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug1").innerHTML = errors; 
				//alert(errors);
                // Write the answer.
                if(result){
					document.getElementById('M_'+idm).innerHTML = result['out'];
                }
        },
        true  // do not disable caching
    );
}

function SaveMsg(formid,idm){
    JsHttpRequest.query(
        'loader.php?p=forum_action&act=SaveMsg&idm='+idm,
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug1").innerHTML = errors; 
				//alert(errors);
                // Write the answer.
                if(result){
					document.getElementById('M_'+idm).innerHTML = result['out'];
                }
        },
        true  // do not disable caching
    );
}

function EditTheme(idt){
	if(document.getElementById('ETF')!=null){
		alert("У вас уже открыто окно редактирования сообщения. Сначала закройте его.");
		return false;
	}
			XBB.path = "/include/bbcode";
			XBB.textarea_id = "ttext1";
			XBB.area_width = "700px";
			XBB.area_height = "300px";
			XBB.state = "plain";
			XBB.lang = "ru_utf8";
	getdata('','post','?p=forum_action&act=MakeEditFormTheme&idt='+idt,'T_'+idt);
			XBB.init();
}

function StopEditTheme(idt){
    JsHttpRequest.query(
        'loader.php?p=forum_action&act=cancelEditTheme',
        {
             'idt': idt
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug1").innerHTML = errors; 
				//alert(errors);
                // Write the answer.
                if(result){
					document.getElementById('T_'+idt).innerHTML = result['out'];
                }
        },
        true  // do not disable caching
    );
}

function SaveTheme(formid,idt){
    JsHttpRequest.query(
        'loader.php?p=forum_action&act=SaveTheme&idt='+idt,
        {
             'form': document.getElementById(formid)
        },
        function(result, errors){
                // Write errors to the debug div.
                //document.getElementById("debug1").innerHTML = errors; 
				//alert(errors);
                // Write the answer.
                if(result){
					document.getElementById('T_'+idt).innerHTML = result['out'];
					document.getElementById('H_'+idt).innerHTML = '<h1>'+result['head']+'</h1>';
                }
        },
        true  // do not disable caching
    );
}

function addUserToSection(idu, fio){
	var addstr = '<span id="su'+idu+'"><input type="hidden" name="idu['+idu+']" id="idu['+idu+']" value="'+idu+'" />'+fio+' (<a href="javascript:void(null)" onclick="delelem(\'su'+idu+'\')">Видалити</a>)<br /></span>';
	jQuery("#selUsers").append(addstr);
}
