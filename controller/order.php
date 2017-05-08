<?php
class OrderController extends Controller{
    
    public function generateAction(){
        $cno = $_GET['cno'];
        $cnos = explode(',',$cno);
        foreach( $cnos as $key=>$no ){
            $cnos[$key] = (int)$no;
        }
        $cno = implode(',',$cnos);
        if( empty($cno) ){
            alertMsg('参数不正确！','/');
        }
        $uno = getUno();
        $Query = Query::init()->from('user_cart_info')->andWhere('uci_no in(' . $cno . ')' );
        $Query->andWhere('uci_uno=?',$uno);
        $Query->leftJoin('goods_info','gi_no=uci_gno');
        $Query->leftJoin('shoper_info','gi_sno=si_no');
        $carts = $Query->all();
        
        $address = Query::init()->from('user_delivery_address_info')->andWhere('udai_uno=?',$uno)->all();
        
        $this->assign('address',$address);
        $this->assign('carts',$carts);
        $this->display('site/order_generate.tpl');
    }
    
    public function submitAction(){
        
        $cno = $_POST['cno'];
        $goods = $_POST['goods'];
        $pay = $_POST['pay'];
        $counts = $_POST['counts'];
        $addrNo = $_POST['addrNo'];
        
        $verFormKey = $_POST['verFormKey'];
        if( !verFormKey($verFormKey) ){
            alertMsg('表单参数不正确！');
        }
        
        $cnos = explode(',',$cno);
        foreach( $cnos as $key=>$no ){
            $cnos[$key] = (int)$no;
        }
        $cno = implode(',',$cnos);
        if( empty($cno) ){
            alertMsg('参数不正确！','/');
        }
        

        $uno = getUno();
        $Query = Query::init()->from('user_cart_info')->andWhere('uci_no in(' . $cno . ')' );
        $Query->andWhere('uci_uno=?',$uno);
        $Query->leftJoin('goods_info','gi_no=uci_gno');
        $carts = $Query->all();
        
        $Query = Query::init()->from('user_delivery_address_info a')->andWhere('udai_no=? and udai_uno=?',[$addrNo,$uno]);
        $Query->leftJoin('prov_city_area_info b','udai_pro=b.pcai_no');
        $Query->leftJoin('prov_city_area_info c','udai_city=c.pcai_no');
        $Query->leftJoin('prov_city_area_info d','udai_area=d.pcai_no');
        $Query->select('a.*,b.pcai_name prov,c.pcai_name city,d.pcai_name area');
        $addr = $Query->one();
        if( empty($addr) ){
            alertMsg('请选择地址！','/cart');
        }
        
        if( empty($carts) ){
            alertMsg('没有查询到购物车数据！','/cart');
        }
        
        foreach( $carts as $k=>$cart ){
            $count = $counts[$cart['uci_no']];
            if( $cart['gi_count']<$count ){
                alertMsg('商品库存不够！','/cart');
            }
            $cart['count'] = $count;
        }
       
        
        $db = DB::init();
        
        do{
            $charge_no = md5( time() . rand(1000,10000) . rand(2000,10000) );
            $order = Query::init()->from('orders_info')->andWhere('oi_charge_no=?',$charge_no)->one();
        }while( $order );
        
        foreach( $carts as $cart ){
            
            $Record = new Record();
            $Record->oi_uno= $uno;
            $Record->oi_gno = $cart['gi_no'];
            $Record->oi_ctime = time();
            $Record->oi_count = $count;
            $Record->oi_price = $cart['gi_price'];
            $Record->oi_status = 0;
            $Record->oi_rece = 0;
            $Record->oi_charge_no = $charge_no;
            $Record->oi_addr = json_encode($addr);
            $Record->oi_express="";
            $db->insert('orders_info',$Record);
            $ono = $db->connobj->lastInsertId();
            $db->exec('delete from user_cart_info where uci_no =? and uci_uno=?',[$cart['uci_no'],$uno]);
            
        }
        
        header('location:/pay?chargeNo=' . $charge_no . '&paytype=' . $pay);
        
    }
    
}