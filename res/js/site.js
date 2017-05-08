$(function(){
  $("#u_list>li:first-child>a").hover(
    function(){
      $("#u_list ul").removeClass("view_state");
    },
    function(){
      $("#u_list ul").addClass("view_state");
    }
  );
  $("#u_list ul").hover(
    function(){
      $("#u_list ul").removeClass("view_state");
    },
    function(){
      $("#u_list ul").addClass("view_state");
    }
  );
  $("#add_list div").hover(
    function(){
      $(this).children("p").show(600);
    },function(){
      $(this).children("p").hide(100);
    }
  );
  $("#myshop_cart input[type=button]").on("click",function(){
    
  })
});

 function sendPhoneCode(elm,telName){
    
    var type = 'verify';
    
    if( typeof arguments[2] != "undefined" ){
        var type = arguments[2];
    }
        
    var tel = $('input[name='+telName+']').val();
    
    var verkey = $('input[name=verkey]').val();
    
    if( !tel ){
        alert('手机号码不正确!');
        return;
    }
    
    $.post('/sendcode/sms',{phone:tel,verkey:verkey,type:type},function(data){
        
         data = $.parseJSON(data);
         
         if(data.result_code == 200 ){
            
            $(elm).attr('onclick','');
             
            $(elm).html('重新获取验证码！（60）');
            
            var i = 59;
            
            var timer = setInterval(function(){
                if( i >0 ){
                    $(elm).html('重新获取验证码！（'+i+'）');
                    
                }else{
                    $(elm).html('点击发送短信');
                    $(elm).attr('onclick','sendPhoneCode(this,"'+telName+'"' + ',"'+type+'"' + ')');
                    clearTimeout(timer);
                }
                i--;
            },1000);
            
         }else{
            
            alert(data.result_desc);
            
         }
    });
    
}

function identify(vercodeName){
    
    $.post('/user/identify',{vercode:$('input[name='+vercodeName+']').val()},function(data){
        data = $.parseJSON(data);
        if( data.result_code == 200 ){
            oprateStage(2);
        }else{
            alert(data.result_desc);
        }
    });
    
}
function oprateStage(num){
    var steps = $('#step_form li');
    console.log(steps[0]);
    if( num == 1 ){
        steps[0].className = "cur";
        steps[1].className = "no";
        steps[2].className = "no";
        
    }else if( num == 2 ){
        steps[0].className = "no";
        steps[1].className = "cur";
        steps[2].className = "no";
        $('#step1').hide();
        $('#step2').show();
    }else if( num == 3 ){
        steps[0].className = "no";
        steps[1].className = "no";
        steps[2].className = "cur";
        $('#step2').hide();
        $('#step3').show();
    }
}

/*
 @param string data {"result_code":200,"result_desc":"消息"}
 @param int type  0 不弹出消息 | 1 弹出消息
*/
function doResult(data){
    
    type = 0;
    
    if( typeof arguments[1] != "undefined" ){
        type = arguments[1];
    }
    
    data = $.parseJSON(data);
    
    if( type == 1 ){
        alert(data.result_desc);
    }
    
    if( data.result_code == 200 ){
        window.location.reload();
        return true;
    }
    
    return false;
}