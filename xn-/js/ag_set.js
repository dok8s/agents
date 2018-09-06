document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){ 

	}
}
function Chk_acc(){
	rs_form.act.value='Y';
	close_win();
}
function Chk_acc2(){
	rs_form_2.act.value='Y';
	close_win_2();
}

function show_win(vs_str,rtype,sc,so,war_set_1,war_set_2,war_set_3,war_set_4,add_count,instart,instrat_2,instart_3,instart_4,kind) {
	document.all["r_title"].innerHTML = '<font color="#FFFFFF">请输入'+ vs_str + '退水</font>';
	j1=0;
	j2=0;
	j3=0;
	j4=0;
	var d=add_count;
	while (rs_form.war_set_1.length){
		document.rs_form.war_set_1.options[0]=null;
	}
	while (rs_form.war_set_2.length){
		document.rs_form.war_set_2.options[0]=null;
	}
	while (rs_form.war_set_3.length){
		document.rs_form.war_set_3.options[0]=null;
	}
	while (rs_form.war_set_4.length){
		document.rs_form.war_set_4.options[0]=null;
	}	
	for(var i=0;i<=instart;i+=d){
		document.rs_form.war_set_1.options[j1]=new Option(i,i);
		if(i==war_set_1) document.rs_form.war_set_1.selectedIndex=j1;
		j1++;
	}
	for(var i=0;i<=instrat_2;i+=d){
		document.rs_form.war_set_2.options[j2]=new Option(i,i);
		if(i==war_set_2) document.rs_form.war_set_2.selectedIndex=j2;
		j2++;
	}
	for(var i=0;i<=instart_3;i+=d){
		document.rs_form.war_set_3.options[j3]=new Option(i,i);
		if(i==war_set_3) document.rs_form.war_set_3.selectedIndex=j3;
		j3++;
	}
	for(var i=0;i<=instart_4;i+=d){
		document.rs_form.war_set_4.options[j4]=new Option(i,i);
		if(i==war_set_4) document.rs_form.war_set_4.selectedIndex=j4;
		j4++;
	}	
	rs_form.kind.value=kind;
	rs_form.rtype.value=rtype;
	rs_form.SC.value=sc;
	rs_form.SO.value=so;
	rs_window.style.top=document.body.scrollTop+event.clientY+15;
	rs_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["rs_window"].style.display = "none";
	document.all["rs_window_2"].style.display = "none";	
	document.all["rs_window"].style.display = "block";
}
function show_win2(vs_str,rtype,sc,so,war_set_1,add_count,instart,kind) {
	document.all["r_title_2"].innerHTML = '<font color="#FFFFFF">请输入'+ vs_str + '退水</font>';
	j1=0;
	var d=add_count;
	while (rs_form_2.war_set_1.length){
		document.rs_form_2.war_set_1.options[0]=null;
	}
	for(var i=0;i<=instart;i+=d){
		document.rs_form_2.war_set_1.options[j1]=new Option(i,i);
		if(i==war_set_1) document.rs_form_2.war_set_1.selectedIndex=j1;
		j1++;
	}
	rs_form_2.kind.value=kind;
	rs_form_2.SC_2.value=sc;
	rs_form_2.SO_2.value=so;
	rs_form_2.rtype.value=rtype;
	rs_window_2.style.top=document.body.scrollTop+event.clientY+15;
	rs_window_2.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["rs_window"].style.display = "none";
	document.all["rs_window_2"].style.display = "none";	
	document.all["rs_window_2"].style.display = "block";
}
function close_win() {
	document.all["rs_window"].style.display = "none";
}
function close_win_2() {
	document.all["rs_window_2"].style.display = "none";
}
function count_so(a){
	switch(a){
		case(1):
			b=eval(document.all.SC.value)/2;
			document.all.SO.value=b;
			break;
		case(2):
			b=eval(document.all.SC_2.value)/2;
			document.all.SO_2.value=b;
			break;
	}
}