{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-设置密码{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
       
        <form action="/user/index/setpwd" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>旧密码:</label>
                <input type="password" class="require" title="旧密码不能为空" name="oldpass" style="border-radius:4px; border:1px solid gray;">          
              </p>
			  <p>
                
                <label>新密码:</label>
                <input type="password" class="require" title="新密码不能为空" name="newpass" style="border-radius:4px; border:1px solid gray;">          
              </p>
			  <p>
                
                <label>确认新密码:</label>
                <input type="password" class="require" title="确认密码不能为空" name="surepass" style="border-radius:4px;border:1px solid gray;">          
              </p>
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" style="border-radius:4px;border:1px solid gray;" class="btn">
            </p>
          </div>
          
          <div id="step2" style="display:none">
          
                <p>
                    <label>新密码:</label>
                    <input type="password" name="newPassword">
             
                  </p>
                  <p>
                    <label>再次输入:</label>
                    <input type="password" name="newPasswordSure">
                  </p>
                  <p>
                    <label>&nbsp;</label>
                    <input type="button" value="确认" onclick="save()">
                  </p>
                
          </div>
          
          <div id="step3" style="display:none">
          
                <p style="font-size:14px;">~亲，修改密码成功！</p>
                
          </div>
        </form>
      </div>
{/block}

