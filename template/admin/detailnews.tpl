{extends file="admin/layout/admin.tpl"}
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
    {include file="admin/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">新闻详情</div> 
           {if $smarty.get.type eq 0}
          <div id="step1">
		  <form action="/admin/other/sendmess" method= "post" class="form_common" id="gen_from" name="editForm">
              <p>
                 
                <label>新闻标题:</label>
                <input style="width:400px; type="text" name="umi_title" placeholder=" " value=" {$news['ni_title']}" readonly>
              </p>
			  <p>
                
                <label>新闻类型:</label>
                <select class="sendmess" name="type" readonly> 
				
					
						<option value="{$news['ni_type']}" selected readonly>{$type}</option>
				   
					
				</select>
              </p>	
             </form>			  
             </div>                 
          <div style="margin:0px auto;width:800px;height:400px;">
		  <label style="font-size:14px;color:gray;height:30px;line-height:30px;">新闻内容：</label>
		    <script type="text/plain" id="myEditor" style="width:1000px;height:240px;">
                {$news['ni_body']}
          </script>
		  </div>
		  {else}
		      <form action="/admin/other/sendmess" method= "post" class="form_common" id="gen_from" name="editForm">
              <p>
                 
                <label>新闻标题:</label>
                <input style="width:400px;" type="text" name="umi_title" placeholder=" " value=" {$news['ni_title']}" readonly>
              </p>
			  <p>
                
                <label>新闻类型:</label>
                <select class="sendmess" name="type" readonly> 
				
					
						<option value="{$news['ni_type']}" selected readonly>{$type}</option>
				   
					
				</select>
              </p>
               <p>
			      <div id="myCarousel" class="carousel slide col-md-11" style=" margin-left:2rem;height:400px;">
			   <!-- 轮播（Carousel）指标 -->
			     
			   <!-- 轮播（Carousel）项目 -->
			   <div class="carousel-inner" role="listbox" style="height:400px;">
			      {foreach from=$picnews key=k item=pic}
				  <div class="item {if $k eq 0}active{/if}">
					
					     <img src="{$pic['pic']}" style="height:400px;width:100%" alt="First slide">
					     <div class="carousel-caption bottom">{$pic['desc']}</div>
					 
				  </div>
				  {/foreach}
				  
			   </div>
			   <!-- 轮播（Carousel）导航 -->
			   <a class="carousel-control left" href="#myCarousel" data-slide="prev">
				  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				  <span class="sr-only">Previous</span>
				  
			   </a>
			   <a class="carousel-control right" href="#myCarousel" data-slide="next">

				  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				  <span class="sr-only">Next</span>
			  </a> 
			</div> 
               </p>			   
             </form>
		  {/if}
    </div>
{/block}

