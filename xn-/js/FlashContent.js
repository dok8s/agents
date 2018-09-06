/**
 * call the function in swf
 */
function callas(Datas){
	if (top.flash_cont_cutoff == "N" || top.flash_cont_flag <= 0) { return false; }
	try{
		parent.swfFrame.FlashContent.JScall(Datas);
	}catch (e) {/*
		if (top.langx == "zh-tw") {
			alert("您是否已安装 ActiveX 控制项了呢!\n本公司为了让您使用上更便利，请先安装 ActiveX 控制项。");
		} else if (top.langx == "zh-cn"){
			alert("蜡岆瘁眒假蚾 ActiveX 讽秶砐賸儸!\n挂鼠侗峈賸蜡妏蚚奻载晞瞳ㄛ珂假蚾 ActiveX 讽秶砐﹝");
		} else {
			alert("Have you installed Active X ? For your convenience, please install Active X.\n");
		}
		location = document.location.protocol+"//"+document.location.host+"/d1";*/
	}
}

function getHREF(){
	return document.location.href;
}

function getCommand(fun_type){
	var user_layer = "";
	var path = document.location.pathname;
	if (path.indexOf("corp") > 0)        { user_layer = "c"; }
	else if (path.indexOf("world") > 0)  { user_layer = "s"; }
	else if (path.indexOf("agents") > 0) { user_layer = "a"; }
	var cmd = getFileName()+","+fun_type+","+user_layer+","+getHREF();
	return cmd;
}

function getFileName(){
	var path = document.location.pathname;
	var file_name = path.split("/");
	return file_name[file_name.length-1];
}
