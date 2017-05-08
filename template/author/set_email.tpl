{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-设置新邮箱{/block}
{block name="main"}
    {include file="author/include/center.tpl"}
    <div id="m_right">
        <div id="step_form">
           <ul>
            <li class="cur">设置新邮箱</li>
            
           </ul>
        </div>
			<style>
	  input{
	      border:1px solid gray;
		  border-radius:4px;
		  
	   }
	   </style>
        <form action="/author/base/setemail" method= "post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>登录密码:</label>
                <input type="password" name="pass" class="require" title="登录密码不能为空！">
              </p>
			  <p>
                
                <label>旧邮箱:</label>
                <input readonly type="text" name="email"  value="{$smarty.session.news.uemail}" />     
              </p>
			  <p>
                <label>新邮箱:</label>
                <input type="text" name="newemail" class='emailreg' value="">   
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" class="btn">
            </p>
             
               
             </div>
          
         
        </form>
        
      </div>
{/block}

