{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-评论详情{/block}
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
	.news_title{
	margin-top:2rem;
	    text-align:center;
		
	}
	.news_title span{
       color:rgb(66,160,121);
	}
</style>
    {include file="author/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">评论详情</div> 
		  <div class="news_title">评论新闻主题:<span>{$title}</span></div>
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
		    
            <tr>
				<th style="" class="td-first">评论者头像</th>
				<th>评论者</th>
				<th style="">评论内容</th>
				<th style="">创建时间</th>   			                				
				
			</tr>
            <tbody>
                {if $comment}
				{foreach $comment as $au}
                <tr>
					<td class="td-first"><img src="{$au['ui_header']}" style="width:64px;height:64px;border-radius:50%;"></td>
					<td>{$au['ui_name']}</td>
					<td>{$au['ci_body']|htmlspecialchars}</td>
                    <td>{$au['ci_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>
					
			     </tr>
                 {/foreach}
                 {else}
                <tr><td colspan="7">没有数据！</td></tr>
                {/if} 
            </tbody>
        </table>
        <div class="page">{if !empty($news)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

