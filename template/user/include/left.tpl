<style>
    #m_left ul li{
	  height:40px;
	  line-height:40px;
	}
</style>
<div id="m_left"> 
<h2>
    <img src="/res/img/setting_black.png">设置
</h2>
<ul>
  <li><a {if currentActionIn(['/user/index/setgen'])}class="cur_two_level"{/if} href="/user/index/setgen">基本信息</a></li>
  <li><a {if currentActionIn(['/user/index/setphone'])}class="cur_two_level"{/if} href="/user/index/setphone">修改手机号码</a></li>  
  <li><a {if currentActionIn(['/user/index/setEmail'])}class="cur_two_level"{/if}href="/user/index/setEmail">修改邮箱</a></li>
  <li><a {if currentActionIn(['/user/index/setpwd'])}class="cur_two_level"{/if}href="/user/index/setpwd">修改密码</a></li>
  <li><a {if currentActionIn(['/user/index/setkey'])}class="cur_two_level"{/if}href="/user/index/setkey">修改秘钥</a></li>
</ul>
<h2>
    <img src="/res/img/mess_black.png">个性中心
  </h2>
<ul>
<li><a href="/user/personal/message" {if currentActionIn(['/user/personal/message'])}class="cur_two_level"{/if}>我的消息{if $messcount neq 0}<em style="clear:both;width:20px;height:20px;background:red;border-radius:50%;line-height:20px;">{$messcount}</em>{/if}</a></li>
<li><a {if currentActionIn(['/user/personal/comment'])}class="cur_two_level"{/if}href="/user/personal/comment">我的评论</a></li>
<li><a {if currentActionIn(['/user/personal/collect'])}class="cur_two_level"{/if}href="/user/personal/collect">我的收藏</a></li>
<li><a {if currentActionIn(['/user/personal/myfavo'])}class="cur_two_level"{/if}href="/user/personal/myfavo">我的兴趣</a></li>
</ul>
<h2>
  <img src="/res/img/collect.png">其它相关
</h2>
<ul>
 
  <li><a {if currentActionIn(['/user/other/myadvice'])}class="cur_two_level"{/if} href="/user/other/myadvice">提交建议</a></li>
  <li><a {if currentActionIn(['/user/other/apply'])}class="cur_two_level"{/if} href="/user/other/apply">申请记者</a></li>
  
</ul>
</div>