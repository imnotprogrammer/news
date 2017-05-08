<?php
class UserAddrController extends Controller{
    
    public function __construct(){
        isLogin();
        $_REQUEST = html_escape($_REQUEST);
    }
    
    public function indexAction(){
        $uno = getUno();
        $Query = new Query();
        $Query->from('user_delivery_address_info a');
        $Query->leftJoin('prov_city_area_info b','a.udai_pro = b.pcai_no');
        $Query->leftJoin('prov_city_area_info c','a.udai_city = c.pcai_no');
        $Query->leftJoin('prov_city_area_info d','a.udai_area = d.pcai_no');
        $Query->select('a.*,b.pcai_name as pro_name,c.pcai_name as city_name,d.pcai_name as area_name');
        $Query->andWhere('udai_uno=?',$uno);
        $Query->orderBy('udai_default desc,udai_no desc');
        $addrerssLists = $Query->limit(100)->all();
        $this->assign('addrerssLists',$addrerssLists);    
        $this->display('user/set_addr_list.tpl');
    }
    
     
     public function addAction(){
        $phone = $addr = $zhname = $areaId = $provId = $cityId = $addrNo = "";
        extract( safe_extract( $_REQUEST ) );
        if( !$phone || !$addr || !$zhname ){
            returnMsg(102,'参数不能为空！');
        }
        if( !preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$phone)){
            returnMsg(101,'手机号码不正确！');    
        }
        $Record = new Record();
        $uno = getUno();
        $Record->udai_uno = $uno;
        $Record->udai_uname = $zhname;
        $Record->udai_phone = $phone;
        $Record->udai_address = $addr;
        $Record->udai_pro = $provId;
        $Record->udai_city = $cityId;
        $Record->udai_area = $areaId;
        $db = DB::init();
        $result = $db->insert('user_delivery_address_info',$Record);
        if($result){
            returnMsg(200,'添加收货地址成功！');         
        }else{
            returnMsg(101,'添加收货地址失败！');    
        }
     }
     
     
     public function modifyAction(){
        $phone = $addr = $zhname = $areaId = $provId = $cityId = $addrNo = "";
        extract( safe_extract( $_REQUEST ) );
        if( !$phone || !$addr || !$zhname ){
            returnMsg(102,'参数不能为空！');
        }
        if( !preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$phone)){
            returnMsg(101,'手机号码不正确！');    
        }
        $Record = new Record();
        $uno = getUno();
        $Record->udai_uname = $zhname;
        $Record->udai_phone = $phone;
        $Record->udai_address = $addr;
        $Record->udai_pro = $provId;
        $Record->udai_city = $cityId;
        $Record->udai_area = $areaId;
        $db = DB::init();//var_dump( $addrNo,$uno );
        $result = $db->update('user_delivery_address_info',$Record,['udai_no'=>(int)$addrNo,'udai_uno'=>(int)$uno]);
        if($result){
            returnMsg(200,'修改收货地址成功！');         
        }else{
            returnMsg(101,'修改收货地址失败！');    
        }
     }
     
     public function delAction(){
        
        $addrNo = $_GET['addrNo'];
        $uno = getUno();
        $UserAddr = new UserAddr();
        $result = $UserAddr->delAddress($addrNo,$uno);
        if( $result ){
            returnMsg(200,'删除收货地址成功！');   
        }else{
            returnMsg(104,'删除收货地址失败！');   
        }
        
     }
     
     public function defaultAction(){
        
        $addrNo = $_GET['addrNo'];
        $uno = getUno();
        $UserAddr = new UserAddr();
        $result = $UserAddr->defaultAddress($addrNo,$uno);
        if( $result ){
            returnMsg(200,'设置默认地址成功！');   
        }else{
            returnMsg(104,'设置默认地址失败！');   
        }
        
     }
     
}