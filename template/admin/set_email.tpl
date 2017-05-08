{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-设置新邮箱{/block}
{block name="main"}
    {include file="admin/include/center.tpl"}
	<style>
	   input{
	      border:1px solid gray;
		  border-radius:4px;
		  
	   }
	</style>
    <div id="m_right">
        <div id="step_form">
           <ul>
            <li class="cur">设置新邮箱</li>
            
           </ul>
        </div>
        <form action="/admin/base/setEmail" method= "post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>登录密码:</label>
                <input type="password" name="pass" class="require" title="登录密码不能为空">
              </p>
			  <p>
                
                <label>旧邮箱:</label>
                <input type="text" readonly name="email" class="require" title="旧邮箱" value="{$smarty.session.news.uemail}" />     
              </p>
			  <p>
                <label>新邮箱:</label>
                <input type="text" name="newemail" class='emailreg'  value="">   
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" class="btn">
            </p>
             
               
             </div>
          
         
        </form>
        
      </div>
{/block}

