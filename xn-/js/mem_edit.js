function SubChk()
{
 if(document.all.agents_id.value=='')
 { document.all.agents_id.focus(); alert("请务必选择代理商!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("帐号请务必输入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("密码请务必输入!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("确认密码请务必输入!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("密码确认错误,请重新输入!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("会员名称请务必输入!!"); return false; }
 if(document.all.pay.value =='3'){
  if(document.all.pay_type[0].checked && (document.all.maxcredit.value=='0' || document.all.maxcredit.value==''))
  {
 	 document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; 
  }
 }
 if(document.all.pay.value =='0'){
  if(document.all.maxcredit.value=='0' || document.all.maxcredit.value=='')
  {
 	 document.all.maxcredit.focus(); alert("总信用额度请务必输入!!"); return false; 
  } 	
 }
 if ((document.all.old_aid.value!=document.all.agents_id.value) && document.all.keys.value=='update')
 {alert("你已变更此之会员代理商~~请重新设定该会员之详细设定!!")}
 if(!confirm("是否确定写入会员资料?"))
 {
  return false;
 }
 	if (document.all.type.value != document.all.mem_line.value){
		alert('您已经改变了会员的盘口属性，\n\n所有的退水值将被归零，\n\n请重新进入更新退水设定。');
		document.all.mem_line.value='Y';
		}
}
