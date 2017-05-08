<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}便民之家-管理员{/block}</title>
    <link rel="stylesheet" href="/res/css/admin.css" />
    <link rel="stylesheet" href="/res/css/common.css" /> 
    <link rel="stylesheet" href="/res/css/shoper_home.css" /> 
	<link rel="stylesheet"  href="/res/css/webuploader.css" />
	<link rel="stylesheet"  href="/res/css/dialog.css" />
	<link rel="stylesheet"  href="/res/css/login_reg.css" />
	<!--<link rel="stylesheet"  href="/res/css/bootstrap.css" />-->
	<link href="/umeditor/themes/default/css/umeditor.css" rel="stylesheet">
    <script src="/res/js/jquery.min.js"></script>
    <script src="/umeditor/umeditor.config.js"></script>
    <script src="/umeditor/umeditor.min.js"></script>
    <script src="/umeditor/lang/zh-cn/zh-cn.js"></script>
	<script src="/res/js/layer/layer.js"></script>  
	<script src="/res/js/bootstrap.js"></script>
	<script src="/res/js/common.js"></script>
    <script src="/res/js/site.js"></script>
	<script src="/res/js/dialog.js"></script>
	
  </head>
  <body class="set_page">
    <style>
   #h_right>a{
      color:white;
	}
	.special-a:hover{
	  text-decoration:none;
	}
  </style>
     <header style="height:80px;margin-top:0px;">
      <div id="h_left" style="height:80px;width:63%;margin-left:1rem;line-height:80px;">
        <a href="/" style="height:80px;line-height:80px;"><img src="/res/img/other_logo.jpg" width="140" height="40" style="margin-top:20px;"></a>
      </div>
      <div id="h_right"  style="height:80px;width:35%;line-height:80px;color:white;text-align:center;">
        <a href="/">首页</a>
        <span>|</span>
        {if !isLogin()}
		
        <a href="/index/login">登录</a>
        <span>|</span>
        <a href="/index/reguser">注册</a>
		{else}
		  <a href="javascript:void(0)">{if !empty($smarty.session.news.uheader)}<img src="{$smarty.session.news.uheader}" style="width:64px;height:64px; border-radius:50%;">{else}<img src="/res/img/user.jpg" style="width:64px;height:64px; border-radius:50%;">{/if}</a>
		  <a href="javascript:void(0)" class="special-a"><b style="color:black;">你好，</b>{$smarty.session.news.uname}</a> 
		
		{/if}
        {if isShopUser()}
          <span>|</span>
          <a href="/author/index/index">记者中心</a>
          {/if}
          {if isAdmin()}
          <span>|</span>
          <a href="/admin/index/index">后台管理</a>
          {/if}
		  {if isUser()}
          <span>|</span>
          <a href="/user/index/index">用户中心</a>
          {/if}
		  <span>|</span>
		  <a href="/index/loginout">退出</a>
      </div>
    </header>
    <div id="main" class="set_list">
      {block name="main"}
            {block name="left"}
            左边菜单
            {/block}
            {block name="right"}
            右边主要部分
            {/block}
      {/block}
    </div>
    <footer>新闻之家&copy;2015-2018</footer>
  </body>
  {block name="js"}
  {/block}
</html>