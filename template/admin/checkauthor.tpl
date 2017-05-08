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
          <div class="h_title">记者申请审核表</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="width:20%" class="td-first">申请人</th>
				<th style="width:25%">申请理由</th>
				
				<th style="width:15%">创建时间</th>	
                <th>处理备注</th>				
				<th >操作</th>
			</tr>
            <tbody>
                {if $authr}
				{foreach $authr as $au}
                <tr>
					<td class="td-first"><img class="img" src="{$au['ui_header']}" ><br>{$au['ui_name']}</td>
					<td>{$au['aai_body']}</td>
					<td>{$au['aai_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>
                    <td>{if $au['aai_desc']}{$au['aai_desc']}{else}--{/if}</td>					
					<td>
					    {if $au['aai_status'] eq 0}
                           <a class="f-size" href="javascript:void(0)" onclick="author({$au['ui_no']},2,{$au['aai_no']})">同意</a>	
						   <a class="f-size" href="javascript:void(0)" onclick="author({$au['ui_no']},1,{$au['aai_no']})">拒绝</a>						
						   
						   {else}
                            已处理						   
                         {/if}
						 
					</td>
			     </tr>
                 {/foreach}
                 {else}
                <tr><td colspan="7">没有数据！</td></tr>
                {/if} 
            </tbody>
        </table>
        <div class="page">{if !empty($authr)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

