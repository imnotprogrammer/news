{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-我的评论{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
    <div class="user_title clearfix">
        <ul class="user_tab1">
            <li class="curr" style="border-bottom-color:rgb(66, 160, 121);">
                <a href="javascript:void(0);">我的评论</a>
            </li>
        </ul>
    </div>
    <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
        <table class="table-list">
            <tr>
				<th style="width:20%" class="td-first">新闻主题</th>
				<th style="width:25%">新闻作者</th>
				<th style="width:30%">评论内容</th>
				<th style="width:15%">评论时间</th>
				
				<th >操作</th>
			</tr>
            <tbody>
                {if !empty($comment)}
                {foreach $comment as $comm}
                <tr>
					<td class="td-first">{$comm.ni_title}</td>
					<td>{$comm.ui_name}</td>
					<td>{$comm.ci_body|htmlspecialchars}</td>
					<td>{$comm.ci_ctime|date_format:"%Y-%m-%d %H:%I:%S"}</td>
                   
					
					<td>
                        <a href="javascript:void(0)" onclick="delcomment('{$comm.ci_no}')">删除</a>
					</td>
			     </tr>
                 {/foreach}
                 {else}
                 <tr><td colspan="7">没有数据！</td></tr>
                 {/if}
            </tbody>
        </table>
        <div class="page">{if !empty($withdraws)}{$page}{/if}</div>
    </div>
	      <script type="text/javascript">
      {literal}
      function delcomment(gno){
         if( confirm('是否删除此条评论？') ){
            $.post('/user/personal/comment',{dno:gno},function(data){
                data = $.parseJSON(data);
                if(data.result_code == 200 ){
                   layer.msg(data.result_desc);
				   window.location.reload();
                }
            });
         }   
      }
      {/literal}
      </script>
</div>
{/block}