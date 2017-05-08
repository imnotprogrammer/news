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
			  
                <h3 class="index_h3" style="letter-spacing:2px;font-size:16px;font-weight:bold;">留言我们</h3>
				<form method="post" action="/index/note" id="gen_from">
				    <textarea class="require" title="留言内容不能为空" placeholder="留言内容" name="note" style="width:600px;height:200px;border:1px solid rgb(66,160,121);border-radius:4px;"></textarea>
					<input type="button" class="btn" value="留言" style="width:100px;height:30px;background:rgb(66,160,121);color:white;">
				</form>
              </div>
			 
        </div>

             {include file="site/include/right.tpl"}
              
        </div>
         
    </div>
	{include file="site/include/footer.tpl"}
<body>
</html>