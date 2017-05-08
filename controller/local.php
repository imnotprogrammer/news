<?php
class LocalController extends Controller{
    
    public function indexAction(){
        
        $cno = $areaId;
        extract( safe_extract($_GET) );
        
        list($page,$start) = getPage(KPER_PAGE_COUNT);
        $categorys = ClassInfo::getCacheMenus();
        
        $areas = getUserArea();
        $provId = $areas['provId'];
        
        if( !empty($provId) ){
            $countys = Query::init()->from('prov_city_area_info')->andWhere('pcai_pno=?',$provId)->all();
        }else{
            $countys = [];
        }
        
    
        
        $Query = Query::init()->from('goods_info');
        $Query->andWhere('gi_type=3 and gi_status=2');
        
        if( $cno ){
            $Query->andWhere('gi_classno in(select sc_no from site_class_info where sc_status=1 and sc_parno=?)',$cno);
        }
        
        if( $provId ){
            //$Query->andWhere('gi_prov=?',$provId);
        }
        
        if( $areaId ){
            $Query->andWhere('gi_area=?',$areaId);
        }
        
        $goods = $Query->limit(PER_PAGE_COUNT)->offset($start)->all();
        $count = $Query->count();
        
        $Page = new Page($count,PER_PAGE_COUNT);
        
        $this->assign('goods',$goods);
        $this->assign('page',$Page->fpage());
        $this->assign('countys',$countys);
        $this->assign('categorys',$categorys);
        $this->display('site/local.tpl');  
        
    }
}