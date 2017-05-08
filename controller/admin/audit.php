<?php
class AuditController extends Controller{
    
    public function __construct(){
        isLogin();
        if( !isAdmin() ){
            header("location:/");
            exit;
        }  
    }
    
    public function shopauditAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        $Query = Query::init();
        list($page,$start) = getPage(PER_PAGE_COUNT);
        $Query->select('*')->from('shoper_info')->andWhere('si_status=1')->limit(PER_PAGE_COUNT);
        $Query->offset($start);
        if( $search ){
            $Query->like('si_name',$search);
        }
        
        $shops = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('shops',$shops);
        $this->assign('page',$Page->fpage());
        $this->display('admin/audit-shop.tpl');
    }
    
    public function shopAuditDetailAction(){
        $sno = $_GET['sno'];
        $shop = Query::init()->select('*')->from('shoper_info')->andWhere('si_no=?',$sno)->one();  
        $shop['prov'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$shop['si_pro'])->one();
        $shop['city'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$shop['si_city'])->one();
        $shop['area'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$shop['si_area'])->one();
        $this->assign('shop',$shop);
        $this->display('admin/audit-shop-detail.tpl');
          
    }
    
    public function auditShopDoAction(){
        
        $sno = $type = $desc = "";
        extract( safe_extract($_REQUEST) );
        $db = DB::init();
        if( $type == 1 ){
            
            $msg = '~亲，店铺审核成功！';
            $title = '店铺审核成功';
            $si_status = 2;
            
        }else{
            $msg = $desc;
            $title = '店铺审核没有通过';
            $si_status = 3;
        }
        
        $status = $db->update('shoper_info',['si_status'=>$si_status],['si_no'=>$sno]);
        if( !$status ){
            returnMsg(104,'操作失败！');
        }
        
        $Record = new Record();
        $Record->umi_title = $title;
        $Record->umi_body = $msg;
        $Record->umi_ctime = time();
        $Record->umi_status = 2;
        $Record->umi_uno = Query::init()->select('ui_no')->from('user_info')->leftJoin('shoper_info','ui_no=si_uno')->column();
        $db->insert('user_message_info',$Record);
        returnMsg(200,'操作成功！');
        
    }
    
    
    public function goodsauditAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        $Query = Query::init();
        list($page,$start) = getPage(PER_PAGE_COUNT);
        $Query->select('*')->from('goods_info')->andWhere('gi_status=1')->limit(PER_PAGE_COUNT);
        $Query->offset($start);
        if( $search ){
            $Query->like('gi_name',$search);
        }
        
        $goods = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('goods',$goods);
        $this->assign('page',$Page->fpage());
        $this->display('admin/audit-goods.tpl');
    }
    
    public function auditGoodsDoAction(){
        
        $gno = $type = $desc = "";
        extract( safe_extract($_REQUEST) );
        $db = DB::init();
        if( $type == 1 ){
            
            $msg = '~亲，商品审核成功！';
            $title = '商品审核成功';
            $gi_status = 2;
            
        }else{
            $msg = $desc;
            $title = '商品审核没有通过';
            $gi_status = 0;
        }
        
        $status = $db->update('goods_info',['gi_status'=>$gi_status],['gi_no'=>$gno]);
        if( !$status ){
            returnMsg(104,'操作失败！');
        }
        
        $Record = new Record();
        $Record->umi_title = $title;
        $Record->umi_body = $msg;
        $Record->umi_ctime = time();
        $Record->umi_status = 2;
        $Record->umi_uno = Query::init()->select('ui_no')->from('user_info')->leftJoin('shoper_info','ui_no=si_uno')->column();
        $db->insert('user_message_info',$Record);
        returnMsg(200,'操作成功！');
        
    }
    
    public function goodsAuditDetailAction(){
        $gno = $_GET['gno'];
        $goods = Query::init()->select('*')->from('goods_info')->andWhere('gi_no=?',$gno)->one();  
        $goods['prov'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$goods['gi_pro'])->one();
        $goods['city'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$goods['gi_city'])->one();
        $goods['area'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$goods['gi_area'])->one();
        $goods['imglist'] = explode(',',$goods['imglist']);
        $this->assign('goods',$goods);
        $this->display('admin/audit-goods-detail.tpl');
          
    }
    
    public function jobauditAction(){
        
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        $Query = Query::init();
        list($page,$start) = getPage(PER_PAGE_COUNT);
        $Query->select('*')->from('shoper_job_info')->andWhere('sji_status=1')->limit(PER_PAGE_COUNT);
        $Query->offset($start);
        if( $search ){
            $Query->like('sji_sno',$search);
        }
        
        $shoperjoblist = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('shoperjoblist',$shoperjoblist);
        $this->assign('page',$Page->fpage());

        $this->display('admin/audit-job.tpl');//audit-job-detail.tpl
    }
    public function getjobauditoneAction(){
        $sno = "";
        extract( safe_extract($_REQUEST) );
        $Query = Query::init(); 
        $shoperjoblist = Query::init()->select('*')->from('shoper_job_info')->andWhere('sji_no=?',$sno)->one();
        $shoperjoblist['prov'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$shoperjoblist['sji_pro'])->one();
        $shoperjoblist['city'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$shoperjoblist['sji_city'])->one();
        $shoperjoblist['area'] = Query::init()->from('prov_city_area_info')->andWhere('pcai_no',$shoperjoblist['sji_area'])->one();
        //$shoperjoblist['imglist'] = explode(',',$shoperjoblist['imglist']);
        $this->assign('shoperjoblist',$shoperjoblist);
        $this->display('admin/audit-job-detail.tpl');  
           
    }
    public function auditJobauditDoAction(){
        $sno = $type = $desc = "";
        extract( safe_extract($_REQUEST) );
        $db = DB::init();
        if( $type == 1 ){
            
            $msg = '~亲，招聘审核成功！';
            $title = '招聘审核成功';
            $sji_status = 2;
            
        }else{
            $msg = $desc;
            $title = '招聘商品审核没有通过';
            $sji_status = 0;
        }
        
        $status = $db->update('shoper_job_info',['sji_status'=>$sji_status],['sji_no'=>$sno]);
        if( !$status ){
            returnMsg(104,'操作失败！');
        }
        
        $Record = new Record();
        $Record->umi_title = $title;
        $Record->umi_body = $msg;
        $Record->umi_ctime = time();
        $Record->umi_status = 2;
        $Record->umi_uno = Query::init()->select('ui_no')->from('user_info')->leftJoin('shoper_info','ui_no=si_uno')->column();
        $db->insert('user_message_info',$Record);
        returnMsg(200,'操作成功！');        
    }
    
    public function commentAuditAction(){
        $search = $type = "";
        extract( safe_extract($_REQUEST) );
        $Query = Query::init();
        list($page,$start) = getPage(PER_PAGE_COUNT);//->andWhere('sji_status=1')
        $Query->select('*')->from('goods_comments_info ')->limit(PER_PAGE_COUNT);
        $Query->offset($start);
        if( $search ){
            $Query->like('gci_body',$search);
        }
        
        $goodscommentslist = $Query->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);  
        $this->assign('goodscommentslist',$goodscommentslist);
        $this->assign('page',$Page->fpage());
        
        $this->display('admin/audit-comment.tpl');
    }
    public function getauditcommentAction(){
        $sno = "";
        extract( safe_extract($_REQUEST) );
        $Query = Query::init(); 
        $shoperjoblist = Query::init()->select('*')->from('goods_comments_info')->andWhere('gci_uno=?',$sno)->one();
        $this->assign('goodscommentslist',$goodscommentslist);
        $this->display('admin/audit-comment-detail.tpl');     
    }
    public function auditCommentDoAction(){
        $sno = $type = $desc = "";
        extract( safe_extract($_REQUEST) );
        $db = DB::init();
        if( $type == 1 ){
            
            $msg = '~亲，招评价核成功！';
            $title = '招评价核成功';
            $sji_status = 2;
            
        }else{
            $msg = $desc;
            $title = '评价商品审核没有通过';
            $sji_status = 0;
        }
        
        $status = $db->update('goods_comments_info',['gci_status'=>$sji_status],['gci_uno'=>$sno]);
        if( !$status ){
            returnMsg(104,'操作失败！');
        }
        
        $Record = new Record();
        $Record->umi_title = $title;
        $Record->umi_body = $msg;
        $Record->umi_ctime = time();
        $Record->umi_status = 2;
        $Record->umi_uno = Query::init()->select('ui_no')->from('user_info')->leftJoin('shoper_info','ui_no=si_uno')->column();
        $db->insert('user_message_info',$Record);
        returnMsg(200,'操作成功！');    
    }
    
}