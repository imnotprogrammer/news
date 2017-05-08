<?php
class CollectController extends Controller{
    
    public function __construct(){
        isLogin();    
    }
    
    public function collectshopAction(){
        $UserCollect = new UserCollect;
        $uno = getUno();
        $collectShops = $UserCollect->collectShop($uno);
        $this->assign('collectShops',$collectShops);
        $this->display('user/collect_shop.tpl');
    }
    
    public function delCollectShopAction(){
        
        $sno = (int)$_REQUEST['sno'];
        $uno = getUno();
        if(  !$sno ){
            return;
        }
        $UserCollect = new UserCollect();
        $UserCollect->delCollectShop($uno,$sno);
        returnMsg(200,'删除收藏商铺成功！');
        
    }
    
    public function collectgoodsAction(){
        
        $UserCollect = new UserCollect;
        $uno = getUno();
        $collectGoods = $UserCollect->collectGoods($uno);
        $this->assign('collectGoods',$collectGoods);
        $this->display('user/collect_goods.tpl');
        
    }
    
    public function delCollectGoodsAction(){
        
        $gno = (int)$_REQUEST['gno'];
        $uno = getUno();
        if(  !$gno ){
            return;
        }
        $UserCollect = new UserCollect();
        $UserCollect->delCollectGoods($uno,$gno);
        returnMsg(200,'删除收藏商品成功！');
        
    }
    
    public function collectjobAction(){
        $UserCollect = new UserCollect;
        $uno = getUno();
        $collectJobs = $UserCollect->collectJobs($uno);
        $jobParams = include 'config/job.inc.php';
        $this->assign('collectJobs',$collectJobs);
        $this->assign('jobParams',$jobParams);
        $this->display('user/collect_job.tpl');
    }
    
    public function delCollectJobAction(){
        
        $jno = (int)$_REQUEST['jno'];
        $uno = getUno();
        if(  !$jno ){
            return;
        }
        $UserCollect = new UserCollect();Debug::log($uno,$jno);
        $UserCollect->delCollectJob($uno,$jno);
        returnMsg(200,'删除收藏工作成功！');
        
    }
}