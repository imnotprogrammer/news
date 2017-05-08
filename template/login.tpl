<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}就要去新闻之家{/block}</title>
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
          <li><input type="text" placeholder=" 手机号码/注册邮箱" name="uname" id="u_name"></li>
          <li><input type="password" placeholder=" 登录密码" name="upass" id="u_pass"><a class="forget_pass" href="/index/findpass">忘记密码</a></li>
          <li>
            <input type="text" placeholder=" 输入验证码" name="uvercode" id="u_pass" style="width: 10rem;">
            <img src="/vercode"  onclick="this.src='/vercode?'+Math.random()" style=" vertical-align: middle; border: 2px solid #ddd;"/>
          </li>
          <li>
          <button type="button" id="login_but" onclick="login()">登录</button>
          
          </li>
        </ul>
      </form>
    </section>
    <footer>就要去新闻之家&copy;2015</footer>
  </body>
  </html>