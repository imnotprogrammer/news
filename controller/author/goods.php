<?php
class GoodsController extends Controller{
    
    public function listAction(){
    
        $type = $_GET['type'];
        
        
        $sno = getSno();
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $Csql = new Csql('select %s from goods_info','*');
        $Csql->ac('gi_type=?',(int)$type);
        $Csql->ac('gi_sno=?',$sno);
        $Csql->al( sprintf('limit %d,%d',$start,PER_PAGE_COUNT) );
        $db = DB::init();
        list($goods,$count) = $Csql->getList($db);
        
        $Page = new Page($count,PER_PAGE_COUNT);
        
        $this->assign('page',$Page->fpage());
        $this->assign('goodslist',$goods);
        $this->display('shanghu/goods.tpl');
    }
    
    public function delgoodsAction(){
        $gino = '';
        extract(safe_extract($_POST));
        $goodsInst = new Goods();
       
        if($goodsInst->delGoodsOne($gino)){
            returnMsg(200,'商品删除成功！');    
        }else{
            returnMsg(101,'商品删除失败！');     
        }
        
    }
    
    public function addAction(){
        
        $sno = getSno();
        
        if( $_POST ){
            
            $gname = $desc = $classno = $count = $price = $discountPrice = $listingDate = $returnGoods = $prov = $city = $area = $type = "";
            extract( safe_extract($_POST) );
            if( !$gname ){
                alertMsg('商品名称不能为空！');
            }
            
            if( count($_FILES['imgs']['name'])>6 ){
                alertMsg('商品相册列表的图片不能超过6张！') ;  
            }
            
            $UploadFile = new UploadFile('logo');
            $logoFiles = $UploadFile->uploadALIOSS();
            if( empty($logoFiles) ){
                alertMsg('logo图片，' . $UploadFile->msg);
            }
            
            $UploadFile = new UploadFile('imgs','noSelectFile');
            $imgs = $UploadFile->uploadALIOSS();
            
            if( $imgs === false ){
                alertMsg('商品相册列表，' . $UploadFile->msg);
            }
            
            $Record = new Record();
            $Record->gi_no = (int)( rand(10000,99999) . rand(1000,9999) ) ;
            $Record->gi_sno = $sno;
            $Record->gi_name = $gname;
            $Record->gi_desc = $desc;
            $Record->gi_classno = $classno;
            $Record->gi_count = $count;
            $Record->gi_price = $price;
            $Record->gi_discount = $discountPrice;
            $Record->gi_listed = $listingDate;
            $Record->gi_7days_service = $returnGoods;
            $Record->gi_prov = $prov;
            $Record->gi_city = $city;
            $Record->gi_area = $area;
            $Record->gi_logo = $logoFiles[0];
            $Record->gi_imglist = implode(',',$imgs);
            $Record->gi_type = $type;
            $Record->gi_status=1;
            
            $db = DB::init();
            $status = $db->insert('goods_info',$Record);
            if( !$status ){
                alertMsg('添加失败！请重试！');
            }
            header('location:/shanghu/goods/list?type='.$type);
            exit;
            
        }else{
            
            $ClassInfo = new ClassInfo();
        
            //$ClassInfo->cacheMenus();
            
            //$Areas = new Areas();
            
            //$Areas->cacheAreas();
            
            $classInfos = $ClassInfo->getCacheMenus();
            
            $this->assign('classInfos',$classInfos);
            
            $this->display('shanghu/goods_add.tpl');
            
        }
        
    }
    
    public function modifyAction(){
        
        $sno = getSno();
        $gno = $_GET['gno'];
        
        if( $_POST ){
            
            $gname = $desc = $classno = $count = $price = $discountPrice = $listingDate = $returnGoods = $prov = $city = $area = $type = "";
            $delImgsIndex= '';
            extract( safe_extract($_POST) );
            
            if( count($_FILES['imgs']['name'])>6 ){
                alertMsg('商品相册列表的图片不能超过6张！') ;  
            }
            
            $UploadFile = new UploadFile('logo','noSelectFile');
            $logoFiles = $UploadFile->uploadALIOSS();
             
            if( $logoFiles === false ){
                alertMsg('logo图片，' . $UploadFile->msg);
            }
            
            $UploadFile = new UploadFile('imgs','noSelectFile');
            $imgs = $UploadFile->uploadALIOSS();
            
            if( $imgs === false ){
                alertMsg('商品相册列表，' . $UploadFile->msg);
            }
            
            $Goods = new Goods();
            
            $goods = $Goods->selectGoods($sno,$gno);
            
            $imgLists = explode(',',$goods['gi_imglist']);
            $noChangeImgs = [];
            if( !empty($delImgsIndex) ){
                $delImgsIndex = explode(',',$delImgsIndex);
            }else{
                $delImgsIndex = [];
            }
            
            foreach( $imgLists as $key=>$img ){
                if( $_FILES['imgs']['error'][$key] == 4 && !in_array($key,$delImgsIndex) ){
                    $noChangeImgs[] = $img;
                }
            }
            $imgs = array_merge($noChangeImgs,$imgs);
            if( count($imgs) >6 ){
                alertMsg('商品相册列表的图片不能超过6张！') ;   
            }
            
            $Record = new Record();
            $Record->gi_name = $gname;
            $Record->gi_desc = $desc;
            $Record->gi_count = $count;
            $Record->gi_price = $price;
            $Record->gi_discount = $discountPrice;
            $Record->gi_listed = $listingDate;
            $Record->gi_7days_service = $returnGoods;
            if( $logoFiles ){
                $Record->gi_logo = $logoFiles[0];
            }
            $Record->gi_imglist = implode(',',$imgs);
            
            $db = DB::init();
            $status = $db->update('goods_info',$Record,['gi_no'=>$gno,'gi_sno'=>$sno]);
            if( !$status ){
                alertMsg('保存失败！请重试！');
            }
            header('location:/shanghu/goods/list?type=' . $goods['gi_type']);
            exit;
            
        }else{
            
            $ClassInfo = new ClassInfo();
        
            //$ClassInfo->cacheMenus();
            
            //$Areas = new Areas();
            
            //$Areas->cacheAreas();
            
            $Goods = new Goods();
            
            $goods = $Goods->selectGoods($sno,$gno);
            
            if( !empty($goods['gi_imglist']) ){
                $goods['gi_imglist'] = explode(',',$goods['gi_imglist']);
            }else{
                $goods['gi_imglist'] = [];
            }
            
            $classInfos = $ClassInfo->getCacheMenus();
            
            $this->assign('goods',$goods);
            
            $this->assign('classInfos',$classInfos);
            
            $this->display('shanghu/goods_modify.tpl');
            
        }
        
    }

    
    public function returnAction(){
        $type = '';
        extract( safe_extract($_REQUEST) );
        list($start,$page) = getPage(PER_PAGE_COUNT);
        $sno = getSno();
        
        $sql = 'select %s from return_goods_apply_info a
                    left join orders_info b on a.rgai_ono=b.oi_no
                    left join goods_info c on b.oi_gno=c.gi_no';
                    
        $Csql = new Csql($sql,'a.*,c.gi_name');
        
        $Csql->ac('gi_sno=?',$sno);
        
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
        $this->display('shanghu/goods_return.tpl');   
    }
    
    public function doReturnGoodsAction(){
        $rg_no = (int)$_REQUEST['rg_no'];
        $type = $_REQUEST['type'];
        $desc = $_REQUEST['desc'];
        if( !$type && !$desc ){
            returnMsg(104,'请填写拒绝的理由！');
        }
        $db = DB::init();
        $sno = getSno();
        $sql = 'update return_goods_apply_info set rgai_addr_sell=? ,rgai_if_agree_sell=? 
                    where rgai_no=?
                    and rgai_ono in(
                        select oi_no from orders_info 
                            left join goods_info on oi_gno=gi_no
                                where gi_sno=? 
                    )';
       $status =  $db->exec($sql,[$desc,$type,$rg_no,$sno]);
       if( $status ){
            returnMsg('200','操作成功！');
       }else{
            returnMsg(104,'操作失败！');
       }
    }
    
    public function sureReturnAction(){
        $rg_no = (int)$_REQUEST['rg_no'];
        if( !$rg_no ){
            return;
        }
        $db = DB::init();
        $sno = getSno();
        $sql = 'select * from return_goods_apply_info
                    left join orders_info on rgai_ono=oi_no
                    left join goods_info on oi_gno=gi_no
                        where rgai_no=?
                        and gi_sno=?
                            limit 1';
        $record = $db->exec($sql,[$rg_no,$sno],102);
        
        if( !empty($record) ){
            $sql = 'update return_goods_apply_info set rgai_result_sell=1
                    where rgai_no=?';
            $status =  $db->exec($sql,[$rg_no,$sno]);
            
        }
        
       if( $status ){
            $sql = 'select * from orders_info
                        where oi_no in(
                            select rgai_no from return_goods_apply_info
                                where 
                        )
                            limit 1';
            returnMsg('200','操作成功！');
       }else{
            returnMsg(104,'操作失败！');
       }
    }
    
}