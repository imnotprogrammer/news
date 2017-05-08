{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-设置秘钥{/block}
{block name="main"}
    {include file="author/include/center.tpl"}
    <div id="m_right">
        <span style="height:30px;line-height:30px;margin-top:2rem;padding-left:2rem;color:red;">此功能主要用于用户在忘记密码时，用于找回密码的验证!</span>
        <form action="/author/base/setkey" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>登录密码:</label>
                <input type="password" name="oldpass" class="require" title="登录密码不能为空！" style="border-radius:4px; border:1px solid gray;">          
              </p>
			  <p>
                
                <label>新秘钥:</label>
                <input type="password" name="newkey" class="require" title="新秘钥不能为空！" style="border-radius:4px; border:1px solid gray;">          
              </p>
			  <p>
                
                <label>确认秘钥:</label>
                <input type="password" name="surekey" class="require" title="确认密钥不能为空！" style="border-radius:4px;border:1px solid gray;">          
              </p>
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" style="border-radius:4px;border:1px solid gray;" class="btn">
            </p>
          </div>
          
          
          
      
        </form>
      </div>
{/block}

