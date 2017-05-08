{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-排行榜{/block}
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
          <div class="h_title">新闻浏览排行榜</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
			    <th class="td-first">排名</th>
				<th style="" >新闻标题</th>
				<th>新闻赞数</th>
				<th style="">浏览次数</th>
				
				<th style="">创建时间</th>   			                				
				
			</tr>
            <tbody>
                {if $news}
				{foreach from=$news key=k item=i}
                <tr>
					<td class="td-first">{$k+1}</td>
					<td>{$i['ni_title']}</td>
					<td>{$i['ni_count']}</td>
                    <td>{$i['ni_browser']}</td>
					<td>{$i['ni_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>
					
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

