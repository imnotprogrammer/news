{extends file="user/layout/usercenter.tpl"}
{block name="title"}新闻之家-我的兴趣{/block}
{block name="main"}
    {include file="user/include/left.tpl"}
    <div id="m_right">
    <div class="user_title clearfix">
        <div id="step_form">
           <ul>
            <li class="cur"><img src="">我的兴趣</li>          
           </ul>
        </div>
    </div>


     <div class="myfavo addclass">
	  <h2>新闻类别</h2>
		 <ul class="ul_class">
		 {if $class}
		     {foreach $class as $c}
			 {if $c['state'] eq 0}
              <li class="cur" title="{$c.nti_no}" onclick="changetype({$c.nti_no})">{$c.nti_name}</li>
              {else if $c['state'] eq 1}
			    <li class="checkfavo" title="{$c.nti_no}" onclick="changetype({$c.nti_no})">{$c.nti_name}</li>
              {/if}			  
             {/foreach}	
			 {else}
			  <li class="novalue">你的兴趣很多，棒棒哒！</li>
        {/if}			 
         </ul>
     </div>
     <div class="type_button" style="margin-right:2rem;"><button class="save_button">保存</button></div>	 
    </div>
	      <script type="text/javascript">
      {literal}
          function newclass(obj){
		     obj.className="checkfavo";
		  }
      
      {/literal}
      </script>
</div>
{/block}