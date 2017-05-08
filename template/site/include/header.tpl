 <div class="container">
	 <div class="row " style="">
	   <div class="col-md-8" style="padding-top:2rem;">
	     <a href="/"><img src="/res/img/logo.JPG"></a>
	   </div>
	   <div class="col-md-4" style="height:40px;">
	       <ul class="login_reg">
		   <li><a href="/">首页</a></li>
		   <li class="spec"><a>|</a></li>
		      {if !empty($smarty.session.news.uno) and isset($smarty.session.news.uno)}
			     <li><span style="color:black;">你好，</span><a style="text-decoration:none;">{$smarty.session.news.uname}</a></li><li class="spec">
				 <a>|</a></li>
				 {if $smarty.session.news.utype eq 1}
				   <li><a href="/user/index/index">用户中心</a></li>
				  {elseif $smarty.session.news.utype eq 2}
				     <li><a href="/author/index/index">记者中心</a></li>
					{elseif $smarty.session.news.utype eq 3}
					   <li><a href="/admin/index/index">后台管理</a></li>
				 {/if}
				 <li class="spec"><a>|</a></li>
				 <li><a href="/index/loginout">退出</a></li>
			  {else}
		      <li><a href="/index/login">登录</a></li>
			  <li class="spec"><a>|</a></li>
			  <li><a href="/index/reguser">注册</a></li>
			  {/if}
		   </ul>
	   </div>
	 </div>
	 </div>
    <div class="container"style="margin-top:2rem;">

      <!-- Static navbar -->
      <nav class="navbar navbar-default" style='background:rgb(66, 160, 121);'>
        <div class="container">
          
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav col-md-8">
			
              <li {if empty($smarty.get.type)}class="active"{/if}><a href="/" >主页</a></li>
              {foreach $alltype as $type}
              <li {if !empty($smarty.get.type) and $smarty.get.type eq $type['nti_no']} class="active"{/if}><a href="/news/newslist?type={$type['nti_no']}">{$type['nti_name']}</a></li>
			  {/foreach}
			  
			  {if !empty($smarty.session.news.uno)}
				  <li {if !empty($smarty.get.type) and $smarty.get.type eq 100} class="active"{/if}><a href="/news/newslist?type=100" >兴趣</a></li>
			  {/if}
            </ul>
			<ul class=" nav navbar-nav col-md-4">
			     <li class="special-li" style="width:320px;height:40px;">

				<form method="get" action="/index/search">
			         <input class="searchkey" style="border:1px solid rgb(66, 160, 121);width:200px;height:30px;"type="text" name="key" value="{if !empty($smarty.get.key)}{$smarty.get.key}{/if}" >
					 <button class="search" type="submit" style="height:30px;width:60px;border-radius:4px;border:none;background:white;color:rgb(66, 160, 121);"> 搜索</button>
			    </form>
				
			  </li>
			</ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
    </div>