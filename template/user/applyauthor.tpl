{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-申请作者{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
        <div id="step_form">
           <ul>
            <li class="cur">申请作者</li>
            
           </ul>
        </div>
        <form action="/user/other/apply" method= "post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>
                
                <label>申请理由:</label>
                <textarea type="text" name="body" class="require" title="申请理由还是写点吧！"style="border:1px solid color:gray;border-radius:4px;"></textarea>
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

