{extends file="admin/layout/admin.tpl"}
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
    {include file="admin/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">评论列表</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
			    <th>用户头像</th>
				<th style="" class="td-first">用户昵称</th>
								
				<th style="">评论新闻标题</th>
                <th>评论内容</th>				
				<th>创建时间</th>
			</tr>
            <tbody>
                {if $comment}
				{foreach $comment as $need}
                <tr>					
					<td><img class="img" src="{$need['ui_header']}"></td>
					<td class="td-first">{$need['ui_name']}</td>
					<td>{$need['ni_title']}</td>
                    <td>{$need['ci_body']|htmlspecialchars}</td>	
                    <td>{$need['ci_ctime']}</td>														
			     </tr>
                 {/foreach}
                 {else}
                <tr><td colspan="7">没有数据！</td></tr>
                {/if} 
            </tbody>
        </table>
        <div class="page">{if !empty($comment)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

