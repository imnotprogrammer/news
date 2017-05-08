{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-普通用户{/block}
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
          <div class="h_title">普通用户信息列表</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="" class="td-first">用户</th>
				<th style="" class="td-first">邮箱</th>
				<th style="" class="td-first">电话</th>
				<th style="">创建时间</th>
				
							
				<th >操作</th>
			</tr>
            <tbody>
                {if $info}
				{foreach $info as $need}
                <tr>
					<td class="td-first"><img class="img" src="{if {$need['ui_header']}}{$need['ui_header']}{else}/res/img/user.jpg{/if}"><br>{$need['ui_name']}</td>
					
					<td>{if empty($need['ui_email'])}未设置{else}{$need['ui_email']}{/if}</td>
                     <td>{if empty($need['ui_phone'])}未设置{else}{$need['ui_phone']}{/if}</td>
                     <td>{$need['ui_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>					 
					<td>
					    {if $need.ui_status eq 0}
					    <a class="f-size" href="javascript:void(0)" onclick="fobidauthor({$need['ui_no']},0)">解封</a>						
						{else}
						   <a class="f-size" href="javascript:void(0)" onclick="fobidauthor({$need['ui_no']},1)">封号</a>	
                         {/if}						 
					</td>
			     </tr>
                 {/foreach}
				 
                {else}
                <tr><td colspan="7">没有数据！</td></tr>
                {/if} 
            </tbody>
			

        </table>
        <div class="page">{if !empty($info)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

