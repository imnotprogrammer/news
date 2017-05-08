<?php
class JobController extends Controller{
    
    public function listAction(){
        $sno = getSno();
        list($start,$page) = getPage(PER_PAGE_COUNT);
        $Csql = new Csql('select %s from shoper_job_info','*');
        $Csql->ac('sji_sno=?',$sno);
        $Csql->al( sprintf('limit %d,%d',$start,PER_PAGE_COUNT) );
        $db = DB::init();
        list($jobs,$count) = $Csql->getList($db);
        $jobParams = require WEB_ROOT . '/config/job.inc.php';
        $this->assign('jobParams',$jobParams);
        $this->assign('jobs',$jobs);
        $this->display('shanghu/job_list.tpl');
    }
    
    public function delAction(){
        $sno = getSno();
        $jno = $_REQUEST['jno'];
        $sql = 'delete from shoper_job_info where sji_no=? and sji_sno=?';
        $db = DB::init();
        $status = $db->exec($sql,[$jno,$sno]);    
        if( $status ){
            returnMsg(200,'删除工作成功！');
        }else{
            returnMsg(104,'删除工作失败！');
        }
    }
    
    public function addAction(){
        
        $sno = getSno();
        
        if( !empty($_POST) ){
            $name = $work_type = $concat = $concatTel = $work_money = $work_year = $welfare = $school_year = "";
            $sex_limit = $desc = $prov = $city = $area = "";
            extract( safe_extract($_POST) );
            $Record = new Record();
            $Record->sji_sno = $sno;
            $Record->sji_ctime = time();
            $Record->sji_name = $name;
            $Record->sji_pro = $prov;
            $Record->sji_city = $city;
            $Record->sji_area = $area;
            $Record->sji_contact = $concat;
            $Record->sji_phone = $concatTel;
            $Record->sji_salary = $work_money;
            $Record->sji_experience = $work_year;
            $Record->sji_sex = $sex_limit;
            $Record->sji_educational = $school_year;
            $Record->sji_welfare = $welfare;
            $Record->sji_desc = $desc;
            $Record->sji_status = 1;
            $Record->sji_classno = $work_type;
            $db = DB::init();
            $status = $db->insert('shoper_job_info',$Record);
            if( $status ){
                returnMsg('200','保存成功！');
            }else{
                returnMsg(104,'网络错误！请重试！');
            }
        }else{
            $jobConfigs = require WEB_ROOT . '/config/job.inc.php';
            $Job = new Job();
            $jobClass = $Job->getJobClass();
            $this->assign('jobClass',$jobClass);
            $this->assign('jobConfigs',$jobConfigs);
            $this->display('shanghu/job_add.tpl');
        }
        
    }
    
}