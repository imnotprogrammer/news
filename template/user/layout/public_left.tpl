<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}就要去便民之家--用户中心页面{/block}</title>
    <link rel="stylesheet" href="/res/css/center.css" />
    <script src="/res/js/jquery.min.js"></script>
    <script src="/res/js/layer/layer.js"></script>
    <script src="/res/js/autocomplete.js"></script>
    <script src="/res/js/common.js"></script> 
    <script src="/res/js/userhome.js"></script> 
		<script src="/res/js/adminhome.js"></script> 
		<script src="/res/js/shoperhome.js"></script> 
	<!--<script src="/res/js/site.js"></script> // res文件下没有此目录，造成console控制台报错-->
	  <script src="/res/js/layer/layer.js"></script> 
	  <script src="/res/js/area_one.js"></script>
    <script src="/res/js/class_one.js"></script>
  </head>
  <body>
  {block name="head"}
    <header>
      <div>
        <div id="top_navigation">
          <div><span></span><a href="/city">切换城市</a><a href="/">首页</a></div>
          <ul>
            <li><a href="/help">帮助中心</a></li>
            <li><a href="/usercenter/order/list" target="_blank">我的订单</a></li>
            <li><a href="/usercenter/finance/index">会员中心</a></li>
            <li><a href="/cart">购物车</a></li>
            {if empty($smarty.session.bmzj.uno)}
            <li><a href="/reg">注册</a></li>
            <li><a href="/login">登录</a></li>
            {else}
            <li><span>Hi,{$smarty.session.bmzj.uname}</span><a href="/login/loginout">退出</a><a href="/usercenter/other/message">消息(<span style="color: red; margin-right: 0;">{if $messcount}$messcount{else}0{/if}</span>)</a></li>
            {/if}
          </ul>
        </div>
      </div>
      <div>
        <div id="index_logo_part" >
          <div><img src="/res/img/logo.png"></div>
          <form action="/search" method="get">
            <ul>
              <li><input type="text" name="sword" placeholder="店铺、商品、招聘搜索"></li>
              <li style="border-left: none;"><button type="submit">搜索</button></li>
            </ul>
          </form>
        </div>
      </div>
    </header>
   {/block}
    <section id="main">    
      {block name="main"}
      {/block}
      <ul id="aside">
        <li><a href="/"><img src="/res/img/home.png"><br>网站首页</a></li>
        <li><a href="/help"><img src="/res/img/help.png"><br>帮助中心</a></li>
        <li><a href="/about"><img src="/res/img/service.png"><br>联系我们</a></li>
        <li><a href="#"><img src="/res/img/top.png"><br>返回顶部</a></li>
      </ul>
    </section>
    <footer>
      <div>
        <ul>
          <li>xxx有限公司</li>
          <li>四川成都市温江区城区温江区锦绣大道99号（SBI）302</li>
          <li>蜀ICP备14029689号</li>
          <li>Copyright&nbsp;&nbsp;&nbsp;2016-2016</li>
        </ul>
        <img src="/res/img/weidian.jpg">
      </div>
    </footer>
    {block name="js"}
    {/block}
  </body> 
</html>