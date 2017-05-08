{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-我的收藏{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
	<div class="user_title clearfix">
        <ul class="user_tab1">
            <li class="curr" style="border-bottom-color:rgb(66, 160, 121);">
                <a href="javascript:void(0);">我的收藏</a>
            </li>
        </ul>
    </div>
        <div class="shoper_list" style="margin-top:20px;border:1px solid rgb(66, 160, 121);">
          
           <table class="table-list">
            <tr>
				<th style="" class="td-first">新闻主题</th>
			
				<th style="">收藏时间</th>
				
				<th >操作</th>
			</tr>
            <tbody>
                
                {foreach $collect as $comm}
                <tr>
					<td class="td-first"><a href="/site/news/detail?nno={$comm.ni_no}" style="color:rgb(66, 160, 121);">{$comm.ni_title}</a></td>
					<td>{$comm.cni_ctime|date_format:"%Y-%m-%d %H:%I:%S"}</td>
					
                   
					
					<td>
                        <a href="javascript:void(0)" onclick="delCollectGoods('{$comm.cni_no}')" style="color:rgb(66, 160, 121);">删除</a>
					</td>
			     </tr>
                 {/foreach}
        </div>
      </div>
      <script type="text/javascript">
      {literal}
      function delCollectGoods(gno){
         if( confirm('是否删除收藏的新闻？') ){
            $.post('/user/personal/delcollect',{dno:gno},function(data){
                data = $.parseJSON(data);
                if(data.result_code == 200 ){
                   layer.msg(data.result_desc);
				   //window.location.reload();
                }
            });
         }   
      }
      {/literal}
      </script>
{/block}