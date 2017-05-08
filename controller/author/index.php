<?php
    class indexController extends Controller{
		public function __construct(){
			isLogin();
			if(!isShopUser()){
			  header('location:/index/error');
		  }
			$messnum =Query::init()->select('umi_no')->from('user_message_info')->andWhere('umi_status=0 and umi_uno=?',[getUno()])->count();
		$this->assign('messcount',$messnum);
		}
		public function indexAction(){
			list($page,$start) = getPage(PER_NUM_COUNT);
			$news = new Query();
			$data['list'] = $news->from('news_info')
			             ->innerJoin('news_type_info','nti_no=ni_type')
			             ->andWhere('ni_uno=?',[getUno()])
			             ->offset($start)
						 ->limit(PER_NUM_COUNT)
						 ->orderby('ni_ctime desc')
						 
						 ->all();
						 //print_r($data['list']);
			$page =new Page($news->count(),PER_NUM_COUNT);
            $this->assign("news",$data['list']);
            $this->assign("page",$page->fpage());			
			$this->display("author/news_list.tpl");
		}
		public function newsdetailAction(){
			if($_GET){
				extract(safe_extract($_GET));
				$onedata = Query::init()->from('news_info')->andWhere('ni_no=?',[$no])->one();
				$type=Query::init()->select('nti_name')->from('news_type_info')->andWhere('nti_no=?',[$onedata['ni_type']])->one();
				$this->assign('news',$onedata);
				$this->assign('type',$type['nti_name']);
				$this->display('author/newsdetail.tpl');
			}
		}
		public function authorAction(){
			//$this->display("author/shop_modify.tpl");
		}
       public function addnewsAction(){
            if($_POST){
               extract(safe_extract($_POST));
                
				if(isset($_POST['mdino'])){
					$mdinews = [
                    
                    'ni_title' => $ni_title,
                     'ni_body' => $editorValue,
                     'ni_type' => $ni_type,
                     'ni_status'=> 0,
                     'ni_if_img_text' =>0,
                     //'ni_uno'  => getUno(),
                      //'ni_ctime' => time(),
                      //'ni_count' => 0,
                      'ni_desc'  => '',
                       'ni_admin'=>'',
                       'ni_img_news'=>'',
					   'ni_browser'=>0
                 ];
				    DB::init()->update('news_info',$mdinews,array('ni_no'=>$_POST['mdino']));
				    returnMsg(200,"成功修改新闻，请等待审核！");
				}else{
					 $news = [
                     'ni_no'   => uniqid(),
                    'ni_title' => $ni_title,
                     'ni_body' => $editorValue,
                     'ni_type' => $ni_type,
                     'ni_status'=> 0,
                     'ni_if_img_text' =>0,
                     'ni_uno'  => getUno(),
                      'ni_ctime' => time(),
                      'ni_count' => 0,
                      'ni_desc'  => '',
                       'ni_admin'=>'',
                       'ni_img_news'=>'',
					   'ni_browser'=>0
                 ];
                    DB::init()->insert('news_info',$news);
                    returnMsg(200,"成功添加新闻，请等待审核！");
				}
            }else{
				if($_GET){
					$onedata = Query::init()->select()->from('news_info')->andWhere('ni_no=?',[$_GET['no']])->one();
					$this->assign("onedata",$onedata);
				}
            $type=Query::init()->from('news_type_info')->all();
            $this->assign("alltype",$type);
			$this->display("author/addnews.tpl");
           }
        }
        public function addpicnewsAction(){
			if($_POST){
				extract(safe_extract($_POST));
				$imgpath = file_get_contents("http://localhost/img-news/".getUno().".txt");
				file_put_contents(WEB_ROOT."/img-news/1.txt",$imgpath.'   \n');
				$arrpath = explode(',',$imgpath);
				$headlogo = $arrpath[0];
				 if(empty($picstr)){
				    if(!$imgpath){					
					    returnMsg(201,'请点击添加新闻按钮之前上传图片');
					    exit;				  
				   }
				}
				if(isset($picstr)){
					$data=Query::init()->select('ni_img_news')->from('news_info')->andWhere('ni_no=?',[$mdino])->one();
					$achstr=$picstr.',';
					$imgpath=$imgpath.str_replace($achstr,"",$data['ni_img_news']);
					file_put_contents("ss.txt",$achstr.'  '.$data['ni_img_news']);
					$arr = [
					     
						 'ni_type'=>$type,
						 'ni_title'=>$title,
						 'ni_body'=>$desc,
						 'ni_uno'=>getUno(),
						 'ni_img'=>$headlogo,
						 'ni_img_news'=>$imgpath,
						 'ni_if_img_text'=>1,
						 'ni_ctime'=>time(),
						 'ni_status'=>0,
						 'ni_count'=>0,
						 'ni_admin'=>'',
						 'ni_desc'=>'',
						 'ni_browser'=>0
					];
					DB::init()->update('news_info',$arr,array("ni_no"=>$mdino));
					file_put_contents(WEB_ROOT."/img-news/".getUno().".txt",'');
					returnMsg(202,"修改新闻成功!");
				}else{
					$arr = [
					     'ni_no'=>uniqid(),
						 'ni_type'=>$type,
						 'ni_title'=>$title,
						 'ni_body'=>$desc,
						 'ni_uno'=>getUno(),
						 'ni_img'=>$headlogo,
						 'ni_img_news'=>$imgpath,
						 'ni_if_img_text'=>1,
						 'ni_ctime'=>time(),
						 'ni_status'=>0,
						 'ni_count'=>0,
						 'ni_admin'=>'',
						 'ni_desc'=>'',
						 'ni_browser'=>0
					];
					file_put_contents(WEB_ROOT."/img-news/1.txt",$imgpath);
					DB::init()->insert('news_info',$arr);
					file_put_contents(WEB_ROOT."/img-news/".getUno().".txt",'');
					returnMsg(200,"添加图片新闻成功!");
				}	
			}else{
				if($_GET){
					$onedata = Query::init()->select()->from('news_info')->andWhere('ni_no=?',[$_GET['no']])->one();
					$this->assign("onedata",$onedata);
				}
				$type=Query::init()->from('news_type_info')->all();
				$this->assign("alltype",$type);
				$this->display("author/addpicnews.tpl");
			}
		}
        public function commentAction(){
               list($page,$start) = getPage(PER_NUM_COUNT);
			$news = new Query();
			$data['list'] = $news->from('news_info')
			             ->innerJoin('news_type_info','nti_no=ni_type')
			             ->andWhere('ni_uno=?',[getUno()])
			             ->offset($start)
						 ->limit(PER_NUM_COUNT)
						 ->orderby('ni_ctime desc')
						 
						 ->all();
						 //print_r($data['list']);
			$page =new Page($news->count(),PER_NUM_COUNT);
            foreach($data['list'] as $data){
                $temp = $data;
                $count = Query::init()->select('count(*) as comm_count')->from('comment_info')->andWhere('ci_nno=?',[$data['ni_no']])->all();
                $temp['comm_count'] = $count[0]['comm_count'];
                $rs[] = $temp;
            }
            $this->assign("comment",$rs);
            $this->assign("page",$page->fpage());
            
            $this->display('author/comment.tpl');
        }
        public function allcommentAction(){
             if($_GET){
                 list($page,$start) = getPage(PER_NUM_COUNT);
                 $Query = new Query();
                 $allcomment = $Query->from('comment_info')
                                     ->innerJoin('user_info','ui_no=ci_uno')
                                     ->andWhere('ci_nno=?',[$_GET['no']])
                                     ->offset($start)
                                     ->limit(PER_NUM_COUNT)
                                     ->all();
                $page = new Page($Query->count(),PER_NUM_COUNT);
                $this->assign('page',$page->fpage());
                $this->assign('comment',$allcomment);
                $this->assign('title',$_GET['title']);
                $this->display('author/detailcomment.tpl');
             }
        }
       public function browserAction(){
		  
                 list($page,$start) = getPage(PER_NUM_COUNT);
                 $Query = new Query();
                 $allcomment = $Query->from('news_info')
                                     //->innerJoin('user_info','ui_no=ci_uno')
                                     ->andWhere('ni_uno=?',[getUno()])
                                     ->offset($start)
                                     ->limit(PER_NUM_COUNT)
									 ->orderby('ni_browser desc')
                                     ->all();
                $page = new Page($Query->count(),PER_NUM_COUNT);
                $this->assign('page',$page->fpage());
                $this->assign('news',$allcomment);
                //$this->assign('title',$_GET['title']);
                $this->display('author/browser.tpl');
        }
		
	   
	}
?>