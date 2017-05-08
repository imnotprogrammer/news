<style>
  #m_left ul li{
      height:40px;
  }
</style>
<div id="m_left">
    <h2>
      <img src="/res/img/home.png">用户设置
    </h2>
    <ul>
          <li><a href="/admin/base/index"{if currentActionIn(['/admin/base/index','/admin/base/setgen'])} class="cur_two_level"{/if}>基本信息</a></li>
          <li><a href="/admin/base/setpwd" {if currentActionIn(['/admin/base/setpwd'])} class="cur_two_level"{/if}>修改密码</a></li>
          <li><a href="/admin/base/setemail" {if currentActionIn(['/admin/base/setemail'])} class="cur_two_level"{/if}>修改邮箱</a></li>
          <li><a href="/admin/base/setphone" {if currentActionIn(['/admin/base/setphone'])} class="cur_two_level"{/if}>修改联系电话</a></li>
       

    </ul>
    <h2>
      <img src="/res/img/setting_black.png">新闻管理
    </h2>
    <ul>
          <li><a href="/admin/index/index"{if currentActionIn(['/admin/index/index','/admin/index/newsdetail'])} class="cur_two_level"{/if}>未审核新闻</a></li>
          
		  <li><a href="/admin/index/checkauthor" {if currentActionIn(['/admin/index/checkauthor'])} class="cur_two_level"{/if}>记者审核</a></li>
          
          <li><a href="/admin/index/authorinfo" {if currentActionIn(['/admin/index/authorinfo'])} class="cur_two_level"{/if}>记者信息</a></li>
          <li><a href="/admin/index/userinfo" {if currentActionIn(['/admin/index/userinfo'])} class="cur_two_level"{/if}>用户信息</a></li>
		  <li><a href="/admin/index/newstype" {if currentActionIn(['/admin/index/newstype','/admin/index/addtype'])} class="cur_two_level"{/if}>新闻类型</a></li>
        
          

    </ul>
    <h2>
      <img src="/res/img/mess_black.png">其它管理
    </h2>
    <ul>
          <!--<li><a href="/admin/other/findpass"{if currentActionIn(['/admin/other/message'])} class="cur_two_level"{/if}>找回密码</a></li>-->
          <li><a href="/admin/other/comment" {if currentActionIn(['/admin/other/comment','/admin/index/orderdetail'])} class="cur_two_level"{/if}>评论信息</a></li>
          <li><a href="/admin/other/note" {if currentActionIn(['/admin/other/note'])} class="cur_two_level"{/if}>留言信息</a></li>
          <li><a href="/admin/other/sendmess" {if currentActionIn(['/admin/other/sendmess','/admin/admin/add'])} class="cur_two_level"{/if}>发送消息</a></li>
          <li><a href="/admin/other/donteinfo" {if currentActionIn(['/admin/other/donteinfo'])} class="cur_two_level"{/if}>捐赠信息</a></li>        
    </ul>
</div>