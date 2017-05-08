<?php
class JobController extends Controller{
    
    public function indexAction(){
        
        $jc_no = $areaId;
        extract( safe_extract($_GET) );
        
        list($page,$start) = getPage(PER_PAGE_COUNT);
        
        $areas = getUserArea();
        $provId = $areas['provId'];
        
        if( !empty($provId) ){
            $countys = Query::init()->from('prov_city_area_info')->andWhere('pcai_pno=?',$provId)->all();
        }else{
            $countys = [];
        }
        $jobClass = Query::init()->from('job_class_info')->andWhere('jsoc_status=1')->all();
        $Query = Query::init();
        $Query->from('shoper_job_info a')->leftJoin('job_class_info b','sji_classno=jsoc_no');
        $Query->leftJoin('shoper_info c','si_no=sji_sno');
        $Query->select('a.*,b.*,c.si_logo,c.si_no,c.si_name');
        
        if( !empty($provId) ){
            $Query->andWhere('sji_city=?',$provId);
        }
        
        if( !empty($areaId) ){
            $Query->andWhere('sji_area=?',$areaId);    
        }
        
        $Query->andWhere('jsoc_status=1');
        if( $jc_no ){
            $Query->andWhere('sji_classno=?',$jc_no);
        }
        $jobs = $Query->limit(PER_PAGE_COUNT)->offset($start)->all();
        $count = $Query->count();
        $Page = new Page($count,PER_PAGE_COUNT);
        $jobParams = include WEB_ROOT . '/config/job.inc.php';
        
        $this->assign('countys',$countys);
        $this->assign('jobParams',$jobParams);
        $this->assign('page',$Page->fpage());
        $this->assign('jobs',$jobs);
        $this->assign('jobClass',$jobClass);
        $this->display('site/jobhome.tpl');  
        
    }
}