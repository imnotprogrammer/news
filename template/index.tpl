
<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}新闻之家-主页{/block}</title>
    <link rel="stylesheet" href="/res/css/admin.css" />
    <link rel="stylesheet" href="/res/css/common.css" /> 
    <link rel="stylesheet" href="/res/css/shoper_home.css" /> 
	<link rel="stylesheet"  href="/res/css/webuploader.css" />
	<link rel="stylesheet"  href="/res/css/dialog.css" />
	<link rel="stylesheet"  href="/res/css/index.css" />
	<link rel="stylesheet"  href="/res/css/bootstrap.css" />
	<link href="/umeditor/themes/default/css/umeditor.css" rel="stylesheet">
	
    <script src="/res/js/jquery.min.js"></script>
	<script src="/res/js/bootstrap.js"></script>

	
    <script src="/umeditor/umeditor.config.js"></script>
    <script src="/umeditor/umeditor.min.js"></script>
    <script src="/umeditor/lang/zh-cn/zh-cn.js"></script>
	<script src="/res/js/layer/layer.js"></script>  
	<script src="/res/js/common.js"></script>
    <script src="/res/js/site.js"></script>
	<script src="/res/js/dialog.js"></script>
	
  </head>
  <body>

    {include file="site/include/header.tpl"}
	<script>
	    $(function(){
		    $('.carousel').carousel();
		})
	</script>
	<div class="container">
	  <div class='row' style=" margin-top:2rem;border-top:2px solid rgb(66,160,121);">
	     <div class="col-md-7" style="margin-top:2rem;">
		    <h3 style="font-size:14px;">图片新闻</h3>
		   	<div id="myCarousel" class="carousel slide">
			   <!-- 轮播（Carousel）指标 -->
			   <ol class="carousel-indicators">
			   {foreach from=$picnews key=k item=i}
				  <li data-target="#myCarousel" data-slide-to="{$k}" {if $k eq 0}class="active"{/if}></li>
				  
			   {/foreach}
			   </ol>   
			   <!-- 轮播（Carousel）项目 -->
			   <div class="carousel-inner" role="listbox">
			      {foreach from=$picnews key=k item=pic}
				  <div class="item {if $k eq 0}active{/if}">
					 <a href="/news/index?type=1&no={$pic['ni_no']}">
					     <img src="{$pic['ni_img']}" style="height:300px;width:100%" alt="First slide">
					     <div class="carousel-caption bottom">{$pic['ni_title']|htmlspecialchars}</div>
					 </a>
				  </div>
				  {/foreach}
				  
			   </div>
			   <!-- 轮播（Carousel）导航 -->
			   <a class="carousel-control left" href="#myCarousel" data-slide="prev">
				  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				  <span class="sr-only">Previous</span>
				  
			   </a>
			   <a class="carousel-control right" href="#myCarousel" data-slide="next">

				  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				  <span class="sr-only">Next</span>
			  </a> 
			</div> 		 
		 </div>
		 
		 <div class="col-md-5" style="margin-top:0px;">
	        <div class="span12" style=" ">
				  <div class="tabbable" id="tabs-659969">
					 <ul class="nav nav-tabs">
						<li class="active">
						  <a href="#hot" data-toggle="tab">热点新闻</a>
						</li>
						<li>
						  <a href="#new" data-toggle="tab">最新新闻</a>
						</li>
					</ul>
				  <div class="tab-content">
					<div class="tab-pane active" id="hot">
					   <ul class="index_ul">
					   {foreach $right['hot']['list'] as $list}
					     <li><a href="/news/index?type={$list['ni_if_img_text']}&no={$list['ni_no']}">{$list['ni_title']|htmlspecialchars}</a></li>
					 {/foreach}
					   </ul>
					</div>
                    <div class="tab-pane" id="new">
					
						<ul class="index_ul">
					     {foreach $right['news']['list'] as $list}
					     <li><a href="/news/index?type={$list['ni_if_img_text']}&no={$list['ni_no']}">{$list['ni_title']|htmlspecialchars}</a></li>
					 {/foreach}

						</ul>
					
					</div>
				   </div>
				   </div>
	          </div>         
		 </div>
	  </div>
	  <!--新闻主题内容-->
	  <div class="row" style="margin-top:2rem;border-top:2px solid rgb(66,160,121);border-radius:4px;">
	      {foreach $news as $new}
	      <div class="col-md-4" style="margin-top:4rem;border:none;height:40rem;border-bottom:2px solid rgb(66,160,121);">
			  <h3 href="" class="index_h3" style="color:rgb(66,160,121);margin-top:0rem; font-weight:bold;letter-spacing:2px;">
                 {$new['name']}新闻
                <a href="/news/newslist?type={$new['type']}" style="color:rgb(66,160,199);">    更多...</a></h3>
              <div class="" style="margin-top:2rem;">
                {if $new['list']}
			    {foreach $new['list'] as $list}
				<a href="/news/index?type={$list['ni_if_img_text']}&no={$list['ni_no']}" class="list-group-item " style="padding-top:0px;border:none;height:40px;line-height:40px;">
                {$list['ni_title']|htmlspecialchars}
                </a>
				{/foreach}
				{else}
				该栏目暂时还没有数据！
				{/if}
              </div>
			
            </div>
			{/foreach}
	  </div>
	</div>
	{include file="site/include/footer.tpl"}
  </body>
  </html>