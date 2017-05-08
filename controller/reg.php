<?php
class RegController extends Controller{
    
     public function indexAction(){
        //$this->display('jquerytpl/sendsms.html');
        $this->display('site/reg.tpl');
    }
    
    public function reguserAction(){
        $phone = $email = $pwd = $surepwd =  $code ='';
        
        extract( safe_extract( $_REQUEST ) );
        
        $sess_email = $_SESSION['bmzj']['reg_email'];
        
        $sess_code = $_SESSION['bmzj']['phonecode'][$phone];
        
        if( !$sess_code || $sess_code != $code ){
            returnMsg(101,'验证码不正确！');
        }
        
        if( $pwd != $surepwd ){
            returnMsg(101,'两次密码不一致！');
        }
        
        if( strlen($pwd)<6 || strlen($pwd)>16 ){
            returnMsg(101,'密码不正确，长度为6到16位！');
        }
        
        $user = Query::init()->select('*')->from('user_info')->andWhere('ui_phone=?',$phone)->one();
        if( $user ){
            returnMsg(103,'该手机号码已被注册');
        }
        $User = new User();
        
        if(  $User->regUser($phone,$email,$pwd) ){
            returnMsg(200,'注册成功！'); 
        }else{
            returnMsg(104,'网络错误！');
        }   
        
    }
}