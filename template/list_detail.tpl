<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}便民之家-新闻列表{/block}</title>
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
	<div class="container" style="min-height: 30rem;margin-top:4rem;">
      <div class="row">
        <div class="col-md-8" style=" height:885px;border:2px solid rgb(66,160,121);">
           
              <div class="list-group" style="margin-top:2rem;">
			  
                <h3 class="index_h3" style="letter-spacing:2px;font-size:16px;font-weight:bold;">{$title}</h3>
				{if $lists}
				{foreach $lists as $list}
				<a href="/news/index?type={$list['ni_if_img_text']}&no={$list['ni_no']}" class="list-group-item aa col-md-8" style="border:none;padding-left:4rem;">
                  {$list['ni_title']|htmlspecialchars}
				  
                </a><span class="aa" style="text-align:right;float:left;" class="col-md-4">{$list['ni_ctime']|date_format:"%Y-%m-%d"}</span>
				{/foreach}
				<div class="page" style="margin-top:2rem;">{$page}</div>
				{else}
                <center style="height:200px;line-height:200px;">亲，该栏目暂时还没有数据,如果是兴趣栏目，那么请在用户中心设置自己的兴趣！</center>			 
             {/if}
              </div>
			 
        </div>

             {include file="site/include/right.tpl"} 
              
        </div>
         
    </div>
	{include file="site/include/footer.tpl"}
<body>
</html>