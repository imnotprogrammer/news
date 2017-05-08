<div id="m_left">
    <h2>
      <img src="/res/img/home.png">商品与店铺
    </h2>
    <ul>
      <li><a href="/shanghu/shop/modify" {if currentActionIn(['/shanghu/shop/modify'])}class="cur_two_level"{/if}>店铺装修</a></li>
      <li><a href="/shanghu/goods/list?type=1" {if currentActionIn(['/shanghu/goods/list']) && $smarty.get.type==1}class="cur_two_level"{/if}>商品列表</a></li>
      <li><a href="/shanghu/goods/list?type=2" {if currentActionIn(['/shanghu/goods/list']) && $smarty.get.type==2}class="cur_two_level"{/if}>特价商品列表</a></li>
      <li><a href="/shanghu/goods/add" {if currentActionIn(['/shanghu/goods/add'])}class="cur_two_level"{/if}>添加商品</a></li>
    </ul>
  </div>