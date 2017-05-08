<?php
class UserorderController extends Controller{
    
    public function indexAction(){
        
        $search = $type = $time = '';
        extract( safe_extract($_REQUEST) );
        $uno = getUno();
        list($page,$start) = getPage(10);
        $time = (int)$time;
        
        $Query = Query::init()->from('orders_info');
        $Query->leftJoin('goods_info','gi_no=oi_gno');
        $Query->leftJoin('return_goods_apply_info','rgai_ono=oi_no');
        $Query->select('orders_info.*,gi_name,gi_logo,rgai_no');
        
        if( $type == '' ){
            
        }elseif( $type == 'nopay' ){
            $Query->andWhere('oi_status=0');
        }elseif( $type == 'pay' ){
            $Query->andWhere('oi_status=1');
        }elseif( $type == 'success' ){
            $Query->andWhere('oi_status=1 and oi_rece=1');
        }elseif( $type == 'nocomment' ){
            $Query->andWhere('oi_if_comment=0');
        }elseif( $type == 'refund' ){
            $Query->andWhere('oi_status=2');
        }else{
            $Query->andWhere('1=0');
        }
        
        if( $search ){
            $Query->like('gi_name',$search);
        }
        
        if( $time == '1' ){
            $month = date('m');
            $y = date('y');
            
            if( $month > 3 ){
                $month = $month -3;
            }else{
                $month = $month + 12 -3 ;
                $y = $y-1;
            }
            $time = strtotime($y . '-' . $month . '-01');
            $Query->andWhere('oi_ctime>?',$time);
        }elseif( $time == '2' ){
            $time = strtotime(date('y'). '-01-01');
            $Query->andWhere('oi_ctime>?',$time);
        }elseif( $time == '3' ){
            $stime = strtotime(date('y')-2 . '-01-01');
            $etime = strtotime(date('y')-1 . '-01-01');
            $Query->andWhere('oi_ctime>? and oi_ctime<?',[$stime,$etime]);
        }elseif( $time == '4' ){
            $stime = strtotime(date('y')-3 . '-01-01');
            $etime = strtotime(date('y')-2 . '-01-01');
            $Query->andWhere('oi_ctime>? and oi_ctime<?',[$stime,$etime]);
        }elseif( $time == '5' ){
            $stime = strtotime(date('y')-3 . '-01-01');
            $etime = strtotime(date('y')-4 . '-01-01');
            $Query->andWhere('oi_ctime>? and oi_ctime<?',[$stime,$etime]);
        }elseif( $time == '6' ){
            $stime = strtotime(date('y')-5 . '-01-01');
            $etime = strtotime(date('y')-6 . '-01-01');
            $Query->andWhere('oi_ctime>? and oi_ctime<?',[$stime,$etime]);
        }
        
        //$Csql->ac('oi_uno=?',$uno);
        
        $Query->orderBy('oi_ctime desc');
        $Query->limit(10)->offset($start);
        
        $orders = $Query->all();
        $count = $Query->count();
        
        //Debug::log($orders,$uno);
        
        foreach( $orders as $key=>$order ){
            $orders[$key]['oi_express'] = json_decode($order['oi_express'],true);
        }
        
        $Page = new Page($count,10);
        $this->assign('orders',$orders);
        $this->assign('page',$Page->fpage());
        $this->display('user/order.tpl');
    }
    
    public function generateAction(){
        $gno = $_GET['gno'];
            
    }   
      
    public function cancelAction(){
        
        $ono = $_GET['ono'];
        $uno = getUno();
        if( !$ono ){
            return;
        }
        $Orders = new Orders();
        
        $order = $Orders->getUserOrder($uno,$ono);
        
        if( $order['oi_status'] == 0 ){
            $status = $Orders->delOrder($uno,$ono);
            if( $status ){
                returnMsg(200,'取消订单成功！');
            }else{
                returnMsg(104,'取消订单失败');
            }
        }elseif( $order['oi_status'] == 1 && $order['oi_rece'] == 0 ){
            returnMsg(104,'取消订单失败！订单已付款,正在等待收货中...');
        }elseif( $order['oi_status'] == 1 && $order['oi_rece'] == 1 ){
            $status = $Orders->delOrder($uno,$ono);
            if( $status ){
                returnMsg(200,'删除订单成功！');
            }else{
                returnMsg(104,'删除订单失败！');
            }
        }else{
            returnMsg(104,'操作失败！');
        }
        
    }
}