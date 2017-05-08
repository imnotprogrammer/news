<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}就要去便民之家{/block}</title>
    <link rel="stylesheet" href="/res/css/dialog.css" />
    <link rel="stylesheet" href="/res/css/login_reg.css" />
    <script src="/res/js/jquery.min.js"></script>
    <script src="/res/js/dialog.js"></script>
    <script src="/res/js/login_reg.js"></script>
    <script src="/res/js/site.js"></script>
    <script src="/res/js/form.js"></script>
    <script src="/res/js/layer/layer.js"></script>
  </head>

  <body>
    <style type="text/css">
  section input:focus,
  section input[type=text]:focus,
  section input[type=password]:focus,
  textarea:focus,
  select:focus{
    border:1px #f60 solid;
  }
  section input[type=text],
  section input[type=password]{
    padding-left:10px;
    width:390px;
  }
  </style>
    <!--
      <div class="speech-bubble speech-bubble-left">
        <span>箭头在左侧</span>
      </div>
    -->
    <header>
      <div id="h_left">
        <a href="/"><img src="/res/img/logo2.png" width="210" height="72"></a>
      </div>
      <div id="h_right">
        <a href="/">首页</a>
        <span>|</span>
        
        <a href="/login">登录</a>
        <span>|</span>
        <a href="/reg">注册</a>
        {if isShopUser()}
          <span>|</span>
          <a href="/shanghu/index/info">商户中心</a>
          {/if}
          {if isAdmin()}
          <span>|</span>
          <a href="/admin/index/orders">后台管理</a>
          {/if}
      </div>
    </header>
    {block name="main"}
    {/block}
    <footer>就要去便民之家&copy;2015</footer>
  </body>
</html>