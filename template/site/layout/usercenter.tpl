<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}就要去便民超市--中国第一家网上服务超市{/block}</title>
    <link rel="stylesheet" href="/res/css/index.css" />
    <link rel="stylesheet" href="/res/css/shoper_home.css" />
    <link rel="stylesheet" href="/res/css/common.css" />
    <link rel="stylesheet" href="/res/js/layer/skin/layer.css" />
    <script src="/res/js/jquery.min.js"></script>
    <script src="/res/js/jquery.superslide.js"></script>
    <script src="/res/js/outer.js"></script>
    <script src="/res/js/area.js"></script>
    <script src="/res/js/layer/layer.js"></script>
  </head>
  <body>
    {block name="head"}
    <header>
      <div>
        <div><span>{$smarty.session.userarea.cityName}</span><a href="/city">切换城市</a></div>
        <ul>
          <li><a href="/help">帮助中心</a></li>
          <li><a href="/userorder" target="_blank">我的订单</a></li>
          <li><a href="/user/indexhome">会员中心</a></li>
          {if isShopUser()}
          <li><a href="/shanghu/index/info">商户中心</a></li>
          {/if}
          {if isAdmin()}
          <li><a href="/admin/index/orders">后台管理</a></li>
          {/if}
          {if !isset($smarty.session.bmzj.uno)}
          <li><a href="/reg">注册</a></li>
          {/if}
          <li ><a href="/cart">购物车</a></li>
          <li>{if isset($smarty.session.bmzj.uno)}
                <span>Hi,{$smarty.session.bmzj.uname}</span><a href="/login/loginout">退出</a>
                {else}
                <a href="/login">请登录</a>
                {/if}
          </li>
          
        </ul>
      </div>
    </header>
    {/block}
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
    <input type="hidden" name="userProvId" value="{$smarty.session.userIpArea.provId}"/>
    <input type="hidden" name="userCityId" value="{$smarty.session.userIpArea.cityId}"/>
    <input type="hidden" name="userCountyId" value="{$smarty.session.userIpArea.countyId}"/>
  </body>
</html>