{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-未审核新闻-详情{/block}
{block name="main"}
<style>
  .h_title{
     margin-top:10px;
     margin-left:10px;
     border:1px solid  rgb(66, 160, 121); 
     border-radius:4px;
	 height:40px;
	 width:120px;
	 line-height:40px;
	 font-size:14px;
	 text-align:center;
	 color:white;
	 background:rgb(66,160,121);
    }
    .f-size{
	   font-size:14px;
	 
	 
  }
    .img{
	    width:64px;
		height:64px;
		border-radius:50%;
	}
	input{
	    border:1px solid gray;
		border-radius:4px;
	}
</style>
    {include file="author/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">新闻详情</div> 
           {if $smarty.get.type eq 0}
          <div id="step1">
		  <form action="/admin/other/sendmess" method= "post" class="form_common" id="gen_from" name="editForm">
              <p>
                 
                <label>新闻标题:</label>
                <input type="text" name="umi_title" placeholder=" " value=" {$news['ni_title']}" readonly>
              </p>
			  <p>
                
                <label>新闻类型:</label>
                <select class="sendmess" name="type" readonly> 
				
					
						<option value="{$news['ni_type']}" selected readonly>{$type}</option>
				   
					
				</select>
              </p>
              <p style="display:block;width:810px;height:610px;margin-left:30px;">
		        <span>新闻内容:</span>
		        <script type="text/plain" id="myEditor" style="">
                 {$news['ni_body']}
                </script>

               </p>		  
             </form>			  
             </div>                 
        
		  {else}
		  {/if}
    </div>
{/block}

