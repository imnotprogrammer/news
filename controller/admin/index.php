<?php
  class IndexController extends Controller{
	  public function __construct(){
		 isLogin();
		if(!isAdmin()){
		    header('location:/index/error');
		}  
	  }
	  public function getInfo($tablename,$start,$field){
		  $query =  Query::init();
		  $data['list'] =  $query->from($tablename)
		                         //->andWhere('ni_status=0')
								 ->innerJoin("user_info",'ui_no=aai_uno')
		                         ->offset($start)
		                         ->limit(PER_NUM_COUNT)
								 ->orderby($field.' desc')
		                         ->all();
		  $data['count'] = $query->count();
		  
		  return $data;
	  }
      public function getCheckAuthor($start){
		  $query = Query::init();
		  $data['list'] = $query->select('ni_no,ni_if_img_text,ni_title,ui_name,ni_ctime,ui_header,ni_status')
		                       ->from('news_info')
		                        ->innerJoin('user_info','ni_uno=ui_no')
								
								 ->orderby('ni_ctime desc')
		                         ->limit(PER_NUM_COUNT)								 
								 ->offset($start)
		                         ->all();
		  $data['count'] = $query->count();
		  //print_r($data);
		  return $data;
		  
	  }
	  
	  public function getAuthor($start,$type=2){
		  //$query =  Query::init();
          
			
			$sql = 'select ui_no,ui_type,ui_name,ui_header,ui_status,ui_ctime  from user_info 
			        inner join news_info on ui_no=ni_uno where ui_type=? limit %d,10';
			        //where ui_no=(select ni_uno from news_info)';
		    $db = DB::init();
			$sql = sprintf($sql,$start);
		    $data['list'] = $db->exec($sql,[$type],103);
		    $data['count'] = $db->exec($sql,[$type],101);
          
		  
		  return $data;
	  }
	  public function getPubUser($start,$type){
		  $sql = 'select ui_email,ui_phone,ui_no,ui_type,ui_name,ui_header,ui_status,ui_ctime  from user_info 
			        where ui_type=? limit %d,10';
		$sql1 = 'select count(*) from user_info 
			        where ui_type=?';
		  $db = DB::init();
			$sql = sprintf($sql,$start);
		    $data['list'] = $db->exec($sql,[$type],103);
		    $data['count'] = $db->exec($sql1,[$type],101);
			return $data;
	  }
	  public function indexAction(){
		  list($page,$start) = getPage(PER_NUM_COUNT);
		  $needcheck = $this->getCheckAuthor($start);
		  //print_r($needcheck);
		  $page = new Page($needcheck['count'],PER_NUM_COUNT);
		  $this->assign("needcheck",$needcheck['list']);
		  $this->assign("page",$page->fpage());
		  $this->display('admin/needcheck.tpl');
	  }
	  /*public function passnewsAction(){
		  $this->display('admin/passnews.tpl');
	  }*/
	  //申请作者
	  public function checkauthorAction(){
		  list($page,$start) = getPage(PER_NUM_COUNT);
		  $authr =  $this->getInfo("apply_author_info",$start,'aai_ctiime'); //apply_author_info;
		  $page = new Page($authr['count'],PER_NUM_COUNT);
		  $this->assign("page",$page->fpage());
		  $this->assign("authr",$authr['list']);
		  $this->display('admin/checkauthor.tpl');
		  
		  //$this->display("admin/checkauthor.tpl");
	  }
	 // 已经存在的作者
	  public function authorinfoAction(){
		  list($page,$start) = getPage(PER_NUM_COUNT);
		  $in = $this->getPubUser($start,2);
		  foreach($in['list'] as $info){
			  $num = Query::init()->select('count(*) as num')->from('news_info')->andWhere('ni_uno=?',[$info['ui_no']])->one();
			  $sum = Query::init()->select('sum(ni_count) as sum')->from('news_info')->andWhere('ni_uno=?',[$info['ui_no']])->one();
			  $info['num'] = $num['num'];
			  $info['sum'] = $sum['sum'];
			  $rs[]=$info;
		  }
		  //print_r($rs);
		  $this->assign('info',$rs);
		  $page = new Page($in['count'],PER_NUM_COUNT);
		  $this->assign("page",$page->fpage());
		  $this->display('admin/authorinfo.tpl');
	  }
	  public function userinfoAction(){
		  list($page,$start) = getPage(PER_NUM_COUNT);
		  $in = $this->getPubUser($start,1);
		 // print_r($in);
		  //print_r($rs);
		  $this->assign('info',$in['list']);
		  $page = new Page($in['count'],PER_NUM_COUNT);
		  $this->assign("page",$page->fpage());
		  $this->display('admin/userinfo.tpl');
	  }
	  public function newstypeAction(){
		  $type = Query::init()->from('news_type_info')->all();
		  $this->assign('type',$type);
		  $this->display('admin/newstype.tpl');
	  }
	  public function addtypeAction(){
		  if($_POST){
			  if(Query::init()->from("news_type_info")->andWhere("nti_name=?",[$_POST['nti_name']])->one()){
				  returnMsg(201,"该新闻类型已经存在！");
				  exit;
			  }
			  DB::init()->insert('news_type_info',array("nti_name"=>$_POST['nti_name'],"nti_ctime"=>time()));
			  returnMsg(200,"添加新闻类型成功");
		  }else{
		    $this->display("admin/addtype.tpl");
		  }
	  }
	  public function deltypeAction(){
		  if($_POST){
			  DB::init()->exec("delete from news_type_info where nti_no=?",[$_POST['no']]);
			  returnMsg(200,"删除成功");
		  }
	  }
	  public function forbidAction(){
		  if($_POST){
			  if($_POST['type'] ==1){
				  DB::init()->update("user_info",array("ui_status"=>0),array("ui_no"=>$_POST['uno']));
				  returnMsg(200,"已成功封号");
			  }else{
				   DB::init()->update("user_info",array("ui_status"=>1),array("ui_no"=>$_POST['uno']));
				  returnMsg(200,"已成功解封");
				  
			  }
		  }
	  }
	  public function newsdetailAction(){
		  if($_GET){
			 
			 $loneynews = Query::init()->from("news_info")->andWhere("ni_no=?",[$_GET['no']])->one();
			 $type = Query::init()->select('nti_name')->from("news_type_info")->andWhere("nti_no=?",[$loneynews['ni_type']])->one();
			 $this->assign("news",$loneynews);
			 $this->assign("type",$type['nti_name']);
			 if($_GET['type']==1){
				 $user =  new User();
				  $this->assign("picnews",$user->getOnePic($_GET['no']));
			 }
		     $this->display("admin/detailnews.tpl");
		  }
	  }
	  public function newscheckAction(){
		  if($_POST){
			  DB::init()->update("news_info",array("ni_status"=>$_POST['type']),array("ni_no"=>$_POST['no']));
			  if($_POST['type']==2){
				  returnMsg(200,"已将新闻成功发布");
			  }else{
				  returnMsg(201,"已将新闻退回给作者！");
			  }
		  }
	  }
	  public function authorAction(){
		  if($_POST){
			  extract(safe_extract($_POST));
			  $db= DB::init();
			  if($type ==2){
				  $db->update("apply_author_info",array('aai_status'=>1,"aai_desc"=>$desc),array("aai_no"=>$ano));
				  $db->update("user_info",array("ui_type"=>2),array('ui_no'=>$uno));
				  $db->insert("user_message_info",array("umi_sno"=>getUno(),"umi_title"=>"作者申请通知","umi_body"=>"你的作者申请已经同意了！","umi_uno"=>$uno,"umi_ctime"=>time(),"umi_status"=>0));
				  returnMsg(200,"已经同意作者申请");
			  }else{
				  $db->update("apply_author_info",array('aai_status'=>1,"aai_desc"=>$desc),array("aai_no"=>$ano));
				 $db->insert("user_message_info",array("umi_sno"=>getUno(),"umi_title"=>"作者申请通知","umi_body"=>"你的作者申请已经被拒绝了！","umi_uno"=>$uno,"umi_ctime"=>time(),"umi_status"=>0));
				  returnMsg(203,"已经拒绝该作者申请！");
			  }
		  }else{}
	  }
  }
?>