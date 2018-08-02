<?php
require ("app/member/include/config.inc.php");
require ("app/member/include/define_function_list.inc.php");
if(ip_drop()){
    echo "<script>location.href='/ip_drop.htm';</script>";
    exit;
}
$langx = "zh-cn";
if(array_key_exists('langx', $_REQUEST)){
    $langx=$_REQUEST['langx'];
}
?>
<?php if($langx=="zh-tw"):?>


  <html>
  <head>
    <title>index</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/style/control/index4.css" type="text/css">
    <script language="JavaScript" src="/js/HttpRequest.js"></script>
    <script language="JavaScript" src="/js/index.js"></script>
    <script language="JavaScript" src="/js/ga.js"></script>
    <script language="JavaScript" src="/js/zh-tw.js"></script>
    <script language="JavaScript" type="text/JavaScript">
      var def_user = "登錄帳號";
      var def_passwd = "密碼";
      var def_passwd_safe = "安全代碼";
      var info_user = "請輸入帳號";
      var info_passwd = "請輸入密碼";
      var info_passwd_safe = "請輸入安全代碼";
    </script>
  </head>

  <body oncontextmenu="window.event.returnValue=false" onLoad="onload();">
  <div class="main">
    <div class="lang">
      <a href="./index.php?langx=zh-tw"><span name="link_tw" class="lan_word_on">繁體版</span></a>
      <a href="./index.php?langx=zh-cn"><span name="link_cn" class="lan_word">简体版</span></a>
      <a href="./index.php?langx=en-us"><span name="link_us" class="lan_word">English</span></a>
    </div>

    <div class="agLOGO"></div>

    <div class="new" style="
    width: 100%;
">
      <div id="new_btn" class="new_btn_on" onclick="chgdomain('new');" style="
    width: 50%;
    height: 40px;
    line-height: 40px;
    text-align: center;
    background-color: #CA9D49;
    color: #FFFFFF;
    float: left;
    cursor: pointer;
">新版</div>
      <div id="old_btn" class="new_btn" onclick="chgdomain('old');" style="
    background-color: #D8D5D5;
    color: #737373;
    width: 50%;
    height: 40px;
    line-height: 40px;
    text-align: center;
    float: left;
    cursor: pointer;
">舊版</div>
    </div>
    <div class="loginBOX">
      <form id="LoginForm" name="LoginForm" method="post" action="" onSubmit="return chk_acc();">
        <input id="langx" type="hidden" name="langx" value=zh-tw>
        <div class="log_btnG">
          <span id="btn_A" onClick="checkF('A');" class="log_btnON">登入 1</span>
          <span id="btn_B" onClick="checkF('B');" class="log_btn">登入 2</span>
          <span id="btn_C" onClick="checkF('C');" class="log_btn">登入 3</span>
        </div>
        <div class="login">
          <div class="account">
            <input id="username" class="input_box" type="text" name="username" value="" maxlength="26" tabindex="1" onFocus="inputFocus(this,def_user);" onBlur="inputBlur(this,def_user);" placeholder="登錄帳號">
          </div>
          <div class="password">
            <input id="passwd" class="input_box" type="password" name="passwd" value="" maxlength="28" tabindex="2" onFocus="inputFocus(this,def_passwd);" onBlur="inputBlur(this,def_passwd);" placeholder="密碼">
          </div>

          <div id="Sefe">
            <div class="notice">未設定安全代碼不需輸入</div>
            <div class="safe">
              <input id="passwd_safe" class="input_box" type="password" name="passwd_safe" value="" maxlength="28" tabindex="2" onFocus="inputFocus(this,def_passwd_safe);" onBlur="inputBlur(this,def_passwd_safe);" placeholder="安全代碼">
            </div>
          </div>

          <div id="hr_info" class="warn" style="display:none;"><span>請輸入帳號</span></div>
          <div class="remember">
            <label><input type="checkbox" id="remember"/><span></span></label>
            <span class="remember_word">記住我的帳號</span>
          </div>
          <input class="send_btn" type="button" id="Forms Button1" onClick="chk_type();" value="登入">
        </div>
      </form>
    </div>
  </div>
  </div>

  <div class="foot_tw"></div>
  </body>
  </html>
<?php endif?>
<?php if($langx=="en-us"):?>

  <html>
  <head>
    <title>index</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/style/control/index4.css" type="text/css">
    <script language="JavaScript" src="/js/HttpRequest.js"></script>
    <script language="JavaScript" src="/js/index.js"></script>
    <script language="JavaScript" src="/js/ga.js"></script>
    <script language="JavaScript" src="/js/en-us.js"></script>
    <script language="JavaScript" type="text/JavaScript">
      var def_user = "Login ID";
      var def_passwd = "Password";
      var def_passwd_safe = "Safe Code";
      var info_user = "Please enter your Login ID!";
      var info_passwd = "Please enter your Password!";
      var info_passwd_safe = "Please enter your Safe Code!";
    </script>
  </head>

  <body oncontextmenu="window.event.returnValue=false" onLoad="onload();">
  <div class="main">
    <div class="lang">
      <a href="./index.php?langx=zh-tw"><span name="link_tw" class="lan_word">繁體版</span></a>
      <a href="./index.php?langx=zh-cn"><span name="link_cn" class="lan_word">简体版</span></a>
      <a href="./index.php?langx=en-us"><span name="link_us" class="lan_word_on">English</span></a>
    </div>

    <div class="agLOGO"></div>
    <div class="new" style="
    width: 100%;
">
      <div id="new_btn" class="new_btn_on" onclick="chgdomain('new');" style="
    width: 50%;
    height: 40px;
    line-height: 40px;
    text-align: center;
    background-color: #CA9D49;
    color: #FFFFFF;
    float: left;
    cursor: pointer;
">New Site</div>
      <div id="old_btn" class="new_btn" onclick="chgdomain('old');" style="
    background-color: #D8D5D5;
    color: #737373;
    width: 50%;
    height: 40px;
    line-height: 40px;
    text-align: center;
    float: left;
    cursor: pointer;
">Old Site</div>
    </div>
    <div class="loginBOX">
      <form id="LoginForm" name="LoginForm" method="post" action="" onSubmit="return chk_acc();">
        <input id="langx" type="hidden" name="langx" value=en-us>

        <div class="log_btnG">
          <span id="btn_A" onClick="checkF('A');" class="log_btnON">LOGIN 1</span>
          <span id="btn_B" onClick="checkF('B');" class="log_btn">LOGIN 2</span>
          <span id="btn_C" onClick="checkF('C');" class="log_btn">LOGIN 3</span>
        </div>
        <div class="login">
          <div class="account">
            <input id="username" class="input_box" type="text" name="username" value="" maxlength="26" tabindex="1" onFocus="inputFocus(this,def_user);" onBlur="inputBlur(this,def_user);" placeholder="Login ID">
          </div>
          <div class="password">
            <input id="passwd" class="input_box" type="password" name="passwd" value="" maxlength="28" tabindex="2" onFocus="inputFocus(this,def_passwd);" onBlur="inputBlur(this,def_passwd);" placeholder="Password">
          </div>

          <div id="Sefe">
            <div class="notice_en">Enter Safe Code if it is set for your account.</div>
            <div class="safe_en">
              <input id="passwd_safe" class="input_box" type="password" name="passwd_safe" value="" maxlength="28" tabindex="2" onFocus="inputFocus(this,def_passwd_safe);" onBlur="inputBlur(this,def_passwd_safe);" placeholder="Safe Code">
            </div>
          </div>

          <div id="hr_info" class="warn" style="display:none;">Please enter your username!</div>
          <div class="remember">
            <label><input type="checkbox" id="remember"/><span></span></label>
            <span class="remember_word_en">Remember Me</span>
          </div>
          <input class="send_btn" type="button" id="Forms Button1" onClick="chk_type();" value="LOG IN">
        </div>
      </form>
    </div>

  </div>
  </div>
  <div class="foot_us"></div>
  </body>
  </html>
<?php endif?>
<?php if($langx=="zh-cn"):?>
  <html>
  <head>
    <title>index</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/style/control/index4.css" type="text/css">
    <script language="JavaScript" src="/js/HttpRequest.js"></script>
    <script language="JavaScript" src="/js/index.js"></script>
    <script language="JavaScript" src="/js/ga.js"></script>
    <script language="JavaScript" src="/js/zh-cn.js"></script>
    <script language="JavaScript" type="text/JavaScript">
      var def_user = "登录帐号";
      var def_passwd = "密码";
      var def_passwd_safe = "安全代码";
      var info_user = "请输入帐号";
      var info_passwd = "请输入密码";
      var info_passwd_safe = "请输入安全代码";
    </script>
  </head>

  <body  onLoad="onload();">
  <div class="main">
    <div class="lang">
      <a href="./index.php?langx=zh-tw"><span name="link_tw" class="lan_word">繁体版</span></a>
      <a href="./index.php?langx=zh-cn"><span name="link_cn" class="lan_word_on">简体版</span></a>
      <a href="./index.php?langx=en-us"><span name="link_us" class="lan_word">English</span></a>
    </div>

    <div class="agLOGO"></div>
    <div class="new" style="
    width: 100%;
">
      <div id="new_btn" class="new_btn_on" onclick="chgdomain('new');" style="
    width: 50%;
    height: 40px;
    line-height: 40px;
    text-align: center;
    background-color: #CA9D49;
    color: #FFFFFF;
    float: left;
    cursor: pointer;
">新版</div>
      <div id="old_btn" class="new_btn" onclick="chgdomain('old');" style="
    background-color: #D8D5D5;
    color: #737373;
    width: 50%;
    height: 40px;
    line-height: 40px;
    text-align: center;
    float: left;
    cursor: pointer;
">旧版</div>
    </div>
    <div class="loginBOX">

      <form id="LoginForm" name="LoginForm" method="post" action="" onSubmit="return chk_acc();">
        <input id="langx" type="hidden" name="langx" value=zh-cn>

        <div class="log_btnG">
          <span id="btn_A" onClick="checkF('A');" class="log_btnON">登入 1</span>
          <span id="btn_B" onClick="checkF('B');" class="log_btn">登入 2</span>
          <span id="btn_C" onClick="checkF('C');" class="log_btn">登入 3</span>
        </div>
        <div class="login">
          <div class="account">
            <input id="username" class="input_box" type="text" name="username" value="" maxlength="26" tabindex="1" onFocus="inputFocus(this,def_user);" onBlur="inputBlur(this,def_user);" placeholder="登录帐号">
          </div>
          <div class="password">
            <input id="passwd" class="input_box" type="password" name="passwd" value="" maxlength="28" tabindex="2" onFocus="inputFocus(this,def_passwd);" onBlur="inputBlur(this,def_passwd);" placeholder="密码">
          </div>

          <div id="Sefe">
            <div class="notice">未设定安全代码不需输入</div>
            <div class="safe">
              <input id="passwd_safe" class="input_box" type="password" name="passwd_safe" value="" maxlength="28" tabindex="2" onFocus="inputFocus(this,def_passwd_safe);" onBlur="inputBlur(this,def_passwd_safe);" placeholder="安全代码">
            </div>
          </div>

          <div id="hr_info" class="warn" style="display:none;">请输入帐号</div>
          <div class="remember">
            <label><input type="checkbox" id="remember"/><span></span></label>
            <span class="remember_word">记住我的帐号</span>
          </div>
          <input class="send_btn" type="button" id="Forms Button1" onClick="chk_type();" value="登入">
        </div>
      </form>
    </div>
  </div>
  </div>

  <div class="foot_tw"></div>
  </body>
  </html>
<?php endif?>