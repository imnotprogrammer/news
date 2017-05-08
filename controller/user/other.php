<?php
  class OtherController extends Controller{
	  public function __construct(){
		  isLogin();
		  $messnum =Query::init()->select('umi_no')->from('user_message_info')->andWhere('umi_status=0 and umi_uno=?',[getUno()])->count();
		$this->assign('messcount',$messnum);
	  }
	  public function indexAction(){
		  
	  }
	  public function myadviceAction(){
		  if($_POST){
			  DB::init()->insert("note_info",array('n_body'=>$_POST['note'],'n_uno'=>getUno(),'n_ctime'=>time()));
		      returnMsg(200,"恭喜你，留言成功");
		  }else{
		    $this->display("user/advice.tpl");
		  }
	  }
	  public function applyAction(){
		  if($_POST){
			   $arr = [
			     "aai_uno" =>getUno(),
				 "aai_body"=>$_POST['body'],
				 "aai_ctime"=>time(),
				 "aai_status"=>0
			   ];
			  DB::init()->insert("apply_author_info",$arr);
		      returnMsg(200,"作者申请信息已经发送，请等待处理"); 
		  }else{
		    $this->display('user/applyauthor.tpl');
		  }
	  }
  }
?>