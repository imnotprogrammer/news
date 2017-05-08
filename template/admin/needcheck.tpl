{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-未审核新闻{/block}
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
    {include file="admin/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">未审核新闻列表</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="" class="">新闻主题</th>
				<th style="">新闻作者</th>
				
				<th style="">创建时间</th>	
                 				
				<th >操作</th>
			</tr>
            <tbody>
                {if $needcheck}
				{foreach $needcheck as $need}
                <tr>
					<td class="td-first">{$need['ni_title']|htmlspecialchars|truncate:25:'...'}</td>
					<td><img class="img" src="{$need['ui_header']}"><br>{$need['ui_name']|htmlspecialchars}</td>
					<td>{$need['ni_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>			
					<td>
					    {if $need.ni_status eq 0}
					    <a class="f-size" href="/admin/index/newsdetail?no={$need['ni_no']}&type={$need['ni_if_img_text']}">查看</a>						
                        <a class="f-size" href="javascript:void(0)" onclick="news('{$need['ni_no']}',2)">发布</a>
                        <a class="f-size" href="javascript:void(0)" onclick="news('{$need['ni_no']}',1)">退回</a>
						{else}
						   <a class="f-size" href="/admin/index/newsdetail?no={$need['ni_no']}&type={$need['ni_if_img_text']}">查看</a>	
                         {/if}
						 
					</td>
			     </tr>
                 {/foreach}
                 {else}
                <tr><td colspan="7">没有数据！</td></tr>
                {/if} 
            </tbody>
        </table>
        <div class="page">{if !empty($needcheck)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

