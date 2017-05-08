<div id="shml_header">
  <div id="shmlh_left">
    <img src="{$shop.si_logo}">
  </div>
  <div id="shmlh_right">
    <ul>
      <li>{$shop.si_name}</li>
      <li>
        <div>
        {scoreImg($shop.si_total_score,$shop.si_score_count)}
        </div>
      </li>
      <li><span>电话：</span>{$shop.si_phone}</li>
      <li><span>联系人：</span>{$shop.si_contact}</li>
      <li><span>地址：</span>{$shop.si_address}</li>
    </ul>
  </div>
</div>
 <div id="shml_nav">
  <ul>
    <li><a href="/shop?sno={$smarty.get.sno}" {if currentActionIn(['/shop/index'])}class="shmln_cur"{/if}>首页</a></li>
    <li><a href="/shop/goods?sno={$smarty.get.sno}" {if currentActionIn(['/shop/goods'])}class="shmln_cur"{/if}>商品</a></li>
    <li><a href="/shop/album?sno={$smarty.get.sno}" {if currentActionIn(['/shop/album'])}class="shmln_cur"{/if}>相册</a></li>
    <li><a href="/shop/job?sno={$smarty.get.sno}" {if currentActionIn(['/shop/job'])}class="shmln_cur"{/if}>招聘</a></li>
  </ul>
</div>