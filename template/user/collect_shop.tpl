{extends file="user/layout/usercenter.tpl"}
{block name="title"}便民之家-收藏商铺{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
        <div class="shoper_list">
          {foreach $collectShops as $collectShop}
          <div>
            <ul>
              <li>
                <img src="{$collectShop.si_logo}">
              </li>
              <li>
                {for $i=0;$i<calScore($collectShop.si_total_score,$collectShop.si_average_consum);$i++}
                <img src="/res/img/yellow_star.png">
                {/for}
              </li>
              <li>{$collectShop.si_name}</li>
            </ul>
            <a href="javascript:void(0);"><img src="/res/img/del.png" onclick="delCollectShop({$collectShop.si_no})"></a>
          </div>
          {/foreach}
          
        </div>
      </div>
      <script type="text/javascript">
      {literal}
      function delCollectShop(sno){
         if( confirm('是否删除收藏的商铺？') ){
            $.post('/collect/delcollectshop',{sno:sno},function(data){
                data = $.parseJSON(data);
                if(data.result_code == 200 ){
                    window.location.reload();
                }
            });
         }   
      }
      {/literal}
      </script>
{/block}