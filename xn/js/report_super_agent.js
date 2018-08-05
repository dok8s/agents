
function Chk_acc(){
	if(document.all.acc_date.value=='' || document.all.acc_date.value.length != 10){
		document.all.acc_date.focus();
		alert("请输入赛程日期(YYYYMMDD)!!");
		return false;
	}
	return true;
}

function show_win1(Ag_id,Ag_name) {
	agAcc1.in_who_id.value=Ag_id;
	acc_window.style.top=document.body.scrollTop+event.clientY+15;
	acc_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["acc_window"].style.display = "block";
	document.all.acc_date.focus();
}
function close_win1() {
	document.all["acc_window"].style.display = "none";
}

function show_win(Chk_id,Chk_who,total) {
//	alert(Chk_who+' - '+total);
	if (total == "0" || total == "-0" || Chk_id == "") {
		alert(total + '不需要结帐!!');
		return false;
	}

	agAcc.in_gold.value=""
	agAcc.in_who_id.value=Chk_id
	agAcc.in_who_name.value=Chk_who
	input_window.style.top=document.body.scrollTop+event.clientY+15;
	input_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["input_window"].style.display = "block";
	agAcc.in_gold.focus();
	setTimeout("close_win()",60000);
}
function close_win() {
	agAcc.in_who_id.value=""
	agAcc.in_who_name.value=""
	document.all["input_window"].style.display = "none";
}
function Chk_IN() {
	if (agAcc.in_gold.value == "") {
		alert('请输入金额');
		return false;
	}
//	alert('ID=' + agAcc.in_who_id.value + '姓名=' + agAcc.in_who_name.value + '金额=' + agAcc.in_gold.value)
	strFeatures = "top=150,left=150,width=400,height=305,toolbar=0,menubar=0,location=0,directories=0,status=0"; 
	objNewWindow = window.open("" , "win_agAcc", strFeatures); 
	return true;
}