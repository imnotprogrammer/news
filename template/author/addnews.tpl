{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-添加普通新闻{/block}
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
	{if !empty($smarty.get.no)}
          <div class="h_title">修改普通新闻</div> 
           
          <div id="step1">
		  <form action="/author/index/addnews" method= "post" class="form_common" id="gen_from" name="editForm">
              <p>
                 
                <label>新闻标题:</label>
                <input type="text" style="width:350px;" name="ni_title" class="require" title="新闻标题不能为空！" placeholder=" " value="{$onedata['ni_title']}" >
              </p>
			  <p>
                
                <label>新闻类型:</label>
                <select class="sendmess" name="ni_type" > 
				
					{foreach $alltype as $type}
						<option value="{$type['nti_no']}"  {if $onedata['ni_type'] eq $type['nti_no']}selected{/if}>{$type['nti_name']}</option>
				   {/foreach}
					
				</select>
              </p>
              <p style="display:block;width:810px;height:610px;">
		        <span>新闻内容:</span>
		        <script type="text/plain" id="myEditor" class="isedit" style="">
                 {$onedata['ni_body']}
                </script>

               </p>
               <p>
                   <input type="hidden"  name="ni_body" value="" >
                   <input type="hidden"  name="mdino" value="{$onedata['ni_no']}" >				   
                   <input type="button" value="修改新闻" class="btn" style="margin-left:30px;">	
               </p>	  
             </form>			  
             </div>                 
        {else}
		     <div class="h_title">添加普通新闻</div> 
           
          <div id="step1">
		  <form action="/author/index/addnews" method= "post" class="form_common" id="gen_from" name="editForm">
              <p>
                 
                <label>新闻标题:</label>
                <input type="text" style="width:350px;" name="ni_title" class="require" title="新闻标题不能为空！" placeholder=" " value="" >
              </p>
			  <p>
                
                <label>新闻类型:</label>
                <select class="sendmess" name="ni_type" > 
				
					{foreach $alltype as $type}
						<option value="{$type['nti_no']}">{$type['nti_name']}</option>
				   {/foreach}
					
				</select>
              </p>
              <p style="display:block;width:810px;height:610px;">
		        <span>新闻内容:</span>
		        <script type="text/plain" id="myEditor" class="isedit" style="">
                 
                </script>

               </p>
               <p>
                   <input type="hidden"  name="nti_body" value="" >	
                   <input type="button" value="发表新闻" class="btn" style="margin-left:30px;">	
               </p>	  
             </form>			  
             </div>
		  {/if}
    </div>
{/block}

