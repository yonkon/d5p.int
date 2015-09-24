/**
* nlsmenu.js v.2.0
* Copyright 2005-2007, addobject.com. All Rights Reserved
* Author Jack Hermanto, www.addobject.com
*/
var nlsMenu = new Object();
var nlsMenuMgr = new Object();
var nlsWinElmt = [];

var ag0=window.navigator.userAgent;
var nls_isIE = (ag0.indexOf("MSIE") >=0);
var nls_isIE5 = (ag0.indexOf("MSIE 5.0") >=0);
var nls_isSafari = (ag0.indexOf("Safari") >=0);
var nls_isOpera = (ag0.indexOf("Opera") >=0);
if (nls_isOpera) {nls_isIE=false; nls_isIE5=false;};

function NlsMenuManager(mgr) {
  this.mgrId = mgr;
  this.menus = new Object();
  this.menubar = null;
  this.timeout = 1000;
  this.flowOverFormElement = false;
  this.assocMenuMgr = [];
  this.defaultEffect=null;
  this.icPath="";
  this.memorizeSel=false;
  this.rt=new Object();
  
  this.tmId = null;
  this.setTimeout=function(a, t) { this.tmId = window.setTimeout(a, t); };
  this.clearTimeout=function() { if (this.tmId!=null) { window.clearTimeout(this.tmId); this.tmId=null;}};
  
  nlsMenuMgr[mgr] = this;
  if(nls_isIE)window.attachEvent("onload", function(){nlsMenuMgr[mgr].init();});
  
  return this;
};

var NlsMnMgr = NlsMenuManager.prototype;
NlsMnMgr.createMenu = function(mId) {
  var m=new NlsMenu(mId)
  m.mgr=this; m.mgrId=this.mgrId; m.icPath=this.icPath;
  m.useEffect(this.defaultEffect);
  if (this.design) { m.$menuItemClick = NlsMenu.$dsItemClick; }
  this.menus[mId]=m;
  return m;
};

NlsMnMgr.createMenubar = function (mbarId) {
  if (this.menubar) alert("Menubar already exists!");
  var m=new NlsMenubar(mbarId);  
  m.mgr=this; m.mgrId=this.mgrId; m.icPath=this.icPath;
  if (this.design) { m.$menuItemClick = NlsMenu.$dsItemClick; }
  this.menubar=m;
  return m;  
};

NlsMnMgr.renderMenus = function (plc) {
  if (plc && plc!="") {
    var d=NlsMenu.$GE(plc); var s="";
    for (it in this.menus) { s+=this.menus[it].renderMenu(); } 
    d.innerHTML=s;
  } else {
    for (it in this.menus) { document.write(this.menus[it].renderMenu()); } 
  }
};

NlsMnMgr.renderMenubar = function (plc) {
  if (this.menubar) {
    if (plc && plc!="") {
      NlsMenu.$GE(plc).innerHTML=this.menubar.renderMenubar();
    } else {
      document.write(this.menubar.renderMenubar());
    }
  }
  if(this.memorizeSel) this.loadPath();
};

NlsMnMgr.hideMenus = function () {
  for (var it in this.menus) {if (this.menus[it].rt.active) this.menus[it].hideMenu();}
  if (this.menubar) this.menubar.hideMenu();
};

NlsMnMgr.addAssocMenuMgr = function(frm, mgrId) {
  this.assocMenuMgr[this.assocMenuMgr.length] = [frm, mgrId];
};

NlsMnMgr.getMenu= function(mId) { return this.menus[mId]; };

NlsMnMgr.init=function() {
  if(this.menubar)this.menubar.init();
}

function listAllWinElmt() {
  nlsWinElmt = [];
  var arrWinEl = document.getElementsByTagName("SELECT");
  var elm; var tmp; var x; var y;
  for(var i=0; i<arrWinEl.length; i++) {
    elm = arrWinEl[i]; tmp=elm; x=0; y=0;
    while (tmp!=null) { 
      x += tmp.offsetLeft; y+=tmp.offsetTop;
      tmp = tmp.offsetParent;
    }
    nlsWinElmt[nlsWinElmt.length] = {e:elm, eX1:x, eY1:y, eX2:x+elm.offsetWidth, eY2:y+elm.offsetHeight};
  }
};

function NlsMenuItem(id, capt, url, ico, enb, xtra, subId, title, crossFrame, subFrame, subPos, subPosAdj, subDir) {
  this.id = id;
  this.intKey = "";
  this.capt = capt;
  this.url = (url==null? "" : url);
  this.ico = (ico==null || ico=="" || ico.length==0) ? null: ico;
  this.enable=(enb==null?true:enb);
  this.xtra = xtra;
  this.stlprf="";
  this.target=null;
  this.title=title==null?"":title;
  this.itemEffect=null;
  this.visible="false";
  this.state=1;
  this.selected=false;
  
  this.subMenuId = (subId?subId:"");
  this.crsFrame = (crossFrame?crossFrame:false);
  this.subFrame = (subFrame?subFrame:null);
  this.subPos = (subPos?subPos:[null,null]);
  this.subPosAdj = (subPosAdj?subPosAdj:[0,0]);
  this.subDir = (subDir?subDir:["right","down"]);
  this.toString=function() {return "NlsMenuItem";};
  
  this.useItemEffect=function(effName) {
    this.itemEffect=new NlsMenuItemEffect(this.intKey, effName);
  };
  
  this.rt={subUrl:null,loaded:0};
  
  return this;
};

function NlsMenuSeparator(cstSeparator) {
  this.stlprf = "";
  this.intKey = "";
  this.seprt = cstSeparator!=null?cstSeparator:"";
  this.render = function () {
    if (this.seprt!="") return this.seprt;
    return ("<table border=0 cellpadding=0 cellspacing=0 width='100%' height='0%'><tr>" + 
            "<td class=\""+this.stlprf+"nlsseparator\"></td>" + 
            "</tr></table>");
  };
                 
  this.toString=function() {return "NlsMenuSeparator";};
};

function NlsCustomMenuItem(cst) {
  this.intKey = "";
  this.cstMenu = (cst?cst:"&nbsp;");
  this.toString=function() {return "NlsCustomMenuItem";};
};
 
function NlsMenu(mId) {
  /*private*/
  this.lsItm=null;
  this.mgrId = "";
  this.mgr=null;
  this.winElmt=null;
  this.container=null;
  this.customBorder=null;
  this.shadow=new NlsMenuShadow("none", "5px", mId);
  this.count=0;
  this.isMenubar=false;
  this.effect=null;
  this.srItems=[];
  
  this.rt={ready:true,active:false};
  
  /*public*/
  this.mId = mId;
  this.items = new Object();
  this.stlprf="";
  this.subMenuIc=null;
  this.target="_self";
  this.icPath="";
  this.itemSpc="";
  this.stretchItem=true;
  
  this.selection=false;
  
  this.showIcon=false;
  this.showSubIcon=true;
 
  this.absWidth="";
  this.orient="V";

  this.defItmEff=null;
  this.defPos=[0,0];
  
  this.maxItemCol=100;
  this.zIndex = 100;
  
  this.wnd = window;
  nlsMenu[mId] = this;
  return this;
};

var NLSMENU=NlsMenu.prototype;

NLSMENU.addItem = function(key, capt, url, ico, enb, xtra, subId, title) {
  var intKey = this.mId+"_"+key;
  var it = new NlsMenuItem(key, capt, url, ico, enb, xtra, subId, title);
  it.intKey = intKey;
  it.mId=this.mId;
  this.items[intKey]=it;
  this.srItems[this.srItems.length]=it;
  if (this.defItmEff!=null && typeof(NlsMenuItemEffect) != "undefined") { it.useItemEffect(this.defItmEff); }
  this.count++;
  return it;
};

NLSMENU.addSeparator = function(separator) { 
  var intKey = "sep_"+this.count;
  var it = (separator ? separator : new NlsMenuSeparator());
  it.stlprf = this.stlprf;
  it.intKey = intKey;
  this.items[intKey] = it;
  this.srItems[this.srItems.length]=it;
  this.count++;
  return it;
};

NLSMENU.addSubmenu = function(key, subId, crsFrame, subFrame, subPos, subPosAdj, subDir) {
  var intKey = this.mId+"_"+key;
  var it = this.items[intKey];
  it.subMenuId=subId;
  it.subFrame=(subFrame?subFrame:null);
  it.crsFrame=(crsFrame?crsFrame:false);
  it.subPos = (subPos?subPos:[null,null]);
  it.subPosAdj = (subPosAdj?subPosAdj:[0,0]);
  it.subDir = (subDir?subDir:["right","down"]);
  return it;
};

NLSMENU.addCustomMenu = function (custom) {
  var intKey = "cst_"+this.count;
  var it = new NlsCustomMenuItem(custom);
  it.intKey = intKey;
  this.items[intKey] = it;
  this.srItems[this.srItems.length]=it;
  this.count++;
  return it;
};

NLSMENU.getItemById = function (key) {
  return this.items[this.mId+"_"+key];
};

NLSMENU.setItemStyle = function (key, stlprf) {
  var intKey = this.mId+"_"+key;
  var mnItem = this.items[intKey];
  mnItem.stlprf=stlprf;
};

NLSMENU.setItemText = function (key, tx) {
  var intKey = this.mId+"_"+key;
  var mnItem = this.items[intKey];
  mnItem.capt=tx;
  var oD=NlsMenu.$GE(intKey+"x2");
  if (oD) oD.innerHTML=tx;
}

NLSMENU.enableItem = function (key, b) {
 var it = this.items[this.mId+"_"+key] ;
 it.enable=b;
 setMnStyle(NlsMenu.$GE(it.intKey), (b?(it.selected?"S":"N"):"D"), NlsMenu.getPrf(it, this));
 setMnIcon(this, it, "N");
};

NLSMENU.dropShadow = function (pos, offset) {
  if (this.shadow) { this.shadow.pos=pos; this.shadow.offset=(offset?offset:"5px"); } else
  { this.shadow=new NlsMenuShadow(pos, offset, this.mId); }
};

NLSMENU.applyBorder = function (bTop, bBottom, bLeft, bRight) {
  if (!bTop && !bBottom && !bLeft && !bRight) {
    this.customBorder=null;
  } else {
    this.customBorder=new NlsMenuBorder(bTop, bBottom, bLeft, bRight);
  }
};

NLSMENU.useEffect = function (efN) {
  if(efN!=null && efN!="") {
    this.effect=new NlsMenuEffect(this.mId, efN);
  }
};

NLSMENU.renderMenu = function() {
  var scPath="", sbIc=null;
  var allScs = (document.getElementsByTagName ? document.getElementsByTagName("SCRIPT"): document.scripts);
  for (var i=0;i<allScs.length;i++) {
    if (allScs[i].src.toLowerCase().indexOf("nlsmenu.js")>=0) { scPath=allScs[i].src.replace(/nlsmenu.js/gi, ""); }
  }
  if (!this.subMenuIc) { sbIc=[scPath+"img/account.png", scPath+"img/account.png"];} 
  else {sbIc=[this.icPath+this.subMenuIc[0]]; if(this.subMenuIc[1])sbIc[1]=this.icPath+this.subMenuIc[1];}
  
  var cs="<table cellpadding='0' cellspacing='0' ";
  var sAbs=(this.absWidth==""?"":"width='"+this.absWidth+"'");
  var smenu="<table cellpadding='0' cellspacing='"+(this.itemSpc==""?"0":this.itemSpc)+"' width='100%'>";
  var tmpCnt=0, prf=this.stlprf, it=null, rt=null, menu=null;
  for (var i=0; i<this.srItems.length; i++) {
    it=this.srItems[i];
    menu=nlsMenu[it.subMenuId];
    if(!it.crsFrame) {
      if(menu)menu.prIt=it.intKey;
      if(!menu && it.rt && !it.rt.subUrl) { it.subMenuId=""; }
    }
    if (it.toString()=="NlsMenuSeparator") {
      smenu+=(this.orient=="V"?"<tr>":"");
      smenu+=("<td class='"+this.stlprf+"nlsseparatorcontainer'>"+it.render()+"</td>");
      smenu+=(this.orient=="V"?"</tr>":"");
    } else 
    if (it.toString()=="NlsCustomMenuItem") {
      smenu+=(this.orient=="V"?"<tr>":"");
      smenu+=("<td>"+it.cstMenu+"</td>");
      smenu+=(this.orient=="V"?"</tr>":"");
    } else {
      prf=NlsMenu.getPrf(it, this);      
      if (this.orient=="V") { smenu+="<tr>"; }
      if (this.orient=="H") { if (tmpCnt==0) smenu+="<tr>"; tmpCnt++; }
      smenu+="<td align='center' id=\""+it.intKey+"\" class=\""+prf+"nlsitemcontainer\" onmouseover=\"nlsMenuItemOver(event, '"+it.intKey+"')\" onclick=\"return nlsMenu['"+this.mId+"'].$menuItemClick(event, '"+it.intKey+"');\">";
      smenu+=cs+(this.stretchItem?"width='100%'":"")+" height='100%'><tr style=\"cursor:pointer;\" title=\""+it.title+"\">";
      
      if (this.showIcon) { 
        smenu+="<td id=\""+it.intKey+"x1\" class=\""+prf+"nlsiconcell\" align=\"center\" nowrap>";
          if(it.ico) {
            if(it.ico[0]) smenu+="<img id=\"ic_"+it.intKey+"\" "+(it.enable?"":"style='display:none'")+" src=\""+this.icPath+it.ico[0]+"\">";
            if(it.ico[1]) smenu+="<img id=\"icovr_"+it.intKey+"\" style='display:none' src=\""+this.icPath+it.ico[1]+"\">";
            if(it.ico[2]) smenu+="<img id=\"icdis_"+it.intKey+"\" "+(!it.enable?"":"style='display:none'")+" src=\""+this.icPath+it.ico[2]+"\">";
          }
        smenu+="</td>"; 
      }
      
      smenu+="<td align='left' id=\""+it.intKey+"x2\" class=\""+prf+(it.enable?"nlsitem\"":"nlsitemdisable\"")+" nowrap>"+it.capt+"</td>";
      if (this.showSubIcon && it.subMenuId!="")  { smenu+="<td id=\""+it.intKey+"x3\" class=\""+prf+"nlssubmenucell\" align=\"center\" nowrap>"+ (it.subMenuId!=""? "<img id='subic_"+it.intKey+"' src=\""+sbIc[0]+"\">" + (sbIc.length>1?"<img id='subicovr_"+it.intKey+"' style='display:none' src=\""+sbIc[1]+"\">":"") :"") +"</td>"; }
      smenu+="</tr></table>";
      smenu+="</td>";
      if (this.orient=="V") { smenu+="</tr>"; }
      if (this.orient=="H" && tmpCnt==this.maxItemCol) { smenu+="</tr>"; tmpCnt=0; }
    }
  }
  
  if(this.orient=="H" && tmpCnt!=0 ) {
    if(this.srItems.length>this.maxItemCol)
      while(++tmpCnt<=this.maxItemCol) smenu+="<td class=\""+prf+"nlsitemcontainer\">&nbsp;</td>";
    smenu+="</tr>";
  }
  smenu += "</table>";
  smenu = cs+"class='"+this.stlprf+"nlsmenu' "+ sAbs + "><tr><td>"+smenu+"</td></tr></table>";
    
  if (this.customBorder!=null) smenu = this.customBorder.applyBorder(smenu, this.stlprf);
  smenu = this.shadow.dropShadow(smenu);

  smenu = "<div " + (nls_isIE && !this.isMenubar?"style='position:absolute;z-index:"+(this.zIndex-1)+";'":"") + ">" + smenu;
  if (!this.isMenubar &&  nls_isIE && !nls_isIE5 && this.mgr.flowOverFormElement) {
    smenu += "<iframe id='"+this.mId+"ifrm' scrolling='no' frameborder=0 width='1' height='1' style='position:absolute;top:0px;left:0px;z-index:-1;filter:alpha(opacity=0)' src='"+scPath+"img/blank.gif"+"'></iframe>"; 
  }
  smenu+="</div>";
  
  if (arguments[0]=="content") return smenu;
  
  smenu = "<div id='"+this.mId+"' style="+(this.isMenubar?"''":"'position:absolute;z-index:"+this.zIndex+";display:none;'")+" onmouseover=\"_nlsMenuItemOver('"+this.mgrId+"')\" onmouseout=\"nlsMenuItemOut('"+this.mgrId+"')\">" + smenu + "</div>";

  return smenu;
};

NLSMENU.init=function() {
  var v=this.rt.vshade; if(!v) v=NlsMenu.$GE("vshade_"+this.mId);
  var itm=this.rt.actmn; if(!itm) itm=NlsMenu.$GE("actmn_"+this.mId);
  if(v){
    var o=itm.childNodes[0].offsetHeight-parseInt(this.shadow.offset);
    if(o>=0) v.style.height=o+"px";
  }
  this.rt.actmn=itm;
  this.rt.vshade=v;
};

function NlsMenuShadow(pos, offset, mId) {
  this.pos=pos;
  this.offset=offset;
  this.mId=mId;

  this.dropShadow = function (smenu) {
    var mn = nlsMenu[this.mId];
    var cs="<table cellpadding=0 cellspacing=0 ";
    var shadow = "<div>"+cs+"id='effwin_"+this.mId+"' height='0px'>";
    var hshadow = "<td style='padding-@@PAD:"+this.offset+";'>"+cs+"width='100%' height='5px' class='"+mn.stlprf+"horzshadow'><tr><td></td></tr></table></td>";
    var vshadow = "<td style='padding-@@PAD:"+this.offset+";height:100%;'>"+cs+"id='vshade_"+this.mId+"' width='5px' height='100%' class='"+mn.stlprf+"vertshadow'><tr><td></td></tr></table></td>";
    var menutd = "<td id='actmn_"+this.mId+"'>"+smenu+"</td>";
    var cornertd = "<td class='"+mn.stlprf+"cornshadow' width='5px' height='5px'></td>";
    var av=[vshadow.replace(/@@PAD/gi,"top"), vshadow.replace(/@@PAD/gi,"bottom")];
    var ah=[hshadow.replace(/@@PAD/gi,"left"), hshadow.replace(/@@PAD/gi,"right")];
    switch (this.pos) {
      case "none":
        shadow += "<tr>"+menutd+"</tr>";
        break;
      case "bottomright" :
        shadow += "<tr>"+menutd+av[0]+"</tr>" + 
          "<tr>"+ah[0]+cornertd+"</tr>";
        break;
      case "bottomleft" :
        shadow += "<tr>"+av[0]+menutd+"</tr>" + 
          "<tr>"+cornertd+ah[1]+"</tr>";
        break;
      case "topleft" :
        shadow += "<tr>"+cornertd+ah[1]+"</tr>" + 
          "<tr>"+av[1]+menutd+"</tr>";
        break;
      case "topright" :
        shadow += "<tr>"+ah[0]+cornertd+"</tr>" + 
          "<tr>"+menutd+av[1]+"</tr>";
        break;
    }
    return shadow + "</table></div>";  
  };
};

NLSMENU.showMenu = function(x1, y1, x2, y2, mnOrient, subDir, subAdj) {
  this.mgr.clearTimeout();
  
  if(this.menuOnShow(this.mId)==false)return; 
  
  var ctx = NlsMenu.$GE(this.mId);
  if (!ctx) return;
  ctx.style.visibility="hidden";
  ctx.style.display="";
  if(nls_isIE)this.init();
  
  var w=window, d=document.body, de=document.documentElement;
  var scrOffX = w.scrollX||d.scrollLeft||de.scrollLeft;
  var scrOffY = w.scrollY||d.scrollTop||de.scrollTop;
  var cW=w.innerWidth||d.clientWidth;
  var cH=w.innerHeight||d.clientHeight;
  var mW=ctx.childNodes[0].offsetWidth;
  var mH=ctx.childNodes[0].offsetHeight;
  var sDir=(subDir?[subDir[0], subDir[1]]:["right", "down"]);
  var adjX=(subAdj?subAdj[0]:this.defPos[0]), adjY=(subAdj?subAdj[1]:this.defPos[1]);
  
  var dmfrm = NlsMenu.$GE(this.mId+"ifrm");
  if (dmfrm) { 
    var actMn = NlsMenu.$GE("actmn_"+this.mId).children[0];
    dmfrm.width = actMn.offsetWidth;
    dmfrm.height = actMn.offsetHeight;
  }
  var mX=0,mY=0;
  if (mnOrient=="V") {
    if (sDir[0]=="right") {
      if(x2+mW>cW){if(x1>=mW){mX=x1-mW+adjX+scrOffX;sDir[0]="left"}else{mX=cW-mW-1+scrOffX;}}else{mX=x2+scrOffX-adjX;}
    } else {
      if(x1-mW<0){if(x2+mW<cW){mX=x2-adjX+scrOffX;sDir[0]="right"}else{mX=scrOffX;}}else{mX=x1-mW+adjX+scrOffX;}
    }
    if (sDir[1]=="down") {
      if(y1+mH>cH){if(y2>=mH){mY=y2-mH+scrOffY-adjY;sDir[1]="up"}else{mY=cH-mH-1+scrOffY;}}else{mY=y1+scrOffY+adjY;}
    } else {
      if(y1-mH<0){if(y1+mH<cH){mY=y1+scrOffY-adjY;sDir[1]="down"}else{mY=scrOffY;}}else{mY=y2-mH+scrOffY-adjY;}
    }
  } else { 
    if (sDir[0] == "right") {
      if(x1+mW>cW){if(x2>=mW){mX=x2-mW+scrOffX-adjX;sDir[0]="left"}else{mX=cW-mW-1+scrOffX;}}else{mX=x1+scrOffX+adjX;}
    } else {
      if(x2-mW<0){if(x1+mW<cW){mX=x1+scrOffX+adjX;sDir[0]="right"}else{mX=scrOffX;}}else{mX=x2-mW+scrOffX-adjX;}
    }
    if (sDir[1] == "down") {
      if(y2+mH>cH){if(y1>=mH){mY=y1-mH+scrOffY+adjY;sDir[1]="up"}else{mY=cH-mH-1+scrOffY;}}else{mY=y2+scrOffY-adjY;}
    } else {
      if(y1-mH<0){if(y2+mH<cH){mY=y2+scrOffY-adjY;sDir[1]="down"}else{mY=scrOffY;}}else{mY=y1-mH+scrOffY+adjY;}
    }
  }
  
  if (nls_isIE5 || !this.mgr.flowOverFormElement) {
    if (this.winElmt==null) hideWinElmt(this, mX, mY, mX+mW, mY+mH);
    if (this.winElmt==null) this.winElmt=[];
    for(var i=0;i<this.winElmt.length;i++) {
      this.winElmt[i].style.visibility="hidden";
    }
  }
  with (ctx.style) { 
    left=mX+"px"; top=mY+"px"; 
    zIndex = this.zIndex; 
    if (this.effect) { 
      with (this.effect) {prop["dir"]=sDir[(mnOrient=="V"?0:1)]; start(false); visibility="visible"; run();}
    } else { visibility="visible"; }
  }
  this.rt.active=true;
};

function hideWinElmt(mn, mX1, mY1, mX2, mY2) {
  var oe;
  for (var i=0; i<nlsWinElmt.length; i++) {
    oe = nlsWinElmt[i];
    if ((oe.eX1>=mX1 && oe.eX1<=mX2 && oe.eY1>=mY1 && oe.eY1<=mY2) ||
        (oe.eX1>=mX1 && oe.eX1<=mX2 && oe.eY2>=mY1 && oe.eY2<=mY2) ||
        (oe.eX2>=mX1 && oe.eX2<=mX2 && oe.eY1>=mY1 && oe.eY1<=mY2) ||
        (oe.eX2>=mX1 && oe.eX2<=mX2 && oe.eY2>=mY1 && oe.eY2<=mY2) ||
        (mX1>=oe.eX1 && mX1<=oe.eX2 && mY1>=oe.eY1 && mY1<=oe.eY2) ||
        (mX1>=oe.eX1 && mX1<=oe.eX2 && mY2>=oe.eY1 && mY2<=oe.eY2) ||
        (mX2>=oe.eX1 && mX2<=oe.eX2 && mY1>=oe.eY1 && mY1<=oe.eY2) ||
        (mX2>=oe.eX1 && mX2<=oe.eX2 && mY2>=oe.eY1 && mY2<=oe.eY2) ||
        (oe.eX1<mX1 && oe.eX2>mX2 && oe.eY1>=mY1 && oe.eY1<=mY2) ||
        (oe.eX1<mX1 && oe.eX2>mX2 && oe.eY2>=mY1 && oe.eY2<=mY2)
       ) {
      if (oe.e.style.visibility!="hidden") {
        oe.e.style.visibility="hidden";
        if (mn.winElmt==null) mn.winElmt=[];
        mn.winElmt[mn.winElmt.length]=oe.e;
      }
    }
  }
};

NLSMENU.showMenuAbs = function(x, y) {
  var ctx = NlsMenu.$GE(this.mId);
  ctx.style.top=y+"px"; ctx.style.left=x+"px"; 
  ctx.style.display="";
  this.rt.active=true;
};

NLSMENU.hideMenu = function() {
  var ctx = NlsMenu.$GE(this.mId);
  if (!ctx) return;
  if (!this.isMenubar) {
    this.rt.active=false;
    if (this.effect) {
      this.effect.start(true); 
      if ((nls_isIE && this.effect.effName!="aoslide") || nls_isOpera && this.effect.effName!="aoslide") {ctx.style.visibility="hidden";} else { this.effect.onHide=function() {ctx.style.visibility="hidden";}; };
      this.effect.run();
    } else { ctx.style.visibility="hidden"; }
  
    this.menuOnHide(this.mId);
  } else {
    this.isMenuOpened = false;
  }
  
  if (this.lsItm!=null) {
    var it=this.items[this.lsItm.id];
    if(it.state!=2 && !it.selected) {
      setMnStyle(this.lsItm, (it.enable?"N":"D"), NlsMenu.getPrf(it, this)); 
      setMnIcon(this, it, "N");
    }
    this.lsItm=null;
  }
  if (this.winElmt!=null && this.winElmt.length>0) {
    for (i=0;i<this.winElmt.length;i++) {
      this.winElmt[i].style.visibility = "visible";
    }
  }
  if (typeof(window.status)!="undefined") window.status="";
};

NLSMENU.hasSubmenu=function(key) {
  var s=this.items[this.mId+"_"+key].subMenuId;
  return(nlsMenu[s]);
};

function $itemClick(mn, it) {
  var mnMgr = nlsMenuMgr[mn.mgrId];
  mnMgr.hideMenus();
  var assMgr = mnMgr.assocMenuMgr;
  if ( assMgr && assMgr.length > 0) {
    for (var i=0;i<assMgr.length;i++) { assMgr[i][0].hideAllNlsMenu(); }
  }  

  var trgt=it.target;
  if (trgt==null) trgt=mn.target!=null?mn.target:"_self";
  if (it.url!="") {
    window.open(it.url, trgt);
  } else {
    return mn.menuOnClick(mn.mId, it.id);
  }  
};

NLSMENU.$menuItemClick = function(e, itemId) {
  if (!this.items[itemId].enable) return;

  var it=this.items[itemId], prf=NlsMenu.getPrf(it, this);
  var oIt = NlsMenu.$GE(itemId), mgr=this.mgr;
  
  if(this.isMenubar && this.dropOnClick && this.hasSubmenu(it.id)) {
    if(!this.isMenuOpened) {
      NlsMenu.showMenu(this, it);
      this.isMenuOpened = true;
    } else {
      mgr.hideMenus();      
      setMnStyle(oIt, (it.enable ? "O" : "D"), prf); 
      setMnIcon(this, it, "O");
      this.isMenuOpened = false;
      return null;
    }
  } else {
    if(it.toggle) {
      this.setItemState(itemId, (it.state==1?2:1));
    } else if(this.selection) {
      this.setSelection(itemId, true);
    } else if(mgr.memorizeSel) {
      mgr.selectPath(this.mId, it.id);
      mgr.savePath(itemId);
    }
    $itemClick(this, it);
  }
};

NLSMENU.menuOnClick = function (menuId, itemId) {return true;};
NLSMENU.menuOnShow = function (menuId) {return true;};
NLSMENU.menuOnHide = function (menuId) {return true;};

NLSMENU.reload = function(dh) {
  var ef=this.effect;
  if(ef) { ef.elm=null; ef.prop["init"]=false; }
  if(dh!=true) this.mgr.hideMenus();
  var m=NlsMenu.$GE(this.mId);
  m.innerHTML=this.renderMenu("content");
};

function setMnIcon(mn, mnItm, f) {
  var tf=(mnItm.enable?f:"D");
  if (mn.showIcon && mnItm.ico && mnItm.ico.length>1) {
    var k=mnItm.intKey;
    var c=NlsMenu.$GE("ic_"+k), o=NlsMenu.$GE("icovr_"+k), d=NlsMenu.$GE("icdis_"+k);
    
    c.style.display=(tf=="N"||(tf=="D" && !d)?"":"none");
    o.style.display=(tf=="O"?"":"none");
    if(d) d.style.display=(tf=="D"?"":"none");
  }
  
  if (mn.showSubIcon && mnItm.subMenuId!="") {
    var ic=NlsMenu.$GE("subicovr_"+mnItm.intKey);
    if(ic){
      ic.style.display=(tf=="O"?"":"none");
      ic=NlsMenu.$GE("subic_"+mnItm.intKey);
      if(ic)ic.style.display=(tf=="N"||tf=="D"?"":"none");
    }
  } 
};

function setMnStyle(it, s, prefix) {
  var suff=(s=="O"?"over":(s=="S"?"sel":""));
  it.className=prefix+"nlsitemcontainer"+suff;
  var r = it.childNodes[0].rows[0], rc=null;
  for (var i=0; i<r.cells.length; i++) {
    rc=r.cells[i];
    if(rc.id==it.id+"x1") rc.className=prefix+"nlsiconcell"+suff;
    if(rc.id==it.id+"x2") rc.className=prefix+"nlsitem"+(s=="D"?"disable":suff);
    if(rc.id==it.id+"x3") rc.className=prefix+"nlssubmenucell"+suff; 
  }
};

function nlsMenuItemOver(e, itId) {
  var m=itId.split("_");
  var prMenu = nlsMenu[m[0]];
  if(prMenu.mgr.design==true)return;
  var li = prMenu.lsItm;
  if (!prMenu.rt.active || !prMenu.rt.ready) return;
  
  var it=null, st="", nli=null;
  if (li!=null) {
    it=prMenu.items[li.id];
    if (it.intKey==itId) return;
    if(it.state!=2 && !it.selected) { /*toggle pressed*/
      var st=NlsMenu.getPrf(it, prMenu);
      var ef=(it.itemEffect!=null);
      if (ef) { it.itemEffect.init(); }
      setMnStyle(li, (it.enable ? "N" : "D"), st);
      setMnIcon(prMenu, it, "N");
      if (ef) { it.itemEffect.start(); }
    }
      
    var tmp=(it.crsFrame?it.subFrame.nlsGetMenu(it.subMenuId):nlsGetMenu(it.subMenuId));
    while(tmp!=null) { 
      nli = null;
      if (tmp.lsItm) {
        it=tmp.items[tmp.lsItm.id];
        nli = (it.crsFrame ? it.subFrame.nlsGetMenu(it.subMenuId) : tmp.wnd.nlsGetMenu(it.subMenuId));
      } 
      tmp.hideMenu(); tmp=nli; 
    }
  }
  
  var oIt = NlsMenu.$GE(itId);
  it=prMenu.items[itId];
  if (typeof(window.status)!="undefined") window.status=it.url;
  if(it.state!=2 && !it.selected) {
    if (it.itemEffect!=null) { it.itemEffect.init(); }
    setMnStyle(oIt, (it.enable ? "O" : "D"), NlsMenu.getPrf(it, prMenu)); 
    setMnIcon(prMenu, it, "O");
    if (it.itemEffect!=null) { it.itemEffect.start(); }
  }
  
  if (!prMenu.isMenubar || 
      (prMenu.isMenubar && !prMenu.dropOnClick) || 
      (prMenu.isMenubar && prMenu.dropOnClick && prMenu.isMenuOpened)) { NlsMenu.showMenu(prMenu, it); }
  
  prMenu.lsItm=oIt;
};

function nls_getXY(oIt) {
  var p=new Object(); p.x=0;p.y=0;p.x2=0;p.y2=0; var tmp=oIt;var d=document;
  while(tmp) { p.x+=tmp.offsetLeft; p.y+=tmp.offsetTop; tmp=tmp.offsetParent } ;
  p.x -= (window.scrollX||d.body.scrollLeft||d.documentElement.scrollLeft); 
  p.y -= (window.scrollY||d.body.scrollTop||d.documentElement.scrollTop); 
  if (oIt) { p.x2=p.x+oIt.offsetWidth; p.y2=p.y+oIt.offsetHeight;};
  return p;
};

NlsMenu.showMenu=function(mn, it) {
  if(it.rt.subUrl && it.rt.loaded==0) {
    //ajax menu
    NlsMenuUtil.loadAJAXMenu(mn,it);
  } else {
    NlsMenu.$showMenu(mn,it);
  }
}

NlsMenu.$showMenu=function(prMenu, it) {
  var oIt = NlsMenu.$GE(it.intKey);
  if (it.subMenuId!="" && it.enable==true) {
    var p=nls_getXY(oIt), smn=null;
    if (it.crsFrame) {
      var ps=it.subPos;
      if (ps[0]=="REL") { } else { p.x = ps[0]; p.x2=p.x; }
      if (ps[1]=="REL") { } else { p.y = ps[1]; p.y2=p.y; }
      if (!it.subFrame.nlsGetMenu) return;
      smn = it.subFrame.nlsGetMenu(it.subMenuId);
      if (!smn) return;
    } else {
      smn = nlsGetMenu(it.subMenuId);
      if (!smn) return;
      if (smn.zIndex <= prMenu.zIndex) { smn.zIndex = prMenu.zIndex+1 }
      
    }
    smn.showMenu(p.x, p.y, p.x2, p.y2, prMenu.orient, it.subDir, it.subPosAdj);
  }
};

NlsMenu.getPrf=function(it, mn) {
  if(!it.stlprf || it.stlprf=="")return mn.stlprf; else return it.stlprf;
}

function nls_showMenu(mId, oIt, orient, subDir, subPosAdj) {
  var sMenu = nlsGetMenu(mId);
  if (!sMenu) { hideAllNlsMenu(); return;} 
  sMenu.mgr.clearTimeout();
  if (sMenu.rt.active) return;
  var p=nls_getXY(oIt);
  sMenu.mgr.hideMenus();
  sMenu.showMenu(p.x, p.y, p.x2, p.y2, orient, subDir, subPosAdj);
}

function nls_hideMenu(mId) {
  var sMenu = nlsGetMenu(mId);
  if (!sMenu) return;
  nlsMenuItemOut(sMenu.mgrId);
}

function _nlsMenuItemOver(mgrId) {
  var mgr = nlsMenuMgr[mgrId];
  if(mgr.design==true) return;  
  mgr.clearTimeout();
  
  var am = mgr.assocMenuMgr;
  if ( am && am.length > 0) {
    for (var i=0; i<am.length; i++) {
      if (!am[i][0].nlsMenuMgr) continue;
      am[i][0].nlsMenuMgr[am[i][1]].clearTimeout();
    }
  } 
  for (var it in nlsMenuMgr) {
    if (it!=mgrId) {
      nlsMenuMgr[it].hideMenus();
    }
  }
};

function nlsMenuItemOut(mgrId) {
  var mnMgr = nlsMenuMgr[mgrId];
  if(mnMgr.design==true) return;
  mnMgr.clearTimeout();
  mnMgr.setTimeout(function() { _nlsMenuItemOut(mgrId) }, mnMgr.timeout);

  var assMgr = mnMgr.assocMenuMgr;
  if ( assMgr && assMgr.length > 0) {
    for (var i=0; i<assMgr.length; i++) {
      var frm = assMgr[i];
      if (!frm[0].nlsMenuMgr) continue;
      frm[0].nlsMenuMgr[frm[1]].clearTimeout();
      frm[0].nlsMenuMgr[frm[1]].setTimeout(function() { frm[0]._nlsMenuItemOut(mgrId); }, mnMgr.timeout);
    }
  }
};

function _nlsMenuItemOut(mgrId) {
  nlsMenuMgr[mgrId].hideMenus();
};

function nlsGetMenu(mId) {
  return nlsMenu[mId];
};

/*===================================================*/
/*NlsMenuBar class*/
/*===================================================*/

NLSMENU.isMenuOpened = false;

NLSMENU.dropOnClick = false;

NLSMENU.renderMenubar = function () {
  return this.renderMenu();
};

function NlsMenubar(mId) {
  var mnBar = new NlsMenu(mId);
  mnBar.isMenubar=true;
  mnBar.rt.active=true;
  return mnBar;
};

/*===================================================*/
/*Public general methods*/
/*===================================================*/

function hideAllNlsMenu() {
  for (it in nlsMenu) {if (nlsMenu[it].rt.active) nlsMenu[it].hideMenu();}
};

/**Cross browser related methods*/
NlsMenu.$GE=function(id) {
  if (document.all) {
      return document.all(id);
  } else
  if (document.getElementById) {
      return document.getElementById(id);
  }
};


