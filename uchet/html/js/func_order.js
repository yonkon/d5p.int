function addFileField(namefield, parent){
		var div = document.createElement("div");
		div.innerHTML = "<input name=\"" + namefield + "[]\" type=\"file\" class=\"normal_border less_width\" /> &nbsp; <input type=\"button\" onclick=\"return deleteField(this)\" value=\" - \">";
		document.getElementById(parent).appendChild(div);
}

function deleteField(a) {
	var contDiv = a.parentNode;
	contDiv.parentNode.removeChild(contDiv);
}

function syncList(){}
syncList.prototype.sync = function(){
	for (var i=0; i < arguments.length-1; i++)	document.getElementById(arguments[i]).onchange = (function (o,id1,id2){return function(){o._sync(id1,id2);};})(this, arguments[i], arguments[i+1]);
	document.getElementById(arguments[0]).onchange();
}
syncList.prototype._sync = function (firstSelectId, secondSelectId){
	var firstSelect = document.getElementById(firstSelectId);
	var secondSelect = document.getElementById(secondSelectId);
	secondSelect.length = 0;
	if (firstSelect.length>0){
		var optionData = this.dataList[ firstSelect.options[firstSelect.selectedIndex==-1 ? 0 : firstSelect.selectedIndex].value ];
		for (var key in optionData || null) secondSelect.options[secondSelect.length] = new Option(optionData[key], key);
		if (firstSelect.selectedIndex == -1) setTimeout( function(){ firstSelect.options[0].selected = true;}, 1 );
		if (secondSelect.length>0) setTimeout( function(){ secondSelect.options[0].selected = true;}, 1 );
	}
	secondSelect.onchange && secondSelect.onchange();
};