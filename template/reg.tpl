<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}新闻之家-注册用户{/block}</title>
    <link rel="stylesheet" href="/res/css/dialog.css" />
    <link rel="stylesheet" href="/res/css/login_reg.css" />
    <script src="/res/js/jquery.min.js"></script>
    <script src="/res/js/dialog.js"></script>
    <script src="/res/js/login_reg.js"></script>
    <script src="/res/js/common.js"></script>
    <script src="/res/js/form.js"></script>
    <script src="/res/js/layer/layer.js"></script>
  </head>
<body>
<header>
      <div id="h_left">
        <a href="/"><img src="/res/img/logo.jpg" width="142" height="40"></a>
      </div>
      <div id="h_right">
        <a href="/">首页</a>
        <span>|</span>
        
        <a href="/index/login">登录</a>
        <span>|</span>
        <a href="/index/reguser">注册</a>
        
      </div>
    </header>

<section>
      <form name="loginForm">
        <ul>
          <li><input type="text" placeholder=" 邮箱" id="reg_email" name="email"></li>
          <li class="reg_code_part"><input type="text" placeholder=" 验证码" name="code" style="width:250px;"><a style="width:170px" href="javascript:void(0);" id="getcode" onclick="sendPhoneCode()">获取验证码</a></li>
          <li><input type="password" placeholder=" 登录密码" name="pwd"></li>
          <li><input type="password" placeholder=" 确认密码" name="surepwd"></li>
		  <li><input type="text" placeholder=" 密保--用于找回密码" name="setprotectkey"></li>
          <li><button type="button" onclick="reg()">注册</button></li>
        </ul>
        <input type="hidden" name="verkey" value="{produceVerPhoneCode()}"/>
      </form>
    </section>
    <footer>新闻之家&copy;2015</footer>
  </body>
  </html>