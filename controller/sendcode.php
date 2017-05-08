<?php
class sendcodeController extends Controller{
    
    /**
     * /sendcode/sms
     * 
     * 发送短信验证码
     * 
     * @param $_REQUEST['phone']
     * 
     * @return {result_code:200,result_desc:""}
     * 
     */
    public function smsAction(){
        $code = rand(100000,999999);
        $phone = $name = $verkey = $type = '';
        extract( safe_extract( $_REQUEST ) );
        
        if( $type == 'new' ){
            if( !preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",intval($phone))){
                
                returnMsg(101,'手机号码不正确！');    
            }
        }else if($type == 'verify'){
            $phone = getUphone();
            if( empty($phone) ){
                return false;
            }
        }else{
            returnMsg(101,'参数不正确！'); 
        }
        
        if(empty($code)){
            returnMsg(101,'验证码不能为空！');      
        }
        if(empty($verkey)){
            returnMsg(101,'参数不正确！'); 
        }
        $sess_codekey = $_SESSION['bmzj']['codekey'];
        if( $verkey != $sess_codekey ){
            returnMsg(101,'发送失败！');
        }
        $see_setphone = $_SESSION['bmzj']['sendtime'];
        $chatime = time()-$see_setphone;
        $count = $_SESSION['bmzj']['sendcount'];
        if($chatime<20 ){
            if( $count >= 2 ){
                returnMsg(101,'发送短信太频繁！请稍后发送！'); 
            }       
        }else{
            $_SESSION['bmzj']['sendcount'] = 0;
        }
        
        $sms = new SMS;
        $tplvalue = '#name#='.$name.'&#code#='.$code;
        $content = $sms->sendsms('ecdf0c2eaa99060bf769bb634d993ce7',intval($phone),'7569',$tplvalue);
        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                
                if( $type == 'verify' ){
                    $_SESSION['bmzj']['ver_phonecode'] = $code;
                }else {
                    $_SESSION['bmzj']['phonecode'][$phone] = $code;
                }
                $_SESSION['bmzj']['sendtime'] = time();
                
                $_SESSION['bmzj']['sendcount'] = $_SESSION['bmzj']['sendcount']+1;
                
                returnMsg(200,'验证码发送成功:'.$code."/".$phone);
              
            }else{
                returnMsg(101,'短信发送失败!');
            }
        }else{
            returnMsg(103,'请求发送短信失败!');
        }
        
    }
    /**
     * 找回密码手机验证
     * @param $_REQUEST['phone']
     * @return {result_code:200,result_desc:""} 
     */
     public function backsmsAction(){
                 
     } 
    
    /**
     * sendcodeController::emailAction()
     * 
     * @return {result_code:200,result_desc:""} 
     */
    public function sendEmailCodeAction(){
        
        $email = '';
        extract( safe_extract( $_REQUEST ) );
        $isemail = filter_var($email,FILTER_VALIDATE_EMAIL);
        if(empty($isemail)){
            returnMsg(102,'邮箱格式错误！');         
        }
        
        $code = rand(100000,999999);
        $sendcode = sendEmail($email,'便名之家邮箱验证',"你的验证码为 : ".$code);
        if($sendcode){
            $_SESSION['bmzj']['ver_emailCode'] = $code;
            $_SESSION['bmzj']['ver_email'] = $email;
            returnMsg(200,'验证码发送成功！');     
        }else{
            returnMsg(101,'验证码发送失败！');     
        }   
            
    }
}