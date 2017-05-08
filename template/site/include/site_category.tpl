<div id="ih_left">
      <h1>全部分类</h1>
      <div id="c_list" style="{if currentActionIn(['/index/index'])}{else}display: none;{/if}">
        {foreach ClassInfo::getCacheMenus() as $class}
        <div>
          <h5><a href="#">{$class.sc_name}</a></h5>
          <ul>
            {foreach $class.secondClass as $secondClass}
            <li><a href="#">{$secondClass['sc_name']}</a></li>
            {/foreach}
          </ul>
        </div>
        {/foreach}
      
      </div>
</div>