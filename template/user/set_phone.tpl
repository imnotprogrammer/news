{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-设置手机号码{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
	<style>
	   #step1 input{
	       border:1px solid gray;
		   border-radius:4px;
	   }
	</style>
    <div id="m_right">
        <div id="step_form">
           <ul>
            <li class="cur">设置新号码</li>
            
           </ul>
        </div>
        <form action="/user/index/setPhone" method="post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>登录密码:</label>
                <input type="password" name="pass" class='require' title="登录密码不能为空!">
              </p>
			  <p  {if empty($smarty.session.news.uphone)}style="display:none;"{/if} >
                
                <label>旧号码:</label>
                <input type="text" name="tel"  readonly=true value="{$smarty.session.news.uphone}"  />     
              </p>
			  <p>
                <label>新号码:</label>
                <input type="text" name="newtel" class='phonereg' >   
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" class="btn">
            </p>
             
               
             </div>
          
         
        </form>


      </div>
{/block}

