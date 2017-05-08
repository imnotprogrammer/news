{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-我的消息{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
	    <div style="margin-top:10px;margin-left:10px;">
	       <h2 style="width:120px;height:40px;font-size:14px;border-radius:4px;color:white;background-color:rgb(66, 160, 121);text-align:center;line-height:40px;">我的消息</h2>
		</div>
        {if !empty($messages)}
        <div id="message_list">
         
         {foreach $messages as $message}
          <div class="{if $message.umi_status==0}no_read{else}yes_read{/if}" style="position:relative">
            {if $message.umi_status==0}
            <span onclick="hasRead({$message.umi_no})" style="position:absolute;right:20px;line-height:20px;cursor:pointer">设为已读</span>
            {else}
            <span style="position:absolute;right:20px;line-height:20px">已读</span>
            {/if}
            <ul>
              <li>{$message.umi_title}</li>
              <li>{$message.umi_body}</li>
              <li>
                <span>发件人：</span><em>官</em>新闻之家
                发送时间：</span>{$message.umi_ctime|date_format:"%Y-%m-%d %H:%I:%S"}</li>
            </ul>
          </div>
          {/foreach}
		  
        </div>
        <div class="page">{$page}</div>
      {else}
      <div id="job_tip">
          还没有任何消息供您阅读
      </div>
      {/if}
      </div>
      <script type="text/javascript">
      {literal}
      function hasRead(mno){
        $.post('/user/personal/message',{"mno":mno},function(data){
            data=$.parseJSON(data);
            if(data.result_code==200){
                window.location.reload();
            }
        });
      }
      {/literal}
      </script>
{/block}