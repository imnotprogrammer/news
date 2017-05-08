{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-评论列表{/block}
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
          <div class="h_title">评论列表</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="" class="td-first">新闻标题</th>
				<th>新闻评论数</th>
				<th style="">新闻类型</th>
				<th style="">创建时间</th>   			                				
				<th >操作</th>
			</tr>
            <tbody>
                {if $comment}
				{foreach $comment as $au}
                <tr>
					<td class="td-first">{$au['ni_title']}</td>
					<td>{$au['comm_count']}</td>
					<td>{$au['nti_name']}</td>
                    <td>{$au['ni_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>
					<td>
					  {if $au['comm_count'] neq 0} 
				         <a class="f-size"  href="/author/index/allcomment?title={$au['ni_title']}&no={$au['ni_no']}">查看所有评论</a>
                     {else}
                       --
                     {/if}												  	 
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

