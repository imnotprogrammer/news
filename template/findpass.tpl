<!DOCTYPE html>
<html lang="zh-CN">
  <head class="set_page">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{block name="title"}便民之家-找回密码{/block}</title>
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
   <script src="/res/js/form.js"></script>	
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
	<style>
	    .form_common input{
		   
			
		}
	</style>
	<div class="container" style="min-height: 30rem;margin-top:4rem;">
      <div class="row">
        <div class="col-md-8" style=" height:440px;border:2px solid rgb(66,160,121);">
           
              
			  
                <h3 class="index_h3" style="letter-spacing:2px;font-size:16px;font-weight:bold;">找回密码</h3>
				<form method="post" action="/index/findpass" class="form_common" id="gen_from" name="editForm">
				    <p>
					    <label>邮箱:</label>
					    <input type="text" name="email"  style="width:180px;height:30px;border-radius:4px; border:1px solid gray;">
						<label style="color:red;font-size:12px;height:30px;width:200px;">请保证自己填写的邮箱正确，</label>
					</p>
					<p>
					    <label>秘钥:</label>
					    <input type="password" name="key"  style="width:180px;height:30px;border-radius:4px; border:1px solid gray;">
					</p>
					<p>  
                        <label>&nbsp;</label>					
					    <input type="button" value="找回密码" style="width:100px;height:30px;line-height:20px;" class="btn">
				    </p>
				</form>
              
			 
        </div>

           {include file="site/include/right.tpl"}    
              
        </div>
         
    </div>
	<div class="row bottom_row" >
	     <div class="col-md-6">
		    
		 </div>
		 <div class="col-md-6">
		    
		 </div>
	  </div>
<body>
</html>