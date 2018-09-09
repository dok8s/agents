function SubChk()
{
  if (document.all.password.value==''){
    document.all.password.focus();
    alert("请输入密码!!");
    return false;
  }
  if (document.all.REpassword.value==''){
    document.all.REpassword.focus();
    alert("请输入重复密码!!");
    return false;
  }  
  if(document.all.password.value != document.all.REpassword.value)
  { document.all.password.focus(); alert("两次输入的密码不相同!!"); return false; }
}
