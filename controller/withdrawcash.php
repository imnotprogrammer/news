<?php
class withdrawcashController extends Controller {
    
    public function listAction(){
        $type = '';
        extract( safe_extract($_REQUEST) );
        list($page,$start) = getPage(PER_PAGE_COUNT);
        $uno = getUno();
        $Query = Query::init();
        $Query->from('withdraw_apply_info');
        $Query->andWhere('wai_uno=?',$uno);
        
        if( $type == 'wait' ){
            $Query->andWhere('wai_atime=0');
        }elseif( $type == 'complete' ){
            $Query->andWhere('wai_atime!=0');
        }
        
        $Query->limit(PER_PAGE_COUNT)->offset($start);
        
        $withdraws = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('withdraws',$withdraws);
        $this->assign('page',$Page->fpage());
        $this->display('user/withdrawcash_list.tpl');
    }
    
    public function addAction(){
        $uno = getUno();
        $userInfo = Query::init()->from('user_info')->andWhere('ui_no=?',$uno)->one();
        $this->assign('userInfo',$userInfo);
        $this->display('user/withdrawcash_add.tpl');
    }
    
    public function doAddAction(){
        
        $password = $money = "";
        
        extract( safe_extract($_REQUEST) );
        $uno =getUno();
        
        if( !$password ){
            returnMsg(104,'提现密码不能为空！');
        }
        
        if( !$money ){
            returnMsg(104,'提现金额不能为空！');
        }
        
        $userInfo = Query::init()->select('*')->from("user_info")->andWhere('ui_no=?',[$uno])->one();
        
        if( $userInfo['ui_withdraw_pass'] != md5_encrypt($password) ){
            returnMsg(104,'提现密码不正确！');
        }
        
        $poundage = getPoundage($money);
    
        $Record = new Record();
        $Record->wai_uno = $uno;
        $Record->wai_money=$money;
        $Record->wai_ctime = time();
        $Record->wai_poundage = $poundage;
        
        $db = DB::init();
        $db->beginTransaction();
        
        $status = $db->insert('withdraw_apply_info',$Record);
        
        $status = $db->exec('update user_info set ui_withdraw=ui_withdraw-? where ui_withdraw-?>=0 and ui_no=?',[$money+$poundage,$money+$poundage,$uno]);
        
        if( $status && $db->rowCount() == 1 ){
             $db->commit();
        }else{
            $db->rollBack();
            $status = false;
        }
        
        if( $status ){
            returnMsg(200,'添加提现申请成功！');
        }else{
            returnMsg(104,'提现金额不正确！');
        }
    }
    
}