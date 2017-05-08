<?php
class IndexController extends Controller{
	
	public function __construct(){
		$alltype = Query::init()->from('news_type_info')->all();
		$this->assign("alltype",$alltype);
		//print_r($alltype);
	}
    public function indexAction(){
		$user = new User();
		$this->assign("picnews" ,$user->getPicNews());
		$this->assign("right" ,$user->getTabNews());
		$this->assign("news" ,$user->getIndexNews());
		$this->display('index.tpl');
	}
	public function loginAction(){
		if($_POST){		
        
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
		
		
        
        if( !empty($userInfo) && $userInfo['ui_pass'] ==md5($password)){
            
                if($userInfo['ui_status'] == 0){
					returnMsg(201,"你的用户账号已经被封号!");
					exit;
				}
                
                $ip = $_SERVER['SERVER_ADDR'];
                
                
                $_SESSION['news'] = [
                    'uno'=>$userInfo['ui_no'],
                    'uname'=>$userInfo['ui_name'],
                    'uphone'=>$userInfo['ui_phone'],
                    'uemail'=>$userInfo['ui_email'],
                    'uqq'=>$userInfo['ui_qq'],
                    'usex'=>$userInfo['ui_sex'],
                    'utype'=>$userInfo['ui_type'],
                    //'upower'=>$userInfo['ui_power'],
                    //'uweixin'=>$userInfo['ui_weixin'],
                    'uheader'=>$userInfo['ui_header'],
                    'ui_type'=>$userInfo['ui_type']
                ];
                
                
               
          
            returnMsg(200,'登陆成功！');
            
        }else{
            returnMsg(102,'用户名或密码不正确！');
        }
    
		}
		else{
		  $this->display('login.tpl');
		}
	}
	public function reguserAction(){
		if($_REQUEST){
			$key = $phone = $email = $pwd = $surepwd =  $code ='';
			
			extract( safe_extract( $_REQUEST ) );
			
			//sess_email = $_SESSION['news']['reg_email'];
			$sess_code = $_SESSION['news']['reg_code'];
			
			//$code = rand(0,9);
			
			
			
			if( !$sess_code || $sess_code != $code ){
				returnMsg(101,'验证码不正确！');
			}
			
			if( $pwd != $surepwd ){
				returnMsg(101,'两次密码不一致！');
			}
			
			if( strlen($pwd)<6 || strlen($pwd)>16 ){
				returnMsg(101,'密码不正确，长度为6到16位！');
			}
			
			$user = Query::init()->select('*')->from('user_info')->andWhere('ui_email=?',[$email])->one();
			if( $user ){
				returnMsg(103,'该邮箱已被注册');
			}
			$User = new User();
			
			if(  $User->regUser($email,$pwd,$setprotectkey) ){
				returnMsg(200,'注册成功！'); 
			}else{
				returnMsg(104,'网络错误！');
			}   
	}else{
		$this->display('reg.tpl');
	}
    }
	public function sendcodeAction(){
		if($_POST){
			$code = '';
			for($i = 0;$i<6;$i++){
				$code .= rand(0,9);
			}
			list($type,$str) = SendEmail::send($_POST['email'],$code,2);
			//list()
			if($type==200){
				$_SESSION['news']['reg_code'] = $code;
			}
			returnMsg($type,$str);
		}
	}
	public function loginoutAction(){
        
        session_destroy();
        
        header('location:/index/login');
        
    }
	public function searchAction(){
		if($_GET){
			list($page,$start)=getPage(PER_NUM_COUNT);
			$key = $_GET['key'];
			$user = new User();
			$data = $user->searchData($key,$start);
			$this->assign("searchdata",$data['list']);
			$this->assign("right",$user->getTabNews());
			$this->assign("page",(new Page($data['count'],PER_NUM_COUNT))->fpage());
			$this->display('search.tpl');
		}
	}
	public function findpassAction(){
		 if($_POST){
			 extract(safe_extract($_POST));
			 $isexe = Query::init()->select('*')->from('user_info')->andWhere('ui_email=?',[$email])->one();
			 if($isexe){
				 if(md5($key) == $isexe['ui_protectkey']){
					 $code = uniqid();
					 list($status,$returnstr) = SendEmail::send($email,$code);
             					 
					 DB::init()->update('user_info',array('ui_pass'=>md5($code)),array('ui_email'=>$email));
                     returnMsg(208,$returnstr);				
				}else{
				     returnMsg(202,"你输入的秘钥不正确！");
				}
			 }else{
				 returnMsg(204,"你输入的邮箱不存在，请核对要找回密码的邮箱！");
			 }
		 }else{
		    $user = new User();
			$this->assign("right",$user->getTabNews());
			$this->display('findpass.tpl');
		 }
	}
	public function errorAction(){
		$this->display('404.tpl');
	}
	public function noteAction(){
	   if(!$_POST){
		 $this->assign('right',(new User())->getTabNews());
		 $this->display('note.tpl');
	   }else{
		   if(!isset($_SESSION['news'])){
			   returnMsg(201,'你还未登录');
			   exit;
		   }
		   DB::init()->insert('note_info',array('n_ctime'=>time(),'n_uno'=>getUno(),'n_body'=>$_POST['note'],'n_status'=>0));
		   returnMsg(200,"留言成功!");
	   }
	}
}