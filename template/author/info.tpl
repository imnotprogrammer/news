{extends file="shanghu/layout/shanghu.tpl"}
{block name="title"}便民之家-个人中心{/block}
{block name="main"}
    {include file="shanghu/include/center.tpl"}
    <div id="m_right">
        <div id="user_header">
          <ul>
            <li><img src="/res/img/user.jpg"></li>
            <li class="uh_two">
              <ul>
                <li>{$userInfo.ui_name}</li>
                <li style="margin-left:20px"><span>金额：¥{$userInfo.ui_withdraw}</span></li>
                <li style="line-height:30px;margin-left:20px">
                  <a href="#" style="display:inline-block;text-decoration:underline">充值</a>
                  <a href="#" style="display:inline-block;margin-left:10px;text-decoration:underline">提现</a>
                </li>
              </ul>
            </li>
            <li class="uh_two" style="margin-left:20px;">
              <ul style="padding-top:4px">
                 <li>&nbsp;</li>
                <li><span>待读信息：</span><a href="/user/message?type=0">{$messageCount}</a></li>
               
                <li><span>待发货：</span><a href="/userorder?type=">{$orderCount}</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <h3>我的商铺</h3>
        <div class="shoper_list">
          <div id="shml_header" style="width:90%;background:white;border:0">
              <div id="shmlh_left" style="float:left">
                <a style="position:relative" href="/shop?sno={$shop.si_no}"><img src="{$shop.si_logo}" ></a>
              </div>
              <div id="shmlh_right" style="float:left;width:300px">
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
        </div>
        <h3>我的商品</h3>
        <div class="shoper_list" style="margin-bottom:50px">
          {foreach $goods as $g}
          <div>
            <a href="/goods?gno={$g.gi_no}" style="display:block;position:relative;text-decoration:none">
            <ul>
              <li>
                <img src="{$g.gi_logo}">
              </li>
              <li>{$g.gi_name}</li>
              <li>价格：¥{$g.gi_price}</li>
            </ul>
            </a>
          </div>
          {/foreach}
        </div>
        
      </div>
{/block}