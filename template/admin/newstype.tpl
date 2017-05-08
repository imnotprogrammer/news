{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-新闻类型{/block}
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
	.addtype{
	width:100px;
	   height:30px;
	   margin-left:700px;
	   margin-top:5px;  
	}
	.addtype .addtypea{
	width:100px;
	   height:30px;
	   font-size:14px;
	   background:rgb(66,160,121);
	   color:white;
	   display:inline-block;
	   
	   text-align:center;
	   line-height:30px;
	   border-radius:4px;
	   text-decoration:none;
	}
</style>
    {include file="admin/include/center.tpl"}
    <div id="m_right">
          <div class="h_title">记者信息列表</div> 
		  <div class="addtype"><a class="addtypea" href="/admin/index/addtype">添加类型</a></div>
             <div class="bm-list" style="width:80%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="" class="td-first">新闻类型</th>
				<th style="">创建时间</th>
				
						
				<th >操作</th>
			</tr>
            <tbody>
                {if $type}
				{foreach $type as $need}
                <tr>
					<td style="padding-left:30px;">{$need['nti_name']}</td>
					<td>{$need['nti_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}</td>
					
                    				
					<td>
					<a href="javascript:void(0)" class="f-size" onclick="del({$need['nti_no']})">删除</a>
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

