{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-留言信息{/block}
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
          <div class="h_title">留言信息</div> 
             <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
			    <th>用户头像</th>
				<th style="" class="td-first">用户昵称</th>
								
				<th style="">留言信息</th>
                <th style="">回复信息</th>				
				<th>创建时间</th>
				<th>操作</th>
			</tr>
            <tbody>
                {if $note}
				{foreach $note as $need}
                <tr>					
					<td><img class="img" src="{$need['ui_header']}"></td>
					<td class="td-first">{$need['ui_name']}</td>
					<td>{$need['n_body']}</td>
                    <td>{if $need['n_reply']}{$need['n_reply']}{else}--{/if}</td>	
                    <td>{$need['n_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>	
                     <td>
					   {if $need['n_status'] eq 0}
					       <a href="javascript:void(0)" class="f-size" onclick="replynote({$need['n_no']})" >回复</a>
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
        <div class="page">{if !empty($note)}{$page}{/if}</div>
    </div>				 
    </div>
{/block}

