{extends file="admin/layout/admin.tpl"}
{block name="title"}新闻之家-设置基本信息{/block}
{block name="main"}
    {include file="admin/include/center.tpl"}
	<style type="text/css">
	
.file-box{ position:relative;width:340px;display:inline-block;}
.txt{ height:22px; border:1px solid #cdcdcd; border-radius:4px;width:180px;}
.look{ background-color:#FFF; border:1px solid #CDCDCD;border-radius:4px;height:20px; width:70px;}
.file{ position:absolute; top:5px;right:30px; height:20px; width:80px; filter:alpha(opacity:0);opacity: 0;}

</style>
    <div id="m_right">
	   <div id="step_form">
           <ul>
            <li class="cur"><img src="">基本信息修改</li>          
           </ul>
        </div>
        <form action="/admin/base/setgen" method="post" class="form_common" id="gen_from" enctype="multipart/form-data">
		
		 <p style="width:128px;height:128px;">

              <label><img src="{$userlist.ui_header}" width="128px" height="128px" style="border:1px solid white;"/></label>
			  
		  </p>
		  <p  class="file-box">
		      
			  <input type='text' name='textfield' id='textfield' class='txt' placeholder=" 上传头像"/>  
		      <input type='button' class='look' value='浏览...' />
              <input type="file" name="fileField" class="file" id="fileField" onchange="document.getElementById('textfield').value=this.value" />	   
		  </p>
          <p>
            
            <input type="text" value="{$smarty.session.news.uname}" name="uname" placeholder=" 昵称" title="昵称" class="require" style="border-radius:4px;border:1px solid gray;"/>
          </p>
          <p>
            
            <input type="text" value="{$smarty.session.news.uqq}" name="uqq" placeholder=" QQ号码" class="require" title="qq号码" style="border-radius:4px;border:1px solid gray;"/>
          </p>
          <p>
            
            <input type="radio" style="appearance: radio; -webkit-appearance: radio; -moz-appearance: radio;" name="usex" value="1" {if $userlist['ui_sex'] ==1}checked="checked"{/if}/>男
            &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" style="appearance: radio; -webkit-appearance: radio; -moz-appearance: radio;" name="usex" value="2"  {if $userlist['ui_sex'] ==2}checked="checked"{/if}/>女
          </p>
          <p>
            <input type="hidden" name="img" value='{$userlist.ui_header}'>
            <input id="updateuser" type="submit" value="保存" class="btn " style="width:70px;height:35px;line-height:35px;border:1px solid white;color:white;border-radius:4px;background-color: rgb(66, 160, 121);">
          </p>
        </form>
      </div>
{/block}
