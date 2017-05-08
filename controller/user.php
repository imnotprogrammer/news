<?php
class UserController extends Controller{
    
    public function __construct(){
        isLogin();
        $_REQUEST = html_escape($_REQUEST);
    }

    public function indexAction(){
        header('location:/user/setgen');    
    }
    
    public function setgenAction(){
        $uno = getUno();
        $User = new User();
        $userList = $User->getUserList($uno);
        $this->assign('userList',$userList);
        $this->display('user/set_gen.tpl');
    }
    
    public function setphoneAction(){
        $_SESSION['bmzj']['codekey'] = md5(time().rand(1000,10000));
        $this->assign('verkey',$_SESSION['bmzj']['codekey']);
        $this->display('user/set_phone.tpl');
        
    }
    public function setpwdAction(){
        $_SESSION['bmzj']['codekey'] = md5(time().rand(1000,10000));
        $this->assign('verkey',$_SESSION['bmzj']['codekey']);
        $this->display('user/set_pwd.tpl');
        
    }
    public function setemailAction(){
        $_SESSION['bmzj']['codekey'] = md5(time().rand(1000,10000));
        $this->assign('verkey',$_SESSION['bmzj']['codekey']);
        $this->display('user/set_email.tpl');
        
    }
    public function setpaypwdAction(){
        $_SESSION['bmzj']['codekey'] = md5(time().rand(1000,10000));
        $this->assign('verkey',$_SESSION['bmzj']['codekey']);
        $this->display('user/set_pay_pwd.tpl');
        
    }
    public function setwithdrawpwdAction(){
        $_SESSION['bmzj']['codekey'] = md5(time().rand(1000,10000));
        $this->assign('verkey',$_SESSION['bmzj']['codekey']);
        $this->display('user/set_withdraw_pwd.tpl');
        
    }
   
    public function messageAction(){
        $type = $_GET['type'];
        $UserMessage = new UserMessage();
        $uno = getUno();
        list($page,$start) = getPage(PER_PAGE_COUNT);
        $messages = $UserMessage->getList($uno,$type,$start);
        //Debug::log($messages);
        $Page = new Page($messages['count'],PER_PAGE_COUNT);
        $this->assign('messages',$messages['list']);
        $this->assign('page',$Page->fpage());
        $this->display('user/message.tpl');
    }
    
    public function messagehasreadAction(){
        
        $uno = getUno();  
        $mno = $_REQUEST['mno'];
        if( !$mno ){
            return false;
        }
        $UserMessage = new UserMessage();
        $UserMessage->hasRead($uno,$mno);
        returnMsg(200,'设置消息为已读成功！');
        
    }
    
    public function indexhomeAction(){
        $UserInfo = new UserInfo();
        $uno =getUno();
        
        $userInfo = $UserInfo->getUserInfo($uno);
        
        $counts = $UserInfo->getCounts($uno);
        
        $newShops = $UserInfo->getNewShops();
        
        $newGoods = $UserInfo->getNewGoods();
        
        $newOffPriceGoods = $UserInfo->getNewOffPriceGoods();
        
        $this->assign('userInfo',$userInfo);
        $this->assign('counts',$counts);
        $this->assign('newShops',$newShops);
        $this->assign('newGoods',$newGoods);
        $this->assign('newOffPriceGoods',$newOffPriceGoods);
        $this->display('user/index_home.tpl');
    }
    
    /**
     * 手机验证码验证
     */
     public function identifyAction(){
        $vercode = '';
        extract( safe_extract( $_REQUEST ) );
        if(empty($vercode)){
            returnMsg(102,'参数错误！');             
        }
        $sess_code = getVerPhoneCode();
        if($vercode != $sess_code){
            returnMsg(101,'验证码错误！');           
        }   
        returnMsg(200,'验证成功！');
     }
     /**
      * 修改手机号码
      */
     public function updatephoneAction(){
        
        $tel = $verCode  = $phoneCode  = '';    
        
        extract( safe_extract( $_REQUEST ) );
        
        $uno = getUno();
        
        $User = new User();
        if( $User->getUserPhoneEmail($tel,'phone') ){
            returnMsg(102,'该手机已绑定！');            
        }
        
        $uphone = getUphone();
        
        $sess_vercode = getVerPhoneCode();
        
        $sess_phoneCode = $_SESSION['bmzj']['phonecode'][$tel];
        
        if( !$verCode || $sess_vercode != $verCode || !$phoneCode || $sess_phoneCode != $phoneCode){
            returnMsg(102,'验证码不正确！');
        }
    
        $result =$User->updateUserPhone($tel,$uno);
        
        if($result){
            $_SESSION['bmzj']['uphone'] = $tel;
            returnMsg(200,'手机设置成功！');    
        }else{
            returnMsg(101,'手机设置失败！');       
        }
          
     }
     /**
      * 修改支付密码
      */
      public function updatepaypassAction(){
            $paypass  = $verCode = '';
            extract( safe_extract( $_REQUEST ) );
            $uno = getUno();
            $sess_vercode = getVerPhoneCode();
            if(!$verCode || $sess_vercode != $verCode ){
                returnMsg(102,'验证码不正确！');
            }
            $User = new User();
            $result = $User->updateUserPayPass($paypass,$uno);
            if($result){
                returnMsg(200,'支付密码设置成功！');    
            }else{
                returnMsg(101,'支付密码设置失败！');       
            }
        
      }
      /**
      * 修改支付密码
      */
      public function updatewithdrawpwdAction(){
            $withdrawpwd  = $verCode = '';
            extract( safe_extract( $_REQUEST ) );
            $uno = getUno();
            $sess_vercode = getVerPhoneCode();
            if(!$verCode || $sess_vercode != $verCode ){
                returnMsg(102,'验证码不正确！');
            }
            $Record = new Record();
            $Record->ui_withdraw_pass = md5_encrypt($withdrawpwd);
            $db = DB::init();
            $result = $db->update('user_info',$Record,['ui_no'=>$uno]);
            if($result){
                returnMsg(200,'支付密码设置成功！');    
            }else{
                returnMsg(101,'支付密码设置失败！');       
            }
        
      }
      /**
       * 修改邮箱
       */
      public function updateemailAction(){
        $uemail = $uno = $verCode = $phoneCode = '';
        extract( safe_extract( $_REQUEST ) );
        
        $uno = getUno();
        $sess_vercode = getVerPhoneCode();
        $sess_emailCode = $_SESSION['bmzj']['ver_emailCode'];
        $sess_verEmail = $_SESSION['bmzj']['ver_email'];
        
        if( !$uemail || $uemail != $sess_verEmail ){
            returnMsg(101,'邮箱不正确！');
        }
        
        if(  !$verCode || !$phoneCode  || $verCode != $sess_emailCode || $phoneCode != $sess_vercode ){
            returnMsg(102,'验证码不正确！');
        }
        $User = new User();
        if($User->getUserPhoneEmail($uemail,'email')){
            returnMsg(102,'该邮箱已绑定！');            
        }
        $result =$User->updateUserEmail($uemail,$uno);
        if($result){
            $_SESSION['bmzj']['uemail'] = $uemail;
            returnMsg(200,'邮箱设置成功！');    
        }else{
            returnMsg(101,'邮箱设置失败！');       
        }  
      }
       /**
       * 修改用户密码
       */
       public function updatepassAction(){
            $upass  = $verCode = '';
            extract( safe_extract( $_REQUEST ) );
            
            $uno = getUno();
            $sess_vercode = getVerPhoneCode();
            if( !$verCode || $verCode != $sess_vercode ){
                returnMsg(102,'验证码不正确！');
            }
            $User = new User();
            $result = $User->updateUserPass($upass,$uno);
            if($result){
                returnMsg(200,'密码设置成功！');    
            }else{
                returnMsg(101,'密码设置失败！');       
            }
             
       }
    
    /**
     *基本信息 
     */
    public function setUserAction(){
        $uname = $uqq = $usex = '';
        extract( safe_extract( $_REQUEST ) );
        $User = new User();
        $uno = getUno();
        
        if($User->setUserOne($uname,$uqq,$usex,$uno)){
            returnMsg(200,'设置成功！');         
        }else{
            returnMsg(101,'设置失败！');    
        }
                     
    }
    
    
    
}