<?php
class CityController extends Controller{
    
    public function indexAction(){
        
        $areas = file_get_contents( WEB_ROOT . '/config/areas.inc.php' );
        $areas = json_decode($areas,true);
        $hostCitys = include WEB_ROOT . '/config/areahot.inc.php';
        $this->assign('hostCitys',$hostCitys);
        $this->assign('areas',$areas);
        $this->display('site/city.tpl');  
        
    }
    
    public function setAction(){
        $cityId = $_GET['cityId'];
        $city = Query::init()->from('prov_city_area_info')->andWhere('pcai_no=?',$cityId)->one();
        $_SESSION['userarea']['time'] = time();
        $_SESSION['userarea']['cityName'] = $area['pcai_name'];
        $_SESSION['userarea']['cityId'] = $area['pcai_no'];
        $prov = Query::init()->from('prov_city_area_info')->andWhere('pcai_no=?',$city['pcai_pno'])->one();
        $_SESSION['userarea'] = [
            'time'=>time(),
            'cityName'=>$city['pcai_name'],
            'cityId'=>$city['pcai_no'],
            'provId'=>$prov['pcai_no'],
            'countyId'=>0
        ];
        returnMsg(200,'操作成功！');
    }
}