<?Php
class informationController extends Controller{
    
    public function __construct(){
        isLogin();
        if( !isAdmin() ){
            header("location:/");
            exit;
        }  
    }
    
    public function commonuserAction(){
        
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('user_info');
        if( $type == "nologin" ){
            $Query->andWhere('ui_power=0');
        }elseif( $type == 'admin' ){
            $Query->andWhere('ui_type=3');
        }elseif( $type == 'common' ){
            $Query->andWhere('ui_type=1');
        }elseif( $type == 'shopuser' ){
            $Query->andWhere('ui_type=2');
        }
        
        if( $search ){
            $Query->orLikes(['ui_phone'=>$search,'ui_email'=>$search,'ui_name'=>$search,'ui_no'=>$search]);
        }
        $users = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('users',$users);
        $this->assign('page',$Page->fpage());
        $this->display('admin/commonuser.tpl');
    }
    
    public function disableLoginAction(){
        
        $uno = $_POST['uno'];
        $status = $_POST['status'];  
        $db = DB::init();
        if( $status == 0 ){
            $ui_power = 0;
        }else{
            $ui_power = 1;
        }
        if( $ui_power ==0 && Query::init()->from('user_info')->andWhere('ui_type=3 and ui_no=?',$uno)->one() ){
            returnMsg(200,'不能禁止管理登录！');
        }
        
        $db->update('user_info',['ui_power'=>$ui_power],['ui_no'=>$uno]);
        returnMsg(200,'操作成功！');  
        
    }
    
    public function shopuserAction(){
        
        $search = $type = $order = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('user_info')->leftJoin('shoper_info','ui_no=si_uno');
        if( $type == "nowork" ){
            $Query->andWhere('si_status=3');
        }elseif( $type == 'audit' ){
            $Query->andWhere('si_status=1');
        }elseif( $type == 'blacklist' ){
            $Query->andWhere('si_status=4');
        }
        
        if( $search ){
            $Query->orLikes(['si_name'=>$search]);
        }
        
        if( $order == 'withdrash' ){
            $Query->orderby('ui_withdraw desc');
        }elseif( $order == ''){
            $Query->orderby('si_collect desc');
        }else{
            $Query->orderby('si_ctime desc');
        }
        $users = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('users',$users);
        $this->assign('page',$Page->fpage());
        
        $this->display('admin/shopuser.tpl');
    }
    
    public function changeShopStatusAction(){
        $sno = $_POST['sno'];
        $status = $_POST['status'];
        $db = DB::init();
        $db->update('shoper_info',['si_status'=>$status],['si_no'=>$sno]);
        returnMsg(200,'操作成功！');
    }
    
    public function goodsAction(){
         $search = $type = $order = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        
        $Query->from('goods_info');
        
        if( $type == "nowork" ){
            $Query->andWhere('gi_status=3');
        }elseif( $type == 'audit' ){
            $Query->andWhere('gi_status=1');
        }
        
        if( $search ){
            $Query->orLikes(['gi_name'=>$search]);
        }
        
        if( $order == 'collectnum'){
            $Query->orderby('gi_collect desc');
        }else{
            $Query->orderby('gi_ctime desc');
        }
        
        $goods = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('goods',$goods);
        $this->assign('page',$Page->fpage());
        $this->display('admin/goods.tpl');
    }
    
    public function changeGoodsStatusAction(){
        $gno = $_REQUEST['gno'];
        $status = $_REQUEST['status'];
        $db = DB::init();
        $db->update('goods_info',['gi_status'=>$status],['gi_no'=>$gno]);
        returnMsg(200,'操作成功！');    
    }
    
    public function harvestaddressAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('user_delivery_address_info');
        
        if( $search ){
            $Query->like('udai_uname',$search);
        }
        
        $userAddress = $Query->orderby('udai_no desc')->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('userAddress',$userAddress);
        $this->assign('page',$Page->fpage());
        $this->display('admin/harvestaddress.tpl');
    }
    
    public function joblistAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('shoper_job_info')->leftJoin('shoper_info','sji_sno=si_no');
        if( $type == "nowork" ){
            $Query->andWhere('sji_status=3');
        }elseif( $type == 'audit' ){
            $Query->andWhere('sji_status=1');
        }elseif( $type == 'delete' ){
            $Query->andWhere('sji_status=4');
        }
        
        if( $search ){
            $Query->orLikes(['sji_name'=>$search]);
        }
        
        $jobs = $Query->orderby('sji_ctime desc')->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('jobs',$jobs);
        $this->assign('page',$Page->fpage());
        $this->display('admin/joblist.tpl');
    }
    
    public function changeJobStatusAction(){
        $jno = $_REQUEST['jno'];
        $status = $_REQUEST['status'];
        $db = DB::init();
        $db->update('shoper_job_info',['sji_status'=>$status],['sji_no'=>$jno]);
        returnMsg(200,'操作成功！');
    }
    
    public function withdrawcashhistoryAction(){
        
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('withdraw_apply_info');
        
        $withdraws = $Query->orderby('wai_no desc')->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('withdraws',$withdraws);
        $this->assign('page',$Page->fpage());
        $this->display('admin/withdrawcashhistory.tpl');
    }
    
    
    public function returngoodshistoryAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('return_goods_apply_info');
        
        $returnGoodsApplys = $Query->orderby('rgai_no desc')->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('returnGoodsApplys',$returnGoodsApplys);
        $this->assign('page',$Page->fpage());
        $this->display('admin/returngoodshistory.tpl');
    }
    
    public function insdeletterAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Query = new Query();
        $Query->from('user_message_info');
        
        $userMessages = $Query->orderby('umi_no desc')->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('userMessages',$userMessages);
        $this->assign('page',$Page->fpage());
        $this->display('admin/insdeletter.tpl');
    }
    
}