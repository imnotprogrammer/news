<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}便民之家-新闻详情{/block}</title>
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
	{literal}
	<script>
	    var agreecount = 0;
		function agree(no,type){
		   if(agreecount ==0){
		      post({no:no},"/news/agree","/news/index?type="+type+"&no="+no);
		   }
		}
	</script>
	{/literal}
	<div class="container" style="margin-top:4rem;min-height: 30rem;">
      <div class="row">
        <div class="col-md-8" style="border: 2px solid rgb(66,160,121);">
		<div style="height:500px;">
		<h3 style="font-size:14px;">{$onedata['ni_title']|htmlspecialchars}<a href="javascript:void(0)"></a><span></span></h3>
          <small class="" style="display:block;text-align:center;">时间：{$onedata['ni_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}
		<a href="javascript:void(0)" onclick="agree('{$onedata['ni_no']}',{$onedata['ni_if_img_text']})" style="padding-left:30px;">赞(<b>{$onedata['ni_count']}</b>)</a><span style="padding-left:30px;">浏览:{$onedata['ni_browser']}次</span>
		</small><br>       
	   <div id="myCarousel" class="carousel slide col-md-11" style=" margin-left:2rem;height:400px;">
			   <!-- 轮播（Carousel）指标 -->
			     
			   <!-- 轮播（Carousel）项目 -->
			   <div class="carousel-inner" role="listbox" style="height:400px;">
			      {foreach from=$picnews key=k item=pic}
				  <div class="item {if $k eq 0}active{/if}">
					
					     <img src="{$pic['pic']}" style="height:400px;width:100%" alt="First slide">
					     <div class="carousel-caption bottom">{$pic['desc']}</div>
					 
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
			<div class="comment_area" style="border-top:2px solid rgb(66, 160, 121);margin-top:4rem;">
		           <h3 style="font-size:14px;">新闻评论</h3>
				   <textarea class="comment col-md-12" style="height:120px;border:1px solid rgb(66, 160, 121);border-radius:4px;"></textarea>
				   <input type="hidden" value="{$onedata['ni_no']}" class="hidno">
				   <button class="comment_btn">发表评论</button>
				   {if $comment}
				   {foreach $comment as $comm}
				   <div class="" style="height:140px;border-top:2px solid rgb(66, 160, 121);margin-top:1rem;">
				   
				      <span style="display:block;margin-top:1rem;color:rgb(66, 160, 121);;"><img src="{$comm['ui_header']}" style="width:64px;height:64px; border-radius:50%;margin-right:2rem;">{$comm['ui_name']}<b style="padding-left:25rem;font-weight:normal;">评论时间:{$comm['ci_ctime']|date_format:"%Y-%m-%d"}</b></span>
					  <p style="padding-top:2rem;text-indent:2rem;">{$comm['ci_body']|htmlspecialchars}</p>
					  
					  
				   </div>
				   {/foreach}
					  
					<div class="view_btn"><a href="javascript:void(0)" onclick="getMore({$page})" class="morecomment">查看更多评论...</a></div>
					{else}
					  <div class="" style="height:100px;text-align:center;margin-top:2rem;border-top:1px solid rgb(66, 160, 121)">
				            <p style="padding-top:2rem;">还没有评论额，亲，快来抢沙发!				      					 				  
				     </div>
					{/if}
		    </div>
        </div>
            {include file="site/include/right.tpl"}
          
      
        </div>
      
    </div>
	{include file="site/include/footer.tpl"}
<body>
</html>