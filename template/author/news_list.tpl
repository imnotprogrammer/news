{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-新闻列表{/block}
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
</style>
    {include file="author/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">新闻列表</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="" class="td-first">新闻标题</th>
				<th>新闻类型</th>
				<th style="">新闻格式</th>
				
				<th style="">创建时间</th>
   				
                <th>新闻状态</th>				
				<th >操作</th>
			</tr>
            <tbody>
                {if $news}
				{foreach $news as $au}
                <tr>
					<td class="td-first">{$au['ni_title']}</td>
					<td>{$au['nti_name']}</td>
					<td>{if $au['ni_if_img_text'] eq 0}普通新闻{else}图片新闻{/if}</td>
                    <td>{$au['ni_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>
                    <td>{if $au['ni_status'] eq 0}未处理{elseif $au['ni_status'] eq 1}未通过审核{else}通过审核{/if}</td>					
					<td>
					    {if $au['ni_status'] eq 1}
                           <a class="f-size" href="{if $au['ni_if_img_text'] eq 0}/author/index/addnews?no={$au['ni_no']}{else}/author/index/addpicnews?no={$au['ni_no']}{/if}">修改</a>
                         {/if}						   
						   <a class="f-size"  href="/author/index/newsdetail?no={$au['ni_no']}&type={$au['ni_if_img_text']}">查看</a>												  	 
					</td>
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

