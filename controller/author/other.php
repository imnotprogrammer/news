<?php
  class OtherController extends Controller{
	  public function __construct(){
		  isLogin();
		  if(!isShopUser()){
			  header('location:/index/error');
		  }
		  $messnum =Query::init()->select('umi_no')->from('user_message_info')->andWhere('umi_status=0 and umi_uno=?',[getUno()])->count();
		$this->assign('messcount',$messnum);
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
		  if($_POST){				
				DB::init()->update('user_message_info',array('umi_status'=>1),array("umi_no"=>$_POST['mno']));				
				returnMsg(200,"标记成功！");				
			}else{
				list($page,$start)=getPage(PER_NUM_COUNT);
				$mess=$this->getMessage($start);
				$page = new Page($mess['count'],PER_NUM_COUNT);
				$this->assign('messages',$mess['list']);
				$this->assign('page',$page->fpage());
				$this->display('author/mymessage.tpl');
		    }
		  
	  }
	  public function needknowAction(){
		  
	  }
  }
?>