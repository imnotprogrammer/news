<?php
class BaseController extends Controller{
    
    public function __construct(){
        isLogin();
		if(!isAdmin()){
		    header('location:/index/error');
		}
        //$_REQUEST = html_escape($_REQUEST);
    }

    public function indexAction(){
        header('location:/admin/base/setgen');    
    }
	public function messageAction(){
		$this->display("admin/message.tpl");
	}
    public function getPass(){
		$pass=Query::init()->from('user_info ')->andWhere('ui_no='.getUno())->one();
		return $pass['ui_pass'];
	}
    public function setgenAction(){
		if($_POST){
			//print_r($_FILES['fileField']);
			$img=new Ftpfile();
			$imgpath=$img->ftp("fileField");
			if($imgpath==1){
				$imgpath=$_POST['img'];
			}else{
				unlink('.'.$_POST["img"]);
			}
			$arr=array(
			  "ui_name"=>$_POST['uname'],
			  "ui_qq"=>$_POST["uqq"],
			  "ui_sex"=>$_POST['usex'],
			  "ui_header"=>$imgpath,
			);
			
			DB::init()->update('user_info',$arr,array("ui_no"=>getUno()));
			$_SESSION['news']['uname']=$_POST['uname'];
			$_SESSION['news']['usex']=$_POST['usex'];
			$_SESSION['news']['uqq']=$_POST['uqq'];
			alertMsg("修改基本信息成功","/admin/base/setgen");
		}else{
			//echo 1111;
			$uno = getUno();
			$gen=Query::init()->from('user_info ')->andWhere('ui_no='.getUno())->one();
			$this->assign('userlist',$gen);
			$this->display('admin/set_gen.tpl');
		}
    }
    
    public function setPhoneAction(){
         if($_POST){
			if($_POST['pass']==$this->getPass()){
				DB::init()->update('user_info',array('ui_phone'=>$_POST['newtel']),array("ui_no"=>getUno()));
				$_SESSION['news']['uphone'] = $_POST['newtel'];		
				returnMsg(200,"设置新号码成功");
			}else{
				returnMsg(201,"你输入的密码不正确");
			}
		}else{
            $this->display('admin/set_phone.tpl');
        }
    }
	public function saveAction(){
		
	}
    public function setpwdAction(){
      if($_POST){
			if($_POST['oldpass']==$this->getPass()){
				if($_POST['newpass']==$_POST['surepass']){
				DB::init()->update('user_info',array('ui_pass'=>$_POST['newpass']),array("ui_no"=>getUno()));
				//$_SESSION['news']['email'] = $_POST['newemail'];		
				returnMsg(200,"设置新密码成功");
				}else{
					returnMsg(201,"设置新密码与确认密码不匹配！请重试！");
				}
			}else{
				returnMsg(201,"你输入的旧密码不正确");
			}
		}else{
            $this->display('admin/set_pass.tpl');
        }
        
    }
    public function setEmailAction(){
        if($_POST){
			if(md5($_POST['pass'])==$this->getPass()){
				$isexe = Query::init()->select('ui_no')->from('user_info')->andWhere('ui_email=?',[$_POST['newemail']])->one();
				if($isexe){
					returnMsg(203,"你的邮箱已经被绑定，请输入另外的邮箱！");
					exit;
				}
				DB::init()->update('user_info',array('ui_email'=>$_POST['newemail']),array("ui_no"=>getUno()));
				$_SESSION['news']['uemail'] = $_POST['newemail'];		
				returnMsg(200,"设置新邮箱成功");
			}else{
				returnMsg(201,"你输入的密码不正确");
			}
		}else{
            $this->display('admin/set_email.tpl');
        }
        
    }
}


?>