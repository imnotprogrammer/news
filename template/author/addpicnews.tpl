{extends file="author/layout/author.tpl"}
{block name="title"}新闻之家-添加图片新闻{/block}
{block name="main"}
    {include file="author/include/center.tpl"}
    <div id="m_right">
    <div class="user_title clearfix">
        <ul class="user_tab1">
            <li class="curr" style="border-bottom-color:rgb(66, 160, 121);">
                <a href="javascript:void(0);">添加图片新闻</a>
            </li>
        </ul>
    </div>
	<style>
	   .ni_title{
	      height:40px;
		  width:300px;
		
			border:1px solid rgb(66,160,121);
	   }
	  .ni_type{
	     width:50px;
		 height:30px;
	  }
	</style>
    <div class="bm-list" style="width:90%;margin:20px auto;border:1px solid rgb(66, 160, 121);border-radius:2px;">
            {if empty($smarty.get.no)}
			<div style="width:300px;height:40px;margin-top:2rem;margin-left:2rem;">
			    <input type="text" name="ni_title" class="ni_title" placeholder="新闻标题">
			 </div>
			 <div style="width:80px;height:30px;margin-top:2rem;margin-left:2rem;">
			    <select name="ni_type" class="ni_type" style="width:80px;height:30px"> 
				
					{foreach $alltype as $type}
						<option style="width:50px;height:20px" value="{$type['nti_no']}">{$type['nti_name']}</option>
				   {/foreach}
					
				</select>
			 </div>
			 <div style="width:400px;height:150px;margin-top:2rem;margin-left:2rem;">
			    <textarea class="desc" style="width:400px;height:150px;" placeholder="此处填写图片新闻备注，最好一张图片对应一行文字！结尾以句号分割"></textarea>
			 </div>
			<div id="wrapper" style="margin-top:2rem;">
              <div id="container">
            <!--头部，相册选择和格式选择-->
             
				<div id="uploader">
					<div class="queueList">
						<div id="dndArea" class="placeholder">
							<div id="filePicker"></div>
							<p>或将照片拖到这里，单次最多可选300张</p>
						</div>
					</div>
					<div class="statusBar" style="display:none;">
						<div class="progress">
							<span class="text">0%</span>
							<span class="percentage"></span>
						</div><div class="info"></div>
						<div class="btns">
							<div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
						</div>
					</div>
				</div>
             </div>
          </div>
		  <div><button type="submit" class="addpic_btn" style="width:100px;height:40px;color:white;background:rgb(66,160,121);border:none;border-radius:4px;margin-left:2rem;margin-bottom:2rem;">添加新闻</button></div>
          {else}
	        
<div style="width:300px;height:40px;margin-top:2rem;margin-left:2rem;">
			    <input type="text" name="ni_title" class="ni_title" placeholder="新闻标题" value="{$onedata['ni_title']}">
			 </div>
			 <div style="width:80px;height:30px;margin-top:2rem;margin-left:2rem;">
			    <select name="ni_type" class="ni_type" style="width:80px;height:30px"> 
				
					{foreach $alltype as $type}
						<option style="width:50px;height:20px" value="{$type['nti_no']}" {if $onedata['ni_type'] eq $type['nti_no']}selected{/if}>{$type['nti_name']}</option>
				   {/foreach}
					
				</select>
			 </div>
			 <div style="width:400px;height:150px;margin-top:2rem;margin-left:2rem;">
			    <textarea class="desc" style="width:400px;height:150px;" placeholder="此处填写图片新闻备注，最好一张图片对应一行文字！结尾以句号分割">{$onedata['ni_body']}</textarea>
			 </div>
			 <div style="width:100%;margin-top:2rem;margin-left:2rem;">
			      <ul style="width:100%;display:block;">
				  {foreach ','|explode:$onedata['ni_img_news'] as $img}
				  {if $img}
				     <li onclick="delpic(this)"  style="width:128px;height:140px;margin-left:2rem;float:left;"><img style="width:128px;height:128px;" src="{$img}"><a href="javascript:void(0)"  style="display:block;width:128px;height:30px;border-radius:4px;text-align:center;line-height:30px;background:rgb(66,160,121);color:white;text-decoration:none;">删除</a></li>
					 {/if}
					 {/foreach}
					 
				  </ul>
				  <input type="hidden" name="imgstr" value="{$onedata['ni_img_news']}" class="exisit_pic">
			      <input type="hidden" name="no" value="{$onedata['ni_no']}" class="mdino">
			 </div>
		
			<div id="wrapper" style="margin-top:14rem;">
              <div id="container">
            <!--头部，相册选择和格式选择-->
             
				<div id="uploader">
					<div class="queueList">
						<div id="dndArea" class="placeholder">
							<div id="filePicker"></div>
							<p>或将照片拖到这里，单次最多可选300张</p>
						</div>
					</div>
					<div class="statusBar" style="display:none;">
						<div class="progress">
							<span class="text">0%</span>
							<span class="percentage"></span>
						</div><div class="info"></div>
						<div class="btns">
							<div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
						</div>
					</div>
				</div>
             </div>
          </div>
		  <div><button type="submit" class="addpic_btn" style="width:100px;height:40px;color:white;background:rgb(66,160,121);border:none;border-radius:4px;margin-left:2rem;margin-bottom:2rem;">修改新闻</button></div>			
	      {/if}
	</div>
    
</div>
{literal}
   <script>
       var piclist;
	   var picarr = new Array();
       function delpic(obj){
	      obj.style.display="none";
          var img = obj.getElementsByTagName("img").item(0).src;
		   picarr.push(img);
		  //picarr = $(".exisit_pic").val().split(',');
		  //alert(picarr);
		   //picarr = picarr.splice(jQuery.inArray(img,picarr),1);
		  //alert(picarr);
		  //alert(picarr.join(','));
		  $(".exisit_pic").val(picarr.join(','));
		 
	   }
   </script>
{/literal}
{/block}