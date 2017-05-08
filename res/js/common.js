  var i=0;
  var panduan=0;
  var arr= new Array();
  var typearr = new Array();
  function alertmsg(info){
	  layer.msg(info);
	  setTimeout(function(){window.location.href=$('#gen_from').attr("action");},2000);
  }
  function infomsg(info){
	  
	  setTimeout(function(){layer.msg(info);},1000);
  }
  function post(info,path,ret){
	  $.post(path,info,function(data){
		  data=$.parseJSON(data);
		  if(data.result_code==200){
			  layer.msg(data.result_desc);
			  
		  }else{
			  layer.msg(data.result_desc);			  
		  }
		  setTimeout(function(){
				  window.location.href=ret;
			  },2000);
	  })
  }
  var pagestart = 0;
  function getMore(page){
	  var str = '';
	  var no = $('.hidno').val();
	  $.post('/news/getmore',{"no":no,"pg":page},function(data){
		  data = $.parseJSON(data);
		  //alert(data.result_desc);
		  //return false;
		  if(data.result_code==200){
			  $.each($.parseJSON(data.result_desc),function(i,val){
				  var date = new Date(val.ci_ctime);
				  var time = date.getYear()+'-'+date.getMonth()+'-'+date.getDay();
				 str+='<div class="" style="height:140px;">';
				   
				 str+='<span style="display:block;"><img src="'
				         +val.ui_header+'" style="width:64px;height:64px; border-radius:50%;margin-right:2rem;">'
				         +val.ui_name+'<b style="padding-left:25rem;">评论时间:'
				         +time+'<b></span>';
			     str+='<p style="padding-top:2rem;text-indent:2rem;">'+val.ci_body+'</p></div>';
					  
					  
				   
			  });
			  $('.view_btn').before(str);
			  //alert(str);
                pagestart = (pagestart+1);
			  $('.morecomment').attr('onclick','getMore('+(pagestart*10)+')');
		  }else if(data.result_code==201){
			  $('.morecomment').html(data.result_desc);
		  }else{
			  $('.morecomment').html("加载失败,请重试!");
		  }
	  })
  }
  function del(no){
	  var d = dialog({
		  title:"删除提示",
		  content:"你确定要删除此条新闻类型？",
		  okValue:"确定",
		  ok:function(){
			  post({"no":no},"/admin/index/deltype","/admin/index/newstype");
		  },
		  cancelValue:"取消",
		  cancel:function(){}
	  });
	  d.showModal();
	  return false;
  }
  //登录
  function login(){
      var loginForm = document.loginForm;
      $.post(
         '/index/login',
        {
            username:loginForm.uname.value,
            password:loginForm.upass.value,
            vercode:loginForm.uvercode.value
        },
        function(data){
            data = $.parseJSON(data);
            if(data.result_code == 200){
                               
                        window.location.href='/index/index';

            }else{
                layer.msg(data.result_desc);
            }
            
        });
  }
  //注册
  function reg(){
        var form = new tsForm('loginForm');
        var status = form.validate('reg_email','isEmpty','邮箱不能为空！') && 
        form.validate('reg_email',form.reg.email,'邮箱格式不正确！') &&
        form.validate('code','isEmpty','验证码不能为空！') &&
        form.validate('pwd','isEmpty','登录密码不能为空！') &&
        form.validate('surepwd','isEmpty','确认密码不能为空！') &&
		form.validate('setprotectkey','isEmpty','密保不能为空，请牢记！') &&
        form.validate('pwd',form.get('surepwd'),'两次输入密码不相同');
        if( !status ){
            return false;
        }
        $.post('/index/reguser',form.getData(),function(data){
            data = $.parseJSON(data);
            alert(data.result_desc);
            if( data.result_code == 200 ){
                window.location.href = '/index/login';
            }
        });
    }
   //发送验证码至邮箱；
   function sendPhoneCode(){
	   var email = $('#reg_email').val();
	   var regstr = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
	   if(!regstr.test(email)){
		   layer.msg("邮箱格式错误！");
		   return false;
	   }
	   //alert(email);
	   $.post('/index/sendcode',{"email":email},function(data){
        
         data = $.parseJSON(data);
         
         if(data.result_code == 200 ){
			 layer.msg(data.result_desc);
            
            $("#getcode").attr('onclick','');
             
            $("#getcode").html('重新获取验证码！（2分钟）');
            
            var i = 180;
            
            var timer = setInterval(function(){
                if( i >0 ){
                    $("#getcode").html('重新获取验证码！（'+i+'）');
                    
                }else{
                    $("#getcode").html('点击发送验证码');
                    $("#getcode").attr('onclick','sendPhoneCode()');
                    clearTimeout(timer);
                }
                i--;
            },1000);
            
         }else{
            
            layer.msg(data.result_desc);
            
         }
    });
   }
   function dialogWin(tit,no,info,dealpath,returnpath){ 
	   var d = dialog({
		  title:tit,
		  content:'<textarea name="desc" placeholder="此处填写备注" cols="40" rows="40" id="abody" />',
		  okValue:"确定",
		  ok:function(){
			  
                post({'no':no,'desc':$('#abody').val()},dealpath,returnpath);
		  },
		  cancelValue:"取消",
		  cancel:function(){}
	  });
	  d.showModal();
	  return false;
	   
	   
   }
  function author(uno,type,ano){
	  var info;
	  var path = "/admin/index/author";
	  if(type == 2){
		  var tit = "同意理由";
		 // info ={"uno":uno,"ano":ano,"type":type,"desc":$("#abody").text()};
	  }else{
		  var tit = "拒绝理由";
		  //info ={"ano":ano,"type":type,"desc":$("#abody").text()};
	  }
	  var d    = dialog({
		  title:tit,
		 content: '<textarea name="desc" placeholder="此处填写备注" cols="40" rows="40" id="abody" />',
          okValue:"确定",
		  ok:function(){
	  //var path = "/admin/index/author";
	  if(type == 2){
		  //var tit = "同意理由";
		  info ={"uno":uno,"ano":ano,"type":type,"desc":$("#abody").val()};
	  }else{
		  //var tit = "拒绝理由";
		  info ={"ano":ano,"type":type,"desc":$("#abody").val(),"uno":uno};
	  }
			  post(info,path,"/admin/index/checkauthor");
		  },
		  cancelValue:"取消",
		  cancel:function(){
			  
		  }
		  
	  });
	  d.showModal();
	  return false;
	  //post(info,path,"/admin/index/checkauthor");
  }
  //留言回复
  function replynote(no){
	   var info = {'no':no,'desc':$('#abody').val()};
	   var path = '/admin/other/reply';
	   var returnpath = '/admin/other/note';
	   dialogWin("回复内容",no,info,path,returnpath);
  }
  function fobidauthor(no,ftype){
	  var info = {"uno":no,"type":ftype};
	  var path = "/admin/index/forbid";
	  post(info,path,"/admin/index/authorinfo");
  }
  function news(no,type){
	  //alert(no);
	  var info = {"no":no,"type":type};
	  var path = "/admin/index/newscheck";
	  post(info,path,"/admin/index/index");
  }
  function findpass(uno){
	  var info = {"uno":uno};
	  var path = "/admin/other/findpass";
	  post(info,path,path);
  }
  function addtext(i){
	  var childarr = new Array();
	  
	  if(arr[i]!=null){
				$('#abody').val(arr[i])
			}

	      var d = dialog({
      title: '新闻之家--添加图片新闻备注',
      content: '<textarea name="news" placeholder="图片新闻备注" cols="40" rows="40" id="abody" />',
      okValue: '添加',
      ok: function() {
       
        if ($("#abody").val() == "") {
          alert("兰渝果提醒你:备注还是写一两个字吧！");
		  return false;
        } else {
			childarr['desc'] = $('#abody').val();
			childarr['picname'] = $('.title').text();
          //alert(arr.push(childarr));
		   childarr = [];
		 document.writeln(JSON.stringify(arr));
           //arr[]=$('#abody').val();
        }
        $(".adddesc").html('已添加备注');
      },
      cancelValue: '取消',
	
	  
      cancel: function() {}
    });
    d.showModal();
    return false;
  }
  function changetype(object){
	  //var curarr =$('.cur');
	   var allcheckfavo = $('.checkfavo');
	//alert(allcheckfavo.length);
	for(var i=0;i<allcheckfavo.length;i++){
		typearr[i]=allcheckfavo.eq(i).attr('title');
		//alert(typearr.length);
	}
	//alert(JSON.stringify(typearr));
	  var allul = $('.ul_class li');
	  //alert(allul.length);
	  for(var i=0;i<allul.length;i++){
		  var temp = allul.eq(i);
		  if(temp.attr('title')==object){
			  //alert(1111);
			  if(temp.attr('class')=='cur'){
				  //alert(temp.attr('title'));
				  typearr.push(temp.attr('title'));
				  temp.attr('class','checkfavo');
				  //alert(JSON.stringify(typearr));
				  break;
			  }
			  if(temp.attr('class')=="checkfavo"){
				  //typearr.splice(jQuery.inArray(temp.attr('title'),1),1);
				  for(var i=0;i<typearr.length;i++){
					  if(typearr[i]==temp.attr('title')){
						  typearr.splice(i,1);
						  i--;
					  }
				  }
				  temp.attr('class','cur');
				  //alert(JSON.stringify(typearr));
				  break;
		        }
				
		  }
	  }			  
	
  }
 $(function(){	
    //提交 
	$(".btn").click(function(){
		//alert(1111);
		//var req=$(".require");
		var email_reg = /^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/;
		var phone_reg = /^[1-9]{1}[0-9]{10}$/;
	   if($('.require').length>0){
		   //(111);
		   var i=$('.require').length;
		   var temp;
		   
		   for(j=0;j< i;j++){
			   temp = $('.require').eq(j);
			   
			   if(temp.val()==''){
				   layer.msg(temp.attr('title'));
				   return false;
			   }
		   }
		   
	   }
	   if($('.phonereg').length>0){
		   //(111);
		   if($('.phonereg').val()==''){
			   layer.msg("新的电话号码不能为空!");
			   return false;
		   }
		   if(!phone_reg.test($('.phonereg').val())){
			   layer.msg('你的电话号码格式不正确，请重新填写!');
			   return false;
		   }
		   
	   }
	   if($('.emailreg').length>0){
		   //(111);
		   if($('.emailreg').val()==''){
			   layer.msg("新的邮箱值不能为空!");
			   return false;
		   }
		   if(!email_reg.test($('.emailreg').val())){
			   layer.msg('你的邮箱格式不正确，请重新填写!');
			   return false;
		   }
		   
	   }
      //if($('textarea[name="editorValue"]').length>0){
		  /*if($('#myEditor').html()==""){
			 //alert($('#myEditor').html());
		      layer.msg('新闻内容不能为空!');
		      return false;
		  }*/
		  
	 //}	 
       if($('.isedit').length>0){
		   
		   var zhi = um.getContentTxt();
		   
		   if(zhi.toString()==false){
			   layer.msg("新闻内容不能为空!");
			   return false;
		   }
	   }	
       // return false;	
	
	  if($(".btn").attr("id")=="updateuser"){
		  //alert(11111);
		  $('.btn').submit();
	  }
	  else{
		var formobj=$('#gen_from');
		//alert(formobj.serialize());
		$.post(formobj.attr("action"),formobj.serialize(),function(data){
			var d=$.parseJSON(data);
             if(d.result_code==200){
				 alertmsg(d.result_desc);
				 i=1;
			 }else if(d.result_code==208){
				 layer.msg(d.result_desc);
			 }
			 else{
				 layer.msg(d.result_desc);
			 }			
		});    
	  }
	});
   //我的兴趣
   
   //发送消息 select 发生改变
   	   if($('.sendmess').find('option:selected').val()==1){
		   $('.reciver').hide();
	   }
   $(".sendmess").change(function(){
	   
	   if($('.sendmess').find('option:selected').val()==1){
		   $('.reciver').hide();
	   }else{
		   $('.reciver').show();		   
	   }
   });
   
	
	$(".save_button").click(function(){
		
		post({"jsonstr":JSON.stringify(typearr)},"/user/personal/updatetype","/user/personal/myfavo");
	});
   if($('#myEditor').length>0){ 
     var um;
	 if($(".isedit").length>0){
		 //alert(1);
       um = UM.getEditor('myEditor');
	 }else{
		 //alert(2);
	   um = UM.getEditor('myEditor',{toolbar:[],readonly:true,initialFrameHeight:600}); 
      
	 }
   }
   $('.comment_btn').click(function(){
	   var val = $('.comment').val();
	   var nno = $('.hidno').val();
	   post({comment:val,no:nno},"/news/comment","");
   });
   $('.search').click(function(){
	   var key = $('.searchkey').val();
	   if(key.length<=0){
		   layer.msg("搜索关键词不能为空!");
		   return false;
	   }
	   $.get('/index/search',{'key':key},function(data){
		   data = $.parseJSON(data);
		   if(data.result_code == 200){
			   
		   }
	   });
   });
   $('.addpic_btn').click(function(){
	     var type = $('.ni_type').val();
		 
		 var title = $('.ni_title').val();
		 var desc = $('.desc').val();
		 if(title.length<=0){
			 layer.msg('亲，新闻标题不能为空。');
			 return false;
		 }
		 if(desc.length<=0){
			 layer.msg('亲，图片的备注还是写两个字吧！，以表示你对工作的负责。');
			 return false;
		 }
		 var jsonstr = {'type':type,'desc':desc,'title':title};
		 if($('.exisit_pic').length>0){
			 jsonstr = {'type':type,'desc':desc,'title':title,'mdino':$(".mdino").val(),'picstr':$('.exisit_pic').val()};
		 }
		 $.post('/author/index/addpicnews',jsonstr,function(data){
			data = $.parseJSON(data);
            if(data.result_code==200){
				layer.msg(data.result_desc);
				window.location.href="/author/index/addpicnews";
			}else if(data.result_code==202){
				layer.msg(data.result_desc);
				window.location.href="/author/index/addpicnews?no="+$(".mdino").val();
			}
			else{
				layer.msg(data.result_desc);
			}			
		 });
   });
})