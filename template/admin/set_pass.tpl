{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-设置密码{/block}
{block name="main"}
    {include file="admin/include/center.tpl"}
    <div id="m_right">
       
        <form action="/admin/base/setpwd" class="form_common" id="gen_from" name="editForm">
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

        </form>
      </div>
{/block}

