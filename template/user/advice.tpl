{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-留言建议{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
        <div id="step_form">
           <ul>
            <li class="cur">留言建议</li>
            
           </ul>
        </div>
        <form action="/user/other/myadvice" method= "post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>留言内容:</label>
                <textarea type="text" class="require" title="留言内容还是写点吧!" name="note" style="border:1px solid color:gray;border-radius:4px;"></textarea>
              </p>
			   <br><br><br>  
              <p>
                <label>&nbsp;</label>
                
                
                <input type="button" value="确定" class="btn">
            </p>
             
               
             </div>
          
         
        </form>
        
      </div>
{/block}

