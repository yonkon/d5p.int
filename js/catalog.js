function doLoadCat(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',{
             'form': document.getElementById(formid), 'p' : 'manage_cat', 'act' : 'SaveSection'
        }, function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						document.getElementById('cat').value = result['cat']; 
						document.getElementById('rcat').value = result['cat']; 
						document.getElementById('AddFieldArea').style.display='block';
						document.getElementById('AddSizeArea').style.display='block';
						document.getElementById('SaveCatButton').value = 'Обновить данные'; 
						document.getElementById('GoToFreeForm').innerHTML=' или <a href="admin.php?p=manage_cat&act=ManageSection"><strong>создать новый раздел</strong></a>';
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}

function doLoadCatSec(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',{
             'form': document.getElementById(formid), 'p' : 'manage_cat', 'act' : 'SaveSectionField'
        }, function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						document.getElementById('p_id').value = result['p_id']; 
						document.getElementById('FieldList').innerHTML = result['fields']; 
						document.getElementById('SaveFieldButton').value = 'Обновить данные';
					}
                }else alert('error');
        },
        true
    );
}

function doLoadDesign(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',{
             'form': document.getElementById(formid), 'p' : 'manage_cat', 'act' : 'designSave'
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						document.getElementById('design').value = result['design']; 
						document.getElementById('SaveDesignButton').value = 'Обновить данные'; 
						document.getElementById('GoToFreeForm').innerHTML=' или <a href="admin.php?p=manage_cat&act=designForm"><strong>добавить новый дизайн</strong></a>';
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}

function doLoadItem(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',
        {
             'form': document.getElementById(formid),
			 'p' : 'manage_cat',
			 'act' : 'SaveItem'
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						document.getElementById('id').value = result['id']; 
						document.getElementById('PhotoArea').style.display='block';
						document.getElementById('CoItemArea').style.display='block';
						document.getElementById('AddItemButton').value = 'Обновить данные'; 
						document.getElementById('TovarPageLink').innerHTML = '&nbsp;&nbsp; &raquo; &nbsp;&nbsp; <a href="/catalog/item/'+result['item_translit']+'/" target="_blank">Посмотреть страницу товара на сайте</a>'; 
						document.getElementById('GoToNewForm').innerHTML=' или <a href="admin.php?p=manage_cat&act=ManageItem&cat='+result['cat']+'"><strong>добавить новый товар</strong></a>';
					}
                }else alert('error');
        },
        true  // do not disable caching
    );
}

function doLoadCatPhoto(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',
        {
             'form': document.getElementById(formid),
			 'p' : 'manage_cat',
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
						if(result['pfirst']=="y") var chr = ' checked="checked" ';
						else var chk = '';
						$("#PhotoList").append(result['imgtag']);
					}
                }else alert('error');
        },
        true
    );
}

function doLoadCatVideo(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',{'form': document.getElementById(formid), 'p' : 'manage_cat', 'act' : 'AddVideo'},
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						var newvideo = '<div style="padding:2px;" id="IDV'+result['idv']+'">N'+result['idv']+' - <a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=manage_cat&act=DeleteVideo&idv='+result['idv']+'\',\'VideoMsg\'); delelem(\'IDV"'+result['idv']+'"\');">Удалить</a> - <a href="javascript:void(null)" onclick="getdata(\'\',\'post\',\'?p=manage_cat&act=EditVideo&idv='+result['idv']+'\',\'PhotoMsg\');">Редактировать</a></div>';
						$("#VideoList").prepend(newvideo);
					}
                }else alert('error');
        },
        true
    );
}

function doLoadCateVideo(formid, formareaid){
	document.getElementById('ARC').style.display='block';
	document.getElementById(formareaid).innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
    JsHttpRequest.query(
        'loader.php',
        {'form': document.getElementById(formid),'p' : 'manage_cat','act' : 'UpdVideo'},
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						document.getElementById(formareaid).innerHTML = result['msg']; 
					}else{
						document.getElementById(formareaid).innerHTML = result['msg']; 
						document.getElementById('VideoMsg').innerHTML = ''; 
					}
                }else alert('error');
        },
        true
    );
}
function ReCalcCost(id){
	$("#OML").html('<img src="/js/img/loader.gif" style="vertical-align:middle;" />');
    JsHttpRequest.query(
        'loader.php',
        {'p' : 'manage_cat','act' : 'ReCalcCost', 'id' : id },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
						$("#OML").html('');
					}else{
						for (var i=0; i < result['ord'].length; i++) {
							var ido = result['ord'][i].ido;
							var cena = result['ord'][i].cena;
							$("#isumm_"+ido).html(cena);
							
						}
						$("#totsumm").html(result['suma']);
						$("#OML").html('');
					}
                }else alert('error');
        },
        true
    );
}

function AddToBasket(id){
	if($("#razmer").val()=="0"){alert("Пожалуйста, выберите размер изделия!");return false;}
    JsHttpRequest.query(
        'loader.php',
		{'p' : 'basket', 'act' : 'AddToBasket', 'id' : id, 'razmer' : $("#razmer").val(), 'kolichestvo' : $("#kolichestvo").val()},
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						divwin=dhtmlwindow.open('AddToBasketBox', 'inline', '', 'Добавление товара в корзину', 'width=400px,height=200px,left=50px,top=70px,resize=1,scrolling=1'); 
						divwin.moveTo('middle', 'middle'); 
						$("#AddToBasketBox_inner").html(result['msg']);
						$("#iteminbasket").html(result['iteminbasket']);
					}
                }else alert('error');
        },
        true
    );
}

function RecalcBasket(id){
    JsHttpRequest.query(
        'loader.php',{
			 'p' : 'basket', 'act' : 'RecalcBasket', 'id' : id,
			 'kolichestvo' : document.getElementById('kol['+id+']').value,
			 'razmer' : document.getElementById('razmer['+id+']').value
        }, function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						document.getElementById('stoimost['+id+']').innerHTML = result['stoimost'];
						document.getElementById('total').innerHTML = result['total'];
						document.getElementById('iteminbasket').innerHTML = result['iteminbasket'];
					}
                }else alert('error');
        },
        true
    );
}

function RemoveFromBasket(id){
    JsHttpRequest.query(
        'loader.php',{
			 'p' : 'basket','act' : 'RemoveFromBasket','id' : id,
			 'razmer' : document.getElementById('razmer['+id+']').value
        },function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						delelem('TR_'+id);
						document.getElementById('total').innerHTML = result['total'];
						document.getElementById('iteminbasket').innerHTML = result['iteminbasket'];
					}
                }else alert('error');
        },
        true
    );
}

function AlertBasket(id){
    JsHttpRequest.query(
        'loader.php',{
			 'p' : 'basket', 'act' : 'AlertBasket', 'id' : id, 'razmer' : document.getElementById('razmer['+id+']').value
        }, function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){alert(result['msg']); 
					}else{
						alert("Для удаления товара из корзины щелкните по иконке в колонке удаления товара!");
						document.getElementById('kol['+id+']').value = result['items'];
					}
                }else alert('error');
        },
        true
    );
}

function doLoadCoItem(formid){
	document.getElementById('ARC').style.display='block';
	document.getElementById('ActionRes').innerHTML ='<img src="/js/img/loader.gif" style="vertical-align:middle;" />';
	var obj = getElementsByClass('CoItem',null,'input');
	var ci = new Array;
	for(i=0;i<obj.length;i++){
			var id = obj[i].id;
		if(obj[i].checked == true) ci[id] = obj[i].value;
	}	
	
    JsHttpRequest.query(
        'loader.php?p=manage_cat&act=updCoItem',
        {
             'form': document.getElementById(formid),
			 'co_id': document.getElementById('co_id').value,
			 'co_cat': document.getElementById('co_cat').value,
			 'ci': ci
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == "ERROR"){
						alert(result['msg']); 
					}else{
						document.getElementById('ActionRes').innerHTML = result['msg'];
					}
                }
        },
        true
    );
}

function loadSelCatOrders(obj, cat, title){
	var ob = getElementsByClass("catselected",null,'a');
	for(i=0;i<ob.length;i++){
		$('#'+ob[i].id).removeClass("catselected");
	}	
	var aid = '#'+obj.id;
	$(aid).addClass("catselected");
	$('#oTable').jqGrid('setGridParam',{url:'loader.php?p=manage_orders&act=loadOrdersList&cat0='+cat+'&JsHttpRequest',page:1}).trigger('reloadGrid'); 
	$('#oTable').jqGrid('setCaption','Раздел: '+title);
}

function loadSupplierInfo(obj, ido){
	var ob = getElementsByClass("itemselected",null,'a');
	for(i=0;i<ob.length;i++){
		$('#'+ob[i].id).removeClass("itemselected");
	}	
	var aid = '#'+obj.id;
	$(aid).addClass("itemselected");
	getdata('','post','?p=manage_orders&act=loadSupplierInfo&ido='+ido,'supplierInfo');
}
function getTotalSumm(ido){
	var obj = getElementsByClass('itemtotsum',null,'span');
	var tot = parseFloat(0);
	for(i=0; i<obj.length; i++){
		tot += parseFloat(obj[i].innerHTML);
	}	
	return tot;
}
function basketStep1(){
    JsHttpRequest.query(
        'loader.php',{'p' : 'basket','act' : 'checkStep1'},
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						$("#tabs").tabs( "option", "disabled", [2,3] );
						$("#tabs").tabs( "select", 1 );
						$("#tabs").tabs( "option", "disabled", [0,2,3] );
					}
                }else alert('error');
        },
        true
    );
}
function basketStep2(){
	var er = 0;
	var email_not_valid = /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/;
	var email_valid = /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/;
	if($("#country").val()==""){$("#country_error").css("display","block"); $("#country").addClass("ierror"); er=1;}else{$("#country_error").css("display","none");$("#country").removeClass("ierror");}
	if($("#region").val()==""){$("#region_error").css("display","block"); $("#region").addClass("ierror"); er=1;}else{$("#region_error").css("display","none");$("#region").removeClass("ierror");}
	if($("#city").val()==""){$("#city_error").css("display","block"); $("#city").addClass("ierror"); er=1;}else{$("#city_error").css("display","none");$("#city").removeClass("ierror");}
	if($("#contact").val()==""){$("#contact_error").css("display","block"); $("#contact").addClass("ierror"); er=1;}else{$("#contact_error").css("display","none");$("#contact").removeClass("ierror");}

	if($("#sname").val()==""){$("#sname_error").css("display","block"); $("#sname").addClass("ierror"); er=1;}else{$("#sname_error").css("display","none");$("#sname").removeClass("ierror");}
	if($("#fname").val()==""){$("#fname_error").css("display","block"); $("#fname").addClass("ierror"); er=1;}else{$("#fname_error").css("display","none");$("#fname").removeClass("ierror");}
	if($("#mname").val()==""){$("#mname_error").css("display","block"); $("#mname").addClass("ierror"); er=1;}else{$("#mname_error").css("display","none");$("#mname").removeClass("ierror");}
	if($("#mphone").val()==""){$("#mphone_error").css("display","block"); $("#mphone").addClass("ierror"); er=1;}else{$("#mphone_error").css("display","none");$("#mphone").removeClass("ierror");}
	if($("#email").val()=="" || email_not_valid.test($("#email").val()) || !email_valid.test($("#email").val())){$("#email_error").css("display","block"); $("#email").addClass("ierror"); er=1;}else{$("#email_error").css("display","none");$("#email").removeClass("ierror");}

	if(er==1) return false;
	$("#tabs").tabs( "option", "disabled", [3] );
	$("#tabs").tabs( "select", 2 );
	$("#tabs").tabs( "option", "disabled", [0,1,3] );
}
function basketStep3(){
    JsHttpRequest.query(
        'loader.php',{'p' : 'basket','act' : 'checkStep3', form : document.getElementById("OrderForm")},
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						$("#tabs").tabs( "option", "disabled", [2] ); $("#tabs").tabs( "select", 3 );
						$("#tabs").tabs( "option", "disabled", [0,1,2] );
						$("#c_fio").html(result['fio']); $("#c_adres").html(result['adres']);
						$("#c_mphone").html(result['mphone']); $("#c_dlv").html(result['dlv']);
						$("#c_pay").html(result['pay']); $("#c_pay").html(result['pay']);
						$("#c_topay").html($("#total").html());
					}
                }else alert('error');
        },
        true
    );
}
function basketBack3(){$("#tabs").tabs( "option", "disabled", [0,1,3] );$("#tabs").tabs( "select", 2);$("#tabs").tabs( "option", "disabled", [0,1,3] );}
function basketBack2(){$("#tabs").tabs( "option", "disabled", [0,2,3] );$("#tabs").tabs( "select", 1);$("#tabs").tabs( "option", "disabled", [0,2,3] );}
function basketBack1(){$("#tabs").tabs( "option", "disabled", [1,2,3] );$("#tabs").tabs( "select", 0);$("#tabs").tabs( "option", "disabled", [1,2,3] );}

function basketSend(){
    JsHttpRequest.query(
        'loader.php',{'p' : 'basket','act' : 'makeOrder', form : document.getElementById("OrderForm")},
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						$("#BOA").html(result['msg']);
					}
                }else alert('error');
        },
        true
    );
}
function toCompare(id,cat,checked){
    JsHttpRequest.query(
        'loader.php',
        {
			 'p' : 'site_server',
			 'act' : 'toCompare',
			 'id' : id,
			 'cat' : cat,
			 'checked' : checked
        },
        function(result, errors){
                //alert(errors); 
                if(result){
					if(result['state'] == 'ERROR'){
						alert(result['msg']); 
					}else{
						alert(result['msg']); 
						$("#CSITEM").html(result['out']);
					}
                }else alert('error');
        },
        true
    );
}