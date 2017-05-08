<div id="m_left" class="">
    <h2>
      <img src="/res/img/home.png">用户设置
    </h2>
    <ul>
          <li><a href="/author/base/index"{if currentActionIn(['/author/base/index','/author/base/setgen'])} class="cur_two_level"{/if}>基本信息</a></li>
          <li><a href="/author/base/setpwd" {if currentActionIn(['/author/base/setpwd'])} class="cur_two_level"{/if}>修改密码</a></li>
          <li><a href="/author/base/setemail" {if currentActionIn(['/author/base/setemail'])} class="cur_two_level"{/if}>修改邮箱</a></li>
          <li><a href="/author/base/setphone" {if currentActionIn(['/author/base/setphone'])} class="cur_two_level"{/if}>修改联系电话</a></li>
		  <li><a href="/author/base/setkey" {if currentActionIn(['/author/base/setkey'])} class="cur_two_level"{/if}>修改秘钥</a></li>
       

    </ul>
    <h2>
      <img src="/res/img/setting_black.png">新闻管理
    </h2>
    <ul>
          <li><a href="/author/index/index"{if currentActionIn(['/author/index/index','/author/index/newsdetail'])} class="cur_two_level"{/if}>新闻列表</a></li>
          <li><a href="/author/index/addnews" {if currentActionIn(['/author/index/addnews','/author/index/orderdetail'])} class="cur_two_level"{/if}>添加普通新闻</a></li>
		  <li><a href="/author/index/addpicnews" {if currentActionIn(['/author/index/addpicnews'])} class="cur_two_level"{/if}>添加图片新闻</a></li>
          
          <li><a href="/author/index/comment" {if currentActionIn(['/author/index/comment','/author/index/allcomment'])} class="cur_two_level"{/if}>新闻评论</a></li>
          <li><a href="/author/index/browser" {if currentActionIn(['/author/index/browser','/author/author/add'])} class="cur_two_level"{/if}>新闻点击量排行</a></li>

          

    </ul>
    <h2>
      <img src="/res/img/mess_black.png">其它信息
    </h2>
    <ul>
          <li><a href="/author/other/message"{if currentActionIn(['/author/other/message'])} class="cur_two_level"{/if}>我的消息{if $messcount neq 0}<em style="clear:both;width:20px;height:20px;background:red;border-radius:50%;line-height:20px;">{$messcount}</em>{/if}</a></li>
              
    </ul>
</div>