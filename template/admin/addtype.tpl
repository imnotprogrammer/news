{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-添加新闻类型{/block}
{block name="main"}
    {include file="admin/include/center.tpl"}
    <div id="m_right">
        <div id="step_form">
           <ul>
            <li class="cur">添加新闻类型</li>
            
           </ul>
        </div>
        <form action="/admin/index/addtype" method= "post" class="form_common" id="gen_from" name="editForm">
          <div id="step1">
              <p>                
                <label>新闻类型:</label>
                <input type="text" name="nti_name" style="border:1px solid gray">
              </p>    
              <p>
                <label>&nbsp;</label>
                <input type="button" value="确定" class="btn">
             </p>                          
             </div>
          
         
        </form>
        
      </div>
{/block}

