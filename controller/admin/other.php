<?php
    class OtherController extends Controller{
		public function __construct(){
			 isLogin();
		if(!isAdmin()){
		    header('location:/index/error');
		}
		}
		public function findpassAction(){
			if(!$_POST){
				
					list($page,$start) = getPage(PER_NUM_COUNT);
					$query = new Query();
					$data['list'] = $query->select('ui_name,ui_no,ui_header,afi_ctime,afi_status')
										 ->from('user_info')
										 ->innerJoin('apply_findpass_info',"ui_no=afi_uno")
										 ->offset($start)->limit(PER_NUM_COUNT)
										 ->orderby('afi_ctime desc')
										 ->all();
										 
					$page = new Page($query->count(),PER_NUM_COUNT);
					$this->assign('page',$page->fpage());
					$this->assign('findpass',$data['list']);			
					$this->display("admin/findpass.tpl");
					
			}else{
				
				  $userinfo = Query::init()->from('user_info')->andWhere('ui_no=?',[$_POST['uno']])->one();
				  $pass = uniqid();
                  $str = SendEmail::send($userinfo['ui_email'],$pass);
				  
				  DB::init()->update('user_info',array("ui_pass"=>$pass),array("ui_no"=>$_POST['uno']));
				  DB::init()->update('apply_findpass_info',array("afi_status"=>1),array("afi_uno"=>$_POST['uno']));
				  DB::init()->insert("user_message_info",array('umi_uno'=>$userinfo['ui_no'],'umi_title'=>"找回密码通知",'umi_body'=>'你的密码已经重置，登录之后，请重新设置密码','umi_ctime'=>time(),'umi_sno'=>getUno(),'umi_status'=>0));
				  returnMsg(200,$str);
				
			}
		}
		public function commentAction(){
			
			list($page,$start) =  getPage(PER_NUM_COUNT);
			$query   = new Query();
			$comment = $query->from('comment_info')->orderby('ci_ctime desc')
			                                       ->innerJoin('user_info',"ci_uno=ui_no")
												   ->innerJoin("news_info",'ci_nno=ni_no')
			                                               ->offset($start)->limit(PER_NUM_COUNT)
														   ->all();
			$page    = new Page($query->count(),PER_NUM_COUNT);
			$this->assign("comment",$comment);
			$this->assign("page",$page->fpage());
			$this->display("admin/comment.tpl");
			
		}
		public function noteAction(){
			list($page,$start) =  getPage(PER_NUM_COUNT);
			$query   = new Query();
			$comment = $query->from('note_info')->orderby('n_ctime desc')
			                                       ->innerJoin('user_info',"n_uno=ui_no")
												   //->innerJoin("news_info",'ci_nno=ni_no')
			                                               ->offset($start)->limit(PER_NUM_COUNT)
														   ->all();
			$page    = new Page($query->count(),PER_NUM_COUNT);
			$this->assign("note",$comment);
			$this->assign("page",$page->fpage());
			$this->display("admin/note.tpl");
		}
		public function sendmessAction(){
			if($_POST){
				extract(safe_extract($_POST));
				$uno = Query::init()->select('ui_no')->from('user_info')->andWhere('ui_name=?',[$umi_name])->one();
				
				if($type == 1){
					$alluser = Query::init()->select('ui_no')->from('user_info')->all();
				  foreach($alluser as $user){
					  $arr = [
						   'umi_title' => $umi_title,
						   'umi_body'  => $umi_body,
						   'umi_ctime' => time(),
						   'umi_uno'   => $user['ui_no'],
						   'umi_sno'   => getUno(),
						   'umi_status'=> 0,
				      ];
				     DB::init()->insert("user_message_info",$arr);
				  }
				}else{
					if(!$uno){
						returnMsg(201,"没有此用户！发送消息失败");
						exit;
					}
					$arr = [
					   'umi_title' => $umi_title,
					   'umi_body'  => $umi_body,
					   'umi_ctime' => time(),
					   'umi_uno'   => $uno['ui_no'],
					   'umi_sno'   => getUno(),
					   'umi_status'=>0,
                   ];
				   DB::init()->insert("user_message_info",$arr);
				}
				returnMsg(200,"发送消息成功");
			}else{
			   $this->display('admin/sendmess.tpl');
			}
		}
		public function replyAction(){
			if($_POST){
				$info = Query::init()->from('note_info')->andWhere('n_no=?',[$_POST['no']])->one();
				DB::init()->update('note_info',array('n_reply'=>$_POST['desc'],'n_status'=>1),array('n_no'=>$_POST['no']));
				DB::init()->insert('user_message_info',array('umi_title'=>'留言回复通知','umi_body'=>$_POST['desc'],'umi_sno'=>getUno(),'umi_ctime'=>time(),'umi_status'=>0,'umi_uno'=>$info['n_uno']));
				returnMsg(200,'回复成功');
			}
		}
		public function donteinfoAction(){}
	}
?>