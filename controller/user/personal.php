<?php
class PersonalController extends Controller{
    
    public function __construct(){
       isLogin();
        //$_REQUEST = html_escape($_REQUEST);
		$messnum =Query::init()->select('umi_no')->from('user_message_info')->andWhere('umi_status=0 and umi_uno=?',[getUno()])->count();
		$this->assign('messcount',$messnum);
    }

    public function indexAction(){
        header('location:/user/index/setgen');    
    }
    public function getMessage($start){
		$mess=new Query();
		$data=$mess->from('user_message_info ')->andWhere('umi_uno='.getUno())->offset($start)->limit(10)->orderby('umi_ctime desc')->all();
		$message['list']=$data;
		$message['count']=$mess->count();
		//print_r($message);
		return $message;
	}
    public function messageAction(){		
			//$uno = getUno();
			if($_POST){				
				DB::init()->update('user_message_info',array('umi_status'=>1),array("umi_no"=>$_POST['mno']));				
				returnMsg(200,"标记成功！");				
			}else{
				list($page,$start)=getPage(PER_NUM_COUNT);
				$mess=$this->getMessage($start);
				$page = new Page($mess['count'],PER_NUM_COUNT);
				$this->assign('messages',$mess['list']);
				$this->assign('page',$page->fpage());
				$this->display('user/my_message.tpl');
		    }
    }
    
    public function commentAction(){
		if($_POST){
			DB::init()->exec("delete from comment_info where ci_no=?",[$_POST['dno']]);
			returnMsg(200,"删除评论成功！");
		}
		$comm=new Query();
         $comment['list']=$comm->from('comment_info')->innerJoin("news_info","ni_no=ci_nno")->innerJoin('user_info',"ui_no=ni_uno")->andWhere('ci_uno=?',[getUno()])->all();
         $comment['count']=$comm->count();
         $this->assign("comment",$comment['list']);	 
        $this->display('user/my_comment.tpl');
    }
	public function collectAction(){
		if($_POST){
		     DB::init()->exec("delete from collect_news_info  where cni_no=?",[$_POST['dno']]);
			 returnMsg(200,"删除成功!");
		}else{
			$coll=new Query();
			$collect['list']=$coll->from('collect_news_info')->innerJoin('news_info',"cni_nno=ni_no")->andWhere('cni_uno=?',[getUno()])->all();
			$collect['count']=$coll->count();
			
			$this->assign("collect",$collect['list']);	 
			$this->display("user/collect_news.tpl");
		}
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
            $this->display('user/set_pass.tpl');
        }
        
    }
    public function setEmailAction(){
        if($_POST){
			if($_POST['pass']==$this->getPass()){
				DB::init()->update('user_info',array('ui_email'=>$_POST['newemail']),array("ui_no"=>getUno()));
				$_SESSION['news']['email'] = $_POST['newemail'];		
				returnMsg(200,"设置新邮箱成功");
			}else{
				returnMsg(201,"你输入的密码不正确");
			}
		}else{
            $this->display('user/set_email.tpl');
        }
        
    }
	
	public function myfavoAction(){
		if(!$_POST){
//$temp='';
			$interest = Query::init()->select('ui_favo')->from('user_info')->andWhere('ui_no=?',[getUno()])->one();
			$myfavo   = json_decode($interest['ui_favo'],true);
			//print_r($myfavo);
			$alltype  = Query::init()->from('news_type_info')->all();
			
				foreach($alltype as $type){
					  $temp['nti_no'] = $type['nti_no'];
					  $temp['nti_name'] = $type["nti_name"];
					  if($myfavo){
					    foreach($myfavo as $my){
						  if($type['nti_no'] ==$my){
							  $temp['state'] = 1;						  
						    }					  
					    }
					  }
					  if(!isset($temp['state'])){
						  $temp['state'] = 0;
					  }
					  $rs[] = $temp;
					  $temp = '';
				}
			
			//print_r($rs);		
			$this->assign("class",$rs);
			//$this->assign("favo",$favo);
			$this->display('user/my_favo.tpl');
		}else{
			
		}
		
	}
	public function updatetypeAction(){
		if($_POST){
			DB::init()->update("user_info",array("ui_favo"=>$_POST['jsonstr']),array('ui_no'=>getUno()));
			returnMsg(200,"兴趣保存成功!");
		}
	}
	public function delcollectAction(){
		if($_POST){
			DB::exec("delete from collect_news_info where cni_no=?",[$_POST['dno']]);
			returnMsg(200,"成功删除此条收藏新闻！");
		}
	}
}
?>
   
    
    

    

        
    
   