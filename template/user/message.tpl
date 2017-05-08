{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-我的消息{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
	<div style="margin:20px auto; width:auto;height:auto;">
        <div id="uploader-demo">
    <!--用来存放item-->
          <div id="fileList" class="uploader-list"></div>
          <div id="filePicker">选择图片</div>
        </div>


      
    </div>
      <script type="text/javascript">
      {literal}
      function hasRead(mno){
	  alert(1111);
        $.post('/user/personal/message',{"umno":mno},function(data){
            data=$.parseJSON(data);
            if(data.result_code==200){
                window.location.reload();
            }
        });
      }
      {/literal}
      </script>
{/block}