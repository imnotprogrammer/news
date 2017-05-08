<?php
class ShopController extends Controller{
    
    public function __construct(){

    }
    public function indexAction(){
        /*$sno = $_GET['sno'];
        $Query = Query::init()->from('goods_info');
        $Query->andWhere('gi_status=2 and gi_type=2');
        $goods = $Query->andWhere('gi_sno=?',$sno)->limit(50)->all();
        $this->getShop();
        $this->assign('goods',$goods);*/
        $this->display('site/shop.tpl');
    }
    public function albumAction(){
        $this->getShop();
        
        $this->display('site/shop_album.tpl');
    }
    public function jobAction(){
        $this->getShop();
        $sno = $_GET['sno'];
        $Query = Query::init();
        $Query->from('shoper_job_info');
        $jobs = $Query->andWhere('sji_sno=? and sji_status=2',$sno)->limit(20)->All();
        $jobParams = include WEB_ROOT . '/config/job.inc.php';
        $this->assign('jobs',$jobs);
          $this->assign('jobParams',$jobParams);
        $this->display('site/shop_job.tpl');
    }
    public function goodsAction(){
        $sno = $_GET['sno'];
        $Query = Query::init()->from('goods_info');
        $Query->andWhere('gi_status=2 and gi_type=1');
        $goods = $Query->andWhere('gi_sno=?',$sno)->limit(50)->all();
        
        $this->getShop();
       $this->assign('goods',$goods);
      
        $this->display('site/shop_goods.tpl');
    }
    
    public function getShop(){
        $sno = $_GET['sno'];
        $shop = Query::init()->from('shoper_info')->andWhere('si_no=?',$sno)->one();
        $Query = Query::init()->from('shoper_info')->andWhere('si_city=?',$shop['si_city']);
        $Query->andWhere('getdistance(si_lat,si_lon,?,?)<10',[$shop['si_lat'],$shop['si_lon']]);
        $Query->select('si_no,si_name,si_lat,si_lon,si_logo,si_score_count,si_total_score');
        $nearShops = $Query->limit(5)->all();
        $this->assign('nearShops',$nearShops);
        $this->assign('shop',$shop);
    }
}