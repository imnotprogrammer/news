<?php
class CategoryController extends Controller{
    
    public function __construct(){
        isLogin();
        if( !isAdmin() ){
            header("location:/");
            exit;
        }  
    }
    
    public function listAction(){
        $Query = Query::init();
        $type = $_GET['type'];
        $datas = $Query->select('a.*')->from('site_class_info a')->orderby('a.sc_weight desc');
        if( $type == 1 ){
            $Query->andWhere('a.sc_parno=0');
        }elseif( $type == 2 ){
            $Query->andWhere('a.sc_parno>0');
            $Query->select('a.*,b.sc_name as pname')->leftJoin('site_class_info b','a.sc_parno=b.sc_no');
            $Query->orderby('a.sc_weight desc,a.sc_parno desc');
        }
        $datas = $Query->all();
        $this->assign('datas',$datas);
        $this->display('admin/category-list.tpl');
    }
    public function disabledAction(){
        $cno = $_GET['cno'];
        $status = $_POST['status'];
        $db = DB::init();
        if( $status == 2 ){
            $category = Query::init()->from('site_class_info')->andWhere('sc_no=?',$cno)->one();
            if( $category['sc_parno'] ){
                $count = Query::init()->from('site_class_info')->andWhere('sc_parno=? and sc_status=1',$category['sc_parno'])->count();
                if( $count<=1 ){
                    returnMsg(104,'该分类是父类中唯一个启用的，不能设置为失效！');
                }
            }
        }
        $db->update('site_class_info',['sc_status'=>$status],['sc_no'=>$cno]);
        
        returnMsg(200,'操作成功！');
    }
    
    public function saveAction(){
        $cno = $_GET['cno'];
        $categorys = Query::init()->from('site_class_info')->andWhere('sc_parno=0')->orderby('sc_weight desc')->all();
        $this->assign('categorys',$categorys);
        if( $cno ){
            $data = Query::init()->from('site_class_info')->andWhere('sc_no=?',$cno)->one();
            $this->assign('data',$data);
        }
        $this->display('admin/category-save.tpl');
    }
    
    public function doSaveAction(){
        $cno = $name = $parent_cno = $weight = $desc = '';
        extract( safe_extract($_REQUEST) );
        
        if(!$name){
           returnMsg(104,'分类名称不能为空！');  
        }
        
        $db = DB::init();
        
        if( $cno ){
            $Record = new Record();
            $Record->sc_name = $name;
            $Record->sc_weight = $weight;
            $db->update('site_class_info',$Record,['sc_no'=>$cno]); 
        }else{
            $Record = new Record();
            $sco = rand(1000,9999) . rand(10000,99999);
            $Record->sc_no = $sco;
            $Record->sc_name = $name;
            $Record->sc_parno = $parent_cno;
            $Record->sc_weight = $weight;
            $Record->sc_status = 1;
            $db->insert('site_class_info',$Record);
            if( !$parent_cno ){
                $Record = new Record();
                $parent_cno = $sco;
                $sco = rand(1000,9999) . rand(10000,99999);
                $Record->sc_no = $sco;
                $Record->sc_name = $name;
                $Record->sc_parno = $parent_cno;
                $Record->sc_weight = $weight;
                $Record->sc_status = 1;
                $db->insert('site_class_info',$Record);
            }
        }
        
        $ClassInfo =new ClassInfo();
        $ClassInfo->cacheMenus();
        
        returnMsg(200,'保存成功！');
    }
    
    public function cityShopAction(){
        $this->display('admin/cityshop.tpl');
    }
    
    public function jobAction(){
        $jobClass = Query::init()->from('job_class_info')->orderby('jsoc_weight desc')->all();
        $this->assign('jobClass',$jobClass);
        $this->display('admin/job.tpl');
    }
    
    public function saveJobClassAction(){
        $jc_no = $_GET['jc_no'];
        if( $jc_no ){
            $jobClass = Query::init()->from('job_class_info')->andWhere('jsoc_no=?',$jc_no)->one();
            $this->assign('jobClass',$jobClass);
        }
        $this->display('admin/job-class-save.tpl');
    }
    
    public function doSaveJobClassAction(){
        $jc_no = $name = $weight = $status = $type = "";
        extract( safe_extract($_REQUEST) );
        $db = DB::init();
        if( $jc_no ){
            $Record = new Record();
            $Record->jsoc_name = $name;
            $Record->jsoc_weight = $weight;
            $Record->jsoc_type = $type;
            $db->update('job_class_info',$Record,['jsoc_no'=>$jc_no]);
        }else{
            $Record = new Record();
            $Record->jsoc_name = $name;
            $Record->jsoc_weight = $weight;
            $Record->jsoc_type = $type;
            $db->insert('job_class_info',$Record);
        }
        returnMsg(200,'保存工作类别成功！');
    }
    
    public function disableJobClassAction(){
        $jc_no = $_GET['jc_no'];
        $status = $_REQUEST['status'];
        $db = DB::init();
        $db->update('job_class_info',['jsoc_status'=>$status],['jsoc_no'=>$jc_no]);
        returnMsg(200,'操作成功！');
        
    }
    
    
}