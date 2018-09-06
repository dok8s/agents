function ChkKeyCode(){
	if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122)){
		return true;
	}
	return false;
}
function ChkKeyInCode(){
if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode> 57) && (event.keyCode> 95 || event.keyCode < 106)){alert(top.str_maxcre); return false;}
}