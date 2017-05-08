<?php
class ReturnGoodsController extends Controller{
    
     public function indexAction(){
        $type = '';
        extract( safe_extract($_REQUEST) );
        list($start,$page) = getPage(PER_PAGE_COUNT);
        
        $sql = 'select %s from return_goods_apply_info';
        $Csql = new Csql($sql,'*');
        
        if( $type == 'wait' ){
            $Csql->ac('rgai_result_sell=0');
        }elseif( $type == 'complete' ){
            $Csql->ac('rgai_result_sell!=0');
        }
        
        $db = DB::init();
        list($returnGoodsApplys,$count) = $Csql->getList($db);
        
        foreach( $returnGoodsApplys as $key=>$returnGoodsApply ){
            $returnGoodsApplys[$key]['rgai_body'] = json_decode($returnGoodsApply['rgai_body'],true);
            $returnGoodsApplys[$key]['rgai_express_buy'] = json_decode($returnGoodsApply['rgai_express_buy'],true);
        }
        
        $Page = new Page($count,PER_PAGE_COUNT);
        $this->assign('returnGoodsApplys',$returnGoodsApplys);
        $this->assign('page',$Page->fpage());
        $this->display('user/returngoods.tpl');
    }
    
    public function applyAction(){
        
        $this->display('user/returngoods_apply.tpl');
        
    }
    
    public function addapplyAction(){
        
         $ono = $desc = "";
         extract( safe_extract($_REQUEST) );
         if( !$ono || !$desc ){
            alertMsg('参数不正确！');
         }
         
         $uno = getUno();
         
         $order = Query::init()->from('orders_info')->andWhere('oi_no=? and oi_uno=?',[$ono,$uno])->one();
         if( !$order ){
            alertMsg('没有查询到订单信息！');
         }
         $returnGoods = Query::init()->from('return_goods_apply_info')->andWhere('rgai_ono=?',[$ono])->one();
         if( $returnGoods ){
            alertMsg('已添加退货申请！');
         }
         
         $body['desc'] = $desc;
         if( isset($_FILES['img']) ){
            $UploadFile  = new UploadFile('img','noSelectFile');
            $UploadFile->validateFile();
            $files = $UploadFile->uploadALIOSS();
            $body['img'] = $files[0];
         }
         $Record = new Record();
         $Record->rgai_ono = $ono;
         $Record->rgai_body = json_encode($body);
         $Record->rgai_ctime = time();
         $db = DB::init();
         $db->insert('return_goods_apply_info',$Record);
         header('location:/returngoods');
    }
    
    public function writeexpressAction(){
        
        if( empty($_POST) ){
            $this->display('user/writeexpress.tpl');
        }else{
            $rno = $ono = $expressNo = $expressName = "";
            extract( safe_extract($_POST) );
            $uno = getUno();
            $returnGoods = Query::init()->from('return_goods_apply_info')->andWhere('rgai_no=? and rgai_ono=?',[$rno,$ono])->one();
            if( empty($returnGoods) ){
                returnMsg(104,'没有查询到退货信息！');
            }
            $order = Query::init()->from('orders_info')->andWhere('oi_no=? and oi_uno=?',[$ono,$uno])->one();
            if( empty($order) ){
                returnMsg(104,'没有查询到订单信息！');
            }
            $express = ['expressNo'=>$expressNo,'expressName'=>$expressName];
            $db = DB::init();
            $db->update('return_goods_apply_info',['rgai_express_buy'=>json_encode($express)],['rgai_no'=>$rno]);
            returnMsg(200,'填写快递信息成功!');
            
        }
        
    }
    
}