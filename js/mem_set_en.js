<!--

document.onkeypress=checkfunc;
function checkfunc(e) {
	switch(event.keyCode){ 

	}
}
function Chk_acc(){
	rs_form.act.value='Y';
	close_win();
}
function show_win(vs_str,rtype,sc,so,war_set,add_count,instart,kind) {
	document.all["r_title"].innerHTML = '<font color="#FFFFFF">please key in '+ vs_str + ' rebate</font>';
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
	rs_form.kind.value=kind;
	rs_form.rtype.value=rtype;
	rs_form.sid.value=document.all.id.value;
	rs_form.SC.value=sc;
	rs_form.SO.value=so;
	rs_window.style.top=document.body.scrollTop+event.clientY+15;
	rs_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["rs_window"].style.display = "block";
	Chg_Sc_Mcy();
	Chg_So_Mcy();
}
function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
function close_win() {
	document.all["rs_window"].style.display = "none";
}

function Chg_Sc_Mcy(){
  ratio=eval(document.all.ratio.value);
  tmp_sc=ratio*eval(document.all.SC.value);
  document.all.mcy_sc.innerHTML=tmp_sc;
}

function Chg_So_Mcy(){
  ratio=eval(document.all.ratio.value);
  tmp_so=ratio*eval(document.all.SO.value);
  document.all.mcy_so.innerHTML=tmp_so;
}

function count_so(){
  b=eval(document.all.SC.value)/2;
  document.all.SO.value=b;
}
//-->