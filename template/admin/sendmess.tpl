{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-发送消息{/block}
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
            <li class="cur">发送消息</li>
            
           </ul>
        </div>
        <form action="/admin/other/sendmess" method= "post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                 
                <label>消息标题:</label>
                <input type="text" name="umi_title" class="require" title="消息标题不能为空！" placeholder=" ">
              </p>

			  <p>
                
                <label>接受范围:</label>
                <select class="sendmess" name="type"> 
				    <option value=1 selected>所有人</option>
					<option value=2 >仅限于一人</option>
				</select>
              </p>
			  <p class="reciver">
                <label class="reciver">接受人:</label>
                <input  class="reciver" type="text" name="umi_name" class='emailreg'  value="">
			  </p>
              <p style="padding-top:2rem;">
                 
                <label>消息内容:</label>
                <textarea type="text" class="require" title="消息内容不能为空！" name="umi_body"placeholder=" "></textarea><br></br>
              </p>	
             <br></br>	<br></br>		  
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" class="btn">
            </p>
             
               
             </div>
          
         
        </form>
        
      </div>
{/block}

