/**
 * Created by Administrator on 2018-08-17.
 */
function ClassSelect_ag(){
  var _self=this;
  _self.classname = "ClassSelect_ag.js";

  var tmpScreen;
  var paramObj;
  var _top;
  var _mc = new Object();
  var _eventHandler = new Array();
  //var selValue,selObj;
  _self.init=function(Top, Div, Param){
    _self.debugPrint("init ClassSelect_ag.js");
    _top = Top
    tmpScreen = Div;
    paramObj = Param;
    _mc["sel_obj"] = new _top["ClassSelectClass"](tmpScreen);
    _self.debugPrint("new ClassSelectClass ClassSelect_ag.js");
    _mc["sel_obj"].init();
    //_mc["sel_obj"].initEvent("onmouseleave");
    _mc["sel_obj"].addEventListener("ONCLOSE", _self.closeEvent);
    _mc["sel_obj"].addEventListener("ONCHANGE", _self.chgEvent);

    _top["obj"].addEventListener("MouseEvent.MOUSE_OVER", _self.selClick,tmpScreen);
    _top["obj"].addEventListener("MouseEvent.MOUSE_LEAVE", _mc["sel_obj"].closeDiv,tmpScreen);


  }
  _self.selClick = function(e,tarObj){
    //var abs = _top["Util"].getObjAbsolute_new(tarObj,"sel");
    //_top["obj"].removeEventListener("MouseEvent.CLICK",tmpScreen);
    //_self.debugPrint(abs["left"]+"|"+abs["top"]);
    //_mc["sel_obj"].openDiv(abs["left"],abs["top"],e);
    _mc["sel_obj"].openDiv(e);
  }
  _self.chgEvent = function(e,tarObj){
    //_self.debugPrint("_self.chgEvent");
    _self.eventhandler(e,"ONCHANGE",tarObj);
  }
  _self.addOption =function(_value,_text){
    var option = _mc["sel_obj"].newOption(_value,_text);
    _mc["sel_obj"].appendOption(option);
    //var obj = _mc["sel_obj"].getOption(_key);
    //_mc["sel_obj"].appendOptionBefor(option,obj);
  }
  _self.setSelected =function(_val){
    _mc["sel_obj"].setSelected(_val);
  }
  _self.closeEvent = function(){
    /*
     setTimeout(function(){
     _top["obj"].addEventListener("MouseEvent.CLICK", _self.selClick,tmpScreen);
     },300);
     */

    _self.eventhandler(null,"ONCLOSE",null);
  }
  _self.clearOption = function(){
    _mc["sel_obj"].clearOption();
  }
  _self.setDisabled = function (_val){
    _mc["sel_obj"].setDisabled(_val);
  }
  _self.disabled = function(){
    return _mc["sel_obj"].disabled();
  }
  _self.value = function(){
    return _mc["sel_obj"].value();
  }



  _self.eventhandler=function(_evt,_eventName,_obj){
    if (_eventHandler[_eventName]!=undefined){
      _eventHandler[_eventName](_evt,_obj);
    }else{
      //alert(_self.name+":"+_eventName+" not override !!");
    }
  }
  _self.addEventListener =function(eventname,eventFunction){
    _eventHandler[eventname]=eventFunction;
  }
  _self.removeEventListener=function(eventname){
    _eventHandler[eventname] = null;
  }
  _self.debugPrint=function(msg){
    try{
      //console.log("["+_self.classname+"]"+msg);
      //console.log(msg);
    }catch(e){
      //alert("["+_self.classname+"]"+msg);
    }
  }
}