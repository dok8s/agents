var cookieAry = new Array();
var getHTML = null;
var selLayer = "A";//預設登1
var pathUrl = "";

function onload(){
	getHTMLObj("hr_info").style.display = "none";
	
	if(window.event){
		getHTMLObj("username").onkeypress = function(){ key_value(event); };
		getHTMLObj("passwd").onkeypress = function(){ key_value(event); };
		getHTMLObj("passwd_safe").onkeypress = function(){ key_value(event); };
	}else{
		getHTMLObj("username").onkeypress = function(event){ key_value(event); };
		getHTMLObj("passwd").onkeypress = function(event){ key_value(event); };
		getHTMLObj("passwd_safe").onkeypress = function(event){ key_value(event); };
	}
	
	cookieAry = document.cookie.split(";");
	doCookie("ag_userA");

	//getHTML = new HttpRequest();
	//getHTML.connectFail=function(stat){alert(top.cnnectFailMsg)};
	//getHTML.addEventListener("LoadComplete",doLoadComplete);
}

function key_value(e){
	if(window.event){//IE
		keynum = e.keyCode;
	}else if(e.which){//Netscape/Firefox/OEera
		keynum = e.which;
	}
	
	if(keynum == "13"){
		do_login();
	}
}

function doCookie(keys){
	document.all.username.value = "";
	
	for(var i=0; i<cookieAry.length; i++){
		var thisCookie = cookieAry[i].split("=");
		
		if(thisCookie[0].indexOf(keys) != -1){
			document.all.username.value = thisCookie[1];
			break;
		}
	}
}

function inputFocus(obj,placehold){
	obj.placeholder = "";
}

function inputBlur(obj,placehold){
	obj.placeholder = placehold;
}

var timeObj;
var timeOut=300;//多久執行
var checking = false;

function do_login(){
	clearTimeout(timeObj)
	timeObj=setTimeout(chk_type,timeOut);
}

function chk_type(){
	var tmpPathUrl = "";
	switch(selLayer){
		case "A":
			pathUrl = "app/corprator/";
			break;
		case "B":
			pathUrl = "app/control/world/";
			break;
		case "C":
			pathUrl = "app/control/agents/";
			break;
		default:
			pathUrl = "app/corprator/";
			break;
	}
	tmpPathUrl = pathUrl + "login.php";
	LoginForm.action=tmpPathUrl;
	LoginForm.submit();
}

//client端 畫面基本檢查
function chk_acc(){
	var hr_infoObj = getHTMLObj("hr_info");
	
	if(document.all.username.value == ""){
		hr_infoObj.innerHTML = info_user;
		hr_infoObj.style.display = "";
		document.all.username.focus();
		checking = false;
		return false;
	}
	
	if(document.all.passwd.value == ""){
		hr_infoObj.innerHTML = info_passwd;
		hr_infoObj.style.display = "";
		document.all.passwd.focus();
		checking = false;
		return false;
	}
	
	/*
	if(document.getElementById("btn_C").className == "log_btn"){
		if(document.all.passwd_safe.value == ""){
			hr_infoObj.innerHTML = info_passwd_safe;
			hr_infoObj.style.display = "";
			document.all.passwd_safe.focus();
			return false;
		}
	}
	*/
	
	return true;
}

function checkF(shows){
	selLayer = shows;
	
	getHTMLObj("btn_A").className = "log_btn";
	getHTMLObj("btn_B").className = "log_btn";
	getHTMLObj("btn_C").className = "log_btn";
	getHTMLObj("btn_"+shows).className = "log_btnON";
	
	doCookie("ag_user"+shows);
	
	var sefeObj = getHTMLObj("Sefe");
	sefeObj.style.display = "";
	
	if(shows == "C"){
		sefeObj.style.display = "none";
	}
	
	getHTMLObj("hr_info").style.display = "none";
}

function get_flash_player(){
	subWin = window.open("/tpl/corprator/activeX.html");
	subWin.focus();
}

function getHTMLObj(keys){
	try{
		return document.getElementById(keys);
	}catch(e){
		alert("cann't get this keys['"+keys+"']");
	}
}

function getUrlParam(){
	var _lang = (getHTMLObj("langx")).value;
	var _username = (getHTMLObj("username")).value;
	var _passwd = (getHTMLObj("passwd")).value;
	var _passwd_safe = (getHTMLObj("passwd_safe")).value;
	
	_passwd_safe = (_passwd_safe == def_passwd_safe)?"":_passwd_safe;
	
	var sendCode = "";
	sendCode += "langx="+_lang;
	sendCode += "&username="+_username;
	sendCode += "&passwd="+_passwd;
	sendCode += "&passwd_safe="+_passwd_safe;
	
	return sendCode;
}

function doLoadComplete(xml){
	if(xml != ""){
		var xmlAry = xml.split("|");
		var _code = xmlAry[0];
		var _value = xmlAry[1];
		
		switch(_code){
			case "060":
				top.location.href = document.location.protocol+"//"+document.domain+"/forbidden.php";
				break;
			case "040":
				checking=false;
				var hr_infoObj = getHTMLObj("hr_info");
				hr_infoObj.innerHTML = _value;
				hr_infoObj.style.display = "";
				
				try{
					document.all.passwd.value = "";
					document.all.passwd_safe.value = "";
					document.all.username.focus();
				}catch(e){}
				break;
			case "020":
				checking=true;
				var isChceked = getHTMLObj("remember").checked;
				if(isChceked){
					document.cookie = "ag_user"+selLayer+"="+document.all.username.value+";";
				}/*else{
					var expires = new Date();
					expires.setTime(expires.getTime() - 1);
					document.cookie = "ag_user"+selLayer+"=; expires=" + expires.toGMTString();
				}*/
				
				window.location.href = pathUrl+"login.php?"+getUrlParam();
				break;
		}
	}
}
