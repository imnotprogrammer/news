      <div id="shm_right" style="min-height:1090px">
        <h3>附近商铺</h3>
        <ul>
          {if !empty($nearShops)}
          {foreach $nearShops as $nearShop}
          <li>
            <img src="{$nearShop.si_logo}">
            <h4>{$nearShop.si_name}</h4>
            <div><span>评分：</span>{scoreImg($nearShop['si_total_score'],$nearShop['si_score_count'])}</div>
          </li>
          {/foreach}
          {else}
          <li>~亲，附近没有商户额!</li>
          {/if}
        </ul>
      </div>