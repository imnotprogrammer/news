<?php
class NewsController extends Controller{
    public function __construct(){
		$alltype = Query::init()->from('news_type_info')->all();
		$this->assign("alltype",$alltype);
	}
    public function indexAction(){
       if($_GET){ 
	   $user = new User();
	      DB::init()->exec('update news_info set ni_browser=ni_browser+1 where ni_no=?',[$_GET['no']]);
	     $onedata = Query::init()->from('news_info')->andWhere("ni_no=?",[$_GET['no']])->one();
		 $this->assign("onedata",$onedata);
		 $this->assign("right",$user->getTabNews());
		 $this->assign("comment",$user->getComment($_GET['no'],0));
		 $this->assign('page',10);
		 
		 if($_GET['type']==0){
            $this->display("pub_news_detail.tpl");
		 }else{
			 $this->assign("picnews",$user->getOnePic($_GET['no']));
			$this->display("img_news_detail.tpl"); 
		 }
	   }
    }
	public function newslistAction(){
		if($_GET)
		{
			list($page,$start) = getPage(PER_NUM_COUNT);
			extract(safe_extract($_GET));
			$user = new User();
			
			
			if($type==100){
			   $data=$user->getFavoNews(getUno(),$start);
			   $this->assign("title",'我的兴趣');
			}else{
				$title = Query::init()->select('nti_name')->from('news_type_info')->andWhere('nti_no=?',[$type])->one();
				$data=$user->getTypeNews($type,$start);
				$this->assign("title",$title['nti_name'].'新闻');
			}
			//print_r($data);
			
			$page =  new Page($data['count'],PER_NUM_COUNT);
			$this->assign("lists",$data['list']);
			
			$this->assign("page",$page->fpage());
			$this->assign("right",$user->getTabNews());
			$this->display("list_detail.tpl");
		}
	}
	public function agreeAction(){
		if($_POST){
			DB::init()->exec('update news_info set ni_count=ni_count+1 where ni_no=?',[$_POST['no']]);
			returnMsg(200,"谢谢你对作者的赞赏");
		}
	}
	public function collectAction(){
		if($_POST){
			if(!isset($_SESSION['news']['uno'])){
				returnMsg(201,"你还没有登录");
			}else{
				$arr = [
				    "cni_no"=>uniqid(),
					"cni_uno"=>getUno(),
					"cni_nno"=>$_POST['no'],
					"cni_ctime"=>time()
				];
				DB::init()->insert("collect_news_info",$arr);
				returnMsg(200,"收藏成功");
			}
		}
	}
	public function commentAction(){
		if($_POST){
			if(isset($_SESSION['news']['uno'])&&!empty($_SESSION['news']['uno'])){
			$comment = [
			    'ci_no'  => uniqid(),
			    'ci_uno' => getUno(),
				'ci_nno' => $_POST['no'],
				'ci_ctime' => time(),
				'ci_body'  => $_POST['comment']
			];
			DB::init()->insert('comment_info',$comment);
			returnMsg(200,"评论成功!");
			}else{
				returnMsg(201,"你还没有登录，赶快去登录吧");
			}
			
		}
	}
	public function getmoreAction(){
		if($_POST){
			$user = new User();
			$start = isset($_POST['pg'])?$_POST['pg']:10;
			
			 
	       if($user->getComment($_POST['no'],intval($start))){
				returnMsg(200,json_encode($user->getComment($_POST['no'],intval($start))));
			}else{
				returnMsg(201,"没有更多评论了");
			}
            			
		}
	}
}