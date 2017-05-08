<?php
class LoginController extends Controller{
    
    public function indexAction(){
        
        if( !empty($_GET['type']) && $_GET['type'] == 'popup' ){
            $this->display('site/login_popup.tpl');
        }else{
            $this->display('site/login.tpl');  
        }
    
    }
    
    public function loginAction(){
        
        $username = $password = $vercode = "";
       
        extract(safe_extract($_POST));
       
        if( empty($username) || empty($password) || empty($vercode) ){
            returnMsg(100,'参数不正确！');
        }
        
        $sess_vercode = $_SESSION['bmzj']['vercode'];
        
        if( $vercode != $sess_vercode ){
            returnMsg(101,'验证码不正确！');
        }
        
        $User = new User();
        
        $userInfo = $User->getUserByEmailOrPhone($username);
        
        if( !empty($userInfo) && $userInfo['ui_pass'] == md5_encrypt($password) ){
            
            if( LOGIN_WEIGHT & $userInfo['ui_power'] ){ 
                
                $ip = $_SERVER['SERVER_ADDR'];
                
                
                $_SESSION['bmzj'] = [
                    'uno'=>$userInfo['ui_no'],
                    'uname'=>$userInfo['ui_name'],
                    'uphone'=>$userInfo['ui_phone'],
                    'uemail'=>$userInfo['ui_email'],
                    'uqq'=>$userInfo['ui_qq'],
                    'usex'=>$userInfo['ui_sex'],
                    'utype'=>$userInfo['ui_type'],
                    'upower'=>$userInfo['ui_power'],
                    'uweixin'=>$userInfo['ui_weixin'],
                    'uheader'=>$userInfo['ui_header'],
                    
                ];
                
                if( !empty($_SESSION['cart']) ){
                    $db = DB::init();
                    foreach( $_SESSION['cart'] as $cart ){
                        
                        
                        $Record = new Record();
                        $Record->uci_uno = $userInfo['ui_no'];
                        $Record->uci_gno = $cart['gno'];
                        $Record->uci_count = $cart['count'];
                        $Record->uci_ctime = time();    
                        $db->insert('user_cart_info',$Record);    
                                   
                    }
                }
                unset( $_SESSION['cart'] );
                if( $userInfo['ui_type'] == 2 || $userInfo['ui_type'] == 3 ){
                    $shopInfo = Query::init()->from('shoper_info')->andWhere('si_uno=?',$userInfo['ui_no'])->one();
                    $_SESSION['bmzj']['sno'] = $shopInfo['si_no'];
                }
                
            }else{
                returnMsg(300,'没有权限登录！');
            }
            
            
            
            returnMsg(200,'登陆成功！');
            
        }else{
            returnMsg(102,'用户名或密码不正确！');
        }
    }
    
    public function loginoutAction(){
        
        session_destroy();
        
        header('location:/login');
        
    }
}