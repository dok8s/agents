function announcement(){
  var _self=this;
  _self.classname = "announcement.js";

  var tmpScreen;
  var paramObj;
  var _top;
  var _mc = new Object();
  var selAry = new Object();
  var def_input = "";

  _self.init=function(Top, Div, Param){
    _self.debugPrint("init announcement.js");
    _top = Top
    tmpScreen = Div;
    paramObj = Param;
    _mc["annType"] = "";
    _mc["showType"] = "general";
    _mc["msgData"] = "";
    _mc["selText"] = "";
    _mc["date"] = "All";

    selAry["general"] = new Array("All","Today","Yesterday","Before");
    selAry["important"] = new Array("All","Today","Yesterday","Before");
    selAry["personal"] = new Array("All","Today","Yesterday");

    if(paramObj.annType != null) _mc["annType"] = paramObj.annType;
    if(paramObj.showtype != null) _mc["showType"] = paramObj.showtype;
    if(paramObj.selText != null) _mc["selText"] = paramObj.selText;
    if(paramObj.date != null) _mc["date"] = paramObj.date;


    //data list
    _mc["announcement_contain"] = _top["Util"].getSpan(tmpScreen,"div","announcement_contain");
    _self.initObj(_mc["announcement_contain"]);
    _self.initStatus();
    _self.showList();
  }

  _self.initObj=function(div){

    var objid = ",top_nav_container,general_btn,important_btn,personal_btn,top_title,title_span,date_container,annoDiv,announceDiv,announceTable,announceTr,anno_table_title,date_title_ann,title_btn,datetime,mdate,date_select_box,sel_label,sel_date,search_box,search_input,search_btn,delete_txt,text,viewmore_contain,btn,no_data,";
    var ary = _top["Util"].getObjAry(div, objid);
    _mc = _top["Util"].mergeArray(_mc ,ary);


    _mc["announceTable_bak"] = _mc["announceTable"].cloneNode(true);

    _self.initOption(_mc["sel_date"], selAry, paramObj.showtype, _mc["date"]);


    //top_nav_container
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["general_btn"]);
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["important_btn"]);
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["personal_btn"]);

    //anno_table_title
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["title_btn"]);

    //date_select_box
    //_top["obj"].addEventListener("SelectEvent.ONCHANGE", _self.changeSelect, _mc["sel_date"]);
    _mc["sel_date"].JS.addEventListener("ONCHANGE",_self.changeSelect);

    //search_box
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["search_btn"]);
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["delete_txt"]);
    // key event 150729 joe ==============================================================
    _self.addEventListener("KeyEvent.KEY_PRESS", _self.keyPressEvent, _mc["search_input"]);
    //====================================================================================
    if(_top["Util"].isIE()&&def_input==""){
      _self.addEventListener("Event.ONFOCUS", _self.inputFocus, _mc["search_input"]);
      _self.addEventListener("Event.ONBLUR", _self.inputBlur, _mc["search_input"]);
      def_input = _top["LS"].getLS("input_search");
      _mc["search_input"].value = def_input;
    }

    //viewmore_contain
    _top["obj"].addEventListener("MouseEvent.CLICK", _self.clickBtn, _mc["btn"]);

    _mc["annType"] = _mc["general_btn"].innerHTML;
    if(paramObj.showtype != null) _mc["annType"] = _mc[paramObj.showtype+"_btn"].innerHTML;
    if(paramObj.selText != null) _mc["search_input"].value = paramObj.selText;
    //if(paramObj.date != null) _mc["sel_date"].value = paramObj.date;
    if(paramObj.date != null) _mc["sel_date"].JS.setSelected(paramObj.date);

    getMaxTable =new _top["MaxTable"](_mc["announceTable"],"announceTr");
    getMaxTable.init();
  }

  _self.inputFocus=function(mouseEvent, targetObj){
    if(targetObj.value==def_input){
      targetObj.value = "";
    }
  }

  _self.inputBlur=function(mouseEvent, targetObj){
    if(targetObj.value==""){
      targetObj.value = def_input;
    }
  }

  _self.initOption=function(selObj, selAry, showtype, selDate){

    var ary = selAry[showtype];
    if(ary==null) ary=selAry["general"];

    //selObj.options.length = 0;
    selObj.JS.clearOption();

    for(var i=0; i<ary.length; i++){
      var _value = ary[i];
      var _txt = _top["LS"].getLS("announcement_"+ary[i]);

      //var varItem = new Option(_txt, _value, false, false);
      //selObj.options.add(varItem);
      selObj.JS.addOption(_value,_txt);

    }
    //selObj.value = selDate;
    selObj.JS.setSelected(selDate);
    //if(selObj.selectedIndex < 0) selObj.selectedIndex=0;
    //_mc["date"] = selObj.value;
    _mc["date"] = selObj.JS.value();
  }


  _self.initStatus=function(){
    _mc["moreCount"] = "50";
    //_mc["date"] = "Today";
    //_mc["opt_today"].selected = true;
    /*
     _mc["selText"] = "";
     _mc["search_input"].value = (_top["Util"].isIE())?def_input:"";
     */

    _mc["dataSort"] = "DESC";
    _mc["viewmore_contain"].style.display = "none";
  }

  _self.clickBtn=function(mouseEvent, tarObj){
    //_self.debugPrint(tarObj.innerHTML);

    if(tarObj.id == "general_btn"){
      _self.clearTable();

      _mc["annType"] = tarObj.innerHTML;
      _mc["showType"] = "general";

      var Obj = new Object();
      Obj.annType = _mc["annType"];
      Obj.showtype = _mc["showType"];

      _self.initStatus();

      goToPage("announcement", Obj);

      //_self.initObj(_mc["announcement_contain"]);
      //_self.showList();

    }else if(tarObj.id == "important_btn"){
      _self.clearTable();

      _mc["annType"] = tarObj.innerHTML;
      _mc["showType"] = "important";

      var Obj = new Object();
      Obj.annType = _mc["annType"];
      Obj.showtype = _mc["showType"];

      _self.initStatus();

      goToPage("announcement", Obj);

      //_self.initObj(_mc["announcement_contain"]);
      //_self.showList();

    }else if(tarObj.id == "personal_btn"){
      _self.clearTable();

      _mc["annType"] = tarObj.innerHTML;
      _mc["showType"] = "personal";

      var Obj = new Object();
      Obj.annType = _mc["annType"];
      Obj.showtype = _mc["showType"];
      //paramObj.showtype = _mc["showType"];
      _self.initStatus();

      goToPage("announcement", Obj);

      //_self.initObj(_mc["announcement_contain"]);
      //_self.showList();

    }else if(tarObj.id == "search_btn"){
      /*
       _self.clearTable();

       _mc["selText"] = _mc["search_input"].value;

       _self.initObj(_mc["announcement_contain"]);

       _self.showList();
       */
      _self.initStatus();
      _mc["selText"] = _mc["search_input"].value;
      var Obj = new Object();
      Obj.annType = _mc["annType"];
      Obj.showtype = _mc["showType"];
      Obj.date = _mc["date"];
      Obj.selText = _mc["selText"];


      goToPage("announcement", Obj);
    }else if(tarObj.id == "delete_txt"){
      if(_mc["search_input"].value != ""){
        /*
         _self.clearTable();

         _mc["selText"] = "";
         _mc["search_input"].value = (_top["Util"].isIE())?def_input:"";

         _self.initObj(_mc["announcement_contain"]);

         _self.showList();
         */
        _mc["selText"] = "";
        var Obj = new Object();
        Obj.annType = _mc["annType"];
        Obj.showtype = _mc["showType"];
        Obj.date = _mc["date"];
        //Obj.selText = _mc["selText"];
        goToPage("announcement", Obj);
      }
    }else if(tarObj.id == "title_btn"){

      _self.clearTable();

      if(_mc["dataSort"] == "DESC"){
        _mc["dataSort"] = "ASC";
        _mc["title_btn"].className = "title_btn2";
      }else{
        _mc["dataSort"] = "DESC";
        _mc["title_btn"].className = "title_btn1";
      }

      _self.initObj(_mc["announcement_contain"]);

      _self.showList();

    }else if(tarObj.id == "btn"){
      _self.clearTable();

      _mc["moreCount"] = _mc["moreCount"]*1+50;

      _self.initObj(_mc["announcement_contain"]);

      _self.showMsg();
    }

  }
  //key event 150729 joe
  _self.keyPressEvent=function(keyEvent, targetObj){
    var keyCode = _top["Util"].getKeyCode(keyEvent);
    if(keyCode==13){

      /*
       _self.clearTable();

       _mc["selText"] = _mc["search_input"].value;

       _self.initObj(_mc["announcement_contain"]);

       _self.showList();
       */

      //_self.initStatus();
      _mc["selText"] = _mc["search_input"].value;
      var Obj = new Object();
      Obj.annType = _mc["annType"];
      Obj.showtype = _mc["showType"];
      Obj.date = _mc["date"];
      Obj.selText = _mc["selText"];


      goToPage("announcement", Obj);

    }
  }
  _self.changeSelect=function(mouseEvent, tarObj){
    /*
     _mc["viewmore_contain"].style.display = "none";
     _mc["date"] = tarObj.value;

     _self.clearTable();
     _self.initObj(_mc["announcement_contain"]);
     _self.showList();
     */
    //_self.initStatus();
    //_mc["date"] = tarObj.value;
    _mc["date"] = _mc["sel_date"].JS.value();
    var Obj = new Object();
    Obj.annType = _mc["annType"];
    Obj.showtype = _mc["showType"];
    Obj.date = _mc["date"];
    Obj.selText = _mc["selText"];

    goToPage("announcement", Obj);
  }



  _self.showList=function(){
    _self.loadingFun(true);
    _self.debugPrint("showList");
    //setTimeout(function(){
    var getHttp = new _top["HttpRequestXMLClass"];
    getHttp.addEventListener("LoadComplete", _self.saveData);
    getHttp.loadURL("/xn/app/scoll.php","POST", _self.targetParam());
    //},2000);
  }

  _self.saveData=function(xml){
    _self.debugPrint("saveData");
    _mc["msgData"] = xml;
    _self.showMsg();

  }

  _self.showMsg=function(){
    _self.debugPrint("showMsg");

    if(_mc["showType"] == "important"){
      _mc["important_btn"].className = "nav_btn_on";
      _mc["personal_btn"].className = "nav_btn";
      _mc["general_btn"].className = "nav_btn";
    }else if(_mc["showType"] == "personal"){
      _mc["important_btn"].className = "nav_btn";
      _mc["personal_btn"].className = "nav_btn_on";
      _mc["general_btn"].className = "nav_btn";
    }else{
      _mc["important_btn"].className = "nav_btn";
      _mc["personal_btn"].className = "nav_btn";
      _mc["general_btn"].className = "nav_btn_on";
    }

    _mc["title_span"].innerHTML = _mc["annType"];

    var xml = _mc["msgData"];

    var xmdObj = new Object();
    xmlnode=new _top["XmlNodeClass"](xml.getElementsByTagName("serverresponse"));
    xmlnodeRoot = xml.getElementsByTagName("serverresponse")[0];

    var _status = _top["Util"].showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"status")));
    if(_status=="error"){
      var code = _top["Util"].showTxt(xmlnode.getNodeVal(xmlnode.Node(xmlnodeRoot,"code")));
      if(!_top["Util"].checkErrorCode(code, _top)) return;
    }

    xmdObj["scoll"] = xmlnode.Node(xmlnodeRoot,"scoll",false);

    if(xmdObj["scoll"].length > 0){

      var ViewMore = xmdObj["scoll"].length;
      if(_mc["moreCount"] < xmdObj["scoll"].length){
        ViewMore = _mc["moreCount"];
        _mc["viewmore_contain"].style.display = "";
      }else{
        _mc["viewmore_contain"].style.display = "none";
      }

      for(var j=0; j<ViewMore; j++){
        var tmp_scoll = xmdObj["scoll"][j];
        xmdObj["detetime"] = xmlnode.Node(tmp_scoll,"detetime");
        xmdObj["text"] = xmlnode.Node(tmp_scoll,"text");

        var time_tmp = _top["Util"].showTxt(xmlnode.getNodeVal(xmdObj["detetime"])).split(" ");
        var date_tmp = time_tmp[0].split("-");

        getMaxTable.addTR(1);
        getMaxTable.replace("*MON*",_top["Util"].showTxt(_self.transMonth(date_tmp[1])));
        getMaxTable.replace("*MDAY*",_top["Util"].showTxt(date_tmp[2])+_top["LS"].getLS("scoll_day"));
        getMaxTable.replace("*TIME*",_top["Util"].showTxt(time_tmp[1]));

        var text_value = _top["Util"].showTxt(xmlnode.getNodeVal(xmdObj["text"]));

        if(_mc["selText"] != "" ){
          //var tmp = new RegExp(_mc["selText"],'g');
          //text_value = text_value.replace(tmp,"<span class=\"search_red\">"+_mc["selText"]+"</span>");
          text_value = replaceSearchData(text_value,_mc["selText"]);
        }

        getMaxTable.replace("*TEXT*",text_value);
      }

      var tbody = _mc["announceTable"].children[0];
      var last_tr = tbody.children[tbody.children.length-1];
      var oClassName = _top["Util"].getObjectClass(last_tr);
      _top["Util"].setObjectClass(last_tr,oClassName+" bottom_line");
      _mc["announceTable"].style.display = "";
      _mc["no_data"].style.display = "none";

    }else{
      _mc["viewmore_contain"].style.display = "none";
      _mc["no_data"].style.display = "";
    }

    _self.loadingFun(false);

  }

  _self.targetParam=function(){
    var par = "";
    par+="login_layer="+_top["userData"].layer;
    par+="&uid="+_top["userData"].uid;
    par+="&langx="+_top["userData"].langx;
    par+="&showtype="+_mc["showType"];
    par+="&selDate="+_mc["date"];
    par+="&selText="+_mc["selText"];
    par+="&dataSort="+_mc["dataSort"];
    par+="&code=read";

    return par;
  }

  _self.clearTable=function(){
    var parNode = _mc["announceTable"].parentNode;
    parNode.removeChild(_mc["announceTable"]);

    var bak = _mc["announceTable_bak"].cloneNode(true);
    _mc["announceTable"] = bak;
    parNode.appendChild(bak);

  }

  _self.loadingFun=function(types){
    var obj = new Object();
    obj.isShow = types;
    _top["obj"].eventhandler("setLoadingVisibleHandler",obj);
  }

  _self.transMonth=function(month){
    var m = month*1 - 1;
    m = (m<10)?"0"+m:m;
    return _top["LS"].getLS("month_"+m);
  }

  function replaceSearchData(div, txt){
    var _search = txt.toUpperCase();
    var pos = -1-_search.length;
    var posAry = new Array();
    var tmp_div = div.toUpperCase();
    var org_div = div;

    while (pos != -1) {
      pos = tmp_div.indexOf(_search, (pos+_search.length));
      if(pos!=-1){
        posAry.push(pos);
      }
    }

    for(var i=posAry.length-1; i>=0; i--){
      var p = posAry[i];
      var s = org_div.substring(0,p);
      var base = org_div.substring(p,p+_search.length);
      var e = org_div.substring(p+_search.length,org_div.length);
      org_div = s+"<span class='search_red'>"+base+"</span>"+e;

    }
    return org_div;
  }

  _self.debugPrint=function(msg){
    try{
      //console.log("["+_self.classname+"]"+msg);
    }catch(e){
      //alert("["+_self.classname+"]"+msg);
    }

  }

}