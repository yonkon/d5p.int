function sendNewForm(){
	if($("#name").val()==""){alert("Пожалуйста, введите название формы!");return false;}
	if($("#f_send").attr("checked")==true && $("#f_email").val()==""){alert("Пожалуйста, введите e-mail на который будут отправляться данные из формы!");return false;}
	document.getElementById('NFFLoad').innerHTML = '<img src="/js/img/9.gif" />';
    JsHttpRequest.query(
        'loader.php?p=form_manage&act=sendNewForm',
        {
             'form': document.getElementById('NFF')
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						var nlink = '<a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=form_manage&act=editForm&idf='+result['idf']+'\',\'WA\')" id="AF'+result['idf']+'">'+result['name']+'</a><br />';
						$("#FormList").prepend(nlink);
						document.getElementById('NFFLoad').innerHTML = '';
						document.getElementById('WA').innerHTML = '';
					}
                }
        },
        true  // do not disable caching
    );
}
function openEditForm(idf){
	getdata('','post','?p=form_manage&act=editForm&idf='+idf,'WA');
	getdata('','post','?p=form_manage&act=editFieldForm&idf='+idf,'WAF');
}
function openEditFieldForm(idf){
	getdata('','post','?p=form_manage&act=editFieldForm&idf='+idf,'WAF');
}
function updForm(){
	if($("#name").val()==""){alert("Пожалуйста, введите название формы!");return false;}
	if($("#f_send").attr("checked")==true && $("#f_email").val()==""){alert("Пожалуйста, введите e-mail на который будут отправляться данные из формы!");return false;}
	document.getElementById('NFFLoad').innerHTML = '<img src="/js/img/9.gif" />';
    JsHttpRequest.query(
        'loader.php?p=form_manage&act=updForm',
        {
             'form': document.getElementById('NFF')
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						document.getElementById('AF'+result['idf']).innerHTML = result['name'];
						document.getElementById('NFFLoad').innerHTML = '';
					}
                }
        },
        true  // do not disable caching
    );
}

function saveField(){
	if($("#f_order").val()==""){alert("Пожалуйста, укажите порядок сортировки поля, целое число!");return false;}
	if($("#f_label").val()==""){alert("Пожалуйста, укажите подпись к полю!");return false;}
	if($("#f_name").val()==""){alert("Пожалуйста, укажите название поля!");return false;}
	document.getElementById('FLoad').innerHTML = '<img src="/js/img/9.gif" />';
    JsHttpRequest.query(
        'loader.php?p=form_manage&act=saveField',
        {
             'form': document.getElementById('FieldForm')
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						if(result['jsact']=="add"){
							var nlink = '<a href="javascript:void(null)" onclick="loadFieldToEdit('+result['id']+')" id="FF'+result['id']+'">'+result['f_label']+'</a><br />';
							$("#FieldList").append(nlink);
						}else{
							document.getElementById('FF'+result['id']).innerHTML = result['f_label'];
						}
						$("#id").val(result['id']);
						document.getElementById('FLoad').innerHTML = '';
					}
                }
        },
        true  // do not disable caching
    );
}

function loadFieldToEdit(id){
	document.getElementById('FLoad').innerHTML = '<img src="/js/img/9.gif" />';
    JsHttpRequest.query(
        'loader.php?p=form_manage&act=loadFieldToEdit',
        {
             'id': id
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						$("#id").val(result['data'].id);
						$("#f_order").val(result['data'].f_order);
						$("#f_name").val(result['data'].f_name);
						$("#f_label").val(result['data'].f_label);
						$("#f_type [value='"+result['data'].f_type+"']").attr("selected", "selected");
						$("#f_init_val").val(result['data'].f_init_val);
						specType(result['data'].f_type);
						$("#f_list").val(result['data'].f_list);
						$("#f_req_alert").val(result['data'].f_req_alert);
						if(result['data'].f_req=="y"){
							$("#f_req").attr("checked",true);
							$("#frq").css("display","block");
						}else{
							$("#f_req").attr("checked",false);
							$("#frq").css("display","none");
						}
						document.getElementById('FLoad').innerHTML = '';
					}
                }
        },
        true  // do not disable caching
    );
}

function specType(val){
	if(val=="radio" || val=="checkbox" || val=="select"){
		$("#datalist").css("display","block");
	}else{
		$("#datalist").css("display","none");
	}
}

function delForm(idf){
	document.getElementById('WA').innerHTML = '<img src="/js/img/9.gif" />';
    JsHttpRequest.query(
        'loader.php?p=form_manage&act=delForm',
        {
             'idf': idf
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						$("#WAF").html("");
						$("#PREVIEW").html("");
						$("#SAF"+idf).remove();
						$("#WA").html(result['msg']);
						alert(result['msg']);
					}
                }
        },
        true  // do not disable caching
    );
}
function delField(id){
    JsHttpRequest.query(
        'loader.php?p=form_manage&act=delField',
        {
             'id': id
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						$("#PREVIEW").html("");
						$("#SFF"+id).remove();
						alert(result['msg']);
					}
                }
        },
        true  // do not disable caching
    );
}