<?php
class UserotherController extends Controller{
    
    public function incomeAction(){
        $type = '';
        extract( safe_extract($_REQUEST) );
        list($start,$page) = getPage(PER_PAGE_COUNT);
        
        $sql = 'select %s from user_income_pay_info';
        $Csql = new Csql($sql,'*');
        
        if( $type == 'in' ){
            $Csql->ac('uipi_type=0');
        }elseif( $type == 'out' ){
            $Csql->ac('uipi_type=1');
        }
        
        $db = DB::init();
        list($incomes,$count) = $Csql->getList($db);
        
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('incomes',$incomes);
        $this->assign('page',$Page->fpage());
        $this->display('user/income.tpl');
    }
    
    public function withdrawCashAction(){
        $type = '';
        extract( safe_extract($_REQUEST) );
        list($start,$page) = getPage(PER_PAGE_COUNT);
        
        $sql = 'select %s from withdraw_apply_info';
        $Csql = new Csql($sql,'*');
        
        if( $type == 'wait' ){
            $Csql->ac('wai_atime=0');
        }elseif( $type == 'complete' ){
            $Csql->ac('wai_atime!=0');
        }
        
        $db = DB::init();
        list($withdraws,$count) = $Csql->getList($db);
        
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('withdraws',$withdraws);
        $this->assign('page',$Page->fpage());
        $this->display('user/withdrawcash.tpl');
    }
    
}