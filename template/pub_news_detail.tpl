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
		function collect(no,type){
		   post({no:no},"/news/collect","/news/index?type="+type+"&no="+no);
		}
	</script>
	{/literal}
	<div class="container" style="min-height: 30rem;margin-top:4rem;">
      <div class="row">
        <div class="col-md-8" style="border: 2px solid rgb(66, 160, 121);">
        {if !empty($onedata)}
        <h3 class="text-center" style="margin-top:2rem; margin-bottom:3rem;">
          {$onedata['ni_title']|htmlspecialchars}
          
        </h3>
		<small class="" style="display:block;text-align:center;">时间：{$onedata['ni_ctime']|date_format:"%Y-%m-%d %H:%I:%S"}
		<a href="javascript:void(0)" onclick="agree('{$onedata['ni_no']}',{$onedata['ni_if_img_text']})" style="padding-left:30px;">赞(<b>{$onedata['ni_count']}</b>)</a>
		<a href="javascript:void(0)" onclick="collect('{$onedata['ni_no']}',{$onedata['ni_if_img_text']})" style="padding-left:30px;">收藏</a>
		<span style="padding-left:30px;">浏览:{$onedata['ni_browser']}次</span>
		</small><br>
        {/if}
        {$onedata['ni_body']}
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
	{include file="site/include/footer.tpl"}
<body>
</html>