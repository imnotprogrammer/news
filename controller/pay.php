<?php
require_once(WEB_ROOT . '/pingpp/init.php');

class PayController extends Controller{
    
    public function indexAction(){
        $chargeNo = $_GET['chargeNo'];
        $channel = $_GET['paytype'];
        $uno = getUno();
        $orders = Query::init()->from('orders_info')->leftJoin('goods_info','oi_gno=gi_no')->andWhere('oi_uno=? and oi_charge_no=?',[$uno,$chargeNo])->all();
   
        if(empty($orders)){
            alertMsg('订单编号不正确！','/cart');
        }
        
        $amount = 0;
        
        foreach( $orders as $order ){
            
            $amount += $order['oi_count']*$order['gi_price'];
            
        }
        
        $amount = $amount * 100;
        
        $orderNo = $chargeNo;
        
        $extra = array();
        switch ($channel) {
            case 'alipay_wap':
                $extra = array(
                    'success_url' => WEB_URL . '/pay/success',
                    'cancel_url' => WEB_URL . '/pay/cancel'
                );
                break;
		
        }
        
        \Pingpp\Pingpp::setApiKey(PINGPP_APP_KEY);
        try {
            $ch = \Pingpp\Charge::create(
                array(
                    'subject'   => 'Your Subject',
                    'body'      => 'Your Body',
                    'amount'    => $amount,
                    'order_no'  => $orderNo,
                    'currency'  => 'cny',
                    'extra'     => $extra,
                    'channel'   => $channel,
                    'client_ip' => $_SERVER['REMOTE_ADDR'],
                    'app'       => array('id' => PINGPP_APP_ID )
                )
            );
           
        
        } catch (\Pingpp\Error\Base $e) {
            header('Status: ' . $e->getHttpStatus());
            echo($e->getHttpBody());
            exit;
        }
        $chstr =  (string)$ch;
        $charr = json_decode($chstr,true);
        
        $db = DB::init();
        foreach( $orders as $order ){
            $db->exec('update orders_info set oi_charge_id=? where oi_uno=? and oi_no=?',[$charr['id'],$uno,$order['oi_no']]);
        }
        $this->assign('ch',$ch);//var_dump( $ch );exit;
        $this->display('site/pay_index.tpl');
        
    }
    
    public function successAction(){
        
        sleep(1);
        
        $chargeNo = $_GET['out_trade_no'];
        $uno = getUno();
        $i = 0;
        do{
        
            $status = 1;
                
            $orders = Query::init()->from('orders_info')->andWhere('oi_charge_no=? and oi_uno=?',[$chargeNo,$uno])->all();
                
            if( empty($orders) ){
                alertMsg('没有查询到订单信息','/cart');
            }
                
            foreach( $orders as $order ){
                if( $order['oi_status'] == 0 ){
                    $status = 0;
                }elseif( $order['oi_status'] == 4 ){
                    $status = 4;
                    break;
                }
            }
            
            if( $status == 0 ){
                sleep(1);
            }elseif( $status == 4 ){
                $this->display('site/pay_fail.tpl');
                exit;
            }elseif( $status == 1 ){
                $this->display('site/pay_success.tpl');
                exit;
            }
            
            $i++;
        }while($i<10);
        
        header('location:/cart');
        
    }
    
    public function cancelAction(){
        
    }
    
    public function notify_ksdAction(){
       
        $raw_data = file_get_contents('php://input');
        
        $signature = $_SERVER['HTTP_X_PINGPLUSPLUS_SIGNATURE'];
        
        $result = verify_signature($raw_data, $signature);
        
        if ($result === 1) {
            
            $data = json_decode($raw_data,true);
            
            $chargeId = $data['data']['object']['id'];
            $amount_settle = $data['data']['object']['amount_settle'];
            $amount = $data['data']['object']['amount'];
            $chargeNo = $data['data']['object']['order_no'];
            $orders = Query::init()->from('orders_info')->andWhere('oi_charge_no=?',$chargeNo)->all();
            
            if( !empty($orders) ){
                
                foreach( $orders as $order ){
                    $oamount += $order['oi_price'] * $order['oi_count'];
                }
                
                $oamount = $oamount * 100;
                
                if( $oamount != $amount ){
                    
                    Debug::log('pay notify error:\n total price is equal! ' .  $amount . ',' . $oamount);
                    echo 'verification failed';
                    
                }else{
                    $db = DB::init();
                    $db->beginTransaction();
                    foreach( $orders as $order ){
                        
                        $status = $db->exec('update orders_info set oi_status=1 where oi_no=?',[$order['oi_no']]);
                        $db->exec('update goods_info set gi_count=gi_count-? where gi_no=? and gi_count-?>=0',[$order['oi_count'],$order['oi_gno'],$order['oi_count']]);
                       
                        if( $db->rowCount() == 0 ){
                            
                            $gcount = Query::init()->select('gi_count')->from('goods_info')->andWhere('gi_no=?',$order['gi_no'])->column();
                            
                            if( $order['status'] == 0 && $chargeId == $order['oi_charge_id'] && $gcount<$order['oi_count'] ){
                                
                                \Pingpp\Pingpp::setApiKey(PINGPP_APP_KEY);
                                $ch = \Pingpp\Charge::retrieve($order['oi_charge_id']);
                                $re = $ch->refunds->create( ['description' => '商品数量不足！'] );
                                echo 'verification succeeded';
                                $db->rollback();
                                $db->update('orders_info',['oi_status'=>4],['oi_charge_no'=>$chargeNo]);
                                exit;
                            }else{
                                echo 'verification failed';
                                $db->rollback();
                                exit;
                            }
                            
                        }
                        
                        if( !$status ){
                            $db->rollBack();
                            echo 'verification failed';
                            exit;
                        }
                        
                    }
                    $db->commit();
                    echo 'verification succeeded';
                }
                
            }else{
                Debug::log('pay notify error:\n is not select order!');
                echo 'verification failed';
            }
            
        } elseif ($result === 0) {
            echo 'verification failed';
        } else {
            echo 'verification error';
        }
        
    }
    
}

function verify_signature($raw_data, $signature) {
    $pub_key_contents = PINGPP_RSA_PUBLIC_KEY;
    // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
    return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
}