<!--
document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){ }
}
function Chk_acc(){
	rs_form.act.value='Y';
	close_win();
}

function chk_table_width(lengx){
	chg_game = new Array("FT","BK","OP","FS");
	chk = "N";
	Minus = 0;
	MY_col = 0;
	if(admin_type){//修改
		Minus += 50;
		chk = "Y";		
	}
	/*	
	if(admin_type_MY){  //额外金额
		Minus += 125;
		MY_col = 1;
		chk = "Y";
	}
	*/
	if(chk == "Y"){
		for(i=0;i<chg_game.length;i++){
			document.getElementById(chg_game[i]+"_Coor").width -= Minus;
			//document.getElementById(chg_game[i]+"_MY_col").colSpan -= MY_col;
		}	
	}
}

function show_win(vs_str,rtype,sc,so,war_set,add_count,instart,kind) {
	document.all["r_title"].innerHTML = '<font color="#FFFFFF">'+eval(kind+"_chg_box_"+rtype+"_title")+'</font>';
	j1=0;
	var d=add_count;
	while (rs_form.war_set.length){
		document.rs_form.war_set.options[0]=null;
	}
	for(var i=0;i<=instart;i+=d){
		document.rs_form.war_set.options[j1]=new Option(i,i);
		if(i==war_set) document.rs_form.war_set.selectedIndex=j1;
		j1++;
	}
	
	printProposeVar(1,kind,rtype);
	
	rs_form.kind.value=kind;
	rs_form.rtype.value=rtype;
	rs_form.SC.value=sc;
	rs_form.SO.value=so;
	rs_window.style.top=document.body.scrollTop+event.clientY+15;
	rs_window.style.left=document.body.scrollLeft+event.clientX-20;
	document.all["rs_window"].style.display = "block";
	//Chg_SC_Mcy();
	//Chg_SO_Mcy();
}

function printProposeVar(printType,gtype,rtype){
	ratio=eval(document.all.ratio.value);
	
	subStr = "";
	printArr = new Array("SC","SO");
	if(printType==2){
		subStr = "_2";
	}
	for(i=0;i<printArr.length;i++){
		//alert(printArr[i]+subStr+"_pro");
		//将上层设定转换为 会员的币值
		//if(ratio*1 != 1){
			document.getElementById(printArr[i]+subStr+"_pro").innerText = Math.floor(upMenSet[gtype+"_"+rtype][i] / ratio /10)*10;
		//document.getElementById("mcy_up_"+printArr[i].toLowerCase()).innerText = ""+ upMenSet[gtype+"_"+rtype][i];
		//}else{
		//	document.getElementById(printArr[i]+subStr+"_pro").innerText = upMenSet[gtype+"_"+rtype][i]
		//}
	}

}

function putToText(printName){
	putVar = document.getElementById(printName+"_pro").innerText;
	document.getElementById(printName).value = putVar;

	//eval("Chg_"+printName+"_Mcy()");
	if(printName == "SC"){
		sub_pro =document.getElementById("SO_pro").innerText; 
		
		if((document.all.SC.value*1)/2 > sub_pro*1){
			document.all.SO.value = sub_pro;
		}else{
			count_so();
		}
		
		//Chg_SO_Mcy();
	}
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function close_win() {
	document.all["rs_window"].style.display = "none";
}

function Chg_SC_Mcy(){
	ratio=eval(document.all.ratio.value);
	 //四捨五入到小数第二位
	tmp_sc=Math.round(ratio*(document.all.SC.value*1)*100)/100;
	//tmp_sc=ratio*eval(document.all.SC.value);
	document.all.mcy_sc.innerHTML=tmp_sc;
}

function Chg_SO_Mcy(){
	ratio=eval(document.all.ratio.value);
	 //四捨五入到小数第二位
	tmp_so=Math.round(ratio*(document.all.SO.value*1)*100)/100;
	//tmp_so=ratio*eval(document.all.SO.value);
	document.all.mcy_so.innerHTML=tmp_so;
}

function count_so(){
	b=(document.all.SC.value*1)/2;
	document.all.SO.value=b;
}

function CheckKey(){
	if(event.keyCode < 48 || event.keyCode > 57 )return false;
}
//-->