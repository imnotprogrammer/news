{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-找回密码{/block}
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
          <div class="h_title">找回密码</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
			    <th>用户头像</th>
				<th style="" class="td-first">用户昵称</th>
								
				<th style="">申请时间</th>				
				<th >操作</th>
			</tr>
            <tbody>
                {if $findpass}
				{foreach $findpass as $need}
                <tr>
					<td class="td-first">{$need['ui_name']}</td>
					<td><img class="img" src="{$need['ui_header']}"></td>
					<td>{$need['afi_ctime']}</td>			
					<td>
					    {if $need.afi_status eq 0}
					    <a class="f-size" href="javascript:void(0)" onclick="findpass({$need['ui_no']})">重置密码</a>						
                        
						{else}
						   用户密码已重置
                         {/if}
						 
					</td>
			     </tr>
                 {/foreach}
                 {else}
                <tr><td colspan="7">没有数据！</td></tr>
                {/if} 
            </tbody>
        </table>
        <div class="page">{if !empty($findpass)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

