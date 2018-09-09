
function show_line(){
	show_cb.innerHTML="";
	var show = document.getElementById("show_div");
	var txt_cb = show_checkbox.innerHTML;
	var txt_tb = show_table.innerHTML;
	var tmp = "";
	show.style.display="block";
	show.style.left =130;
	show.style.top = event.clientY-10;
	for(i=0;i < Format.length; i++){
		if(Format[i][2]=="Y") {
			tmp +=txt_cb;
			tmp = tmp.replace(/\*CODE\*/g, Format[i][0]);
			tmp = tmp.replace("*CODENAME*", Format[i][1]);
			tmp = tmp.replace("*CHECK*",((odd_f.indexOf(Format[i][0])==(-1))? "":"checked"));
			tmp = tmp.replace("*DISABLE*",(Format[i][0] =="H")? "disabled":"");
		}
	}
	txt_tb =txt_tb.replace("*SHOWTABLE*", tmp);
	show.innerHTML=txt_tb;
	
}
function chk_Date(){
	var str="";
	var outstr="";	
	for(i=0;i < Format.length; i++){
		if(document.all("lineData["+Format[i][0]+"]")!= null)
		if(document.all("lineData["+Format[i][0]+"]").checked){
			if(str!=""){
				str+=",";
			}
			str+=Format[i][0];
		}
	}
	odd_f=str;
	close_show();
}
function close_show(){
	var show = document.getElementById("show_div");
	show.style.display="none";
	show_Line_Date();
}
function show_Line_Date(){
	var str="";	
	for(i=0;i < Format.length; i++){
		if(odd_f.indexOf(Format[i][0])!=(-1)){
			if(str!=""){
				str+=",";
			}
			str+=Format[i][1];
		}
	}
	//if(str == "") alert(top.str_oddf);
	document.getElementById('show_cb').innerHTML ="<font style='color: 960000;'>"+str+"</font>";
	document.getElementById('odd_f_str').value =odd_f;
}

function show_oddf(sta){
	if(sta =="show"){
		document.all.oddf_edit.disabled="";
	}else{
		document.all.oddf_edit.disabled="true";
	}
	odd_f="H";
	show_Line_Date();
}