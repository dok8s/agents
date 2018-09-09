<!--
function CheckSTOP(str,chk){
	var enable_s = document.all.enable.value;
	var page = document.all.page.value;
	if(confirm(eval("top.str_confirm_enable"+chk)+top.str_mem+"?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
}
function CheckENABLEPRI(str,chk){
	var confirm_str;
	if(str.match(/enable_pri/)){
		confirm_str = "enable_pri";
	}else{
		confirm_str = "enable";
	}
	var page = document.all.page.value;
	if(confirm(eval("top.str_confirm_"+confirm_str+chk)+top.str_mem+"?")) document.location=str+"&page="+page;
}
function MouEnter(pause_url,pause_chk,pri_url,pri_chk){
	var obj=document.getElementById("showSW");
	var obj_show=document.getElementById("show_enable_table");
	var objtext=obj.innerHTML;
	objtext=objtext.replace("*ACTION_PAUSE_TYPE*",pause_url);
	objtext=objtext.replace("*PAUSE_SHOW_TYPE*",pause_chk);
	objtext=objtext.replace("*ENABLE_PRI_URL*",pri_url);
	objtext=objtext.replace("*PRI_SHOW_TYPE*",pri_chk);
	obj_show.innerHTML=objtext;
	MoveDiv();
}
function MoveDiv(){
	var obj_show=document.getElementById("show_enable_table");
	 obj_show.style.top=document.body.scrollTop+event.clientY-10;
	 obj_show.style.left=document.body.scrollLeft+event.clientX-39;
	 obj_show.style.display="";
}
function CLOSE_STOP_DIV (){
	var obj_show=document.getElementById("show_enable_table");
	obj_show.style.display="none";

}
-->