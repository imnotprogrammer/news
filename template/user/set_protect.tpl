{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-设置秘钥{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
        <span style="height:30px;line-height:30px;margin-top:2rem;padding-left:2rem;color:red;">此功能主要用于用户在忘记密码时，用于找回密码的验证!</span>
        <form action="/user/index/setkey" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>登录密码:</label>
                <input type="password" class="require" title="登录密码不能为空" name="oldpass" style="border-radius:4px; border:1px solid gray;">          
              </p>
			  <p>
                
                <label>新秘钥:</label>
                <input type="password" class="require" title="新秘钥不能为空" name="newkey" style="border-radius:4px; border:1px solid gray;">          
              </p>
			  <p>
                
                <label>确认秘钥:</label>
                <input type="password" name="surekey" class="require" title="确认秘钥不能为空" style="border-radius:4px;border:1px solid gray;">          
              </p>
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" style="border-radius:4px;border:1px solid gray;" class="btn">
            </p>
          </div>
          
          
          
      
        </form>
      </div>
{/block}

